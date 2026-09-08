<?php

namespace App\Http\Controllers;

use App\Models\FormSubmission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $minimumPreferredDate = now()->addDay()->toDateString();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'clinic' => ['required', 'string', 'max:100'],
            'reason' => ['required', 'string', 'max:100'],
            'body_area' => ['nullable', 'string', 'max:255'],
            'preferred_date' => ['nullable', 'date_format:Y-m-d', 'after_or_equal:'.$minimumPreferredDate],
            'preferred_time' => ['nullable', 'string', 'max:20'],
            'terms' => ['accepted'],
        ]);

        FormSubmission::query()->create([
            'form_type' => 'booking',
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'clinic' => $validated['clinic'],
            'reason' => $validated['reason'],
            'body_area' => $validated['body_area'] ?? null,
            'preferred_date' => $validated['preferred_date'] ?? null,
            'preferred_time' => $validated['preferred_time'] ?? null,
            'terms_accepted' => true,
            'source_page' => $request->headers->get('referer'),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return back()->with('booking_success', 'Pedido de marcação enviado com sucesso. Entraremos em contacto em breve.');
    }
}
