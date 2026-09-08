<div @class(['cms-pack-row', 'is-open' => $open ?? false]) data-pack-row>
    <div class="cms-repeater__header">
        <button type="button" class="cms-repeater__toggle" data-pack-row-toggle>
            <span class="cms-repeater__chevron"></span>
            <span data-pack-row-label>Linha {{ is_numeric($rowIndex) ? $rowIndex + 1 : '' }}</span>
        </button>
        <button type="button" class="flex h-9 w-9 shrink-0 cursor-pointer items-center justify-center rounded-[0.55rem] border border-[#e8e4ef] bg-white text-lg leading-none text-[#667085] hover:border-[#fecdca] hover:bg-[#fef3f2] hover:text-[#b42318]" data-pack-row-remove>×</button>
    </div>

    <div class="cms-repeater__body">
        <div class="cms-pack-cells" data-pack-cells>
            @foreach ($row as $cellIndex => $cell)
                @include('admin.content.fields.pack-cell', [
                    'listName' => $listName,
                    'rowIndex' => $rowIndex,
                    'cellIndex' => $cellIndex,
                    'cell' => $cell,
                    'media' => $media,
                    'siteImages' => $siteImages ?? [],
                ])
            @endforeach
        </div>
        <button type="button" class="mt-2 inline-flex cursor-pointer items-center gap-1.5 rounded-full border border-dashed border-[#c9b8e8] bg-[#faf8fd] px-3 py-1.5 text-xs font-semibold text-[#5b2b82] hover:bg-[#f3eefb]" data-pack-cell-add>+ Adicionar célula</button>
    </div>
</div>
