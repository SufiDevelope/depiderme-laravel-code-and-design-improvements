@props(['hover' => false])

<div {{ $attributes->merge([
    'class' => 'rounded-2xl border border-[#e8e4ef] bg-white p-6 shadow-sm'
        .($hover ? ' transition hover:border-[#c9b8e8] hover:shadow-md' : ''),
]) }}>
    {{ $slot }}
</div>
