@extends('layouts.admin')

@section('title', $pageLabel)

@section('content')
    <div class="mb-7 flex flex-wrap items-start justify-between gap-4">
        <div>
            <p class="text-sm font-medium text-[#5b2b82]">
                <a href="{{ route('admin.dashboard') }}" class="text-inherit no-underline">Dashboard</a>
                <span class="text-[#667085]"> / {{ $pageLabel }}</span>
            </p>
            <h1 class="mt-1 text-3xl font-bold tracking-tight">{{ $pageLabel }}</h1>
            <p class="mt-1 text-[#667085]">Edita textos, imagens e listas desta página — sem código.</p>
        </div>
        @if ($pageUrl)
            <x-admin.button :href="url($pageUrl)" variant="secondary" target="_blank" rel="noopener">Ver página ↗</x-admin.button>
        @endif
    </div>

    <form action="{{ route('admin.content.update', $page) }}" method="post" id="cms-form">
        @csrf
        @method('PUT')

        <div class="cms-accordions" data-accordion="single">
            @foreach ($sections as $sectionName => $fields)
                @php
                    $ungrouped = [];
                    $groups = [];

                    foreach ($fields as $key => $field) {
                        if (! empty($field['group'])) {
                            $groups[$field['group']][$key] = $field;
                        } else {
                            $ungrouped[$key] = $field;
                        }
                    }
                @endphp

                <div @class(['cms-accordion', 'is-open' => $loop->first]) data-accordion-item>
                    <button type="button" class="cms-accordion__trigger" data-accordion-trigger aria-expanded="{{ $loop->first ? 'true' : 'false' }}">
                        <span class="cms-accordion__title">{{ $sectionName }}</span>
                        <span class="cms-accordion__meta">{{ count($fields) }} campos</span>
                        <span class="cms-accordion__chevron" aria-hidden="true"></span>
                    </button>

                    <div class="cms-accordion__panel">
                        <div class="cms-accordion__body">
                            @foreach ($ungrouped as $key => $field)
                                @include('admin.content.fields.field', compact('key', 'field', 'media', 'siteImages'))
                            @endforeach

                            @foreach ($groups as $groupName => $groupFields)
                                <div class="cms-field-group">
                                    <p class="cms-field-group__title">{{ $groupName }}</p>
                                    <div class="cms-field-group__grid">
                                        @foreach ($groupFields as $key => $field)
                                            @include('admin.content.fields.field', compact('key', 'field', 'media', 'siteImages'))
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="sticky bottom-4 z-20 mt-6 flex flex-wrap items-center justify-between gap-4 rounded-2xl border border-[#e8e4ef] bg-white/95 p-4 shadow-lg backdrop-blur-sm">
            <p class="text-sm text-[#667085]">Alterações visíveis no site após guardar.</p>
            <x-admin.button type="submit" variant="primary">Guardar alterações</x-admin.button>
        </div>
    </form>

    @include('admin.content.fields.image-modal', compact('media', 'siteImages'))
@endsection

@push('scripts')
    @vite('resources/js/admin-cms.js')
@endpush
