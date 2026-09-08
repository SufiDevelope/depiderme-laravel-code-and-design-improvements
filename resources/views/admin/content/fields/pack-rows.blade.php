@php
    $rows = old("fields.{$key}.rows", $value['rows'] ?? []);
    $listName = "{$inputName}[rows]";
@endphp

<x-admin.label>{{ $field['label'] }}</x-admin.label>
<div class="cms-pack-rows" data-pack-rows>
    <div data-pack-rows-list data-pack-rows-list="{{ $listName }}">
        @foreach ($rows as $rowIndex => $row)
            @include('admin.content.fields.pack-row', [
                'listName' => $listName,
                'rowIndex' => $rowIndex,
                'row' => $row,
                'media' => $media,
                'siteImages' => $siteImages ?? [],
                'open' => $loop->first,
            ])
        @endforeach
    </div>

    <button type="button" class="mt-3 inline-flex cursor-pointer items-center gap-1.5 rounded-full border border-dashed border-[#c9b8e8] bg-[#faf8fd] px-3.5 py-2 text-[0.82rem] font-semibold text-[#5b2b82] hover:bg-[#f3eefb]" data-pack-row-add>+ Adicionar linha</button>

    <template data-pack-row-template>
        @include('admin.content.fields.pack-row', [
            'listName' => $listName,
            'rowIndex' => '__ROW__',
            'row' => [],
            'media' => $media,
            'siteImages' => $siteImages ?? [],
            'open' => true,
            'isTemplate' => true,
        ])
    </template>

    <template data-pack-cell-template>
        @include('admin.content.fields.pack-cell', [
            'listName' => $listName,
            'rowIndex' => '__ROW__',
            'cellIndex' => '__CELL__',
            'cell' => ['type' => 'text'],
            'media' => $media,
            'siteImages' => $siteImages ?? [],
        ])
    </template>
</div>
