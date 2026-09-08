<?php

namespace App\Support;

use App\Models\FormSubmission;

class AdminNavigation
{
    /**
     * @return array<string, array{label: string, url: ?string, fields: array}>
     */
    public static function contentPages(): array
    {
        $pages = config('cms.pages', []);
        $order = config('cms.page_order', []);
        $sorted = [];

        foreach ($order as $slug) {
            if ($slug === 'global' || ! isset($pages[$slug])) {
                continue;
            }

            $sorted[$slug] = $pages[$slug];
        }

        foreach ($pages as $slug => $page) {
            if ($slug === 'global' || isset($sorted[$slug])) {
                continue;
            }

            $sorted[$slug] = $page;
        }

        return $sorted;
    }

    public static function routeName(): string
    {
        return request()->route()?->getName() ?? '';
    }

    public static function isDashboard(): bool
    {
        return self::routeName() === 'admin.dashboard';
    }

    public static function isSubmissions(): bool
    {
        return str_starts_with(self::routeName(), 'admin.submissions.');
    }

    public static function isContentIndex(): bool
    {
        return self::routeName() === 'admin.content.index';
    }

    public static function isPage(string $slug): bool
    {
        return self::routeName() === 'admin.content.edit'
            && request()->route('page') === $slug;
    }

    public static function newSubmissionsCount(): int
    {
        return FormSubmission::query()->where('status', 'new')->count();
    }
}
