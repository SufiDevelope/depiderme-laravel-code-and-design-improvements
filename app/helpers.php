<?php

use App\Services\ContentService;

if (! function_exists('content')) {
    function content(string $page, string $key, mixed $default = null): mixed
    {
        return app(ContentService::class)->get($page, $key, $default);
    }
}

if (! function_exists('content_asset')) {
    function content_asset(string $page, string $key, ?string $default = null): string
    {
        return app(ContentService::class)->assetUrl($page, $key, $default);
    }
}

if (! function_exists('cms_url')) {
    function cms_url(string $path): string
    {
        if ($path === '#' || str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        return url($path);
    }
}

if (! function_exists('cms_field_editable')) {
    function cms_field_editable(array $field): bool
    {
        return ($field['editable'] ?? true) !== false;
    }
}

if (! function_exists('admin_asset_url')) {
    function admin_asset_url(?string $path): string
    {
        if (! is_string($path) || $path === '') {
            return asset('images/placeholder.png');
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        if (str_starts_with($path, 'images/')) {
            return asset($path);
        }

        if (str_contains($path, '/')) {
            return asset('storage/'.$path);
        }

        return asset('images/'.$path);
    }
}

if (! function_exists('nl_to_br')) {
    function nl_to_br(string $text): string
    {
        return nl2br(e($text), false);
    }
}
