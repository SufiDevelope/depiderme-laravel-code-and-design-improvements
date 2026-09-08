@extends('layouts.app')

@section('title', 'Depiderme')

@section('content')
    <x-navbar :fixed="true" />

    <div class="home-section-stack" data-home-section-stack>
        <div class="home-stack-panel hero-shell home-hero-shell relative z-0 min-h-[100svh] bg-[#1a0a2e] lg:min-h-screen" data-home-stack-panel data-home-stack-pin-top>
            <div class="hero-bg pointer-events-none absolute" aria-hidden="true">
                <video
                    class="hero-bg__video"
                    src="{{ asset('videos/hero-bg.mp4') }}"
                    autoplay
                    muted
                    loop
                    playsinline
                    preload="auto"
                ></video>
            </div>

            <div class="home-hero-inner relative z-10 flex min-h-[100svh] flex-col lg:min-h-screen">
                <main class="flex flex-1 flex-col">
                    <x-hero />
                </main>
            </div>
        </div>

        <x-leader-section />

        <x-experience-section />

        <x-clinics-section />
    </div>

    <x-packs-section />

    <x-booking-section />

    <x-end-section class="end-section--home" :mobile-zoom="true" :mobile-position-max="1199" />

    <x-footer />
@endsection
