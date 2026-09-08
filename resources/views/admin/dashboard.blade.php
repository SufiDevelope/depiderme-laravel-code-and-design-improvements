@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <section class="mb-8 flex flex-wrap items-end justify-between gap-5 rounded-2xl bg-[radial-gradient(circle_at_100%_0%,rgba(201,184,228,0.35),transparent_42%),linear-gradient(135deg,#1a0a2e,#271841_52%,#5b2b82)] p-7 text-white shadow-[0_18px_48px_rgba(26,10,46,0.18)]">
        <div>
            <p class="text-[0.72rem] font-bold uppercase tracking-[0.1em] text-white/55">Painel Depiderme</p>
            <h1 class="mt-1 text-[clamp(1.75rem,3vw,2.35rem)] font-bold leading-tight tracking-tight">
                Olá{{ $adminUser?->name ? ', '.$adminUser->name : '' }}
            </h1>
            <p class="mt-2 max-w-xl text-[0.95rem] leading-relaxed text-white/80">Edita o conteúdo do site e acompanha os pedidos de marcação.</p>
        </div>
        <div class="flex flex-wrap gap-2.5">
            <x-admin.button :href="url('/')" variant="hero-outline" target="_blank" rel="noopener">
                Ver site público
                <svg width="14" height="14" viewBox="0 0 16 16" fill="none" aria-hidden="true"><path d="M5 3h8v8M11 5 4 12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </x-admin.button>
            <x-admin.button :href="route('admin.content.edit', 'home')" variant="hero">Editar homepage</x-admin.button>
        </div>
    </section>

    <div class="grid gap-5 lg:grid-cols-[1.4fr_0.6fr]">
        <x-admin.card class="!p-0 overflow-hidden">
            <div class="flex flex-wrap items-center justify-between gap-3 border-b border-[#f0ecf5] px-6 py-5">
                <div>
                    <div class="flex flex-wrap items-center gap-2.5">
                        <h2 class="text-base font-bold">Formulários de marcação</h2>
                        <span class="rounded-full bg-[#f3eefb] px-2.5 py-0.5 text-xs font-bold text-[#5b2b82]">{{ $totalSubmissions }}</span>
                        @if ($newSubmissions > 0)
                            <x-admin.badge variant="new">{{ $newSubmissions }} {{ $newSubmissions === 1 ? 'novo' : 'novos' }}</x-admin.badge>
                        @endif
                    </div>
                    <p class="mt-1 text-sm text-[#667085]">Pedidos enviados pelo formulário do site</p>
                </div>
                <x-admin.button :href="route('admin.submissions.index')" variant="ghost">Ver todos</x-admin.button>
            </div>

            @forelse ($recentSubmissions as $submission)
                <a href="{{ route('admin.submissions.show', $submission) }}" class="flex items-center gap-3 border-b border-[#f0ecf5] px-6 py-4 text-inherit no-underline last:border-b-0 hover:bg-[#faf9fc]">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-[#8877c2] to-[#5b2b82] text-sm font-bold text-white">{{ strtoupper(substr($submission->name, 0, 1)) }}</span>
                    <span class="min-w-0 flex-1">
                        <span class="block text-sm font-semibold">{{ $submission->name }}</span>
                        <span class="block text-xs text-[#667085]">{{ $submission->clinic }} · {{ $submission->created_at->format('d/m/Y H:i') }}</span>
                    </span>
                    <x-admin.badge :variant="$submission->status">{{ $submission->status }}</x-admin.badge>
                </a>
            @empty
                <div class="flex flex-col items-center px-6 py-12 text-center">
                    <span class="mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-[#f3eefb] text-[#5b2b82]">
                        <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M4 6.5h16v11H4z" stroke="currentColor" stroke-width="1.5"/>
                            <path d="M8 10.5h8M8 13.5h5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                    </span>
                    <p class="font-semibold text-[#231f20]">Ainda sem pedidos</p>
                    <p class="mt-1 max-w-xs text-sm text-[#667085]">Quando alguém marcar pelo site, o pedido aparece aqui.</p>
                </div>
            @endforelse
        </x-admin.card>

        <x-admin.card class="!p-0">
            <div class="border-b border-[#f0ecf5] px-5 py-5">
                <h2 class="text-base font-bold">Atalhos</h2>
                <p class="mt-1 text-sm text-[#667085]">Edição rápida</p>
            </div>
            <nav class="divide-y divide-[#f0ecf5]">
                @foreach ([
                    ['href' => route('admin.content.edit', 'home'), 'label' => 'Homepage', 'icon' => 'doc'],
                    ['href' => route('admin.content.edit', 'global'), 'label' => 'Global', 'icon' => 'settings'],
                    ['href' => route('admin.content.edit', 'contact'), 'label' => 'Contactos', 'icon' => 'mail'],
                    ['href' => route('admin.content.index'), 'label' => 'Todas as páginas', 'icon' => 'pages'],
                ] as $action)
                    <a href="{{ $action['href'] }}" class="group flex items-center gap-3 px-5 py-4 text-inherit no-underline transition hover:bg-[#faf9fc]">
                        <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-[#f8f6fc] text-[#5b2b82] transition group-hover:bg-[#f3eefb]">
                            @if ($action['icon'] === 'doc')
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M5 4.5h9l5 5v10.5H5z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/></svg>
                            @elseif ($action['icon'] === 'settings')
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" aria-hidden="true"><circle cx="12" cy="12" r="2.5" stroke="currentColor" stroke-width="1.5"/><path d="M12 4v2M12 18v2M4 12h2M18 12h2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                            @elseif ($action['icon'] === 'mail')
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M4 6.5h16v11H4z" stroke="currentColor" stroke-width="1.5"/><path d="m4 7 8 5 8-5" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/></svg>
                            @else
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M4 6.5h16v11H4z" stroke="currentColor" stroke-width="1.5"/><path d="M8 10.5h8M8 13.5h5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                            @endif
                        </span>
                        <span class="flex-1 text-sm font-semibold">{{ $action['label'] }}</span>
                        <svg class="h-4 w-4 text-[#c9b8e8] transition group-hover:translate-x-0.5 group-hover:text-[#5b2b82]" viewBox="0 0 16 16" fill="none" aria-hidden="true"><path d="M6 4l4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </a>
                @endforeach
            </nav>
        </x-admin.card>
    </div>

    <section class="mt-8">
        <div class="mb-4 flex flex-wrap items-end justify-between gap-3">
            <div>
                <h2 class="text-lg font-bold tracking-tight">Páginas do site</h2>
                <p class="mt-0.5 text-sm text-[#667085]">Edita textos e imagens por página</p>
            </div>
            <x-admin.button :href="route('admin.content.edit', 'global')" variant="ghost">Definições globais</x-admin.button>
        </div>

        <div class="grid gap-3 sm:grid-cols-2 xl:grid-cols-3">
            @foreach ($contentPages as $page)
                <a href="{{ route('admin.content.edit', $page['slug']) }}" class="group flex items-center gap-4 rounded-2xl border border-[#e8e4ef] bg-white p-4 no-underline text-inherit shadow-sm transition hover:border-[#c9b8e8] hover:shadow-md">
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#f8f6fc] text-[#5b2b82] transition group-hover:bg-[#f3eefb]">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none"><path d="M5 4.5h9l5 5v10.5H5z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/></svg>
                    </span>
                    <span class="min-w-0 flex-1">
                        <span class="block font-bold">{{ $page['label'] }}</span>
                        @if ($page['url'])
                            <span class="mt-0.5 block truncate text-xs font-medium text-[#8877c2]">{{ $page['url'] }}</span>
                        @endif
                    </span>
                    <svg class="h-4 w-4 shrink-0 text-[#d8d2e4] transition group-hover:text-[#5b2b82]" viewBox="0 0 16 16" fill="none" aria-hidden="true"><path d="M6 4l4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </a>
            @endforeach

            <a href="{{ route('admin.content.edit', 'global') }}" class="group flex items-center gap-4 rounded-2xl border border-[#ddd0f0] bg-gradient-to-r from-[#faf7ff] to-white p-4 no-underline text-inherit shadow-sm transition hover:border-[#c9b8e8] hover:shadow-md">
                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-white text-[#5b2b82] shadow-sm">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="2.5" stroke="currentColor" stroke-width="1.5"/></svg>
                </span>
                <span class="min-w-0 flex-1">
                    <span class="block font-bold">Global</span>
                    <span class="mt-0.5 block text-xs font-medium text-[#8877c2]">Navbar &amp; footer</span>
                </span>
                <svg class="h-4 w-4 shrink-0 text-[#c9b8e8] transition group-hover:text-[#5b2b82]" viewBox="0 0 16 16" fill="none" aria-hidden="true"><path d="M6 4l4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </a>
        </div>
    </section>
@endsection
