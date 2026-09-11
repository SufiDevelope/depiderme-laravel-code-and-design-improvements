@php
    $sectionPadding = 'site-padding';

    $faqToggleClass = 'mt-1 flex size-8 shrink-0 items-center justify-center rounded-full border border-[#e1c7f9] bg-transparent text-[#e1c7f9]';

    $faqs = content('technology', 'faq.items');
@endphp

<section class="technology-faq-section relative z-20 overflow-x-clip rounded-tr-[40px] bg-[#000010] py-12 sm:py-16 lg:rounded-tr-[80px] lg:py-24" aria-label="Perguntas frequentes">
    <div class="{{ $sectionPadding }}">
        <div class="grid grid-cols-1 gap-10 lg:grid-cols-[minmax(240px,360px)_minmax(0,1fr)] lg:gap-16 xl:gap-24">
            <h2 class="tech-faq-title font-sans text-[40px] font-medium leading-[110%] tracking-[-0.02em] text-[#8877C2] sm:text-[48px] lg:text-[60px]">
                {!! nl_to_br(content('technology', 'faq.title')) !!}
            </h2>

            <div class="tech-faq-accordion flex flex-col" data-faq-accordion data-faq-scroll-open itemscope itemtype="https://schema.org/FAQPage">
                @foreach ($faqs as $faq)
                    @php($isOpen = $loop->first)
                    <div class="border-b border-[#e1c7f9]" data-faq-item itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
                        <button
                            type="button"
                            class="flex w-full cursor-pointer items-start justify-between gap-4 py-5 text-left lg:py-6"
                            data-faq-toggle
                            aria-expanded="{{ $isOpen ? 'true' : 'false' }}"
                        >
                            <span class="tech-faq-question-static min-w-0 flex-1 font-sans text-2xl font-medium leading-[130%] tracking-[-0.02em] text-[#e1c7f9] lg:text-[30px]" itemprop="name">
                                {{ $faq['question'] }}
                            </span>
                            <span class="{{ $faqToggleClass }}" data-faq-icon aria-hidden="true">
                                <svg class="block {{ $isOpen ? 'rotate-180' : '' }}" data-faq-chevron width="12" height="12" viewBox="0 0 12 12" fill="none">
                                    <path d="M2.5 4.5L6 8L9.5 4.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </span>
                        </button>

                        <div
                            class="overflow-hidden {{ $isOpen ? 'max-h-[400px]' : 'max-h-0' }}"
                            data-faq-panel
                            aria-hidden="{{ $isOpen ? 'false' : 'true' }}"
                            itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer"
                        >
                            <div class="flex flex-col gap-4 pb-5 lg:pb-6" itemprop="text">
                                @foreach ($faq['answer'] as $paragraph)
                                    <p class="max-w-[640px] font-body text-base font-normal leading-[130%] tracking-[-0.02em] text-[#FFFFFFB3]">
                                        {{ $paragraph }}
                                    </p>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
