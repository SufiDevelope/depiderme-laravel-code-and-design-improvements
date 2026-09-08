<div class="cms-pricing__item" data-pricing-item>
    <x-admin.field-input
        type="text"
        data-pricing-item-field
        data-pricing-item-field="name"
        name="{{ $listName }}[{{ $gIndex }}][sections][{{ $sIndex }}][items][{{ $iIndex }}][name]"
        value="{{ $item['name'] ?? '' }}"
        placeholder="Nome do tratamento"
    />
    <x-admin.field-input
        class="cms-pricing__price"
        type="text"
        data-pricing-item-field
        data-pricing-item-field="price"
        name="{{ $listName }}[{{ $gIndex }}][sections][{{ $sIndex }}][items][{{ $iIndex }}][price]"
        value="{{ $item['price'] ?? '' }}"
        placeholder="29€"
    />
    <button type="button" class="flex h-9 w-9 shrink-0 cursor-pointer items-center justify-center rounded-[0.55rem] border border-[#e8e4ef] bg-white text-lg leading-none text-[#667085] hover:border-[#fecdca] hover:bg-[#fef3f2] hover:text-[#b42318]" data-pricing-item-remove>×</button>
</div>
