@props([
    'spacesOnly' => false,
    'rise' => true,
])

@php
    $sectionPadding = 'site-padding';

    $spaces = content('about', 'spaces.carousel');
    $spacesCarouselFallback = [
        ['image' => 'about-shop-leiria.png', 'city' => 'Leiria', 'alt' => 'Clínica Depiderme Leiria', 'object' => 'object-[42%_center]'],
        ['image' => 'about-shop-coimbra.png', 'city' => 'Coimbra', 'alt' => 'Clínica Depiderme Coimbra', 'object' => 'object-center'],
        ['image' => 'about-shop-porto.png', 'city' => 'Porto', 'alt' => 'Clínica Depiderme Porto', 'object' => 'object-center'],
        ['image' => 'clinic-4.png', 'city' => 'Vila Real', 'alt' => 'Clínica Depiderme Vila Real', 'object' => 'object-center'],
        ['image' => 'clinic-2.png', 'city' => 'Viseu', 'alt' => 'Clínica Depiderme Viseu', 'object' => 'object-[72%_center]'],
    ];
    $spaces = $spacesOnly || count($spaces) < 5 ? $spacesCarouselFallback : $spaces;
    $professionalSlides = content('about', 'professionals.gallery', null);
    $professionalSlides = is_array($professionalSlides) && count($professionalSlides) > 1
        ? $professionalSlides
        : [
            [
                'url' => content_asset('about', 'professionals.image', 'images/about-professional.png'),
                'alt' => content('about', 'professionals.image_alt'),
                'object' => 'object-[22%_center]',
            ],
            [
                'url' => asset('images/experience-card-2.png'),
                'alt' => 'Profissional Depiderme em tratamento laser',
                'object' => 'object-center',
            ],
            [
                'url' => asset('images/experience-card-1.png'),
                'alt' => 'Consulta Depiderme com profissional certificada',
                'object' => 'object-center',
            ],
        ];
    $mobileClinics = [
        ['city' => 'Leiria', 'image' => 'about-shop-leiria.png', 'object' => 'object-[42%_center]'],
        ['city' => 'Coimbra', 'image' => 'about-shop-coimbra.png', 'object' => 'object-center'],
        ['city' => 'Leiria', 'image' => 'about-shop-porto.png', 'object' => 'object-center'],
        ['city' => 'Vila Real', 'image' => 'clinic-4.png', 'object' => 'object-center'],
        ['city' => 'Viseu', 'image' => 'clinic-2.png', 'object' => 'object-[72%_center]'],
    ];
    $paragraphs = $spacesOnly ? [] : content('about', 'professionals.paragraphs');

    $navBtnClass = 'about-spaces-carousel__nav flex shrink-0 cursor-pointer items-center justify-center rounded-full border bg-transparent text-white transition-opacity hover:opacity-80';
    $navBtnSolidClass = 'flex size-[42px] shrink-0 cursor-pointer items-center justify-center rounded-full bg-[linear-gradient(180deg,#5B2B82_0%,#8A72AF_100%)] text-white transition-opacity hover:opacity-90';
@endphp

<div
    @class([
        'about-spaces-section relative overflow-x-clip',
        $spacesOnly ? 'bg-black' : 'bg-[#000010] rounded-tl-[40px] lg:rounded-tl-[80px]',
        'about-spaces-section--spaces-only' => $spacesOnly,
        'max-lg:overflow-x-visible' => $spacesOnly,
    ])
    @if ($rise) data-section-rise data-section-rise-static-mobile @endif
    data-scroll-laser-section
>
    @unless ($spacesOnly)
        <section class="about-spaces-mobile-grid-section about-spaces-mobile-grid-section--about relative z-10 lg:hidden" data-scroll-laser-section aria-label="Clínicas Depiderme">
            <div class="about-spaces-mobile-grid-section__results">
                <h2>Resultados superiores<br>em menos tempo</h2>
                <p>
                    Equipamentos de última geração que permitem atingir a depilação definitiva num intervalo de tempo mais curto e com maior eficácia.
                </p>
            </div>

            <div class="about-spaces-mobile-grid-section__dark">
                <div class="{{ $sectionPadding }}">
                    <div class="about-spaces-mobile-grid-section__intro">
                        <h2 class="about-spaces-mobile-grid-section__title">
                            {!! nl_to_br(content('about', 'spaces.title')) !!}
                        </h2>

                        <p class="about-spaces-mobile-grid-section__description">
                            {{ content('about', 'spaces.description') }}
                        </p>
                    </div>

                    <a href="{{ url('/clinics') }}" class="about-spaces-mobile-grid-section__pill mx-auto flex h-12 max-w-[350px] items-center justify-center rounded-full bg-[linear-gradient(90deg,#8877C2_0%,#5B2B82_100%)] px-8 text-center font-sans text-base font-semibold leading-[130%] tracking-[-0.02em] text-white">
                        Clínicas
                    </a>

                    <div class="about-spaces-mobile-grid-section__grid mt-10 grid grid-cols-2 gap-x-5 gap-y-5">
                        @foreach ($mobileClinics as $clinic)
                            <article class="about-spaces-mobile-grid-section__card relative overflow-hidden rounded-[8px] bg-[#12081f] shadow-[0_16px_44px_rgba(0,0,0,0.32)]">
                                <img
                                    src="{{ asset('images/' . $clinic['image']) }}"
                                    alt="Clínica Depiderme {{ $clinic['city'] }}"
                                    class="absolute inset-0 block h-full w-full object-cover {{ $clinic['object'] ?? 'object-center' }}"
                                    loading="lazy"
                                >
                                <div class="pointer-events-none absolute inset-0 bg-[linear-gradient(180deg,transparent_48%,rgba(0,0,0,0.16)_100%)]" aria-hidden="true"></div>
                                <p class="absolute bottom-3 left-1/2 z-[2] -translate-x-1/2 whitespace-nowrap rounded-[4px] bg-white/60 px-[10px] py-[5px] font-sans text-sm font-semibold leading-[18px] tracking-[-0.02em] text-black shadow-none backdrop-blur-sm">
                                    {{ $clinic['city'] }}
                                </p>
                            </article>
                        @endforeach
                    </div>
                </div>

                <x-scroll-laser-beam
                    class="scroll-laser-beam--spaces-mobile-grid"
                    data-scroll-laser-mode="section"
                    data-scroll-laser-speed="1.5"
                />
            </div>
        </section>
    @endunless

    @if ($spacesOnly)
        <section class="about-spaces-mobile-grid-section relative z-10 bg-[#02000d] pb-20 pt-20 lg:hidden" data-scroll-laser-section aria-label="Clínicas Depiderme">
            <div class="{{ $sectionPadding }}">
                <div class="about-spaces-mobile-grid-section__intro">
                    <h2 class="about-spaces-mobile-grid-section__title">
                        {!! nl_to_br(content('about', 'spaces.title')) !!}
                    </h2>

                    <p class="about-spaces-mobile-grid-section__description">
                        {{ content('about', 'spaces.description') }}
                    </p>
                </div>

                <div class="about-spaces-mobile-grid-section__pill mx-auto flex h-12 max-w-[350px] items-center justify-center rounded-full bg-[linear-gradient(90deg,#8877C2_0%,#5B2B82_100%)] px-8 text-center font-sans text-base font-semibold leading-[130%] tracking-[-0.02em] text-white">
                    Clínicas
                </div>

                <div class="about-spaces-mobile-grid-section__grid mt-10 grid grid-cols-2 gap-x-5 gap-y-5">
                    @foreach ($mobileClinics as $clinic)
                        <article class="about-spaces-mobile-grid-section__card relative overflow-hidden rounded-[8px] bg-[#12081f] shadow-[0_16px_44px_rgba(0,0,0,0.32)]">
                            <img
                                src="{{ asset('images/' . $clinic['image']) }}"
                                alt="Clínica Depiderme {{ $clinic['city'] }}"
                                class="absolute inset-0 block h-full w-full object-cover {{ $clinic['object'] ?? 'object-center' }}"
                                loading="lazy"
                            >
                            <div class="pointer-events-none absolute inset-0 bg-[linear-gradient(180deg,transparent_48%,rgba(0,0,0,0.16)_100%)]" aria-hidden="true"></div>
                            <p class="absolute bottom-3 left-1/2 z-[2] -translate-x-1/2 whitespace-nowrap rounded-[4px] bg-white/60 px-[10px] py-[5px] font-sans text-sm font-semibold leading-[18px] tracking-[-0.02em] text-black shadow-none backdrop-blur-sm">
                                {{ $clinic['city'] }}
                            </p>
                        </article>
                    @endforeach
                </div>

                <div class="about-spaces-mobile-grid-section__laser pointer-events-none relative mt-2 h-[168px]" aria-hidden="true">
                    <x-scroll-laser-beam
                        class="scroll-laser-beam--spaces-mobile-grid"
                        data-scroll-laser-mode="section"
                    />
                </div>
            </div>
        </section>
    @endif

    <section class="about-spaces-desktop-section relative z-10 hidden pt-16 lg:block lg:pt-[120px]" aria-label="Espaços especializados">
        <div class="about-spaces-inner site-padding lg:pl-[120px]">
            <div class="about-spaces-layout grid grid-cols-1 gap-10">
                <div class="about-spaces-copy relative z-10 w-full min-w-0 max-w-[443px]">
                    <h2 class="about-spaces-title max-w-full font-sans text-[40px] font-medium leading-[110%] tracking-[-0.02em] text-white sm:text-[48px]">
                        {!! nl_to_br(content('about', 'spaces.title')) !!}
                    </h2>

                    <p class="mt-6 font-body text-base font-normal leading-[130%] tracking-[-0.02em] text-[#FFFFFFB3]">
                        {{ content('about', 'spaces.description') }}
                    </p>

                    <a
                        href="{{ url('/clinics') }}"
                        class="mt-8 inline-flex items-center justify-center rounded-full bg-gradient-to-r from-[#8877C2] to-[#5B2B82] px-5 py-[15px] font-sans text-sm font-semibold capitalize leading-[18px] tracking-[-0.02em] text-white no-underline transition-opacity hover:opacity-90"
                    >
                        {{ content('about', 'spaces.button') }}
                    </a>
                </div>

                <div @class([
                    'relative z-10 min-w-0',
                    'xl:flex xl:justify-start' => ! $spacesOnly,
                ])>
                    <div @class([
                        'about-spaces-carousel-shell flex w-full min-w-0 flex-col items-start',
                        'max-lg:-site-gutter-x',
                    ])>
                        <div
                            id="about-spaces-carousel"
                            data-carousel
                            data-carousel-loop="true"
                            data-scroll-gap="29"
                            class="about-spaces-carousel flex w-full snap-x snap-mandatory overflow-x-auto pb-2 [-ms-overflow-style:none] [scrollbar-width:none] [&::-webkit-scrollbar]:hidden"
                        >
                            @foreach ($spaces as $space)
                                <article class="about-spaces-card relative shrink-0 snap-start overflow-hidden rounded-[20px]">
                                    <img
                                        src="{{ asset('images/' . $space['image']) }}"
                                        alt="{{ $space['alt'] }}"
                                        class="block h-full w-full object-cover {{ $space['object'] ?? 'object-center' }}"
                                        loading="lazy"
                                    >
                                    <span class="about-spaces-card__label absolute bottom-4 left-4">
                                        {{ $space['city'] }}
                                    </span>
                                </article>
                            @endforeach
                        </div>

                        <div @class([
                            'flex items-center justify-start gap-3 pl-[var(--site-gutter)] lg:pl-0',
                            'mt-4 lg:mt-6' => $spacesOnly,
                            'mt-10 lg:mt-12' => ! $spacesOnly,
                        ])>
                        <button type="button" class="{{ $navBtnClass }}" data-carousel-prev="about-spaces-carousel" aria-label="Clínica anterior">
                            <svg class="block" width="24" height="24" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M14 7L9 12L14 17" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                        <button type="button" class="{{ $navBtnClass }}" data-carousel-next="about-spaces-carousel" aria-label="Próxima clínica">
                            <svg class="block" width="24" height="24" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M10 7L15 12L10 17" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                        <span class="about-spaces-carousel-progress ml-2 h-px w-[120px]" data-carousel-progress="about-spaces-carousel" aria-hidden="true"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @unless ($spacesOnly)
    <div class="about-spaces-laser-divider relative hidden lg:block" aria-hidden="true">
        <x-scroll-laser-beam
            class="scroll-laser-beam--spaces"
            data-scroll-laser-mode="beam"
        />
    </div>

    <section class="about-professionals-section relative z-10 pb-16 pt-0 lg:pb-24" aria-label="Profissionais certificados">
        <div class="about-professionals-section__layout grid grid-cols-1 items-center gap-10 lg:grid-cols-2 lg:gap-12 xl:gap-16">
            <div class="about-professionals-section__media relative w-full max-lg:-ml-[var(--site-gutter)] max-lg:w-[calc(100%+var(--site-gutter))] lg:w-full">
                <div
                    id="about-professionals-carousel"
                    class="about-professionals-section__image-frame about-professionals-section__carousel relative flex h-[420px] snap-x snap-mandatory overflow-x-auto rounded-tr-[40px] bg-white sm:h-[520px] sm:rounded-tr-[60px] lg:h-[667px] lg:rounded-tr-[120px] [-ms-overflow-style:none] [scrollbar-width:none] [&::-webkit-scrollbar]:hidden"
                    data-carousel
                    data-carousel-loop="true"
                    data-scroll-gap="0"
                >
                    @foreach ($professionalSlides as $slide)
                        <article class="h-full min-w-full snap-start overflow-hidden">
                            <img
                                src="{{ $slide['url'] ?? asset(str_starts_with($slide['image'] ?? '', 'images/') ? $slide['image'] : 'images/' . ($slide['image'] ?? 'about-professional.png')) }}"
                                alt="{{ $slide['alt'] ?? content('about', 'professionals.image_alt') }}"
                                class="about-professionals-section__image block h-full w-full scale-[1.08] object-cover {{ $slide['object'] ?? 'object-center' }} origin-left"
                                loading="lazy"
                            >
                        </article>
                    @endforeach
                </div>

                <div class="about-professionals-section__nav absolute bottom-4 right-4 flex items-center gap-2 sm:bottom-6 sm:right-6 lg:right-8">
                    <button type="button" class="{{ $navBtnSolidClass }}" data-carousel-prev="about-professionals-carousel" aria-label="Anterior">
                        <svg class="block" width="24" height="24" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M14 7L9 12L14 17" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                    <button type="button" class="{{ $navBtnSolidClass }}" data-carousel-next="about-professionals-carousel" aria-label="Seguinte">
                        <svg class="block" width="24" height="24" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M10 7L15 12L10 17" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="about-professionals-section__copy site-padding max-w-[560px] lg:pl-8">
                <h2 class="about-professionals-section__title font-sans text-[40px] font-medium leading-[110%] tracking-[-0.02em] text-white sm:text-[48px] lg:text-[60px]">
                    {!! nl_to_br(content('about', 'professionals.title')) !!}
                </h2>

                <div class="about-professionals-section__body mt-6 flex flex-col gap-4 lg:mt-8">
                    @foreach ($paragraphs as $index => $paragraph)
                        @php
                            $paragraphNormalized = preg_replace('/\s+/', ' ', trim($paragraph));
                        @endphp
                        <p class="font-body text-base font-normal leading-[130%] tracking-[-0.02em] text-[#FFFFFFB3]">
                            @if ($index === 0 && str_starts_with($paragraphNormalized, 'As Clínicas Depiderme contam já com mais de 15 anos'))
                                <span class="about-professionals-section__body-line hidden lg:block">As Clínicas Depiderme contam já com mais de 15 anos de experiência na</span>
                                <span class="about-professionals-section__body-line hidden lg:block">área da depilação laser.</span>
                                <span class="lg:hidden">{{ $paragraph }}</span>
                            @elseif ($index === 1 && str_starts_with($paragraphNormalized, 'Connosco operam profissionais de saúde'))
                                <span class="about-professionals-section__body-line hidden lg:block">Connosco operam profissionais de saúde e profissionais de estética que,</span>
                                <span class="about-professionals-section__body-line hidden lg:block">aliados à tecnologia, partilham o seu conhecimento com o objetivo de lhe</span>
                                <span class="about-professionals-section__body-line hidden lg:block">proporcionar os melhores resultados.</span>
                                <span class="lg:hidden">{{ $paragraph }}</span>
                            @elseif ($index === 2 && str_starts_with($paragraphNormalized, 'As Clínicas Depiderme contam também com profissionais certificados'))
                                <span class="about-professionals-section__body-line hidden lg:block">As Clínicas Depiderme contam também com profissionais certificados</span>
                                <span class="about-professionals-section__body-line hidden lg:block">pela Candela e certificados pela ALTEC (Fototerapia Laser).</span>
                                <span class="lg:hidden">{{ $paragraph }}</span>
                            @else
                                {{ $paragraph }}
                            @endif
                        </p>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    @else
    <div class="about-spaces-laser-divider relative hidden lg:block" aria-hidden="true">
        <x-scroll-laser-beam
            class="scroll-laser-beam--spaces"
            data-scroll-laser-mode="beam"
        />
    </div>
    @endunless
</div>
