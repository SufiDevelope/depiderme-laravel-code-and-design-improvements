<section class="laserderme-hero relative z-0 min-h-[100svh] overflow-hidden"
    style="background: linear-gradient(180deg, #8877C2 6.07%, #DAA9FA 34.58%, #DAA9FA 72%, #FFFFFF 100%);"
    aria-label="Laserderme">
    <div class="pointer-events-none absolute inset-x-0 top-1/2 z-0 -translate-y-1/2 overflow-hidden" aria-hidden="true">
        <div class="flex w-max animate-laserderme-hero-marquee motion-reduce:animate-none">
            @for ($copy = 0; $copy < 2; $copy++)
                <div class="flex shrink-0 items-center">
                    @for ($item = 0; $item < 4; $item++)
                        <span
                            class="laserderme-hero__marquee-text shrink-0 px-8 font-sans text-[clamp(52px,10.5vw,140px)] font-semibold uppercase leading-[110%] tracking-normal text-white sm:px-12 lg:px-16">
                            {{ content('laserderme', 'hero.marquee_text') }}
                        </span>
                    @endfor
                </div>
            @endfor
        </div>
    </div>

    <div
        class="laserderme-hero__inner relative z-10 flex min-h-[inherit] items-center justify-center px-6 pb-28 pt-28 sm:px-10 sm:pb-36 sm:pt-32 lg:pb-20 lg:pt-20">
        <div class="laserderme-hero__product-stage -translate-y-6 sm:-translate-y-8 lg:-translate-y-10">
            <img
                src="{{ content_asset('laserderme', 'hero.image', 'images/cream_hero_page.png') }}"
                alt="{{ content('laserderme', 'hero.image_alt') }}"
                class="laserderme-hero__product h-[clamp(380px,58vh,520px)] w-auto max-w-none sm:h-[clamp(440px,62vh,600px)] lg:h-[min(600px,34vw)] lg:min-h-0 lg:max-h-none"
                loading="eager"
                data-laserderme-hero-product
            >
        </div>
    </div>
</section>
