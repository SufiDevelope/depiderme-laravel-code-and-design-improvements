@php
    $items = old("fields.{$key}.items", $value['items'] ?? []);
    $listName = "{$inputName}[items]";
    $itemFields = $field['item_fields'] ?? [];
    $itemTitle = $field['item_title'] ?? null;
    $addLabel = $field['add_label'] ?? 'Adicionar';
@endphp

<x-admin.label>{{ $field['label'] }}</x-admin.label>
<div class="cms-repeater" data-repeater>
    <div class="cms-repeater__list" data-repeater-list data-repeater-list="{{ $listName }}">
        @foreach ($items as $index => $item)
            @include('admin.content.fields.repeater-item', [
                'listName' => $listName,
                'index' => $index,
                'item' => $item,
                'itemFields' => $itemFields,
                'itemTitle' => $itemTitle,
                'media' => $media,
                'siteImages' => $siteImages ?? [],
                'open' => $loop->first,
            ])
        @endforeach
    </div>

    <button type="button" class="mt-3 inline-flex cursor-pointer items-center gap-1.5 rounded-full border border-dashed border-[#c9b8e8] bg-[#faf8fd] px-3.5 py-2 text-[0.82rem] font-semibold text-[#5b2b82] hover:bg-[#f3eefb]" data-repeater-add>+ {{ $addLabel }}</button>

    @if (! empty($field['hint']))
        <x-admin.hint>{{ $field['hint'] }}</x-admin.hint>
    @endif

    <template data-repeater-template>
        @include('admin.content.fields.repeater-item', [
            'listName' => $listName,
            'index' => '__INDEX__',
            'item' => [],
            'itemFields' => $itemFields,
            'itemTitle' => $itemTitle,
            'media' => $media,
            'siteImages' => $siteImages ?? [],
            'open' => true,
            'isTemplate' => true,
        ])
    </template>
</div>
