@extends('layouts.app')

@section('title', 'Sobre Nós — Depiderme')

@section('content')
    <x-navbar theme="light" :mobile-dark="true" :fixed="true" />

    <main class="bg-white">
        <x-about-hero />
        <x-about-tech-section />
    </main>

    <x-about-spaces-section />

    <x-booking-section variant="about" />

    <x-end-section class="end-section--about" :mobile-zoom="true" :mobile-position-max="1199" />

    <x-footer />
@endsection
