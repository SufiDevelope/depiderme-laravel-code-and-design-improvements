@props(['theme' => 'dark', 'fixed' => false, 'solidOnScroll' => false, 'mobileDark' => false])

@php
    $paginasLinks = content('global', 'navbar.paginas_links');
    $clinicasLinks = content('global', 'navbar.clinicas_links');
    $desktopLinks = content('global', 'navbar.desktop_links');

    $isLight = $theme === 'light';
    $scrollEnabled = $fixed || $solidOnScroll;
    $themeClass = $isLight ? 'navbar--light' : 'navbar--dark';
    $mobileDarkOnLight = $isLight && $mobileDark;
    $showScrollLogoSwap = $scrollEnabled && (! $isLight || $mobileDark);

    $logoSrc = $isLight ? 'images/logo-dark.svg' : 'images/logo.svg';

    $linkClass = 'font-sans text-sm font-medium capitalize leading-[18px] tracking-[-0.02em] no-underline whitespace-nowrap';
    $btnClass = 'inline-flex cursor-pointer items-center justify-center gap-2.5 rounded-full border font-sans text-sm font-semibold capitalize leading-[18px] tracking-[-0.02em] no-underline whitespace-nowrap transition';
    $navPadding = 'site-padding';

    $headerClass = $scrollEnabled
        ? 'site-header fixed inset-x-0 top-0 z-[100] bg-transparent transition-[background-color,box-shadow] duration-300'
        : 'site-header relative z-[100] bg-transparent';
@endphp

<header class="{{ $headerClass }} {{ $themeClass }} {{ $mobileDark ? 'navbar--mobile-dark' : '' }}" @if($scrollEnabled) data-navbar-scroll @endif>
    <div class="site-shell">
        <div class="site-header__bar flex h-24 items-center justify-between {{ $navPadding }}">
        <a href="{{ url('/') }}" class="site-header__logo block w-[clamp(100px,34vw,157px)] shrink-0 lg:w-[166px]">
            @if ($showScrollLogoSwap)
                <img src="{{ asset('images/logo.svg') }}" alt="Depiderme" width="166" height="auto"
                    class="navbar-scroll-logo-light block h-auto w-full {{ $mobileDarkOnLight ? 'lg:hidden' : '' }} lg:w-[166px]">
                <img src="{{ asset('images/logo-dark.svg') }}" alt="Depiderme" width="166" height="auto"
                    class="navbar-scroll-logo-dark hidden h-auto w-full {{ $mobileDarkOnLight ? 'lg:block' : '' }} lg:w-[166px]">
            @else
                <img src="{{ asset($logoSrc) }}" alt="Depiderme" width="166" height="auto"
                    class="block h-auto w-full lg:w-[166px]">
            @endif
        </a>

        {{-- Desktop --}}
        <div class="site-header__desktop-actions hidden min-w-0 items-center lg:flex">
            <nav class="site-header__desktop-nav flex items-center gap-10"
                aria-label="Navegação principal">
                @foreach ($desktopLinks as $label => $path)
                    <a href="{{ cms_url($path) }}" class="site-header__desktop-link navbar-scroll-link {{ $linkClass }}">{{ $label }}</a>
                @endforeach
            </nav>

            <div class="ml-10 flex shrink-0 items-center gap-4">
                <a href="{{ url('/contact') }}" class="site-header__desktop-cta navbar-scroll-btn-outline {{ $btnClass }} px-5 py-[15px]">{{ content('global', 'navbar.contact_label') }}</a>
                <a href="{{ url('/contact') }}" class="site-header__desktop-cta navbar-scroll-btn-solid {{ $btnClass }} px-5 py-[15px]">{{ content('global', 'navbar.booking_label') }}</a>
            </div>

            <div class="ml-10 flex shrink-0 items-center gap-2">
                <button type="button"
                    class="site-header__language inline-flex shrink-0 cursor-pointer items-center gap-1.5 border-0 bg-transparent p-0 navbar-scroll-link"
                    aria-label="Alterar idioma">
                    <span class="font-sans text-sm font-medium uppercase leading-[18px] tracking-[-0.02em]">{{ content('global', 'navbar.language_short') }}</span>
                    <img src="{{ asset('images/arrow-down.png') }}" alt="" width="12" height="6" class="block w-3 shrink-0 navbar-scroll-arrow">
                </button>

                <a href="{{ auth()->check() && auth()->user()->is_admin ? route('admin.dashboard') : route('login') }}"
                    class="site-header__account inline-flex size-9 shrink-0 items-center justify-center navbar-scroll-link"
                    aria-label="{{ auth()->check() && auth()->user()->is_admin ? 'Backend' : 'Login' }}">
                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" aria-hidden="true">
                        <circle cx="9" cy="6" r="3" stroke="currentColor" stroke-width="1.25" />
                        <path d="M3.5 15c0-2.8 2.5-5 5.5-5s5.5 2.2 5.5 5" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" />
                    </svg>
                </a>
            </div>
        </div>

        {{-- Mobile --}}
        <div class="site-header__mobile-actions flex items-center gap-2 sm:gap-3 lg:hidden">
            <a href="{{ url('/contact') }}" class="site-header__mobile-booking navbar-scroll-btn-outline {{ $btnClass }} px-3 py-2.5 sm:px-4" aria-label="{{ content('global', 'navbar.booking_label') }}">
                <span>{{ content('global', 'navbar.booking_label') }}</span>
            </a>

            <a href="tel:{{ preg_replace('/\s+/', '', content('global', 'site.phone', '+351244000000')) }}"
                class="site-header__mobile-phone navbar-scroll-phone inline-flex size-10 shrink-0 items-center justify-center rounded-full border"
                aria-label="Telefonar">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path
                        d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1C10.61 21 3 13.39 3 4c0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.24.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2Z"
                        fill="currentColor" />
                </svg>
            </a>

            <button type="button" id="menu-open"
                class="site-header__mobile-menu navbar-scroll-menu inline-flex size-10 shrink-0 cursor-pointer flex-col items-center justify-center gap-1.5 border-0 bg-transparent p-0"
                aria-label="Abrir menu" aria-expanded="false" aria-controls="mobile-menu">
                <span class="block h-0.5 w-5 navbar-scroll-menu-bar"></span>
                <span class="block h-0.5 w-5 navbar-scroll-menu-bar"></span>
            </button>
        </div>
    </div>
    </div>

    {{-- Mobile menu overlay --}}
    <div id="mobile-menu" class="fixed inset-0 z-[110] hidden bg-black" aria-hidden="true">
        <div class="site-header__mobile-overlay-panel flex h-full flex-col overflow-y-auto">
            <div class="site-header__mobile-overlay-inner {{ $navPadding }}">
                <div class="site-header__mobile-overlay-bar flex h-24 items-center justify-between">
                    <a href="{{ url('/') }}" class="site-header__mobile-overlay-logo block w-[clamp(120px,42vw,157px)] shrink-0">
                        <img src="{{ asset('images/logo.svg') }}" alt="Depiderme" width="157" height="auto"
                            class="block h-auto w-full">
                    </a>

                    <button type="button" id="menu-close"
                        class="inline-flex size-10 cursor-pointer items-center justify-center border-0 bg-transparent p-0 text-white"
                        aria-label="Fechar menu">
                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" aria-hidden="true">
                            <path d="M1 1L17 17M17 1L1 17" stroke="currentColor" stroke-width="1.5"
                                stroke-linecap="round" />
                        </svg>
                    </button>
                </div>

                <div class="site-header__mobile-overlay-links mt-10 grid grid-cols-2 gap-x-6 gap-y-10">
                    <div>
                        <p
                            class="font-sans text-sm font-semibold capitalize leading-[18px] tracking-[-0.02em] text-white">
                            {{ content('global', 'footer.paginas_title') }}</p>
                        <ul class="mt-[25px] flex flex-col gap-5">
                            @foreach ($paginasLinks as $label => $path)
                                <li>
                                    <a href="{{ cms_url($path) }}" class="{{ $linkClass }} text-white">{{ $label }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div>
                        <p
                            class="font-sans text-sm font-semibold capitalize leading-[18px] tracking-[-0.02em] text-white">
                            {{ content('global', 'footer.clinicas_title') }}</p>
                        <ul class="mt-[25px] flex flex-col gap-5">
                            @foreach ($clinicasLinks as $label => $path)
                                <li>
                                    <a href="{{ cms_url($path) }}" class="{{ $linkClass }} text-white">{{ $label }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <div class="relative mt-auto">
                <div class="site-header__mobile-overlay-actions relative z-10 -mb-14 flex flex-col gap-4 {{ $navPadding }}">
                    <a href="{{ url('/contact') }}"
                        class="site-header__mobile-overlay-action {{ $btnClass }} w-full border-white bg-white px-5 py-[15px] text-[#1a0a2e]">{{ content('global', 'navbar.booking_label') }}</a>
                    <a href="{{ url('/contact') }}"
                        class="site-header__mobile-overlay-action {{ $btnClass }} w-full border-white bg-transparent px-5 py-[15px] text-white hover:bg-white/10">{{ content('global', 'footer.contact_button') }}</a>
                    @auth
                        @if (auth()->user()->is_admin)
                            <a href="{{ route('admin.dashboard') }}"
                                class="site-header__mobile-overlay-action {{ $btnClass }} w-full border-white bg-transparent px-5 py-[15px] text-white hover:bg-white/10">Backend</a>
                        @endif
                    @endauth
                </div>

                <div class="site-header__mobile-overlay-bottom relative">
                    <img src="{{ asset('images/laser-line.png') }}" alt="" class="block h-auto w-full"
                        role="presentation">

                    <div class="absolute inset-x-0 bottom-6 flex flex-col items-center gap-6">
                        <button type="button"
                            class="site-header__mobile-overlay-language flex cursor-pointer items-center gap-1.5 border-0 bg-transparent p-0 text-white"
                            aria-label="Alterar idioma">
                            <span
                                class="font-sans text-sm font-medium capitalize leading-[18px] tracking-[-0.02em]">{{ content('global', 'navbar.language_full') }}</span>
                            <img src="{{ asset('images/arrow-down.png') }}" alt="" width="12" height="6"
                                class="block w-3 shrink-0">
                        </button>

                        <div class="site-header__mobile-overlay-socials flex items-center justify-center gap-4">
                            <a href="{{ cms_url(content('global', 'site.instagram')) }}"
                                class="site-header__mobile-overlay-social inline-flex size-10 items-center justify-center rounded-full border border-white/30 text-white transition hover:bg-white/10"
                                aria-label="Instagram">
                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none" aria-hidden="true">
                                    <rect x="1.5" y="1.5" width="15" height="15" rx="4" stroke="currentColor"
                                        stroke-width="1.2" />
                                    <circle cx="9" cy="9" r="3.2" stroke="currentColor" stroke-width="1.2" />
                                    <circle cx="13.2" cy="4.8" r="0.8" fill="currentColor" />
                                </svg>
                            </a>
                            <a href="{{ cms_url(content('global', 'site.facebook')) }}"
                                class="site-header__mobile-overlay-social inline-flex size-10 items-center justify-center rounded-full border border-white/30 text-white transition hover:bg-white/10"
                                aria-label="Facebook">
                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none" aria-hidden="true">
                                    <path
                                        d="M10.2 9.6h2.4l-.3-2.4H10.2V6.3c0-.7.2-1.2 1.3-1.2h1.2V3.1c-.2 0-1-.1-1.9-.1-1.9 0-3.2 1.1-3.2 3.2v2.3H5.8v2.4h1.6V15h2.8V9.6Z"
                                        fill="currentColor" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
