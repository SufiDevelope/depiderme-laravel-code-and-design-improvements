@props(['darkCorner' => false, 'purpleCorner' => false, 'liveGradient' => true])

@php
    $footerPadding = 'site-padding';

    $paginasLinks = content('global', 'footer.paginas_links');
    $clinicasLinks = content('global', 'footer.clinicas_links');
    $socialLinks = content('global', 'footer.social_links');
    $footerHeadline = content('global', 'footer.headline');
    $footerHeadlineNormalized = preg_replace('/\s+/', ' ', trim($footerHeadline));
    $footerHeadlineHtml = str_starts_with($footerHeadlineNormalized, 'O futuro da sua pele') && str_ends_with($footerHeadlineNormalized, 'da tecnologia')
        ? 'O futuro da sua pele<span class="hidden lg:inline"> </span><br class="lg:hidden">come&ccedil;a<br class="hidden lg:block"> com a efic&aacute;cia<br class="lg:hidden"> da tecnologia'
        : nl2br(e($footerHeadline));

    $footerTitleClass = 'font-sans text-xl font-bold capitalize leading-[18px] tracking-[-0.02em] text-white';
    $footerLinkClass = 'block font-sans text-sm font-medium capitalize leading-[18px] tracking-[-0.02em] text-white no-underline transition-opacity hover:opacity-75';
    $footerBtnClass = 'inline-flex w-full cursor-pointer items-center justify-center rounded-full border border-white bg-transparent px-5 py-[14px] font-sans text-sm font-semibold capitalize leading-[18px] tracking-[-0.02em] text-white no-underline whitespace-nowrap transition hover:bg-[#FFFFFF33] lg:w-auto';
@endphp

<div
    @class([
        'footer-shell',
        'bg-black' => $darkCorner,
        'bg-[#8877c2]' => $purpleCorner,
    ])
>
<footer class="site-footer footer-gradient retina-purple-field relative overflow-hidden rounded-tl-[40px] text-white lg:rounded-tl-[80px]" @if ($liveGradient) data-live-gradient data-live-gradient-intensity="strong" @endif>
    <div class="footer__hero {{ $footerPadding }} pt-16 sm:pt-24 lg:pt-[105px]">
        <h2
            class="footer__headline mx-auto max-w-[850px] px-1 text-center font-sans text-[24px] font-medium leading-[115%] tracking-[-0.02em] sm:px-0 sm:text-[35px] sm:leading-[110%] lg:text-[60px]">
            {!! $footerHeadlineHtml !!}
        </h2>

        <div class="footer__actions mt-7 flex flex-col items-stretch gap-4 lg:flex-row lg:items-center lg:justify-center">
            <a href="{{ url('/contact') }}" class="{{ $footerBtnClass }}">{{ content('global', 'footer.contact_button') }}</a>
            <a href="{{ url('/contact') }}" class="{{ $footerBtnClass }}">{{ content('global', 'footer.booking_button') }}</a>
        </div>
    </div>

    <div class="footer__links mt-12 border-y border-white/30 sm:mt-20 lg:mt-[127px]">
        <div class="footer__links-inner {{ $footerPadding }}">
            <div class="grid grid-cols-2 lg:grid-cols-3">
                <div class="footer__column footer__column--pages border-r border-white/30 py-8 pl-4 sm:py-10 sm:pl-[30px] lg:pb-[29px] lg:pt-[34px]">
                    <p class="{{ $footerTitleClass }}">{{ content('global', 'footer.paginas_title') }}</p>
                    <ul class="mt-6 flex flex-col gap-5">
                        @foreach ($paginasLinks as $label => $path)
                            <li><a href="{{ cms_url($path) }}" class="{{ $footerLinkClass }}">{{ $label }}</a></li>
                        @endforeach
                    </ul>
                </div>

                <div class="footer__column footer__column--clinics border-white/30 py-8 pl-4 sm:py-10 sm:pl-[30px] lg:border-r lg:pb-[29px] lg:pt-[34px]">
                    <p class="{{ $footerTitleClass }}">{{ content('global', 'footer.clinicas_title') }}</p>
                    <ul class="mt-6 flex flex-col gap-5">
                        @foreach ($clinicasLinks as $label => $path)
                            <li><a href="{{ cms_url($path) }}" class="{{ $footerLinkClass }}">{{ $label }}</a></li>
                        @endforeach
                    </ul>
                </div>

                <div class="hidden py-10 pl-[30px] lg:block lg:pb-[29px] lg:pt-[34px]">
                    <p class="{{ $footerTitleClass }}">{{ content('global', 'footer.socials_title') }}</p>
                    <ul class="mt-6 flex flex-col gap-5">
                        @foreach ($socialLinks as $label => $path)
                            <li><a href="{{ cms_url($path) }}" class="{{ $footerLinkClass }}">{{ $label }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="footer__social border-b border-white/30 lg:hidden">
        <div class="{{ $footerPadding }} flex items-center justify-center gap-4 py-8">
            <a href="{{ cms_url(content('global', 'site.instagram')) }}"
                class="inline-flex size-10 items-center justify-center rounded-full border border-white/30 text-white transition hover:bg-white/10"
                aria-label="Instagram">
                <svg width="18" height="18" viewBox="0 0 18 18" fill="none" aria-hidden="true">
                    <rect x="1.5" y="1.5" width="15" height="15" rx="4" stroke="currentColor" stroke-width="1.2" />
                    <circle cx="9" cy="9" r="3.2" stroke="currentColor" stroke-width="1.2" />
                    <circle cx="13.2" cy="4.8" r="0.8" fill="currentColor" />
                </svg>
            </a>
            <a href="{{ cms_url(content('global', 'site.facebook')) }}"
                class="inline-flex size-10 items-center justify-center rounded-full border border-white/30 text-white transition hover:bg-white/10"
                aria-label="Facebook">
                <svg width="18" height="18" viewBox="0 0 18 18" fill="none" aria-hidden="true">
                    <path
                        d="M10.2 9.6h2.4l-.3-2.4H10.2V6.3c0-.7.2-1.2 1.3-1.2h1.2V3.1c-.2 0-1-.1-1.9-.1-1.9 0-3.2 1.1-3.2 3.2v2.3H5.8v2.4h1.6V15h2.8V9.6Z"
                        fill="currentColor" />
                </svg>
            </a>
        </div>
    </div>

    <div class="footer__brand mt-10 {{ $footerPadding }} pb-12 sm:mt-16 sm:pb-20 lg:mt-[67px] lg:pb-[102px]">
        <img src="{{ asset('images/logo.svg') }}" alt="Depiderme" class="mx-auto block h-auto w-full max-w-md sm:mx-0 sm:max-w-[1450px] lg:max-w-[1385px]">
    </div>
</footer>
</div>
