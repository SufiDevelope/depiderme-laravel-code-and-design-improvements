@extends('layouts.app')

@section('title', 'Depilação Laser — Depiderme')

@section('content')
    <div class="relative bg-[#000010]">
        <x-navbar :fixed="true" />

        <main>
            <x-technology-hero />
            <x-technology-diagnosis-section />
        </main>
    </div>

    <x-technology-equipment-section />

    <div class="technology-booking-flow">
        <x-technology-faq-section />

        <x-booking-section variant="technology" :rise="false" />
    </div>

    <x-end-section class="end-section--technology" :mobile-zoom="true" :mobile-position-max="1199" />

    <x-footer />
@endsection
