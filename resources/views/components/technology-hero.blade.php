@php
    $sectionPadding = 'site-padding';

    $badgeClass = 'absolute left-3 top-3 z-20 flex size-9 items-center justify-center rounded-full bg-white font-sans text-base font-medium leading-[110%] tracking-[-0.02em] text-[#231f20] shadow-[0_2px_12px_rgba(0,0,0,0.18)] [font-variant:small-caps] lg:left-4 lg:top-4 lg:size-[42px] lg:text-[19.92px]';

    $steps = content('technology', 'hero.gallery');
    $titleLine1 = content('technology', 'hero.title_line1');
    $titleHighlight = content('technology', 'hero.title_highlight');
    $titleLine2 = content('technology', 'hero.title_line2');
    $titleLine2Normalized = preg_replace('/\s+/', ' ', trim($titleLine2));
    $useDesignedDesktopTitle = $titleLine1 === 'Avanço'
        && $titleHighlight === 'tecnológico'
        && $titleLine2Normalized === 'para resultados seguros e eficazes';
    $description = content('technology', 'hero.description');
    $descriptionNormalized = preg_replace('/\s+/', ' ', trim($description));
    $useDesignedDesktopDescription = str_starts_with($descriptionNormalized, 'Antes de iniciar tratamento')
        && str_ends_with($descriptionNormalized, 'dar início às sessões.');
@endphp

<section class="technology-hero retina-purple-field relative overflow-hidden bg-[#000010] pb-16 pt-28 sm:pb-20 sm:pt-32 lg:pb-28 lg:pt-24" data-scroll-laser-section data-live-gradient-intensity="strong" aria-label="Avanço tecnológico">
    <div class="{{ $sectionPadding }} relative z-10">
        <div class="technology-hero__copy grid grid-cols-1 items-start gap-8 lg:grid-cols-2 lg:gap-16 xl:gap-24">
            <h1 class="technology-hero__title max-w-[640px] font-sans text-[40px] font-semibold leading-[110%] tracking-[-0.02em] text-white sm:text-[56px] lg:w-[596px] lg:max-w-[596px] lg:text-[60px]">
                @if ($useDesignedDesktopTitle)
                    <span class="hidden lg:inline">{{ $titleLine1 }} <span class="bg-[linear-gradient(90deg,#8877C2_0%,#E1C7F9_100%)] bg-clip-text text-transparent">{{ $titleHighlight }}</span><br>para resultados<br>seguros e eficazes</span>
                    <span class="lg:hidden">{{ $titleLine1 }} <span class="bg-[linear-gradient(90deg,#8877C2_0%,#E1C7F9_100%)] bg-clip-text text-transparent">{{ $titleHighlight }}</span> {!! nl_to_br($titleLine2) !!}</span>
                @else
                    {{ $titleLine1 }}
                    <span class="bg-[linear-gradient(90deg,#8877C2_0%,#E1C7F9_100%)] bg-clip-text text-transparent">{{ $titleHighlight }}</span> {!! nl_to_br($titleLine2) !!}
                @endif
            </h1>

            <p class="technology-hero__description max-w-[520px] font-sans text-base font-medium leading-[140%] tracking-[-0.02em] text-white sm:text-lg lg:max-w-[480px] lg:justify-self-end lg:text-[20px]">
                @if ($useDesignedDesktopDescription)
                    <span class="technology-hero__description-desktop hidden lg:inline"><span>Antes de iniciar tratamento é feita uma anamnese</span><span>do paciente e um teste de reação cutânea. Trata-se</span><span>de uma consulta que poderá realizar gratuitamente.</span><span>Caso não se verifique nenhuma contra-indicação</span><span>poderá dar início às sessões.</span></span>
                    <span class="lg:hidden">{{ $description }}</span>
                @else
                    {{ $description }}
                @endif
            </p>
        </div>
    </div>

    <div class="technology-hero__laser relative mt-12 sm:mt-14 lg:mt-20">
        <div class="pointer-events-none relative z-0 h-10 overflow-visible sm:h-12 lg:h-14" aria-hidden="true">
            <x-scroll-laser-beam
                class="scroll-laser-beam--technology-gallery"
                data-scroll-laser-mode="section"
                data-scroll-laser-speed="8.5"
            />
        </div>
    </div>

    <div class="technology-hero__gallery tech-hero-gallery relative z-10 mt-10 sm:mt-12 lg:mt-14" data-carousel data-carousel-auto="marquee" data-carousel-auto-speed="58" data-carousel-ignore-reduced-motion="true" data-scroll-gap="16" id="tech-hero-mobile-gallery" data-tech-hero-gallery>
        <div class="tech-hero-gallery__track">
            @for ($copy = 0; $copy < 2; $copy++)
                <div class="tech-hero-gallery__group" @if ($copy > 0) aria-hidden="true" @endif>
                    @foreach ($steps as $index => $step)
                        <article
                            class="tech-hero-gallery__item relative max-lg:h-[var(--item-mobile-h)]"
                            style="height: {{ $step['height'] }}px; --item-mobile-h: {{ $step['mobileHeight'] }}px"
                        >
                            <img
                                src="{{ asset('images/' . $step['image']) }}"
                                alt="{{ $copy === 0 ? $step['alt'] : '' }}"
                                class="block h-full w-full object-cover object-center"
                                loading="lazy"
                            >
                            <span @class([
                                $badgeClass,
                                'lg:left-[calc(50%+12px)]' => $index === 0,
                            ])>
                                {{ $index + 1 }}
                            </span>
                        </article>
                    @endforeach
                </div>
            @endfor
        </div>
    </div>
</section>
