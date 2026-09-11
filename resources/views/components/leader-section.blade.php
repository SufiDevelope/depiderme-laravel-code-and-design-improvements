@php
    $leaderPadding = 'site-padding';
    $headline = content('home', 'leader.headline');
    $description = content('home', 'leader.description');
@endphp

<section class="home-stack-panel leader-section relative z-20" data-home-stack-panel data-leader-section aria-label="Sobre a Depiderme">
    <div
        class="leader-panel w-full rounded-tl-[40px] bg-white {{ $leaderPadding }} py-12 sm:py-16 md:py-16 lg:rounded-tl-[80px] lg:pb-24 lg:pt-20"
        data-leader-panel
    >
        <h2 class="leader-headline" data-leader-headline>
            {!! nl_to_br($headline) !!}
        </h2>

        <p class="leader-desc mt-6 sm:mt-8 lg:mt-10" data-leader-desc>
            {{ $description }}
        </p>
    </div>
</section>
