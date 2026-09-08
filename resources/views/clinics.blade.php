@extends('layouts.app')

@section('title', 'Clínicas — Depiderme')

@section('content')
    @php
        $clinics = content('clinics', 'clinics.list');
    @endphp

    <div class="clinics-page">
        <x-navbar theme="light" :mobile-dark="true" :fixed="true" />

        <main class="relative z-0 bg-black lg:bg-white">
            <x-clinics-page-section :clinics="$clinics" />
        </main>

        <div class="clinics-detail-footer-flow bg-black">
            <x-clinics-detail-section :clinics="$clinics" />
            <div class="about-spaces-laser-divider clinics-footer-laser-divider relative hidden lg:block overflow-visible" aria-hidden="true">
                <x-scroll-laser-beam
                    class="scroll-laser-beam--clinics-end"
                    data-scroll-laser-mode="beam"
                />
            </div>
            <x-footer :dark-corner="true" />
        </div>
    </div>
@endsection
