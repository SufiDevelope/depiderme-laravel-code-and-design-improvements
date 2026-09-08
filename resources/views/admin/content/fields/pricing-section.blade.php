<div @class(['cms-pricing__section', 'is-open' => $open ?? false]) data-pricing-section>
    <div class="cms-repeater__header">
        <button type="button" class="cms-repeater__toggle" data-pricing-section-toggle>
            <span class="cms-repeater__chevron"></span>
            <span data-pricing-section-title>{{ $section['title'] ?? 'Nova secção' }}</span>
        </button>
        <button type="button" class="flex h-9 w-9 shrink-0 cursor-pointer items-center justify-center rounded-[0.55rem] border border-[#e8e4ef] bg-white text-lg leading-none text-[#667085] hover:border-[#fecdca] hover:bg-[#fef3f2] hover:text-[#b42318]" data-pricing-section-remove>×</button>
    </div>

    <div class="cms-repeater__body">
        <x-admin.label>Título da secção</x-admin.label>
        <x-admin.field-input
            class="mb-4"
            type="text"
            data-pricing-section-field
            data-pricing-section-field="title"
            data-pricing-section-name
            name="{{ $listName }}[{{ $gIndex }}][sections][{{ $sIndex }}][title]"
            value="{{ $section['title'] ?? '' }}"
            placeholder="Ex: Zona superior"
        />

        <x-admin.label>Tratamentos e preços</x-admin.label>
        <div class="cms-pricing__items" data-pricing-items>
            @foreach ($section['items'] ?? [] as $iIndex => $item)
                @include('admin.content.fields.pricing-item', compact('listName', 'gIndex', 'sIndex', 'iIndex', 'item'))
            @endforeach
        </div>
        <button type="button" class="mt-2 inline-flex cursor-pointer items-center gap-1.5 rounded-full border border-dashed border-[#c9b8e8] bg-[#faf8fd] px-3 py-1.5 text-xs font-semibold text-[#5b2b82] hover:bg-[#f3eefb]" data-pricing-item-add>+ Adicionar tratamento</button>
    </div>
</div>
