@props([
    'half' => false,
])

<div
    data-scroll-laser-beam
    {{ $attributes->class([
        'scroll-laser-beam',
        'scroll-laser-beam--half' => $half,
    ]) }}
    aria-hidden="true"
>
    <span class="scroll-laser-beam__fill">
        <span class="scroll-laser-beam__aura"></span>
        <span class="scroll-laser-beam__line"></span>
    </span>
    <span class="scroll-laser-beam__sweep"></span>
    <span class="scroll-laser-beam__flare"></span>
</div>
