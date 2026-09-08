@props([
    'href',
    'active' => false,
    'badge' => null,
    'hint' => null,
    'path' => null,
])

@php
    $classes = 'flex items-center justify-between gap-2 rounded-xl border px-3 py-2.5 text-sm transition';
    $classes .= $active
        ? ' border-[#8877c2]/35 bg-[#8877c2]/18 font-semibold text-white shadow-[inset_3px_0_0_0_#c9b8e4]'
        : ' border-transparent text-white/80 hover:bg-white/6 hover:text-white';
@endphp

<a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
    <span class="flex min-w-0 items-center gap-2.5">
        @if (isset($icon))
            <span class="shrink-0 opacity-85 [&_svg]:h-[1.05rem] [&_svg]:w-[1.05rem]">{{ $icon }}</span>
        @endif
        <span class="min-w-0">
            <span class="block leading-snug">{{ $slot }}</span>
            @if ($path)
                <span @class(['block text-[0.68rem] leading-tight', $active ? 'text-white/55' : 'text-white/40'])>{{ $path }}</span>
            @endif
        </span>
    </span>
    @if ($badge)
        <span class="shrink-0 rounded-full bg-[#8877c2] px-2 py-0.5 text-[0.68rem] font-bold text-white">{{ $badge }}</span>
    @elseif ($hint)
        <span class="shrink-0 text-[0.68rem] text-white/40">{{ $hint }}</span>
    @endif
</a>
