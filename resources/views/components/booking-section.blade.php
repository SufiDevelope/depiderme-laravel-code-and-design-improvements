@props(['variant' => 'home', 'rise' => false])

@php
    $sectionPadding = 'site-padding';

    $cmsPage = match ($variant) {
        'about' => 'about',
        'contact' => 'contact',
        'technology' => 'technology',
        default => 'home',
    };

    $sectionClass = match ($variant) {
        'contact' => 'booking-section booking-gradient-about retina-purple-field relative overflow-hidden pt-28 lg:pt-32',
        'about', 'technology' => 'booking-section booking-gradient-about retina-purple-field relative z-20 overflow-hidden pt-10 sm:pt-12 lg:pt-24',
        default => 'booking-section booking-gradient retina-purple-field relative overflow-hidden rounded-tr-[40px] pt-10 sm:pt-12 lg:rounded-tr-[80px] lg:pt-24',
    };

    $shouldRise = in_array($variant, ['about', 'technology'], true) && $rise;
    $bookingTitle = $variant === 'contact'
        ? "Faça a sua\nmarcação"
        : content($cmsPage, 'booking.title');
    $bookingDescription = $variant === 'contact'
        ? 'Connosco operam profissionais de saúde e profissionais de estética que, aliados à tecnologia, partilham o seu conhecimento com o objetivo de lhe proporcionar os melhores resultados.'
        : content($cmsPage, 'booking.description');
    $bookingDescriptionNormalized = preg_replace('/\s+/', ' ', trim($bookingDescription));
    $designedBookingDescription = 'Connosco operam profissionais de saúde e profissionais de estética que, aliados à tecnologia, partilham o seu conhecimento com o objetivo de lhe proporcionar os melhores resultados.';
    $useDesignedHomeBookingDescription = $variant === 'home'
        && str_starts_with($bookingDescriptionNormalized, 'Connosco operam profissionais')
        && str_ends_with($bookingDescriptionNormalized, 'melhores resultados.');
    $useDesignedMobileBookingDescription = str_starts_with($bookingDescriptionNormalized, 'Connosco operam profissionais')
        && str_ends_with($bookingDescriptionNormalized, 'melhores resultados.');
@endphp

<section
    class="booking-section--{{ $variant }} relative {{ $sectionClass }}"
    data-live-gradient-intensity="strong"
    @if ($shouldRise) data-section-rise data-section-rise-static-mobile @if ($variant === 'home') data-section-rise-max="140" @endif @endif
    aria-label="Faça a sua marcação"
>
    <div class="booking-section__inner {{ $sectionPadding }}">
        <div class="booking-section__layout">
            <div class="booking-aside">
                <div class="booking-intro relative z-10 shrink-0">
                    <h2 class="font-sans text-[32px] font-medium leading-[110%] tracking-[-0.02em] text-white sm:text-[40px] lg:text-[60px]">
                        {!! nl_to_br($bookingTitle) !!}
                    </h2>

                    <p class="mt-4 max-w-[480px] font-body text-base font-normal leading-[130%] tracking-[-0.02em] text-white lg:mt-6">
                        @if ($useDesignedHomeBookingDescription)
                            <span class="booking-intro__description booking-intro__description-desktop hidden lg:inline">{{ $designedBookingDescription }}</span>
                            <span class="booking-intro__description booking-intro__description-mobile lg:hidden">{{ $designedBookingDescription }}</span>
                        @elseif ($variant === 'contact' && $useDesignedMobileBookingDescription)
                            <span class="booking-intro__description booking-intro__description-desktop hidden lg:inline">{{ $designedBookingDescription }}</span>
                            <span class="booking-intro__description booking-intro__description-mobile lg:hidden">{{ $designedBookingDescription }}</span>
                        @elseif ($useDesignedMobileBookingDescription)
                            <span class="hidden lg:inline">{{ $bookingDescription }}</span>
                            <span class="booking-intro__description booking-intro__description-mobile lg:hidden">{{ $designedBookingDescription }}</span>
                        @else
                            {{ $bookingDescription }}
                        @endif
                    </p>
                </div>

                <div class="booking-map relative z-0">
                    <img
                        src="{{ content_asset('home', 'booking.map_image', 'images/booking-map.png') }}"
                        alt="{{ content('home', 'booking.map_alt') }}"
                        class="booking-map__image pointer-events-none"
                        loading="lazy"
                    >
                </div>
            </div>

            <x-booking-form class="booking-section__form relative z-20 mt-6 w-full lg:mt-0" />

            <div class="booking-section__tail" aria-hidden="true"></div>
        </div>
    </div>
</section>
