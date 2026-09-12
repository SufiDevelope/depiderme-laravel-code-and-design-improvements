@php
    $orbs = content('pricing', 'hero.orbs');
    $titleHighlight = content('pricing', 'hero.title_highlight');
    $mobileHighlightParts = preg_split('/\s+/', trim($titleHighlight), 2);
    $mobileHighlightLine1 = $mobileHighlightParts[0] ?? '';
    $mobileHighlightLine2 = $mobileHighlightParts[1] ?? '';
    $mobileTitleLine2Text = preg_replace('/\s+/', ' ', trim(content('pricing', 'hero.title_line2')));
    $mobileTitleLine2Text = preg_replace('/\s+intervalo\s+de\s+tempo/u', "\nintervalo\nde tempo", $mobileTitleLine2Text, 1);
    $mobileTitleLine2 = preg_replace(
        '/\R/',
        '<br class="hidden sm:block"><span class="sm:hidden"> </span>',
        e(content('pricing', 'hero.title_line2')),
    );
    $mobileTitleLine2Fixed = nl2br(e($mobileTitleLine2Text), false);
@endphp

<section class="pricing-hero pricing-hero__mobile-frame retina-purple-field relative overflow-hidden pb-28 pt-28 max-lg:pb-12 sm:pb-32 sm:pt-32 lg:pb-40 lg:pt-24" data-live-gradient data-live-gradient-scroll-only data-live-gradient-intensity="cinematic" data-pricing-hero-motion data-reveal-skip aria-label="Preços Depiderme">
    <div class="pricing-hero__inner relative z-[1] isolate mx-auto w-full min-h-[640px] max-w-none sm:min-h-[720px] lg:min-h-[888px] lg:max-w-[1440px]">
        @foreach ($orbs as $orb)
            <div class="pricing-hero__orb absolute z-0 overflow-hidden rounded-full border-[3px] border-white max-lg:border-2 {{ $orb['class'] }}" aria-hidden="true">
                <img
                    src="{{ asset('images/' . $orb['image']) }}"
                    alt="{{ $orb['alt'] }}"
                    class="block h-full w-full object-cover"
                    loading="lazy"
                >
            </div>
        @endforeach

        <div class="pricing-hero__copy pricing-hero__copy--enter pointer-events-none relative z-10 flex min-h-[inherit] items-center justify-center site-padding max-lg:mx-auto max-lg:max-w-[78%] max-lg:py-30 max-lg:pb-18 sm:max-lg:max-w-[68%] sm:max-lg:py-34 sm:max-lg:pb-20">
            <h1 class="pricing-hero__title hidden max-w-[760px] text-center font-sans text-[40px] font-medium leading-[44px] tracking-[-0.02em] text-white sm:block sm:text-[56px] sm:leading-[62px] lg:w-[889px] lg:max-w-[889px] lg:text-[80px] lg:leading-[88px]">
                {{ content('pricing', 'hero.title_line1') }} <span class="bg-[linear-gradient(90deg,#E1C7F9_0%,#FFFFFF_100%)] bg-clip-text text-transparent">{{ content('pricing', 'hero.title_highlight') }}</span><br class="hidden sm:block"><span class="sm:hidden"> </span>{!! $mobileTitleLine2 !!}
            </h1>
            <h1 class="pricing-hero__title pricing-hero__title--mobile text-center font-sans font-medium tracking-[-0.02em] text-white sm:hidden">
                {{ content('pricing', 'hero.title_line1') }} <span class="bg-[linear-gradient(90deg,#E1C7F9_0%,#FFFFFF_100%)] bg-clip-text text-transparent">{{ $mobileHighlightLine1 }}</span><br>
                <span class="bg-[linear-gradient(90deg,#E1C7F9_0%,#FFFFFF_100%)] bg-clip-text text-transparent">{{ $mobileHighlightLine2 }}</span><br>
                {!! $mobileTitleLine2Fixed !!}
            </h1>
        </div>
    </div>
</section>
