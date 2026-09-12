@php
    $sectionPadding = 'site-padding';

    $cardClass = 'flex items-center rounded-[20px] bg-white shadow-[0_20px_60px_rgba(39,24,65,0.12)] will-change-transform motion-reduce:animate-none';
    $cardMobileClass = $cardClass . ' absolute bottom-5 left-4 z-20 max-w-[calc(100%-2rem)] gap-4 p-4 animate-about-hero-card-float sm:bottom-6 sm:left-6 sm:gap-5 sm:p-5 lg:hidden';
    $cardDesktopClass = $cardClass . ' absolute left-1/2 top-[78%] w-[440px] max-w-[calc(100vw-2rem)] gap-5 p-5 animate-about-hero-card-float-desktop motion-reduce:-translate-x-1/2 motion-reduce:-translate-y-1/2';

    $bullets = content('about', 'hero.bullets');
    $cardText = e(content('about', 'hero.card_text'));
    $cardText = str_replace('Candela Medical', '<strong>Candela Medical</strong>', $cardText);
@endphp

<section class="relative bg-white" data-scroll-laser-section data-reveal-skip aria-label="Ciência e tecnologia">
    <div class="about-hero-grid grid grid-cols-1 lg:grid-cols-2 lg:-mt-24 lg:min-h-[1000px]">
        {{-- Coluna esquerda: texto centrado verticalmente face à imagem --}}
        <div class="about-hero-copy {{ $sectionPadding }} relative z-10 flex min-h-0 flex-col justify-center overflow-visible pb-12 pt-28 sm:pt-32 lg:min-h-[1000px] lg:pb-0 lg:pt-24">
            <div class="about-hero-copy__inner relative z-10 flex max-w-[720px] flex-col gap-[30px] overflow-visible lg:w-[628px] lg:max-w-none">
                <h1 class="max-w-[720px] font-sans text-[40px] font-semibold leading-[110%] tracking-[-0.02em] text-[#231f20] sm:text-[56px] lg:w-[628px] lg:max-w-none lg:text-[60px]">
                    {{ content('about', 'hero.title_line1') }}
                    <span class="bg-gradient-to-r from-[#8877C2] to-[#5B2B82] bg-clip-text text-transparent">{{ content('about', 'hero.title_highlight') }}</span><br>
                    {{ content('about', 'hero.title_line2') }}
                </h1>

                <p class="max-w-[520px] font-body text-base font-normal leading-[130%] tracking-[-0.02em] text-[#545462]">
                    {{ content('about', 'hero.description') }}
                </p>

                <ul class="flex max-w-[520px] flex-col gap-5">
                    @foreach ($bullets as $bullet)
                        <li class="flex items-start gap-3">
                            <img src="{{ asset('images/about-check.png') }}" alt="" width="20" height="20"
                                class="mt-0.5 size-5 shrink-0 object-contain">
                            <span class="font-body text-base font-normal leading-[130%] tracking-[-0.02em] text-[#545462]">
                                {{ $bullet }}
                            </span>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Laser: após bullets, horizontal até 10px dentro da imagem --}}
            <x-scroll-laser-beam
                class="scroll-laser-beam--about-hero hidden lg:block"
                data-scroll-laser-mode="section"
                data-scroll-laser-speed="1.65"
                data-scroll-laser-min-scale="0.85"
                data-scroll-laser-min-opacity="0.9"
            />
        </div>

        {{-- Coluna direita: imagem 1000px @ desktop --}}
        <div class="about-hero-media relative z-20 min-h-[440px] sm:min-h-[520px] lg:h-[1000px] lg:min-h-[1000px]">
            <div class="about-hero-image-frame relative z-20 h-full min-h-[inherit] overflow-hidden rounded-tr-[40px] rounded-bl-[60px] sm:rounded-tr-[60px] sm:rounded-bl-[80px] lg:rounded-bl-[120px] lg:rounded-tr-none">
                <img
                    src="{{ content_asset('about', 'hero.image', 'images/about-hero.png') }}"
                    alt="{{ content('about', 'hero.image_alt') }}"
                    class="about-hero-image relative z-20 block h-full min-h-[440px] w-full object-cover object-[center_32%] sm:min-h-[520px] lg:h-[1000px] lg:min-h-[1000px]"
                    loading="eager"
                >

                {{-- Card mobile --}}
                <div class="about-hero-card-mobile {{ $cardMobileClass }}">
                    <img src="{{ content_asset('about', 'hero.card_icon', 'images/about-card-icon.png') }}" alt="" width="97" height="97"
                        class="about-hero-card-mobile__icon size-[72px] shrink-0 object-contain sm:size-[97px]">
                    <p class="about-hero-card-mobile__text font-sans text-xl font-medium leading-[140%] tracking-[-0.02em] text-[#231f20]">
                        {!! $cardText !!}
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Card flutuante desktop: junção das colunas, centrado na altura da imagem --}}
    <div class="pointer-events-none absolute inset-x-0 top-0 z-30 hidden lg:block lg:h-[1000px] lg:-mt-24" aria-hidden="true">
        <div class="about-hero-card-desktop pointer-events-auto {{ $cardDesktopClass }}">
            <img src="{{ content_asset('about', 'hero.card_icon', 'images/about-card-icon.png') }}" alt="" width="97" height="97"
                class="size-[97px] shrink-0 object-contain">
            <p class="pointer-events-auto font-sans text-xl font-medium leading-[140%] tracking-[-0.02em] text-[#231f20]">
                {!! $cardText !!}
            </p>
        </div>
    </div>
</section>
