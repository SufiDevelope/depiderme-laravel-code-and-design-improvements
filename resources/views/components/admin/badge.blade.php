@props(['variant' => 'new'])

@php
    $variants = [
        'new' => 'bg-[#f4ebff] text-[#6941c6]',
        'read' => 'bg-[#f2f4f7] text-[#344054]',
        'contacted' => 'bg-[#ecfdf3] text-[#027a48]',
        'archived' => 'bg-[#f2f4f7] text-[#667085]',
    ];
@endphp

<span {{ $attributes->merge(['class' => 'inline-block rounded-full px-2.5 py-0.5 text-xs font-semibold '.($variants[$variant] ?? $variants['new'])]) }}>
    {{ $slot }}
</span>
