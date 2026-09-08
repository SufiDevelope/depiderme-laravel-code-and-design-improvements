@props([
    'variant' => 'primary',
    'type' => 'button',
    'href' => null,
])

@php
    $base = 'inline-flex items-center justify-center gap-1.5 rounded-full px-5 py-2.5 text-sm font-semibold no-underline transition hover:opacity-90';

    $variants = [
        'primary' => 'border-0 bg-gradient-to-r from-[#8877c2] to-[#5b2b82] text-white',
        'secondary' => 'border border-[#d8d2e4] bg-white text-[#231f20]',
        'ghost' => 'border border-[#d8d2e4] bg-transparent text-[#5b2b82]',
        'danger' => 'border-0 bg-[#b42318] text-white',
        'sidebar' => 'w-full border border-white/20 bg-transparent px-4 py-2 text-sm text-white/90 hover:border-white/30 hover:bg-white/10',
        'hero' => 'border-0 bg-white text-[#271841]',
        'hero-outline' => 'border border-white/25 bg-white/10 text-white',
    ];

    $class = $base.' '.($variants[$variant] ?? $variants['primary']).' '.($attributes->get('class') ?? '');
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->except('class')->merge(['class' => $class]) }}>{{ $slot }}</a>
@else
    <button type="{{ $type }}" {{ $attributes->except('class')->merge(['class' => $class]) }}>{{ $slot }}</button>
@endif
