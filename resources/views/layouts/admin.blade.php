<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — Depiderme</title>
    @vite(['resources/css/admin.css'])
    @stack('head')
</head>
<body class="min-h-screen bg-[#f3f0f8] font-sans text-[#231f20]">
    @php use App\Support\AdminNavigation; @endphp
    <div class="flex min-h-screen max-lg:flex-col">
        <aside class="sticky top-0 flex h-screen w-[292px] shrink-0 flex-col border-r border-white/6 bg-gradient-to-b from-[#12081f] via-[#1a0a2e] to-[#271841] text-white max-lg:static max-lg:h-auto max-lg:w-full">
            <div class="shrink-0 px-5 pb-3 pt-6">
                <a href="{{ route('admin.dashboard') }}" class="block">
                    <img src="{{ asset('images/logo.svg') }}" alt="Depiderme" class="block h-auto w-[132px] max-w-full">
                </a>
                <p class="mt-1.5 text-[0.78rem] text-white/50">Painel de gestão</p>
            </div>

            <nav class="flex-1 space-y-5 overflow-y-auto px-3.5 pb-4 [scrollbar-color:rgba(255,255,255,0.2)_transparent] [scrollbar-width:thin]" aria-label="Navegação principal">
                <div>
                    <p class="mb-2 px-2.5 text-[0.68rem] font-bold uppercase tracking-[0.1em] text-white/40">Menu</p>
                    <div class="space-y-0.5">
                        <x-admin.nav-link :href="route('admin.dashboard')" :active="AdminNavigation::isDashboard()">
                            <x-slot:icon><svg viewBox="0 0 20 20" fill="none" aria-hidden="true"><path d="M3 8.5 10 3l7 5.5V16a1.5 1.5 0 0 1-1.5 1.5H4.5A1.5 1.5 0 0 1 3 16V8.5Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/><path d="M8 17.5V11h4v6.5" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/></svg></x-slot:icon>
                            Dashboard
                        </x-admin.nav-link>
                        <x-admin.nav-link :href="route('admin.submissions.index')" :active="AdminNavigation::isSubmissions()" :badge="$adminNewSubmissions > 0 ? $adminNewSubmissions : null">
                            <x-slot:icon><svg viewBox="0 0 20 20" fill="none" aria-hidden="true"><path d="M4 4.5h12v11H4z" stroke="currentColor" stroke-width="1.5"/><path d="M7 8h6M7 11h4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg></x-slot:icon>
                            Formulários
                        </x-admin.nav-link>
                    </div>
                </div>

                <div>
                    <p class="mb-2 px-2.5 text-[0.68rem] font-bold uppercase tracking-[0.1em] text-white/40">Conteúdo do site</p>
                    <div class="space-y-0.5">
                        @foreach ($adminContentPages as $slug => $pageConfig)
                            <x-admin.nav-link
                                :href="route('admin.content.edit', $slug)"
                                :active="AdminNavigation::isPage($slug)"
                                :path="$pageConfig['url'] ?? null"
                            >
                                <x-slot:icon><svg viewBox="0 0 20 20" fill="none" aria-hidden="true"><path d="M5 3.5h7l3 3V16.5H5z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/><path d="M12 3.5V7h3" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/></svg></x-slot:icon>
                                {{ $pageConfig['label'] }}
                            </x-admin.nav-link>
                        @endforeach
                    </div>
                </div>

                <div>
                    <p class="mb-2 px-2.5 text-[0.68rem] font-bold uppercase tracking-[0.1em] text-white/40">Definições</p>
                    <x-admin.nav-link :href="route('admin.content.edit', 'global')" :active="AdminNavigation::isPage('global')" hint="Navbar & footer">
                        <x-slot:icon><svg viewBox="0 0 20 20" fill="none" aria-hidden="true"><circle cx="10" cy="10" r="2.25" stroke="currentColor" stroke-width="1.5"/><path d="M10 3v1.5M10 15.5V17M3 10h1.5M15.5 10H17" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg></x-slot:icon>
                        Global
                    </x-admin.nav-link>
                </div>
            </nav>

            <div class="shrink-0 border-t border-white/8 bg-black/10 px-5 py-4">
                @if ($adminUser)
                    <p class="mb-3">
                        <span class="block text-[0.68rem] font-bold uppercase tracking-[0.08em] text-white/40">Sessão</span>
                        <span class="mt-0.5 block break-all text-[0.8rem] text-white/85">{{ $adminUser->email }}</span>
                    </p>
                @endif
                <a href="{{ url('/') }}" target="_blank" rel="noopener" class="mb-3 inline-flex items-center gap-1.5 text-[0.82rem] font-semibold text-white/75 no-underline hover:text-white">
                    Ver site público
                    <svg width="14" height="14" viewBox="0 0 16 16" fill="none" aria-hidden="true"><path d="M5 3h8v8M11 5 4 12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </a>
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <x-admin.button type="submit" variant="sidebar">Terminar sessão</x-admin.button>
                </form>
            </div>
        </aside>

        <main class="min-w-0 flex-1 p-6 lg:p-8 lg:px-10">
            @if (session('success'))
                <div class="mb-4 rounded-xl border border-[#abefc6] bg-[#ecfdf3] px-4 py-3 text-sm text-[#027a48]">{{ session('success') }}</div>
            @endif

            @if (optional($errors)->any())
                <div class="mb-4 rounded-xl border border-[#fecdca] bg-[#fef3f2] px-4 py-3 text-sm text-[#b42318]">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>
