@php
    $sectionPadding = 'site-padding';

    $toggleBtnClass = 'pricing-gender-toggle min-w-0 flex-1 basis-0 cursor-pointer border-0 bg-white px-5 py-2.5 font-sans text-base font-medium leading-[130%] tracking-[-0.02em] text-[#5B2B82] transition-[background,color] duration-200 aria-pressed:text-white lg:h-full lg:min-w-0 lg:px-0 lg:py-0';
    $headingClass = 'font-sans text-[35px] font-medium leading-[39px] tracking-[-0.02em] text-[#231f20] sm:text-[40px] sm:leading-[110%] lg:text-[60px]';
    $sectionTitleClass = 'font-sans text-2xl font-medium leading-[120%] tracking-[-0.02em] bg-gradient-to-r from-[#8877C2] to-[#5B2B82] bg-clip-text text-transparent lg:text-[30px]';
    $rowClass = 'pricing-table__row flex items-baseline justify-between gap-6 border-b border-[#e5e5e5] py-3.5 font-body text-base font-normal leading-[130%] tracking-[-0.02em] text-[#231f20] lg:h-[61px] lg:items-center lg:py-0';

    $pricingData = content('pricing', 'table.data');
@endphp

<section class="pricing-content-section relative z-20 overflow-x-clip rounded-tl-[40px] bg-white lg:rounded-tl-[80px]" data-section-rise data-section-rise-max="126" aria-label="Tabela de preços">
    <div class="{{ $sectionPadding }} pb-16 pt-10 sm:pb-20 lg:pb-[140px] lg:pt-[156px]" data-pricing-table>
        <div class="mx-auto w-full max-w-[1000px] lg:max-w-[971px]">
            <div class="flex justify-end pb-8 max-lg:justify-center lg:pb-[39px]">
                <div class="inline-flex h-12 w-full max-w-[350px] overflow-hidden rounded-lg border border-[#5B2B82] [&>button+button]:border-l [&>button+button]:border-[#5B2B82] lg:w-[201px] lg:max-w-none" role="group" aria-label="Selecionar género">
                    @foreach (['mulher' => 'Mulher', 'homem' => 'Homem'] as $key => $label)
                        <button
                            type="button"
                            class="{{ $toggleBtnClass }}"
                            data-pricing-toggle="{{ $key }}"
                            aria-pressed="{{ $key === 'mulher' ? 'true' : 'false' }}"
                        >
                            {{ $label }}
                        </button>
                    @endforeach
                </div>
            </div>

            @foreach ($pricingData as $key => $gender)
                <div
                    class="{{ $key === 'mulher' ? '' : 'hidden' }}"
                    data-pricing-panel="{{ $key }}"
                >
                    <h2 class="{{ $headingClass }} lg:-ml-[3px] lg:w-[628px]">{{ $gender['label'] }}</h2>

                    <div class="mt-6 h-px bg-[#e5e5e5] lg:mt-[33px]" aria-hidden="true"></div>

                    <div class="mt-10 flex flex-col gap-12 lg:mt-[32px] lg:gap-0">
                        @foreach ($gender['sections'] as $section)
                            <div @class([
                                'lg:mt-[99px]' => $loop->index === 1,
                                'lg:mt-[135px]' => $loop->index === 2,
                            ])>
                                <h3 class="{{ $sectionTitleClass }} mb-6 lg:mb-[33px]">{{ $section['title'] }}</h3>

                                <div class="[&>:first-child]:border-t [&>:first-child]:border-[#e5e5e5]">
                                    @foreach ($section['items'] as $item)
                                        <div class="{{ $rowClass }}">
                                            <span>{{ $item['name'] }}</span>
                                            <span class="shrink-0 tabular-nums">{{ $item['price'] }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
