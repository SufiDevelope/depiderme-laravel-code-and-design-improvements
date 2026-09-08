@php
    $sectionPadding = 'site-padding';

    $packRows = content('home', 'packs.rows');

    $pillClass = 'packs-pill inline-flex shrink-0 items-center gap-2 rounded-full border border-black bg-white py-2 pl-3 pr-2.5 sm:gap-3 sm:py-3 sm:pl-6 sm:pr-4';
    $pillLabelClass = 'font-sans text-base font-medium leading-[110%] tracking-[-0.02em] text-[#5B2B82] max-sm:max-w-[11rem] max-sm:whitespace-normal sm:text-[18px] sm:whitespace-nowrap lg:text-[28px]';
    $pillPriceClass = 'flex size-[40px] shrink-0 items-center justify-center rounded-full bg-black font-sans text-sm font-bold leading-[110%] tracking-[-0.02em] text-white sm:size-[48px] sm:text-lg lg:size-[53px]';
    $headerClass = 'grid min-w-0 grid-cols-1 gap-[24px] sm:gap-[32px] md:gap-[48px] lg:grid-cols-[auto_minmax(0,1fr)] lg:gap-[140px]';
    $titleClass = 'font-sans text-[40px] font-medium leading-[110%] tracking-[-0.02em] text-black sm:text-[56px] sm:leading-[88px] md:text-[64px] md:leading-[110%] lg:text-[80px] lg:leading-[88px]';
    $textClass = 'font-body text-[16px] font-normal leading-[130%] tracking-[-0.02em] text-black';
    $linkClass = 'mt-4 inline-flex items-center gap-2 font-body text-[16px] font-bold leading-[130%] tracking-[-0.02em] text-black no-underline transition-opacity hover:opacity-70';
    $pillImageClass = 'packs-image-pill inline-flex h-[52px] shrink-0 overflow-hidden rounded-full sm:h-[68px] lg:h-[77px]';
@endphp

<div class="packs-section relative z-10 overflow-x-clip bg-white pb-[140px]" aria-label="Packs promocionais">
    <div class="packs-section__inner {{ $sectionPadding }} border-t border-[#E1C7F9] pt-8 sm:pt-12 lg:pt-16">
        <div class="packs-section__header {{ $headerClass }}">
            <h2 class="packs-section__title {{ $titleClass }}">
                <span class="packs-section__title-mobile">{{ str_replace("\n", ' ', content('home', 'packs.title')) }}</span>
                <span class="packs-section__title-desktop">{!! nl_to_br(content('home', 'packs.title')) !!}</span>
            </h2>

            <div class="packs-section__intro max-w-[400px]">
                <p class="{{ $textClass }}">
                    {{ content('home', 'packs.description') }}
                </p>

                <a href="{{ url('/pricing') }}" class="packs-section__link {{ $linkClass }}">
                    {{ content('home', 'packs.link_text') }}
                    <span aria-hidden="true">→</span>
                </a>
            </div>
        </div>
    </div>

    <div class="packs-marquees mt-10 flex flex-col gap-3 sm:mt-16 sm:gap-4 lg:mt-[120px]">
        @foreach ($packRows as $index => $row)
            <div @class([
                'packs-marquee',
                'packs-marquee--left' => $index === 0,
                'packs-marquee--right' => $index === 1,
            ])>
                <div class="packs-marquee__track">
                    @for ($copy = 0; $copy < 4; $copy++)
                        <div class="packs-marquee__group" @if ($copy > 0) aria-hidden="true" @endif>
                            @foreach ($row as $pack)
                                @if ($pack['type'] === 'text')
                                    <div class="{{ $pillClass }}">
                                        <span class="{{ $pillLabelClass }}">{{ $pack['label'] }}</span>
                                        <span class="{{ $pillPriceClass }}">{{ $pack['price'] }}</span>
                                    </div>
                                @else
                                    <div class="{{ $pillImageClass }} {{ $pack['widthClass'] }}">
                                        <img
                                            src="{{ asset('images/' . $pack['image']) }}"
                                            alt="{{ $pack['alt'] }}"
                                            class="block h-full w-full object-cover"
                                            loading="lazy"
                                        >
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endfor
                </div>
            </div>
        @endforeach
    </div>
</div>
