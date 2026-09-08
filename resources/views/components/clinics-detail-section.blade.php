@props(['clinics'])

@php
    $sectionPadding = 'site-padding';
    $navBtnClass = 'clinics-detail__nav-button absolute top-1/2 z-[3] flex -translate-y-1/2 cursor-pointer items-center justify-center rounded-full border bg-white text-[#5B2B82] transition-opacity hover:opacity-90';
    $labelClass = 'font-body text-sm font-normal leading-[130%] tracking-[-0.02em] text-[#E1C7F9]';
    $cityClass = 'font-sans text-[36px] font-medium leading-[110%] tracking-[-0.02em] text-white lg:text-[48px]';
    $valueClass = 'font-body text-base font-semibold leading-[130%] tracking-[-0.02em] text-white';
    $dotClass = 'size-2 cursor-pointer rounded-full border-0 bg-white/45 p-0 transition-[background,transform] duration-200';
@endphp

<div
    class="clinics-detail-section relative overflow-x-clip rounded-tl-[60px] bg-black pb-12 max-lg:rounded-none sm:rounded-tl-[80px] sm:pb-16 lg:rounded-tl-[120px] lg:pb-20"
    data-section-rise
    data-clinics-detail-gradient
    data-section-rise-max="0">
    <div class="pointer-events-none absolute inset-0 z-0 rounded-tl-[inherit] bg-black" aria-hidden="true">
    </div>

    <div class="clinics-detail__glow pointer-events-none absolute inset-0 z-[1] overflow-hidden rounded-tl-[inherit]" data-live-gradient-pseudo="before" aria-hidden="true">
        <span class="clinics-detail__glow-ellipse"></span>
    </div>

    <section class="clinics-detail__content-section relative z-10 py-12 pb-20 sm:py-16 sm:pb-24 lg:py-24 lg:pb-32" aria-label="Detalhes das clínicas">
        <nav class="clinics-detail__mobile-nav grid lg:hidden" aria-label="Escolher clínica">
            @foreach ($clinics as $clinic)
                <a href="#clinica-{{ strtolower(str_replace(' ', '-', $clinic['city'])) }}">{{ $clinic['city'] }}</a>
            @endforeach
        </nav>

        <div class="clinics-detail__list {{ $sectionPadding }} flex flex-col gap-14 sm:gap-16 lg:gap-20">
            @foreach ($clinics as $index => $clinic)
                <article id="clinica-{{ strtolower(str_replace(' ', '-', $clinic['city'])) }}"
                    class="relative z-[2] scroll-mt-24 sm:scroll-mt-28">
                    <div
                        class="clinics-detail__article-grid grid grid-cols-1 items-center gap-8 sm:gap-10 lg:grid-cols-[minmax(260px,360px)_minmax(0,1fr)] lg:gap-16 xl:gap-20">
                        <div class="min-w-0">
                            <h2 class="{{ $cityClass }}">{{ $clinic['city'] }}</h2>

                            <div class="clinics-detail__contact-list mt-6 flex flex-col gap-5 sm:mt-8 sm:gap-6 lg:mt-10 lg:gap-8">
                                <div>
                                    <div class="clinics-detail__label-row mb-2 flex items-center gap-2">
                                        <svg class="shrink-0 text-[#E1C7F9]" width="16" height="16" viewBox="0 0 16 16"
                                            fill="none" aria-hidden="true">
                                            <path
                                                d="M8 1.5C5.51472 1.5 3.5 3.51472 3.5 6C3.5 9.5 8 14.5 8 14.5C8 14.5 12.5 9.5 12.5 6C12.5 3.51472 10.4853 1.5 8 1.5Z"
                                                stroke="currentColor" stroke-width="1.25" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <circle cx="8" cy="6" r="1.75" stroke="currentColor" stroke-width="1.25" />
                                        </svg>
                                        <span class="{{ $labelClass }}">Address</span>
                                    </div>
                                    <p class="clinics-detail__value clinics-detail__value--address {{ $valueClass }}">
                                        @foreach (($clinic['detail_address_lines'] ?? [$clinic['address']]) as $lineIndex => $line)
                                            {{ $line }}@if ($lineIndex < count($clinic['detail_address_lines'] ?? [$clinic['address']]) - 1)<br>@endif
                                        @endforeach
                                    </p>
                                </div>

                                <div>
                                    <div class="clinics-detail__label-row mb-2 flex items-center gap-2">
                                        <svg class="shrink-0 text-[#E1C7F9]" width="16" height="16" viewBox="0 0 16 16"
                                            fill="none" aria-hidden="true">
                                            <path
                                                d="M3.5 2.5H5.5L6.5 5.5L5 6.5C5.66667 8.16667 7.33333 9.83333 9 10.5L10 9L13 10V12C13 12.5523 12.5523 13 12 13C6.75329 13 2.5 8.74671 2.5 3.5C2.5 2.94772 2.94772 2.5 3.5 2.5Z"
                                                stroke="currentColor" stroke-width="1.25" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                        <span class="{{ $labelClass }}">Telefone</span>
                                    </div>
                                    <p class="clinics-detail__value {{ $valueClass }}">{{ $clinic['phone'] }}</p>
                                </div>

                                <div>
                                    <div class="clinics-detail__label-row mb-2 flex items-center gap-2">
                                        <svg class="shrink-0 text-[#E1C7F9]" width="16" height="16" viewBox="0 0 16 16"
                                            fill="none" aria-hidden="true">
                                            <path
                                                d="M2.5 4.5L8 8.5L13.5 4.5M3.5 12.5H12.5C13.0523 12.5 13.5 12.0523 13.5 11.5V4.5C13.5 3.94772 13.0523 3.5 12.5 3.5H3.5C2.94772 3.5 2.5 3.94772 2.5 4.5V11.5C2.5 12.0523 2.94772 12.5 3.5 12.5Z"
                                                stroke="currentColor" stroke-width="1.25" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                        <span class="{{ $labelClass }}">Email</span>
                                    </div>
                                    <p class="clinics-detail__value {{ $valueClass }}">{{ $clinic['email'] }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="clinics-detail__gallery relative z-[2] h-[clamp(280px,78vw,420px)] isolate overflow-hidden rounded-2xl bg-black lg:h-[700px] lg:rounded-[20px]" data-clinic-carousel>
                            <div class="clinics-detail__gallery-glow" aria-hidden="true"></div>

                            <div class="relative z-[1] h-full w-full">
                                @foreach ($clinic['gallery'] as $slideIndex => $image)
                                    <img src="{{ asset('images/' . $image) }}"
                                        alt="Clínica Depiderme {{ $clinic['city'] }} — foto {{ $slideIndex + 1 }}"
                                        class="clinics-detail__slide {{ $slideIndex === 0 ? 'is-active' : '' }}"
                                        data-clinic-slide loading="{{ $index === 0 && $slideIndex === 0 ? 'eager' : 'lazy' }}">
                                @endforeach
                            </div>

                            @if (count($clinic['gallery']) > 1)
                                <button type="button" class="{{ $navBtnClass }} left-3 sm:left-4" data-clinic-prev
                                    aria-label="Foto anterior">
                                    <svg class="block" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        aria-hidden="true">
                                        <path d="M15 5L8 12L15 19" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </button>

                                <button type="button" class="{{ $navBtnClass }} right-3 sm:right-4" data-clinic-next
                                    aria-label="Próxima foto">
                                    <svg class="block" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        aria-hidden="true">
                                        <path d="M9 5L16 12L9 19" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </button>

                                <div class="absolute bottom-4 left-1/2 z-[3] hidden -translate-x-1/2 gap-2 sm:bottom-5 sm:flex" data-clinic-dots>
                                    @foreach ($clinic['gallery'] as $slideIndex => $image)
                                        <button type="button" class="{{ $dotClass }} clinics-detail__dot {{ $slideIndex === 0 ? 'is-active' : '' }}"
                                            data-clinic-dot="{{ $slideIndex }}"
                                            aria-label="Ir para foto {{ $slideIndex + 1 }}"></button>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </section>

    {{-- <div class="pointer-events-none absolute inset-x-0 bottom-0 z-0 h-0 overflow-visible" aria-hidden="true">
        <img src="{{ asset('images/laser-line.png') }}" alt=""
            class="absolute -bottom-5 left-1/2 block h-auto w-screen min-w-screen max-w-none -translate-x-1/2 lg:-bottom-24"
            loading="lazy">
    </div> --}}
</div>
