@php
    $sectionPadding = 'site-padding';

    $cards = content('home', 'experience.cards');
    $clinicSlides = content('clinics', 'clinics.list', require config_path('cms/data/clinics.php'));
    $clinicSlides = is_array($clinicSlides) ? $clinicSlides : [];

    $cardTitleClass = 'font-sans text-[32px] font-medium leading-[110%] tracking-[-0.02em] text-black sm:text-[40px] md:text-[48px] lg:text-[60px]';
    $cardTextClass = 'font-body text-[16px] font-normal leading-[130%] tracking-[-0.02em] text-[#545462]';
    $cardMediaClass = 'h-[220px] min-h-[220px] max-h-[220px] overflow-hidden rounded-2xl sm:h-[320px] sm:min-h-[320px] sm:max-h-[320px] md:h-[380px] md:min-h-[380px] md:max-h-[380px] lg:h-[550px] lg:min-h-[550px] lg:max-h-none';
    $mobileNavButtonClass = 'experience-carousel__nav-button inline-flex size-[42px] shrink-0 cursor-pointer items-center justify-center rounded-full border border-black bg-[linear-gradient(180deg,#5B2B82_0%,#8A72AF_100%)] text-white';
@endphp

<section
    class="experience-section relative overflow-x-clip rounded-tr-[40px] bg-[#000010] lg:rounded-tr-[80px]"
    data-scroll-laser-section
    aria-label="Experiência Depiderme"
>
    <div class="experience-section__inner {{ $sectionPadding }} pb-12 pt-12 sm:pb-16 sm:pt-16 lg:pb-28 lg:pt-[88px]">
        <h2 class="experience-section__title">
            {{ content('home', 'experience.title') }}
        </h2>

        <x-scroll-laser-beam
            class="scroll-laser-beam--experience"
            data-scroll-laser-items=".experience-card"
            data-scroll-laser-mode="cumulative-items"
        />

        <div class="experience-carousel__shell relative mt-10 sm:mt-12 lg:mt-16">
        <div
            id="home-experience-carousel"
            class="experience-section__cards relative flex flex-col gap-16 sm:gap-20 lg:gap-[100px]"
            data-carousel
            data-carousel-mobile-only="true"
            data-carousel-loop="true"
            data-scroll-gap="15"
        >
            @foreach ($cards as $card)
                @php
                    $clinicSlide = $clinicSlides[$loop->index % max(count($clinicSlides), 1)] ?? null;
                    $mediaImage = $clinicSlide['image'] ?? $card['image'];
                    $mediaAlt = isset($clinicSlide['city'])
                        ? 'ClÃ­nica Depiderme ' . $clinicSlide['city']
                        : $card['image_alt'];
                @endphp
                <article
                    class="home-stack-panel experience-card relative grid min-h-0 grid-cols-1 gap-6 rounded-2xl bg-[#f2f2f2] p-6 sm:gap-8 sm:rounded-3xl sm:p-8 lg:min-h-[630px] lg:grid-cols-2 lg:items-center lg:gap-20 lg:p-12"
                    data-home-stack-panel
                    data-home-stack-card
                >
                    <div class="experience-card__content flex flex-col items-start">
                        <h3 class="experience-card__title {{ $cardTitleClass }}">
                            @foreach ($card['title_lines'] as $line)
                                <span class="experience-card__title-line">{{ $line }}</span>@if (! $loop->last)<br class="experience-card__title-break">@endif
                            @endforeach
                        </h3>

                        <div class="experience-card__copy mt-6 flex flex-col gap-4">
                            @foreach ($card['paragraphs'] as $paragraph)
                                <p class="{{ $cardTextClass }}">{{ $paragraph }}</p>
                            @endforeach
                        </div>

                        <a
                            href="#"
                            class="experience-card__button mt-6 inline-flex min-w-[142px] items-center justify-center gap-2.5 rounded-full bg-[#271841] px-5 py-3 font-sans text-sm font-semibold leading-[18px] tracking-[-0.02em] text-white no-underline sm:mt-8 sm:py-[15px]"
                        >
                            {{ $card['button'] }}
                        </a>
                    </div>

                    <div class="experience-card__media {{ $cardMediaClass }}">
                        <img
                            src="{{ asset('images/' . $mediaImage) }}"
                            alt="{{ $mediaAlt }}"
                            class="block h-full w-full object-cover"
                            loading="lazy"
                        >
                    </div>
                </article>
            @endforeach
        </div>

        <div class="experience-carousel__mobile-nav hidden items-center justify-between gap-[14px] lg:hidden">
            <button type="button" class="{{ $mobileNavButtonClass }}" data-carousel-prev="home-experience-carousel" aria-label="CartÃ£o anterior">
                <svg class="block" width="24" height="24" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path d="M9 6L3 12L9 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M4 12H23" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                </svg>
            </button>
            <button type="button" class="{{ $mobileNavButtonClass }}" data-carousel-next="home-experience-carousel" aria-label="PrÃ³ximo cartÃ£o">
                <svg class="block" width="24" height="24" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path d="M15 6L21 12L15 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M1 12H20" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                </svg>
            </button>
            <span class="about-spaces-carousel-progress ml-1 h-px w-[120px]" data-carousel-progress="home-experience-carousel" aria-hidden="true"></span>
        </div>
        </div>
    </div>
</section>
