@props([
    'blend' => false,
    'animated' => false,
    'src' => 'videos/laser-beam.mp4',
])

<div
    data-laser-beam-loop
    {{ $attributes->class([
        'laser-beam',
        'laser-beam--blend' => $blend,
        'laser-beam--animated' => $animated,
    ]) }}
    aria-hidden="true"
>
    <div class="laser-beam__stage">
        <video
            class="laser-beam__video"
            src="{{ asset($src) }}"
            muted
            loop
            playsinline
            preload="auto"
        ></video>

        @if ($animated)
            <span class="laser-beam__pulse"></span>
            <span class="laser-beam__flare"></span>
        @endif
    </div>
</div>
