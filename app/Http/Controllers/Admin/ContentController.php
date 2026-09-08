<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContentEntry;
use App\Models\Media;
use App\Services\CmsFieldService;
use App\Services\ContentService;
use App\Support\AdminNavigation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContentController extends Controller
{
    public function __construct(
        private ContentService $content,
        private CmsFieldService $fields,
    ) {}

    public function index(): View
    {
        $pages = collect(AdminNavigation::contentPages())
            ->map(function (array $page) {
                $page['fields'] = collect($page['fields'] ?? [])
                    ->filter(fn (array $field) => cms_field_editable($field))
                    ->all();

                return $page;
            })
            ->put('global', [
                'label' => config('cms.pages.global.label', 'Global'),
                'url' => config('cms.pages.global.url'),
                'fields' => collect(config('cms.pages.global.fields', []))
                    ->filter(fn (array $field) => cms_field_editable($field))
                    ->all(),
            ])
            ->all();

        return view('admin.content.index', compact('pages'));
    }

    public function edit(string $page): View
    {
        $pages = config('cms.pages', []);

        abort_unless(isset($pages[$page]), 404);

        $pageConfig = $pages[$page];
        $entries = ContentEntry::query()
            ->where('page', $page)
            ->get()
            ->keyBy('key');

        $sections = [];

        foreach ($pageConfig['fields'] as $key => $field) {
            if (! cms_field_editable($field)) {
                continue;
            }

            $entry = $entries->get($key);
            $sectionName = $field['section'] ?? 'Geral';

            $sections[$sectionName][$key] = array_merge($field, [
                'value' => $this->fields->valueForForm($entry?->value, $field),
            ]);
        }

        $sections = collect($sections)
            ->filter(fn (array $fields) => $fields !== [])
            ->all();

        $media = Media::query()->latest()->limit(48)->get();
        $siteImages = $this->siteImages();

        return view('admin.content.edit', [
            'page' => $page,
            'pageLabel' => $pageConfig['label'],
            'pageUrl' => $pageConfig['url'] ?? null,
            'sections' => $sections,
            'media' => $media,
            'siteImages' => $siteImages,
        ]);
    }

    public function update(Request $request, string $page): RedirectResponse
    {
        $pages = config('cms.pages', []);
        abort_unless(isset($pages[$page]), 404);

        $pageFields = $pages[$page]['fields'];

        foreach ($pageFields as $key => $field) {
            if (! cms_field_editable($field)) {
                continue;
            }

            $inputKey = "fields.{$key}";
            $type = $field['type'] ?? 'text';

            if (! $request->has($inputKey)) {
                continue;
            }

            $existing = ContentEntry::query()
                ->where('page', $page)
                ->where('key', $key)
                ->value('value');

            $input = $request->input($inputKey);
            $value = $this->fields->valueForStorage($input, $field, $existing);

            ContentEntry::query()->updateOrCreate(
                ['page' => $page, 'key' => $key],
                ['type' => $type, 'value' => $value],
            );
        }

        $this->content->forgetCache();

        return redirect()
            ->route('admin.content.edit', $page)
            ->with('success', 'Conteúdo guardado com sucesso.');
    }

    /**
     * @return list<string>
     */
    private function siteImages(): array
    {
        $paths = glob(public_path('images/*.{jpg,jpeg,png,webp,svg,gif}'), GLOB_BRACE) ?: [];

        return collect($paths)
            ->map(fn (string $path) => 'images/'.basename($path))
            ->sort()
            ->values()
            ->all();
    }
}
