@props(['clinics'])

@php
    $sectionPadding = 'site-padding';
    $clinicObjectClasses = [
        'Leiria' => 'object-[54%_center]',
        'Coimbra' => 'object-[62%_center]',
        'Viseu' => 'object-[58%_center]',
        'Vila Real' => 'object-center',
        'Porto' => 'object-[58%_center]',
    ];

    $cardLabelClass = 'font-sans text-sm font-medium leading-[130%] tracking-[-0.02em] text-[#8877C2]';
    $cardValueClass = 'font-body text-base font-semibold leading-[130%] tracking-[-0.02em] text-[#231f20]';
    $badgeClass = 'absolute left-3 top-3 z-[3] rounded-md bg-gradient-to-r from-[#8877C2] to-[#5B2B82] px-2.5 py-[5px] font-sans text-[13px] font-medium leading-[130%] tracking-[-0.02em] text-white sm:left-4 sm:top-4 sm:px-3 sm:py-1.5 sm:text-sm';
    $cardClass = 'absolute inset-x-3 bottom-3 max-w-none rounded-2xl bg-white p-4 shadow-[0_12px_40px_rgba(35,31,32,0.12)] sm:inset-x-auto sm:bottom-5 sm:left-5 sm:max-w-[calc(100%-40px)] sm:p-5 sm:px-6 lg:bottom-7 lg:left-7 lg:max-w-[320px] lg:p-6 lg:px-7';
@endphp

<section class="clinics-page-hero-section relative hidden overflow-x-clip bg-white pb-0 pt-28 sm:pt-32 lg:block lg:pt-36" data-scroll-laser-section aria-label="As nossas clínicas">
    <div class="{{ $sectionPadding }} relative z-10">
        <h1 class="clinics-page__title mx-auto max-w-[920px] text-center font-sans text-[36px] font-medium leading-[110%] tracking-[-0.02em] text-[#231f20] lg:w-[901px] lg:max-w-[901px] lg:text-[60px] lg:tracking-[-0.03em]">
            O caminho para uma pele<br>perfeita <span class="inline-block bg-gradient-to-r from-[#8877C2] to-[#5B2B82] bg-clip-text text-transparent">{{ content('clinics', 'hero.title_highlight') }}</span>
        </h1>

        <div class="mt-10 sm:mt-12 lg:mt-16">
            <div class="-site-gutter-x scroll-p-site overflow-x-auto site-padding pb-1 [-webkit-overflow-scrolling:touch] [scrollbar-width:none] max-lg:snap-x max-lg:snap-mandatory [&::-webkit-scrollbar]:hidden lg:mx-0 lg:overflow-x-visible lg:px-0 lg:pb-0">
                <div class="clinics-accordion w-max min-w-full lg:w-full lg:min-w-0" data-clinics-accordion>
                    @foreach ($clinics as $index => $clinic)
                        <button
                            type="button"
                            class="clinics-accordion__item group {{ $index === 0 ? 'is-expanded' : '' }}"
                            data-clinic-item
                            data-clinic-index="{{ $index }}"
                            aria-expanded="{{ $index === 0 ? 'true' : 'false' }}"
                        >
                            <span class="{{ $badgeClass }}">{{ $clinic['city'] }}</span>

                            <div class="clinics-accordion__glow" aria-hidden="true"></div>

                            <img
                                src="{{ asset('images/' . $clinic['image']) }}"
                                alt="Clínica Depiderme {{ $clinic['city'] }}"
                                class="absolute inset-0 z-[1] block h-full w-full object-cover {{ $clinicObjectClasses[$clinic['city']] ?? 'object-center' }}"
                                loading="{{ $index === 0 ? 'eager' : 'lazy' }}"
                            >

                            <div class="absolute inset-0 z-[2] opacity-0 pointer-events-none transition-opacity duration-300 group-[.is-expanded]:opacity-100 group-[.is-expanded]:pointer-events-auto" data-clinic-panel aria-hidden="{{ $index === 0 ? 'false' : 'true' }}">
                                <div class="{{ $cardClass }}">
                                    <div class="flex flex-col gap-4 sm:gap-5">
                                        <div>
                                            <div class="mb-1.5 flex items-center gap-2">
                                                <svg class="shrink-0 text-[#8877C2]" width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                                                    <path d="M8 1.5C5.51472 1.5 3.5 3.51472 3.5 6C3.5 9.5 8 14.5 8 14.5C8 14.5 12.5 9.5 12.5 6C12.5 3.51472 10.4853 1.5 8 1.5Z" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" />
                                                    <circle cx="8" cy="6" r="1.75" stroke="currentColor" stroke-width="1.25" />
                                                </svg>
                                                <span class="{{ $cardLabelClass }}">Address</span>
                                            </div>
                                            <p class="{{ $cardValueClass }}">{{ $clinic['address'] }}</p>
                                        </div>

                                        <div>
                                            <div class="mb-1.5 flex items-center gap-2">
                                                <svg class="shrink-0 text-[#8877C2]" width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                                                    <path d="M3.5 2.5H5.5L6.5 5.5L5 6.5C5.66667 8.16667 7.33333 9.83333 9 10.5L10 9L13 10V12C13 12.5523 12.5523 13 12 13C6.75329 13 2.5 8.74671 2.5 3.5C2.5 2.94772 2.94772 2.5 3.5 2.5Z" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                                <span class="{{ $cardLabelClass }}">Telefone</span>
                                            </div>
                                            <p class="{{ $cardValueClass }}">{{ $clinic['phone'] }}</p>
                                        </div>

                                        <div>
                                            <div class="mb-1.5 flex items-center gap-2">
                                                <svg class="shrink-0 text-[#8877C2]" width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                                                    <path d="M2.5 4.5L8 8.5L13.5 4.5M3.5 12.5H12.5C13.0523 12.5 13.5 12.0523 13.5 11.5V4.5C13.5 3.94772 13.0523 3.5 12.5 3.5H3.5C2.94772 3.5 2.5 3.94772 2.5 4.5V11.5C2.5 12.0523 2.94772 12.5 3.5 12.5Z" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                                <span class="{{ $cardLabelClass }}">Email</span>
                                            </div>
                                            <p class="{{ $cardValueClass }}">{{ $clinic['email'] }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </button>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="relative z-0 mt-[35px] h-[92px] min-h-[92px] overflow-visible bg-white" aria-hidden="true">
        <x-scroll-laser-beam
            class="scroll-laser-beam--clinics"
            data-scroll-laser-mode="section"
        />
    </div>
</section>
