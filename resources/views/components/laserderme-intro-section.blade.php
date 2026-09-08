@php
    $sectionPadding = 'site-padding';

    $rotatorWords = content('laserderme', 'intro.rotator_words');
    $rotatorWordsList = array_map('trim', explode(',', $rotatorWords));
    $firstRotatorWord = $rotatorWordsList[0] ?? '';
@endphp

<section
    class="laserderme-intro-section relative z-20 -mt-16 overflow-x-clip rounded-tl-[40px] bg-white sm:-mt-24 lg:-mt-32 lg:rounded-tl-[120px]"
    data-section-rise
    aria-label="Sobre o Laserderme"
>
    <div class="laserderme-intro-section__inner {{ $sectionPadding }} pb-10 pt-20 sm:pb-12 sm:pt-24 lg:pb-16 lg:pt-32">
        <div class="laserderme-intro-section__content grid grid-cols-1 items-start gap-10 lg:grid-cols-[minmax(0,0.95fr)_minmax(0,1.05fr)] lg:gap-16 xl:gap-24">
            <h2 class="laserderme-intro-section__title font-sans text-[clamp(44px,6.5vw,80px)] font-medium leading-[1.1] tracking-[-0.02em] text-[#231f20] lg:text-[80px] lg:leading-[88px]">
                {{ content('laserderme', 'intro.title') }}
                <span
                    class="laserderme-word-rotator block min-w-[9ch]"
                    data-laserderme-word-rotator
                    data-words="{{ $rotatorWords }}"
                    aria-live="polite"
                >
                    <span
                        class="laserderme-word inline-block bg-[linear-gradient(90deg,#8877C2_0%,#5B2B82_100%)] bg-clip-text text-transparent"
                        data-laserderme-word
                    >{{ $firstRotatorWord }}</span>
                </span>
            </h2>

            <p class="laserderme-intro-section__description max-w-[720px] font-sans text-[clamp(18px,2.2vw,30px)] font-medium leading-[130%] tracking-[-0.02em] text-[#231f20] lg:pt-2">
                {{ content('laserderme', 'intro.description_desktop', 'O GentleMax Pro Plus é a mais avançada tecnologia em depilação a laser, um dispositivo de uso dermatológico (Classe IV), aprovado pela FDA.') }}
            </p>
        </div>

        <div class="laserderme-banner-scene mt-10 sm:mt-12 lg:mt-16" data-laserderme-banner-scene data-reveal-skip>
            <div class="laserderme-banner-stage">
                <div class="laserderme-banner-media" data-laserderme-banner-media>
                    <img
                        src="{{ content_asset('laserderme', 'intro.banner_image', 'images/laserderme-banner.png') }}"
                        alt="{{ content('laserderme', 'intro.banner_alt') }}"
                        class="block h-full w-full object-cover object-center"
                        loading="lazy"
                    >
                </div>
            </div>
        </div>
    </div>
</section>
