@php
    $sectionPadding = 'site-padding';
@endphp

<section class="technology-diagnosis-section relative z-20 overflow-x-clip rounded-tl-[40px] bg-white lg:rounded-tl-[80px]" data-scroll-laser-section aria-label="Consulta de diagnóstico">
    <div class="grid grid-cols-1 lg:grid-cols-2 lg:min-h-[939px]">
        <div class="technology-diagnosis__media relative overflow-hidden bg-[#000010] lg:h-[939px] lg:min-h-[939px]">
            <img
                src="{{ content_asset('technology', 'diagnosis.image', 'images/experience-card-2.png') }}"
                alt="{{ content('technology', 'diagnosis.image_alt') }}"
                class="technology-diagnosis__image block w-full object-cover object-top max-lg:h-[clamp(320px,72vw,480px)] max-lg:min-h-0 max-lg:rounded-tl-[40px] lg:h-[939px] lg:min-h-[939px] lg:rounded-tl-[120px]"
                loading="lazy"
            >
        </div>

        <div class="technology-diagnosis__content flex flex-col justify-center bg-white {{ $sectionPadding }} py-12 sm:py-16 lg:min-h-[939px] lg:py-0 lg:pl-16 xl:pl-24">
            <div class="technology-diagnosis__text relative z-20 flex max-w-[560px] flex-col">
                <h2 class="technology-diagnosis__title font-sans text-[40px] font-medium leading-[110%] tracking-[-0.02em] text-[#231f20] sm:text-[48px] lg:text-[60px]">
                    {!! nl_to_br(content('technology', 'diagnosis.title')) !!}
                </h2>

                <div class="technology-diagnosis__body mt-8 flex flex-col gap-4 lg:mt-10">
                    <p class="font-body text-base font-normal leading-[130%] tracking-[-0.02em] text-[#545462]">
                        <span class="technology-diagnosis__line">Antes de qualquer procedimento é feita uma análise das características do pêlo e da</span>
                        <span class="technology-diagnosis__line">pele bem como da sua aptidão ao laser. Posteriormente, executa-se a remoção do</span>
                        <span class="technology-diagnosis__line">pelo (com lâmina) na área que se pretende tratar, de modo a que o máximo de energia</span>
                        <span class="technology-diagnosis__line">laser chegue à raiz do mesmo.</span>
                    </p>
                    <p class="font-body text-base font-normal leading-[130%] tracking-[-0.02em] text-[#545462]">
                        <span class="technology-diagnosis__line">São selecionados os parâmetros de energia adequados a cada paciente em particular.</span>
                        <span class="technology-diagnosis__line">O laser é aplicado sobre a pele, com a potência selecionada e realiza-se então o</span>
                        <span class="technology-diagnosis__line">tratamento.</span>
                    </p>
                </div>

                <a
                    href="#"
                    class="technology-diagnosis__cta mt-8 inline-flex w-fit items-center justify-center rounded-full px-5 py-[15px] font-sans text-sm font-semibold capitalize leading-[18px] tracking-[-0.02em] text-white no-underline lg:mt-10"
                >
                    {{ content('technology', 'diagnosis.cta') }}
                </a>
            </div>
        </div>
    </div>

    <x-scroll-laser-beam :half="true" class="scroll-laser-beam--technology-diagnosis" />
</section>
