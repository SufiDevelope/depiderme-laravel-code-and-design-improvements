@extends('layouts.admin')

@section('title', 'Formulários')

@section('content')
    <div class="mb-8 flex flex-wrap items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold tracking-tight">Formulários</h1>
            <p class="mt-2 text-[#667085]">Pedidos de marcação recebidos no site.</p>
        </div>

        <div class="flex flex-wrap gap-2">
            <x-admin.button :href="route('admin.submissions.index')" :variant="! $status ? 'primary' : 'secondary'">Todos</x-admin.button>
            <x-admin.button :href="route('admin.submissions.index', ['status' => 'new'])" :variant="$status === 'new' ? 'primary' : 'secondary'">Novos</x-admin.button>
            <x-admin.button :href="route('admin.submissions.index', ['status' => 'contacted'])" :variant="$status === 'contacted' ? 'primary' : 'secondary'">Contactados</x-admin.button>
        </div>
    </div>

    <x-admin.card class="!p-0 overflow-x-auto">
        <table class="w-full min-w-[720px] text-left text-sm">
            <thead>
                <tr class="border-b border-[#f0ecf5] text-[#667085]">
                    <th class="px-6 py-3 font-medium">Nome</th>
                    <th class="px-6 py-3 font-medium">Clínica</th>
                    <th class="px-6 py-3 font-medium">Motivo</th>
                    <th class="px-6 py-3 font-medium">Data</th>
                    <th class="px-6 py-3 font-medium">Estado</th>
                    <th class="px-6 py-3 font-medium"></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($submissions as $submission)
                    <tr class="border-b border-[#f0ecf5]">
                        <td class="px-6 py-3">
                            <p class="font-medium">{{ $submission->name }}</p>
                            <p class="text-[#667085]">{{ $submission->email }}</p>
                        </td>
                        <td class="px-6 py-3">{{ $submission->clinic }}</td>
                        <td class="px-6 py-3">{{ $submission->reason }}</td>
                        <td class="px-6 py-3">{{ $submission->created_at->format('d/m/Y H:i') }}</td>
                        <td class="px-6 py-3">
                            <x-admin.badge :variant="$submission->status">{{ $submission->status }}</x-admin.badge>
                        </td>
                        <td class="px-6 py-3 text-right">
                            <a href="{{ route('admin.submissions.show', $submission) }}" class="font-semibold text-[#5b2b82] no-underline">Ver</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center text-[#667085]">Ainda não há submissões.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </x-admin.card>

    <div class="mt-6">{{ $submissions->links() }}</div>
@endsection
