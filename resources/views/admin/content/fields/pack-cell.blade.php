@php
    $prefix = "{$listName}[{$rowIndex}][cells][{$cellIndex}]";
    $type = $cell['type'] ?? 'text';
@endphp

<div class="cms-pack-cell" data-pack-cell>
    <div class="cms-pack-cell__head">
        <x-admin.select class="cms-pack-cell__type" data-pack-cell-type name="{{ $prefix }}[type]">
            <option value="text" @selected($type === 'text')>Texto + preço</option>
            <option value="image" @selected($type === 'image')>Imagem</option>
        </x-admin.select>
        <button type="button" class="flex h-9 w-9 shrink-0 cursor-pointer items-center justify-center rounded-[0.55rem] border border-[#e8e4ef] bg-white text-lg leading-none text-[#667085] hover:border-[#fecdca] hover:bg-[#fef3f2] hover:text-[#b42318]" data-pack-cell-remove>×</button>
    </div>

    <div data-pack-cell-text @class(['cms-pack-cell__fields', 'hidden' => $type !== 'text'])>
        <x-admin.field-input type="text" data-field="label" name="{{ $prefix }}[label]" value="{{ $cell['label'] ?? '' }}" placeholder="Nome do pack" />
        <x-admin.field-input type="text" data-field="price" name="{{ $prefix }}[price]" value="{{ $cell['price'] ?? '' }}" placeholder="Preço (ex: 39€)" />
    </div>

    <div data-pack-cell-image @class(['cms-pack-cell__fields', 'hidden' => $type !== 'image'])>
        @include('admin.content.fields.image-picker', [
            'inputName' => "{$prefix}[image]",
            'inputId' => "pack-{$rowIndex}-{$cellIndex}-img",
            'value' => $cell['image'] ?? '',
            'media' => $media,
            'siteImages' => $siteImages ?? [],
            'dataField' => 'image',
        ])
        <x-admin.field-input class="mt-2" type="text" data-field="alt" name="{{ $prefix }}[alt]" value="{{ $cell['alt'] ?? '' }}" placeholder="Descrição da imagem" />
    </div>
</div>
