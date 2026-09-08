<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login — Depiderme Admin</title>
    @vite(['resources/css/admin.css'])
</head>
<body class="min-h-screen bg-[#f3f0f8] font-sans text-[#231f20]">
    <div class="grid min-h-screen lg:grid-cols-2">
        <aside class="relative hidden overflow-hidden bg-[radial-gradient(circle_at_18%_22%,rgba(201,184,228,0.22),transparent_38%),radial-gradient(circle_at_82%_78%,rgba(91,43,130,0.35),transparent_42%),linear-gradient(160deg,#12081f,#1a0a2e_38%,#271841_72%,#5b2b82)] text-white lg:flex lg:items-center lg:justify-center lg:p-12">
            <div class="pointer-events-none absolute left-[8%] top-[12%] h-56 w-56 rounded-full bg-[#8877c2]/35 blur-3xl"></div>
            <div class="pointer-events-none absolute bottom-[14%] right-[10%] h-72 w-72 rounded-full bg-[#5b2b82]/45 blur-3xl"></div>
            <div class="relative z-10 max-w-sm">
                <img src="{{ asset('images/logo.svg') }}" alt="" class="block h-auto w-48 max-w-[70%]">
                <p class="mt-7 text-lg font-semibold leading-snug tracking-tight">Painel de gestão do site Depiderme</p>
                <p class="mt-3 text-sm leading-relaxed text-white/75">Edita conteúdos, imagens e acompanha os pedidos de marcação num só lugar.</p>
            </div>
        </aside>

        <main class="flex items-center justify-center p-6">
            <div class="w-full max-w-md rounded-2xl border border-[#e8e4ef] bg-white p-8 shadow-[0_20px_48px_rgba(26,10,46,0.08)] sm:p-9">
                <div class="mb-6 lg:hidden">
                    <img src="{{ asset('images/logo.svg') }}" alt="Depiderme" class="block h-auto w-36">
                    <p class="mt-2 text-[0.72rem] font-bold uppercase tracking-[0.1em] text-[#8877c2]">Painel de gestão</p>
                </div>

                <h1 class="text-3xl font-bold tracking-tight">Entrar</h1>
                <p class="mt-1 text-sm text-[#667085]">Acesso reservado a administradores.</p>

                <form action="{{ route('login') }}" method="post" class="mt-7 space-y-4">
                    @csrf

                    <div>
                        <x-admin.label for="email">Email</x-admin.label>
                        <x-admin.field-input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="admin@depiderme.pt" @class(['!border-[#f04438]' => $errors->has('email')]) />
                        @error('email')
                            <p class="mt-1.5 text-xs text-[#b42318]">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <x-admin.label for="password">Password</x-admin.label>
                        <x-admin.field-input id="password" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
                    </div>

                    <label class="flex cursor-pointer items-center gap-2 text-sm text-[#667085]">
                        <input type="checkbox" name="remember" value="1" @checked(old('remember')) class="h-4 w-4 accent-[#5b2b82]">
                        Manter sessão iniciada
                    </label>

                    <x-admin.button type="submit" variant="primary" class="!w-full">Entrar no painel</x-admin.button>
                </form>

                <a href="{{ url('/') }}" class="mt-5 inline-block text-sm font-semibold text-[#5b2b82] no-underline hover:opacity-75">← Voltar ao site público</a>
            </div>
        </main>
    </div>
</body>
</html>
