@php
    $clinics = content('home', 'clinics_teaser.clinics');
    $mobileClinics = content('clinics', 'clinics.list', require config_path('cms/data/clinics.php'));
    $mobileClinics = is_array($mobileClinics) ? $mobileClinics : [];
    $mobileObjectClasses = [
        'Leiria' => 'object-[54%_center]',
        'Coimbra' => 'object-[62%_center]',
        'Viseu' => 'object-[58%_center]',
        'Vila Real' => 'object-center',
        'Porto' => 'object-[58%_center]',
    ];

    $sectionTitleClass = 'font-sans text-[24px] font-medium leading-[130%] tracking-[-0.02em] text-[#9A9A9A] sm:text-[30px]';
    $cityClass = 'font-sans text-[24px] font-medium leading-[130%] tracking-[-0.02em] text-[#231f20] sm:text-[30px]';
    $addressClass = 'font-body text-base font-normal leading-[130%] tracking-[-0.02em] text-[#545462]';
    $contactClass = 'font-body text-sm font-normal leading-[130%] tracking-[-0.02em] text-[#9A9A9A] no-underline transition-opacity hover:opacity-70';
    $navBtnClass = 'inline-flex size-[42px] shrink-0 cursor-pointer items-center justify-center rounded-full border border-black bg-gradient-to-b from-[#5B2B82] to-[#8A72AF] text-white transition-opacity hover:opacity-90';
@endphp

<section id="clinics-teaser" class="home-stack-panel relative bg-[#000010] lg:pt-[235px]" data-home-stack-panel data-reveal-threshold="0.01" data-reveal-root-margin="0px 0px 24% 0px" data-reveal-delay-scale="0.35" aria-label="As nossas clínicas">
    <div
        class="clinics-section__panel relative overflow-hidden bg-[#02000d] lg:-mt-[235px] lg:rounded-tl-[120px] lg:bg-white"
        data-scroll-gradient
        data-live-gradient-intensity="strong"
    >
        <div class="clinics-section__glow" aria-hidden="true">
            <div class="clinics-section__glow-field" data-live-gradient-vector data-live-gradient-intensity="cinematic">
                <span class="clinics-section__glow-blob clinics-section__glow-blob--primary"></span>
                <span class="clinics-section__glow-blob clinics-section__glow-blob--secondary"></span>
                <span class="clinics-section__glow-blob clinics-section__glow-blob--accent"></span>
            </div>
        </div>

        <div class="clinics-section__mobile clinics-section__mobile--redesign relative z-[1] site-padding pb-20 pt-16 lg:hidden">
            <div class="clinics-section__mobile-carousel-shell relative mx-auto">
                <div
                    id="home-clinics-carousel"
                    class="clinics-section__mobile-carousel flex snap-x snap-mandatory overflow-x-auto [-ms-overflow-style:none] [scrollbar-width:none] [&::-webkit-scrollbar]:hidden"
                    data-carousel
                    data-carousel-mobile-only="true"
                    data-carousel-loop="true"
                    data-scroll-gap="0"
                >
                    @foreach ($mobileClinics as $clinic)
                        <article class="clinics-section__mobile-slide relative min-w-full snap-start overflow-hidden">
                            <img
                                src="{{ asset('images/' . $clinic['image']) }}"
                                alt="ClÃ­nica Depiderme {{ $clinic['city'] }}"
                                class="block h-full w-full object-cover {{ $mobileObjectClasses[$clinic['city']] ?? 'object-center' }}"
                                loading="lazy"
                            >
                        </article>
                    @endforeach
                </div>

                <button type="button" class="{{ $navBtnClass }} clinics-section__mobile-nav clinics-section__mobile-nav--prev" data-carousel-prev="home-clinics-carousel" aria-label="ClÃ­nica anterior">
                    <svg class="clinics-section__mobile-arrow block" width="26" height="26" viewBox="0 0 26 26" fill="none" aria-hidden="true">
                        <path d="M11.55 5.9L4.45 13L11.55 20.1" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M5.1 13H22.3" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" />
                    </svg>
                </button>
                <button type="button" class="{{ $navBtnClass }} clinics-section__mobile-nav clinics-section__mobile-nav--next" data-carousel-next="home-clinics-carousel" aria-label="PrÃ³xima clÃ­nica">
                    <svg class="clinics-section__mobile-arrow block" width="26" height="26" viewBox="0 0 26 26" fill="none" aria-hidden="true">
                        <path d="M14.45 5.9L21.55 13L14.45 20.1" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M3.7 13H20.9" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" />
                    </svg>
                </button>
            </div>

            <div class="clinics-section__mobile-content">
                <h2 class="clinics-section__title {{ $sectionTitleClass }}">{{ content('home', 'clinics_teaser.title') }}</h2>

                <div class="clinics-section__divider mt-4 border-t border-[#9A9A9A]"></div>

                <ul class="clinics-section__list">
                    @foreach ($mobileClinics as $clinic)
                        @php
                            $phoneHref = preg_replace('/\D+/', '', $clinic['phone'] ?? '');
                            $mapHref = 'https://www.google.com/maps/search/?api=1&query=' . urlencode(($clinic['address'] ?? '') . ' ' . ($clinic['city'] ?? ''));
                        @endphp
                        <li class="clinics-section__item border-b border-[#9A9A9A]">
                            <details class="clinics-section__mobile-clinic" {{ $loop->first ? 'open' : '' }}>
                                <summary class="clinics-section__mobile-summary">
                                    <span class="min-w-0">
                                        <span class="clinics-section__city {{ $cityClass }}">{{ $clinic['city'] }}</span>
                                        <span class="clinics-section__address {{ $addressClass }}">{{ $clinic['address'] }}</span>
                                    </span>
                                    <span class="clinics-section__mobile-chevron" aria-hidden="true">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none">
                                            <path d="M4.5 7L9 11.5L13.5 7" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </span>
                                </summary>

                                <div class="clinics-section__actions flex">
                                    <a href="tel:{{ $phoneHref }}" class="{{ $contactClass }}">Phone</a>
                                    <a href="mailto:{{ $clinic['email'] ?? '' }}" class="{{ $contactClass }}">Email</a>
                                    <a href="{{ $mapHref }}" class="{{ $contactClass }}" target="_blank" rel="noopener">Map</a>
                                </div>
                            </details>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="clinics-section__mobile clinics-section__mobile--legacy relative z-[1] site-padding pb-20 pt-16 lg:hidden" data-scroll-laser-section>
            <div class="clinics-section__mobile-pill mx-auto flex h-12 max-w-[350px] items-center justify-center rounded-full bg-[linear-gradient(90deg,#8877C2_0%,#5B2B82_100%)] px-8 text-center font-sans text-base font-semibold leading-[130%] tracking-[-0.02em] text-white">
                Clínicas
            </div>

            <div class="clinics-section__mobile-grid mt-10 grid grid-cols-2 gap-x-5 gap-y-5">
                @foreach ($mobileClinics as $clinic)
                    <article class="clinics-section__mobile-card relative overflow-hidden rounded-[8px] bg-[#12081f] shadow-[0_16px_44px_rgba(0,0,0,0.32)]">
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

            <div class="clinics-section__mobile-laser pointer-events-none relative mt-2 h-[168px]" aria-hidden="true">
                <x-scroll-laser-beam
                    class="scroll-laser-beam--clinics-home-mobile"
                    data-scroll-laser-mode="section"
                />
            </div>
        </div>

        <div class="clinics-section__inner relative z-[1] hidden site-padding pb-12 pt-12 sm:pb-12 sm:pt-20 lg:block lg:px-0 lg:pb-16 lg:pt-20 lg:pl-[var(--site-gutter)]">
        <div class="clinics-section__layout relative z-[1] flex flex-col items-stretch gap-8 sm:gap-10 lg:flex-row lg:items-center lg:gap-[60px]">
            <div class="clinics-section__media relative w-full shrink-0 lg:w-auto lg:min-h-[820px]">
                <div
                    id="home-clinics-desktop-carousel"
                    class="clinics-section__desktop-carousel clinics-section__image flex h-[260px] w-full snap-x snap-mandatory overflow-x-auto rounded-2xl sm:h-[420px] sm:rounded-3xl md:max-lg:h-[480px] lg:h-[820px] lg:min-h-[820px] lg:w-auto lg:max-w-none lg:rounded-3xl [-ms-overflow-style:none] [scrollbar-width:none] [&::-webkit-scrollbar]:hidden"
                    data-carousel
                    data-carousel-loop="true"
                    data-scroll-gap="0"
                >
                    <article class="clinics-section__desktop-slide relative min-w-full snap-start overflow-hidden">
                        <img
                            src="{{ content_asset('home', 'clinics_teaser.image', 'images/clinics-store.png') }}"
                            alt="{{ content('home', 'clinics_teaser.image_alt') }}"
                            class="block h-full w-full object-cover"
                            loading="lazy"
                        >
                    </article>

                    @foreach ($mobileClinics as $clinic)
                        <article class="clinics-section__desktop-slide relative min-w-full snap-start overflow-hidden">
                            <img
                                src="{{ asset('images/' . $clinic['image']) }}"
                                alt="Clínica Depiderme {{ $clinic['city'] }}"
                                class="block h-full w-full object-cover {{ $mobileObjectClasses[$clinic['city']] ?? 'object-center' }}"
                                loading="lazy"
                            >
                        </article>
                    @endforeach
                </div>

                <div class="clinics-section__desktop-nav-wrap absolute hidden items-center sm:flex">
                    <button type="button" class="clinics-section__desktop-nav" data-carousel-prev="home-clinics-desktop-carousel" aria-label="Clínica anterior">
                        <svg class="block" width="24" height="24" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <rect x="0.75" y="0.75" width="22.5" height="22.5" stroke="#231F20" stroke-width="1.5" />
                            <path d="M10 7L5 12L10 17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M6 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                        </svg>
                    </button>
                    <button type="button" class="clinics-section__desktop-nav" data-carousel-next="home-clinics-desktop-carousel" aria-label="Próxima clínica">
                        <svg class="block" width="24" height="24" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <rect x="0.75" y="0.75" width="22.5" height="22.5" stroke="#231F20" stroke-width="1.5" />
                            <path d="M14 7L19 12L14 17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M5 12H18" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="clinics-section__content min-w-0 flex-1 lg:pr-[140px]">
                <h2 class="clinics-section__title {{ $sectionTitleClass }}">{{ content('home', 'clinics_teaser.title') }}</h2>

                <div class="clinics-section__divider mt-4 border-t border-[#9A9A9A] sm:mt-5"></div>

                <ul class="clinics-section__list">
                    @foreach ($clinics as $clinic)
                        <li class="clinics-section__item border-b border-[#9A9A9A] py-5 sm:py-6">
                            <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                                <div>
                                    <p class="clinics-section__city {{ $cityClass }}">{{ $clinic['city'] }}</p>
                                    <p class="clinics-section__address {{ $addressClass }} mt-2 sm:mt-3">{{ $clinic['address'] }}</p>
                                </div>

                                <div class="clinics-section__actions flex shrink-0 flex-wrap gap-2 sm:gap-2">
                                    <a href="#" class="{{ $contactClass }}">Phone</a>
                                    <a href="#" class="{{ $contactClass }}">Email</a>
                                    <a href="#" class="{{ $contactClass }}">Map</a>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        </div>
    </div>
</section>
