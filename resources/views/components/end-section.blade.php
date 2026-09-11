@props(['class' => '', 'mobileZoom' => false, 'mobilePositionMax' => 639])

@php
    $sectionPadding = 'site-padding';
@endphp

<section class="end-section relative z-10 overflow-hidden {{ $class }}" data-reveal-skip aria-label="Tratamento Depiderme">
    <img
        src="{{ asset('images/image-end.jpeg') }}"
        alt="{{ content('home', 'end.image_alt') }}"
        class="end-section__image"
        loading="eager"
    >
</section>
