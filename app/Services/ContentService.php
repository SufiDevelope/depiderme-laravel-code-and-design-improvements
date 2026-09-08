<?php

namespace App\Services;

use App\Models\ContentEntry;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

class ContentService
{
    private const CACHE_KEY = 'cms.content.all';

    private const STRUCTURED_TYPES = [
        'json',
        'links',
        'list',
        'repeater',
        'pack_rows',
        'pricing',
    ];

    public function get(string $page, string $key, mixed $default = null): mixed
    {
        // CMS field keys intentionally contain dots (for example,
        // "navbar.desktop_links"), so Laravel's dot-notation config helper
        // cannot address them directly. Read the exact array key instead.
        $fields = config("cms.pages.{$page}.fields", []);
        $field = is_array($fields) ? ($fields[$key] ?? null) : null;

        if ($default === null && is_array($field)) {
            $default = $field['default'] ?? null;
        }

        if (! $this->tableExists()) {
            return $default;
        }

        $entries = $this->allEntries();

        $fullKey = "{$page}.{$key}";

        if (! isset($entries[$fullKey])) {
            return $default;
        }

        $entry = $entries[$fullKey];

        if (in_array($entry['type'], self::STRUCTURED_TYPES, true)) {
            return json_decode($entry['value'] ?? '[]', true) ?? $default;
        }

        $value = $entry['value'];

        return ($value === null || $value === '') ? $default : $value;
    }

    public function assetUrl(string $page, string $key, ?string $default = null): string
    {
        $path = $this->get($page, $key, $default);

        if (! is_string($path) || $path === '') {
            return asset('images/placeholder.png');
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        if (str_starts_with($path, 'images/')) {
            return asset($path);
        }

        return asset('storage/'.$path);
    }

    /**
     * @return array<string, array{type: string, value: ?string}>
     */
    public function allEntries(): array
    {
        return Cache::rememberForever(self::CACHE_KEY, function () {
            return ContentEntry::query()
                ->get()
                ->mapWithKeys(fn (ContentEntry $entry) => [
                    "{$entry->page}.{$entry->key}" => [
                        'type' => $entry->type,
                        'value' => $entry->value,
                    ],
                ])
                ->all();
        });
    }

    public function forgetCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }

    public function syncFromConfig(): void
    {
        foreach (config('cms.pages', []) as $page => $pageConfig) {
            foreach ($pageConfig['fields'] ?? [] as $key => $field) {
                $value = $field['default'] ?? null;
                $type = $field['type'] ?? (is_array($value) ? 'json' : 'text');

                if (in_array($type, self::STRUCTURED_TYPES, true) && is_array($value)) {
                    $value = json_encode($value, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
                }

                ContentEntry::query()->updateOrCreate(
                    ['page' => $page, 'key' => $key],
                    ['type' => $type, 'value' => $value],
                );
            }
        }

        $this->forgetCache();
    }

    private function tableExists(): bool
    {
        try {
            return Schema::hasTable('content_entries');
        } catch (\Throwable) {
            return false;
        }
    }
}
