@extends('layouts.admin')

@section('title', 'Pedido #'.$submission->id)

@section('content')
    <div class="mb-8">
        <a href="{{ route('admin.submissions.index') }}" class="text-sm font-semibold text-[#5b2b82] no-underline">← Voltar aos formulários</a>
        <h1 class="mt-2 text-3xl font-bold tracking-tight">Pedido de marcação</h1>
        <p class="mt-2 text-[#667085]">Recebido em {{ $submission->created_at->format('d/m/Y \à\s H:i') }}</p>
    </div>

    <div class="grid gap-6 lg:grid-cols-[2fr_1fr]">
        <x-admin.card class="space-y-4">
            @foreach ([
                ['label' => 'Nome', 'value' => $submission->name],
                ['label' => 'Email', 'value' => $submission->email, 'href' => 'mailto:'.$submission->email],
                ['label' => 'Telefone', 'value' => $submission->phone, 'href' => 'tel:'.$submission->phone],
            ] as $row)
                <div>
                    <p class="text-sm text-[#667085]">{{ $row['label'] }}</p>
                    <p class="font-medium">
                        @if (! empty($row['href']))
                            <a href="{{ $row['href'] }}" class="text-[#5b2b82] no-underline">{{ $row['value'] }}</a>
                        @else
                            {{ $row['value'] }}
                        @endif
                    </p>
                </div>
            @endforeach

            <div class="grid gap-4 sm:grid-cols-2">
                @foreach ([
                    ['Clínica', $submission->clinic],
                    ['Motivo', $submission->reason],
                    ['Zona do corpo', $submission->body_area ?: '—'],
                    ['Data preferencial', $submission->preferred_date ?: '—'],
                    ['Horário', $submission->preferred_time ?: '—'],
                ] as [$label, $value])
                    <div>
                        <p class="text-sm text-[#667085]">{{ $label }}</p>
                        <p class="font-medium">{{ $value }}</p>
                    </div>
                @endforeach
            </div>
        </x-admin.card>

        <div class="space-y-4">
            <x-admin.card>
                <h2 class="mb-4 font-bold">Estado</h2>
                <form action="{{ route('admin.submissions.status', $submission) }}" method="post" class="space-y-3">
                    @csrf
                    @method('PATCH')
                    <x-admin.select name="status">
                        @foreach (['new' => 'Novo', 'read' => 'Lido', 'contacted' => 'Contactado', 'archived' => 'Arquivado'] as $value => $label)
                            <option value="{{ $value }}" @selected($submission->status === $value)>{{ $label }}</option>
                        @endforeach
                    </x-admin.select>
                    <x-admin.button type="submit" variant="primary" class="!w-full">Atualizar</x-admin.button>
                </form>
            </x-admin.card>

            <x-admin.card>
                <form action="{{ route('admin.submissions.destroy', $submission) }}" method="post" onsubmit="return confirm('Eliminar esta submissão?')">
                    @csrf
                    @method('DELETE')
                    <x-admin.button type="submit" variant="danger" class="!w-full">Eliminar</x-admin.button>
                </form>
            </x-admin.card>
        </div>
    </div>
@endsection
