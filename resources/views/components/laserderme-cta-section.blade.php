@php
    $faces = content('laserderme', 'cta.faces');
    $galleryHeadline = content('laserderme', 'cta.gallery_headline');
    $galleryHeadlineNormalized = preg_replace('/\s+/', ' ', trim($galleryHeadline));
    $galleryHeadlineMatchesCuratedCopy = $galleryHeadlineNormalized === 'Criteriosamente pensado para a sua pele';
    $galleryHeadlineHtml = $galleryHeadlineMatchesCuratedCopy
        ? '<span class="laserderme-cta__headline-line">Criteriosamente</span><span class="laserderme-cta__headline-line">pensado para a sua pele</span>'
        : nl2br(e($galleryHeadline));

    $footerText = content('laserderme', 'cta.footer_text');
    $footerTextNormalized = preg_replace('/\s+/', ' ', trim($footerText));
    $footerTextMatchesCuratedCopy = str_starts_with($footerTextNormalized, 'Disponível apenas')
        && str_ends_with($footerTextNormalized, 'Depiderme');
    $footerTextHtml = $footerTextMatchesCuratedCopy
        ? 'Disponível apenas para<br>compra presencialmente<br>nas clínicas Depiderme'
        : nl2br(e($footerText));

    $galleryHeadlineClass = 'pointer-events-none text-center font-sans text-[clamp(32px,6vw,80px)] font-medium leading-[1.1] tracking-[-0.02em] lg:text-[80px] lg:leading-[88px]';
    $footerTextClass = 'relative mx-auto max-w-[994px] text-center font-sans text-[clamp(32px,6vw,80px)] font-medium leading-[1.1] tracking-[-0.02em] text-white lg:text-[80px] lg:leading-[88px]';
@endphp

<section
    class="relative z-20 overflow-x-clip rounded-tl-[40px] [--box-h:clamp(220px,42vw,510px)] [--box-in-gallery:calc(var(--box-h)*0.24)] [--footer-pt:calc(var(--tube-visible)+clamp(48px,8vw,96px))] [--gallery-h:clamp(360px,72vw,775px)] [--gradient-h:calc(var(--stack-h)-var(--box-in-gallery))] [--products-top:calc(var(--gallery-h)-var(--box-in-gallery))] [--stack-h:calc(var(--box-h)+var(--tube-visible))] [--tube-h:clamp(200px,38vw,440px)] [--tube-visible:calc(var(--tube-h)*0.56)] lg:rounded-tl-[80px] lg:[--box-h:510px] lg:[--gallery-h:775px] lg:[--tube-h:440px]"
    data-laserderme-cta data-scroll-laser-section aria-label="Laserderme nas clínicas Depiderme">
    <div class="relative z-20 h-[var(--gallery-h)]">
        <div class="laserderme-cta-faces flex h-full w-full">
            @foreach ($faces as $face)
                <div class="laserderme-cta-face-shell h-full min-w-0 flex-1 overflow-hidden">
                    <img src="{{ asset('images/' . $face) }}" alt="" class="laserderme-cta-face h-full w-full object-cover" loading="lazy">
                </div>
            @endforeach
        </div>

        <div class="pointer-events-none absolute inset-0 bg-black/10" aria-hidden="true"></div>

        <h2
            class="laserderme-cta__headline {{ $galleryHeadlineClass }} absolute inset-0 mx-auto flex w-full max-w-[921px] items-center justify-center px-6 text-white">
            {!! $galleryHeadlineHtml !!}
        </h2>
    </div>

    <div
        class="laserderme-cta-gradient retina-purple-field relative z-10 overflow-visible bg-black before:pointer-events-none before:absolute before:inset-0 before:z-[1] before:left-1/2 before:w-[min(100vw,1920px)] before:-translate-x-1/2 before:content-[''] before:bg-[radial-gradient(ellipse_120%_85%_at_50%_22%,rgba(218,169,250,0.55)_0%,#5b2b82_12%,rgba(91,43,130,0.72)_28%,rgba(91,43,130,0.32)_48%,rgba(91,43,130,0.08)_68%,transparent_88%)]"
        data-live-gradient-pseudo="before" data-live-gradient-intensity="cinematic">
        <x-scroll-laser-beam
            class="scroll-laser-beam--laserderme-cta"
            data-scroll-laser-mode="section"
        />

        <div class="relative z-[2] h-[var(--gradient-h)]" aria-hidden="true"></div>

        <p class="{{ $footerTextClass }} relative z-[2] site-padding pb-16 pt-[var(--footer-pt)] sm:pb-20 lg:pb-28">
            {!! $footerTextHtml !!}
        </p>
    </div>

    <div class="pointer-events-none absolute left-1/2 top-[var(--products-top)] z-30 -translate-x-1/2" data-reveal-skip>
        <div class="relative h-[var(--stack-h)] w-max brightness-[1.08] contrast-[1.03]" data-laserderme-cream>
            <img src="{{ content_asset('laserderme', 'cta.tube_image', 'images/laserderme-tube.png') }}"
                alt="Laserderme Creme"
                class="laserderme-cream-tube absolute bottom-0 left-1/2 z-[1] block h-[var(--tube-h)] w-auto max-w-none"
                data-laserderme-cream-tube loading="lazy">
            <img src="{{ content_asset('laserderme', 'cta.box_image', 'images/laserderme-box.png') }}"
                alt="Caixa Laserderme Creme" class="relative z-[2] block h-[var(--box-h)] w-auto max-w-none"
                data-laserderme-cream-box loading="lazy">
        </div>
    </div>
</section>
