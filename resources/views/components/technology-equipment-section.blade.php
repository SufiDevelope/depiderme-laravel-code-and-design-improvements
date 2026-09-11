@php
    $sectionPadding = 'site-padding';

    $gallery = collect(content('technology', 'equipment.gallery'))
        ->concat([
            ['image' => 'experience-card-1.png', 'alt' => 'Consulta Depiderme com tecnologia laser'],
            ['image' => 'experience-card-2.png', 'alt' => 'Aplicação laser Depiderme'],
            ['image' => 'about-space-3.png', 'alt' => 'Sala de tratamento Depiderme'],
        ])
        ->unique('image')
        ->values()
        ->all();

    $navBtnClass = 'technology-equipment__nav-button flex size-8 shrink-0 cursor-pointer items-center justify-center rounded-full border border-[#5B2B82] bg-transparent text-[#5B2B82]';
@endphp

<section class="technology-equipment-section bg-white py-16 lg:py-24" aria-label="Tecnologia">
    <div class="{{ $sectionPadding }}">
        <h2 class="technology-equipment-section__title font-sans text-[48px] font-semibold leading-[110%] tracking-[-0.02em] text-[#231f20] sm:text-[72px] lg:text-[140px]">
            {{ content('technology', 'equipment.title') }}
        </h2>

        <div class="mt-8 h-px w-full bg-[#E1C7F9]/60 lg:mt-10"></div>

        <div class="mt-10 grid grid-cols-1 gap-8 lg:mt-14 lg:grid-cols-2 lg:gap-16 xl:gap-24">
            <p class="max-w-[560px] font-sans text-xl font-medium leading-[120%] tracking-[-0.02em] text-[#231f20] sm:text-2xl lg:text-[30px]">
                {{ content('technology', 'equipment.intro') }}
            </p>

            <div>
                <div class="flex max-w-[640px] flex-col gap-4">
                    <p class="font-sans text-base font-medium leading-[140%] tracking-[-0.02em] text-[#545462] lg:text-[20px]">
                        {{ content('technology', 'equipment.paragraph_1') }}
                    </p>
                    <p class="font-sans text-base font-medium leading-[140%] tracking-[-0.02em] text-[#545462] lg:text-[20px]">
                        {{ content('technology', 'equipment.paragraph_2') }}
                    </p>
                </div>

                <img
                    src="{{ content_asset('technology', 'equipment.cert_image', 'images/tech-cert-logos.png') }}"
                    alt="{{ content('technology', 'equipment.cert_alt') }}"
                    class="technology-equipment__cert mt-8 block h-auto w-auto max-w-[280px] sm:max-w-[320px]"
                    loading="lazy"
                >
            </div>
        </div>

        <div class="mt-12 lg:mt-16">
            <div class="max-lg:-site-gutter-x">
                <div
                    id="tech-equipment-carousel"
                    data-carousel
                    data-carousel-loop="true"
                    data-carousel-tap="next"
                    class="tech-equipment-carousel flex snap-x snap-mandatory gap-[30px] overflow-x-auto pb-2 [-ms-overflow-style:none] [scrollbar-width:none] [&::-webkit-scrollbar]:hidden"
                >
                    @foreach ($gallery as $item)
                        <article class="technology-equipment__mobile-card relative h-[420px] w-[280px] max-w-[78vw] shrink-0 snap-start overflow-hidden sm:h-[520px] sm:w-[320px]">
                            <img
                                src="{{ asset('images/' . $item['image']) }}"
                                alt="{{ $item['alt'] }}"
                                class="technology-equipment__mobile-image block h-full w-full object-cover object-center"
                                loading="lazy"
                                draggable="false"
                            >
                        </article>
                    @endforeach
                </div>
            </div>

            <div class="technology-equipment__mobile-controls mt-10 flex items-center gap-3">
                <button type="button" class="{{ $navBtnClass }}" data-carousel-prev="tech-equipment-carousel" aria-label="Imagem anterior">
                    <svg class="block" width="20" height="26" viewBox="0 0 20 26" fill="none" aria-hidden="true">
                        <path d="M18 13H2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M9.5 21L2 13L9.5 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
                <button type="button" class="{{ $navBtnClass }} lg:hidden" data-carousel-next="tech-equipment-carousel" aria-label="Próxima imagem">
                    <svg class="block" width="20" height="26" viewBox="0 0 20 26" fill="none" aria-hidden="true">
                        <path d="M2 13H18" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M10.5 5L18 13L10.5 21" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
                <span class="technology-equipment__mobile-progress ml-2 hidden h-px w-[120px]" data-carousel-progress="tech-equipment-carousel" aria-hidden="true"></span>
            </div>
        </div>
    </div>
</section>
