@extends('layouts.admin')

@section('title', 'Páginas')

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-bold tracking-tight">Páginas</h1>
        <p class="mt-2 text-[#667085]">Seleciona uma página para editar textos e imagens.</p>
    </div>

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
        @foreach ($pages as $slug => $page)
            <a href="{{ route('admin.content.edit', $slug) }}" class="group block rounded-2xl border border-[#e8e4ef] bg-white p-5 no-underline text-inherit shadow-sm transition hover:border-[#c9b8e8] hover:shadow-md">
                <h3 class="text-lg font-bold">{{ $page['label'] }}</h3>
                @if (! empty($page['url']))
                    <p class="mt-1 text-sm text-[#667085]">{{ $page['url'] }}</p>
                @endif
                <div class="mt-4 flex items-center justify-between text-sm font-semibold text-[#5b2b82]">
                    <span>{{ count($page['fields'] ?? []) }} campos</span>
                    <span class="opacity-0 transition group-hover:opacity-100">Editar →</span>
                </div>
            </a>
        @endforeach
    </div>
@endsection
