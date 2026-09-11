@props(['class' => '', 'mobileZoom' => false, 'mobilePositionMax' => 639])

@php
    $sectionPadding = 'site-padding';
@endphp

<section class="end-section relative z-10 overflow-x-clip {{ $sectionPadding }} {{ $class }}" data-reveal-skip aria-label="Tratamento Depiderme">
    <div
        class="end-section__scene"
        data-scroll-expand-scene
        data-scroll-expand-static-mobile
        @if($mobileZoom) data-scroll-expand-mobile-position data-scroll-expand-mobile-max="{{ $mobilePositionMax }}" @endif
    >
        <div class="end-section__stage">
            <div class="end-section__media mx-auto overflow-hidden bg-white" data-scroll-expand-media>
                <img
                    src="{{ content_asset('home', 'end.image', 'images/img-end.png') }}"
                    alt="{{ content('home', 'end.image_alt') }}"
                    class="end-section__image"
                    loading="eager"
                >
            </div>
        </div>
    </div>
</section>
