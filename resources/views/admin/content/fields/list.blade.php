@php
    $items = old("fields.{$key}.items", $value['items'] ?? []);
    $listName = "{$inputName}[items]";
    $isImageList = ($field['item_type'] ?? '') === 'image';
@endphp

<x-admin.label>{{ $field['label'] }}</x-admin.label>

@if ($isImageList)
    <div class="cms-img-list" data-img-list-root>
        <div class="cms-img-list__grid" data-img-list data-img-list="{{ $listName }}">
            @forelse ($items as $index => $item)
                <div class="cms-img-list__item" data-img-list-item>
                    @include('admin.content.fields.image-picker', [
                        'inputName' => "{$listName}[{$index}]",
                        'inputId' => 'img-list-' . Str::slug($key) . "-{$index}",
                        'value' => $item,
                        'media' => $media,
                        'siteImages' => $siteImages ?? [],
                    ])
                    <button type="button" class="cms-img-list__remove" data-img-list-remove title="Remover">×</button>
                </div>
            @empty
                <div class="cms-img-list__item" data-img-list-item>
                    @include('admin.content.fields.image-picker', [
                        'inputName' => "{$listName}[0]",
                        'inputId' => 'img-list-' . Str::slug($key) . '-0',
                        'value' => '',
                        'media' => $media,
                        'siteImages' => $siteImages ?? [],
                    ])
                    <button type="button" class="cms-img-list__remove" data-img-list-remove title="Remover">×</button>
                </div>
            @endforelse
        </div>
        <button type="button" class="mt-3 inline-flex cursor-pointer items-center gap-1.5 rounded-full border border-dashed border-[#c9b8e8] bg-[#faf8fd] px-3.5 py-2 text-[0.82rem] font-semibold text-[#5b2b82] hover:bg-[#f3eefb]" data-img-list-add>+ {{ $field['add_label'] ?? 'Adicionar imagem' }}</button>
    </div>
@else
    <div class="cms-list" data-list-root>
        <div class="cms-list__items" data-list data-list="{{ $listName }}">
            @forelse ($items as $index => $item)
                <div class="cms-list__row">
                    <x-admin.field-input
                        type="text"
                        data-list-field
                        name="{{ $listName }}[{{ $index }}]"
                        value="{{ $item }}"
                        placeholder="{{ $field['item_placeholder'] ?? 'Novo item' }}"
                    />
                    <button type="button" class="flex h-9 w-9 shrink-0 cursor-pointer items-center justify-center rounded-[0.55rem] border border-[#e8e4ef] bg-white text-lg leading-none text-[#667085] hover:border-[#fecdca] hover:bg-[#fef3f2] hover:text-[#b42318]" data-list-remove title="Remover">×</button>
                </div>
            @empty
                <div class="cms-list__row">
                    <x-admin.field-input type="text" data-list-field name="{{ $listName }}[0]" value="" placeholder="{{ $field['item_placeholder'] ?? 'Novo item' }}" />
                    <button type="button" class="flex h-9 w-9 shrink-0 cursor-pointer items-center justify-center rounded-[0.55rem] border border-[#e8e4ef] bg-white text-lg leading-none text-[#667085] hover:border-[#fecdca] hover:bg-[#fef3f2] hover:text-[#b42318]" data-list-remove title="Remover">×</button>
                </div>
            @endforelse
        </div>
        <button type="button" class="mt-3 inline-flex cursor-pointer items-center gap-1.5 rounded-full border border-dashed border-[#c9b8e8] bg-[#faf8fd] px-3.5 py-2 text-[0.82rem] font-semibold text-[#5b2b82] hover:bg-[#f3eefb]" data-list-add>+ {{ $field['add_label'] ?? 'Adicionar item' }}</button>
    </div>
@endif

@if (! empty($field['hint']))
    <x-admin.hint>{{ $field['hint'] }}</x-admin.hint>
@endif

<template data-img-list-template>
    <div class="cms-img-list__item" data-img-list-item>
        <div class="cms-img-picker" data-img-picker>
            <input type="hidden" value="" data-img-input>
            <div class="cms-img-picker__frame" data-img-frame>
                <button type="button" class="cms-img-picker__empty" data-img-replace>
                    <span class="cms-img-picker__empty-icon">+</span>
                    <span>Escolher imagem</span>
                </button>
            </div>
        </div>
        <button type="button" class="cms-img-list__remove" data-img-list-remove title="Remover">×</button>
    </div>
</template>
