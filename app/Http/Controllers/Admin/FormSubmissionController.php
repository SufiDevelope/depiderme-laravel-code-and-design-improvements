<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FormSubmission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FormSubmissionController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->query('status');

        $submissions = FormSubmission::query()
            ->when($status, fn ($query) => $query->where('status', $status))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.submissions.index', compact('submissions', 'status'));
    }

    public function show(FormSubmission $submission): View
    {
        $submission->markAsRead();

        return view('admin.submissions.show', compact('submission'));
    }

    public function updateStatus(Request $request, FormSubmission $submission): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:new,read,contacted,archived'],
        ]);

        $submission->update(['status' => $validated['status']]);

        return back()->with('success', 'Estado atualizado.');
    }

    public function destroy(FormSubmission $submission): RedirectResponse
    {
        $submission->delete();

        return redirect()
            ->route('admin.submissions.index')
            ->with('success', 'Submissão eliminada.');
    }
}
