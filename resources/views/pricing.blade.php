@extends('layouts.app')

@section('title', 'Preços — Depiderme')

@section('content')
    <div class="pricing-page relative bg-[#000010]">
        <x-navbar :fixed="true" />

        <main>
            <x-pricing-hero />
        </main>
    </div>

    <x-pricing-content-section />

    <x-footer />
@endsection
