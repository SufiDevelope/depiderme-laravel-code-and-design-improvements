@php
    $heroPadding = 'site-padding';

    $avatars = [
        'hero-avatar-1.png',
        'hero-avatar-2.png',
        'hero-avatar-3.png',
    ];

    $features = content('home', 'hero.features');

    $contentWidth = 'w-full max-w-none sm:max-w-[min(100%,22rem)] md:max-w-[min(100%,28rem)] lg:max-w-none';
    $featureTitleClass = 'home-hero-feature__title font-sans text-base font-medium leading-[130%] tracking-[-0.02em] text-white';
    $featureDescClass = 'font-body text-xs font-normal leading-[130%] tracking-[-0.02em] text-[#FFFFFF80] sm:text-sm';
@endphp

<section class="home-hero-content relative flex min-h-[inherit] flex-1 flex-col {{ $heroPadding }} lg:min-h-[calc(100vh-6rem)]" aria-label="Introdução">
    <div class="home-hero-copy relative z-10 pt-24 lg:max-w-none lg:pt-[140px]">
        <p class="home-hero-tagline font-sans text-base font-medium leading-[130%] tracking-[-0.02em] text-white lg:hidden">
            {{ content('home', 'hero.tagline') }}
        </p>

        <div class="home-hero-social-proof hidden {{ $contentWidth }} items-center gap-3 lg:flex">
            <div class="flex -space-x-2.5">
                @foreach ($avatars as $avatar)
                    <img src="{{ asset('images/' . $avatar) }}" alt="" width="36" height="36"
                        class="size-9 shrink-0 rounded-full border-2 border-white object-cover">
                @endforeach
            </div>
            <p class="font-body text-sm font-bold leading-[130%] tracking-[-0.02em] text-white">
                {{ content('home', 'hero.social_proof') }}
            </p>
        </div>

        <h1 class="hero-headline">
            <span class="hero-headline__mobile">{{ preg_replace('/\s+/', ' ', content('home', 'hero.headline_desktop')) }}</span>
            <span class="hero-headline__desktop">{{ preg_replace('/\s+/', ' ', content('home', 'hero.headline_desktop')) }}</span>
        </h1>
    </div>

    <div class="flex flex-1 min-h-6" aria-hidden="true"></div>

    <div class="home-hero-features relative z-10 flex flex-col gap-8 pb-12 pt-8 sm:gap-10 sm:pb-16 sm:pt-10 lg:flex-row lg:items-end lg:justify-between lg:gap-6 lg:pb-16 lg:pt-0">
        <ul class="flex {{ $contentWidth }} flex-col gap-5 sm:gap-6 lg:max-w-none">
            @foreach ($features as $feature)
                @php
                    $featureTitle = match (mb_strtolower(trim($feature['title']), 'UTF-8')) {
                        'laser médico de classe iv' => 'Laser Médico de Classe IV',
                        'especialistas em laser' => 'Especialistas em Laser',
                        'tecnologia de duplo laser' => 'Tecnologia de Duplo Laser',
                        default => $feature['title'],
                    };
                    $featureDescription = match (mb_strtolower(trim($feature['description']), 'UTF-8')) {
                        'equipamentos próprios com manutenção oficial e suporte de marca candela.' => 'Equipamentos próprios com manutenção oficial e suporte de marca Candela.',
                        'equipa de saúde com certificação oficial altec e candela.' => 'Equipa de saúde com certificação oficial ALTEC e Candela.',
                        'resultados em pele clara ou escura com tecnologia alexandrite & nd:yag.' => 'Resultados em pele clara ou escura com tecnologia Alexandrite & Nd:YAG.',
                        default => $feature['description'],
                    };
                @endphp
                <li class="home-hero-feature flex items-start gap-3.5">
                    <img src="{{ asset('images/' . $feature['icon']) }}" alt="" width="35" height="35"
                        class="size-[35px] shrink-0 object-contain">
                    <div class="min-w-0 pt-0.5">
                        <p class="{{ $featureTitleClass }}">{{ $featureTitle }}</p>
                        <p class="home-hero-feature__description mt-1 max-w-none sm:max-w-[14rem] {{ $featureDescClass }} lg:max-w-[228px]">{{ $featureDescription }}</p>
                    </div>
                </li>
            @endforeach
        </ul>

        <p class="home-hero-clinic-title hidden max-w-[420px] shrink-0 self-end text-right font-sans text-[48px] font-medium leading-[110%] tracking-[-0.02em] text-white lg:block">
            {{ content('home', 'hero.tagline') }}
        </p>
    </div>
</section>
