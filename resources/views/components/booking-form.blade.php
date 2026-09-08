@props(['idPrefix' => 'booking'])

@php
    $clinics = content('contact', 'form.clinics');
    $reasons = content('contact', 'form.reasons');
    $times = content('contact', 'form.times');
    $minimumPreferredDate = now()->addDay()->toDateString();
@endphp

<div {{ $attributes->merge(['class' => 'booking-form']) }}>
    @if (session('booking_success'))
        <div class="mb-6 rounded-2xl border border-[#abefc6] bg-[#ecfdf3] px-4 py-3 text-sm text-[#027a48]">
            {{ session('booking_success') }}
        </div>
    @endif

    <form action="{{ route('booking.store') }}" method="post" class="booking-form__fields">
        @csrf

        <div class="booking-form__field">
            <label for="{{ $idPrefix }}-name" class="booking-form__label">{{ content('contact', 'form.name_label') }}</label>
            <input
                id="{{ $idPrefix }}-name"
                type="text"
                name="name"
                value="{{ old('name') }}"
                placeholder="{{ content('contact', 'form.name_placeholder') }}"
                class="booking-form__control"
                required
            >
            @error('name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="booking-form__field booking-form__field--email">
            <label for="{{ $idPrefix }}-email" class="booking-form__label">{{ content('contact', 'form.email_label') }}</label>
            <input
                id="{{ $idPrefix }}-email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                placeholder="{{ content('contact', 'form.email_placeholder') }}"
                class="booking-form__control"
                required
            >
            @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="booking-form__field">
            <label for="{{ $idPrefix }}-phone" class="booking-form__label">{{ content('contact', 'form.phone_label') }}</label>
            <input
                id="{{ $idPrefix }}-phone"
                type="tel"
                name="phone"
                value="{{ old('phone') }}"
                placeholder="{{ content('contact', 'form.phone_placeholder') }}"
                class="booking-form__control"
                required
            >
            @error('phone')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="booking-form__field">
            <label for="{{ $idPrefix }}-clinic" class="booking-form__label">{{ content('contact', 'form.clinic_label') }}</label>
            <select id="{{ $idPrefix }}-clinic" name="clinic" class="booking-form__control booking-form__select" required>
                <option value="" disabled @selected(! old('clinic'))>{{ content('contact', 'form.clinic_placeholder') }}</option>
                @foreach ($clinics as $clinic)
                    <option value="{{ $clinic }}" @selected(old('clinic') === $clinic)>{{ $clinic }}</option>
                @endforeach
            </select>
            @error('clinic')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="booking-form__field">
            <label for="{{ $idPrefix }}-reason" class="booking-form__label">{{ content('contact', 'form.reason_label') }}</label>
            <select id="{{ $idPrefix }}-reason" name="reason" class="booking-form__control booking-form__select" required>
                <option value="" disabled @selected(! old('reason'))>{{ content('contact', 'form.reason_placeholder') }}</option>
                @foreach ($reasons as $reason)
                    <option value="{{ $reason }}" @selected(old('reason') === $reason)>{{ $reason }}</option>
                @endforeach
            </select>
            @error('reason')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="booking-form__field">
            <label for="{{ $idPrefix }}-area" class="booking-form__label">{{ content('contact', 'form.area_label') }}</label>
            <input
                id="{{ $idPrefix }}-area"
                type="text"
                name="body_area"
                value="{{ old('body_area') }}"
                placeholder="{{ content('contact', 'form.area_placeholder') }}"
                class="booking-form__control"
            >
            @error('body_area')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="booking-form__row">
            <div class="booking-form__field">
                <label for="{{ $idPrefix }}-date" class="booking-form__label">{{ content('contact', 'form.date_label') }}</label>
                <input
                    id="{{ $idPrefix }}-date"
                    type="date"
                    name="preferred_date"
                    value="{{ old('preferred_date') }}"
                    min="{{ $minimumPreferredDate }}"
                    placeholder="{{ content('contact', 'form.date_placeholder') }}"
                    class="booking-form__control"
                >
                @error('preferred_date')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="booking-form__field">
                <label for="{{ $idPrefix }}-time" class="booking-form__label">{{ content('contact', 'form.time_label') }}</label>
                <select id="{{ $idPrefix }}-time" name="preferred_time" class="booking-form__control booking-form__select">
                    <option value="" @selected(! old('preferred_time'))>{{ content('contact', 'form.time_placeholder') }}</option>
                    @foreach ($times as $time)
                        <option value="{{ $time }}" @selected(old('preferred_time') === $time)>{{ $time }}</option>
                    @endforeach
                </select>
                @error('preferred_time')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <label class="booking-form__terms">
            <input type="checkbox" name="terms" value="1" class="booking-form__checkbox" @checked(old('terms')) required>
            <span>{{ content('contact', 'form.terms_text') }}</span>
        </label>
        @error('terms')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror

        <button type="submit" class="booking-form__submit">
            {{ content('contact', 'form.submit_text') }}
        </button>
    </form>
</div>
