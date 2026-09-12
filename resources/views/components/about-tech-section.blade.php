@php
    $sectionPadding = 'site-padding';

    $items = content('about', 'tech.items');
    $title = trim((string) content('about', 'tech.title'));

    if (preg_match('/^Tecnologia\s+e\s+equipamentos$/iu', $title) === 1) {
        $title = "Tecnologia\ne equipamentos";
    }
@endphp

<section class="about-tech-section relative z-20 bg-white pt-5 pb-[200px]" data-scroll-laser-section aria-label="Tecnologia e equipamentos">
    <div class="{{ $sectionPadding }}">
        <h2 class="about-tech-section__title max-w-[628px] font-sans text-[40px] font-medium leading-[110%] tracking-[-0.02em] text-[#231f20] sm:text-[48px] lg:text-[60px]">
            {!! nl_to_br($title) !!}
        </h2>

        <a
            href="#"
            class="about-tech-section__button mt-[25px] inline-flex items-center justify-center gap-2.5 rounded-full px-5 py-[15px] font-sans text-sm font-semibold capitalize leading-[18px] tracking-[-0.02em] text-white no-underline"
        >
            {{ content('about', 'tech.button') }}
        </a>

        <div class="about-tech-section__items mt-16 grid grid-cols-1 gap-12 sm:mt-20 lg:mt-24 lg:grid-cols-3 lg:gap-0">
            @foreach ($items as $index => $item)
                <article @class([
                    'about-tech-section__item flex flex-col gap-[15px]',
                    'lg:pr-10' => $index === 0,
                    'lg:border-l-[0.5px] lg:border-[#E1C7F9] lg:px-10' => $index === 1,
                    'lg:border-l-[0.5px] lg:border-[#E1C7F9] lg:pl-10' => $index === 2,
                ])>
                    <img
                        src="{{ asset('images/' . $item['icon']) }}"
                        alt=""
                        width="61"
                        height="61"
                        class="size-[61px] shrink-0 object-contain"
                        loading="lazy"
                    >

                    <h3 class="about-tech-section__item-title font-sans text-[24px] font-medium leading-[120%] tracking-[-0.02em] text-[#231f20] sm:text-[28px] lg:text-[30px]">
                        {{ $item['title'] }}
                    </h3>

                    <p class="font-body text-base font-normal leading-[130%] tracking-[-0.02em] text-[#545462]">
                        {{ $item['description'] }}
                    </p>
                </article>
            @endforeach
        </div>

        <x-scroll-laser-beam
            class="scroll-laser-beam--about-tech-mobile lg:hidden"
            data-scroll-laser-mode="section"
            data-scroll-laser-speed="1.65"
            data-scroll-laser-min-scale="0.85"
            data-scroll-laser-min-opacity="0.9"
        />
    </div>
</section>
