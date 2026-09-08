@php
    $sectionPadding = 'site-padding';

    $factors = content('laserderme', 'factors.items');
    $title = content('laserderme', 'factors.title');
    $titleText = preg_replace('/\s+/', ' ', trim($title));
@endphp

<section id="factors" class="laserderme-factors-section bg-[#fbfaff]" aria-label="Factores de crescimento">
    <div class="{{ $sectionPadding }} laserderme-factors__wrap">
        <div class="laserderme-factors__canvas">
            <h2 class="laserderme-factors__title">
                {{ $titleText }}
            </h2>

            <div class="laserderme-factors__items">
                @foreach ($factors as $index => $factor)
                    @php
                        $description = $factor['description'] ?? '';
                        $descriptionText = preg_replace('/\s+/', ' ', trim($description));
                    @endphp
                    <article class="laserderme-factor laserderme-factor--{{ $index + 1 }}">
                        <div class="laserderme-factor__visual" style="--factor-image: url('{{ asset('images/' . $factor['image']) }}')" aria-hidden="true">
                            <img
                                src="{{ asset('images/' . $factor['image']) }}"
                                alt=""
                                class="laserderme-factor__image"
                                loading="eager"
                                decoding="async"
                                fetchpriority="high"
                            >
                        </div>

                        <div class="laserderme-factor__content">
                            <h3 class="laserderme-factor__code">{{ $factor['code'] }}</h3>
                            <p class="laserderme-factor__copy laserderme-factor__copy--desktop">
                                {{ $descriptionText }}
                            </p>
                            <p class="laserderme-factor__copy laserderme-factor__copy--mobile">
                                {{ $descriptionText }}
                            </p>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </div>
</section>
