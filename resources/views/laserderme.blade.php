@extends('layouts.app')

@section('title', 'Laserderme — Depiderme')

@section('content')
    <x-navbar :fixed="true" />

    <main>
        <x-laserderme-hero />
        <x-laserderme-intro-section />
        <x-laserderme-factors-section />
        <div class="laserderme-mobile-gradient-flow">
            <x-laserderme-cta-section />
            <x-about-spaces-section :spaces-only="true" :rise="false" />
            <x-footer />
        </div>
    </main>
@endsection
