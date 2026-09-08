@php
    $items = old("fields.{$key}.items", $value ?? []);
    if (! is_array($items)) {
        $items = [];
    }
    $listName = "{$inputName}[items]";
@endphp

<x-admin.label>{{ $field['label'] }}</x-admin.label>
<div class="cms-links" data-links-root>
    <div class="cms-links__head">
        <span>Texto</span>
        <span>URL</span>
        <span></span>
    </div>
    <div class="cms-links__list" data-links-list data-links-list="{{ $listName }}">
        @forelse ($items as $index => $item)
            <div class="cms-links__row" data-links-item>
                <x-admin.field-input type="text" name="{{ $listName }}[{{ $index }}][label]" value="{{ $item['label'] ?? '' }}" placeholder="Texto do link" />
                <x-admin.field-input type="text" name="{{ $listName }}[{{ $index }}][url]" value="{{ $item['url'] ?? '' }}" placeholder="/pagina" />
                <button type="button" class="flex h-9 w-9 shrink-0 cursor-pointer items-center justify-center rounded-[0.55rem] border border-[#e8e4ef] bg-white text-lg leading-none text-[#667085] hover:border-[#fecdca] hover:bg-[#fef3f2] hover:text-[#b42318]" data-links-remove title="Remover">×</button>
            </div>
        @empty
            <div class="cms-links__row" data-links-item>
                <x-admin.field-input type="text" name="{{ $listName }}[0][label]" value="" placeholder="Texto do link" />
                <x-admin.field-input type="text" name="{{ $listName }}[0][url]" value="" placeholder="/pagina" />
                <button type="button" class="flex h-9 w-9 shrink-0 cursor-pointer items-center justify-center rounded-[0.55rem] border border-[#e8e4ef] bg-white text-lg leading-none text-[#667085] hover:border-[#fecdca] hover:bg-[#fef3f2] hover:text-[#b42318]" data-links-remove title="Remover">×</button>
            </div>
        @endforelse
    </div>
    <button type="button" class="mt-3 inline-flex cursor-pointer items-center gap-1.5 rounded-full border border-dashed border-[#c9b8e8] bg-[#faf8fd] px-3.5 py-2 text-[0.82rem] font-semibold text-[#5b2b82] hover:bg-[#f3eefb]" data-links-add>+ {{ $field['add_label'] ?? 'Adicionar link' }}</button>
</div>
