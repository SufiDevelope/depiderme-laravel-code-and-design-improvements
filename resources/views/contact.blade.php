@extends('layouts.app')

@section('title', 'Contactos — Depiderme')

@section('content')
    <div class="contact-page relative bg-[#8877c2]">
        <x-navbar :fixed="true" />

        <x-booking-section variant="contact" />

        <x-footer :live-gradient="false" />
    </div>
@endsection
