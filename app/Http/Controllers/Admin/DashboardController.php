<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FormSubmission;
use App\Support\AdminNavigation;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $newSubmissions = FormSubmission::query()
            ->where('status', 'new')
            ->count();

        $totalSubmissions = FormSubmission::query()->count();

        $recentSubmissions = FormSubmission::query()
            ->latest()
            ->limit(5)
            ->get();

        $contentPages = collect(AdminNavigation::contentPages())
            ->map(function (array $page, string $slug) {
                $editableFields = collect($page['fields'] ?? [])
                    ->filter(fn (array $field) => cms_field_editable($field));

                return [
                    'slug' => $slug,
                    'label' => $page['label'],
                    'url' => $page['url'] ?? null,
                    'field_count' => $editableFields->count(),
                ];
            })
            ->values()
            ->all();

        return view('admin.dashboard', compact(
            'newSubmissions',
            'totalSubmissions',
            'recentSubmissions',
            'contentPages',
        ));
    }
}
