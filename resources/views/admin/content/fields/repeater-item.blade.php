@php
    $titleValue = $itemTitle ? ($item[$itemTitle] ?? '') : '';
    $displayTitle = is_string($titleValue) && $titleValue !== '' ? $titleValue : 'Novo item';
@endphp

<div @class(['cms-repeater__item', 'is-open' => $open ?? false]) data-repeater-item>
    <div class="cms-repeater__header">
        <button type="button" class="cms-repeater__toggle" data-repeater-toggle aria-expanded="{{ ($open ?? false) ? 'true' : 'false' }}">
            <span class="cms-repeater__chevron" aria-hidden="true"></span>
            <span class="cms-repeater__title" data-repeater-title>{{ $displayTitle }}</span>
        </button>
        <button type="button" class="flex h-9 w-9 shrink-0 cursor-pointer items-center justify-center rounded-[0.55rem] border border-[#e8e4ef] bg-white text-lg leading-none text-[#667085] hover:border-[#fecdca] hover:bg-[#fef3f2] hover:text-[#b42318]" data-repeater-remove title="Remover">×</button>
    </div>

    <div class="cms-repeater__body">
        <div class="cms-repeater__grid">
            @foreach ($itemFields as $subKey => $subField)
                @if (! cms_field_editable($subField))
                    @continue
                @endif
                @php
                    $subType = $subField['type'] ?? 'text';
                    $subValue = $item[$subKey] ?? ($subType === 'list' ? ['items' => []] : '');
                    $subName = "{$listName}[{$index}][{$subKey}]";
                    $subId = 'field-' . Str::slug($key ?? 'item') . "-{$index}-{$subKey}";
                @endphp

                <div @class([
                    'cms-subfield',
                    'cms-subfield--full' => in_array($subType, ['textarea', 'list', 'repeater'], true),
                ])>
                    @if ($subType === 'list')
                        @php
                            $listItems = is_array($subValue) ? ($subValue['items'] ?? $subValue) : [];
                            $isImageList = ($subField['item_type'] ?? '') === 'image';
                        @endphp
                        <x-admin.label>{{ $subField['label'] }}</x-admin.label>
                        @if ($isImageList)
                            <div class="cms-img-list cms-img-list--compact" data-img-list-root data-nested-list data-nested-list="{{ $subKey }}">
                                <div class="cms-img-list__grid" data-img-list data-img-list="{{ $subName }}[items]">
                                    @forelse ($listItems as $li => $listItem)
                                        <div class="cms-img-list__item" data-img-list-item>
                                            @include('admin.content.fields.image-picker', [
                                                'inputName' => "{$subName}[items][{$li}]",
                                                'inputId' => $subId . '-img-' . $li,
                                                'value' => $listItem,
                                                'media' => $media,
                                                'siteImages' => $siteImages ?? [],
                                            ])
                                            <button type="button" class="cms-img-list__remove" data-img-list-remove>×</button>
                                        </div>
                                    @empty
                                        <div class="cms-img-list__item" data-img-list-item>
                                            @include('admin.content.fields.image-picker', [
                                                'inputName' => "{$subName}[items][0]",
                                                'inputId' => $subId . '-img-0',
                                                'value' => '',
                                                'media' => $media,
                                                'siteImages' => $siteImages ?? [],
                                            ])
                                            <button type="button" class="cms-img-list__remove" data-img-list-remove>×</button>
                                        </div>
                                    @endforelse
                                </div>
                                <button type="button" class="mt-2 inline-flex cursor-pointer items-center gap-1.5 rounded-full border border-dashed border-[#c9b8e8] bg-[#faf8fd] px-3 py-1.5 text-xs font-semibold text-[#5b2b82] hover:bg-[#f3eefb]" data-img-list-add>+ {{ $subField['add_label'] ?? 'Adicionar imagem' }}</button>
                            </div>
                        @else
                        <div class="cms-list cms-list--compact" data-list-root data-nested-list data-nested-list="{{ $subKey }}">
                            <div class="cms-list__items" data-list data-list="{{ $subName }}[items]">
                                @forelse ($listItems as $li => $listItem)
                                    <div class="cms-list__row">
                                        <x-admin.field-input type="text" data-list-field name="{{ $subName }}[items][{{ $li }}]" value="{{ $listItem }}" placeholder="{{ $subField['item_placeholder'] ?? '' }}" />
                                        <button type="button" class="flex h-9 w-9 shrink-0 cursor-pointer items-center justify-center rounded-[0.55rem] border border-[#e8e4ef] bg-white text-lg leading-none text-[#667085] hover:border-[#fecdca] hover:bg-[#fef3f2] hover:text-[#b42318]" data-list-remove>×</button>
                                    </div>
                                @empty
                                    <div class="cms-list__row">
                                        <x-admin.field-input type="text" data-list-field name="{{ $subName }}[items][0]" value="" placeholder="{{ $subField['item_placeholder'] ?? '' }}" />
                                        <button type="button" class="flex h-9 w-9 shrink-0 cursor-pointer items-center justify-center rounded-[0.55rem] border border-[#e8e4ef] bg-white text-lg leading-none text-[#667085] hover:border-[#fecdca] hover:bg-[#fef3f2] hover:text-[#b42318]" data-list-remove>×</button>
                                    </div>
                                @endforelse
                            </div>
                            <button type="button" class="mt-2 inline-flex cursor-pointer items-center gap-1.5 rounded-full border border-dashed border-[#c9b8e8] bg-[#faf8fd] px-3 py-1.5 text-xs font-semibold text-[#5b2b82] hover:bg-[#f3eefb]" data-list-add>+ {{ $subField['add_label'] ?? 'Adicionar' }}</button>
                        </div>
                        @endif
                    @elseif ($subType === 'repeater')
                        @php
                            $nestedItems = is_array($subValue) ? ($subValue['items'] ?? $subValue) : [];
                        @endphp
                        <x-admin.label>{{ $subField['label'] }}</x-admin.label>
                        <div class="cms-repeater cms-repeater--nested" data-repeater data-nested-repeater data-nested-repeater="{{ $subKey }}">
                            <div data-repeater-list data-repeater-list="{{ $subName }}[items]">
                                @foreach ($nestedItems as $ni => $nestedItem)
                                    @include('admin.content.fields.repeater-item', [
                                        'listName' => "{$subName}[items]",
                                        'index' => $ni,
                                        'item' => $nestedItem,
                                        'itemFields' => $subField['item_fields'] ?? [],
                                        'itemTitle' => $subField['item_title'] ?? null,
                                        'media' => $media,
                                        'siteImages' => $siteImages ?? [],
                                        'open' => false,
                                    ])
                                @endforeach
                            </div>
                            <button type="button" class="mt-2 inline-flex cursor-pointer items-center gap-1.5 rounded-full border border-dashed border-[#c9b8e8] bg-[#faf8fd] px-3 py-1.5 text-xs font-semibold text-[#5b2b82] hover:bg-[#f3eefb]" data-repeater-add>+ {{ $subField['add_label'] ?? 'Adicionar' }}</button>
                            <template data-repeater-template>
                                @include('admin.content.fields.repeater-item', [
                                    'listName' => "{$subName}[items]",
                                    'index' => '__INDEX__',
                                    'item' => [],
                                    'itemFields' => $subField['item_fields'] ?? [],
                                    'itemTitle' => $subField['item_title'] ?? null,
                                    'media' => $media,
                                    'open' => true,
                                    'isTemplate' => true,
                                ])
                            </template>
                        </div>
                    @elseif ($subType === 'textarea')
                        <x-admin.label :for="$subId">{{ $subField['label'] }}</x-admin.label>
                        <x-admin.textarea
                            id="{{ $subId }}"
                            name="{{ $subName }}"
                            rows="{{ $subField['rows'] ?? 3 }}"
                            data-repeater-field
                            data-repeater-field="{{ $subKey }}"
                            :data-title-source="$subKey === $itemTitle ? true : null"
                        >{{ $subValue }}</x-admin.textarea>
                    @elseif ($subType === 'image')
                        <x-admin.label>{{ $subField['label'] }}</x-admin.label>
                        @include('admin.content.fields.image-picker', [
                            'inputName' => $subName,
                            'inputId' => $subId,
                            'value' => $subValue,
                            'media' => $media,
                            'siteImages' => $siteImages ?? [],
                            'repeaterField' => $subKey,
                        ])
                    @elseif ($subType === 'select')
                        <x-admin.label :for="$subId">{{ $subField['label'] }}</x-admin.label>
                        <x-admin.select
                            id="{{ $subId }}"
                            name="{{ $subName }}"
                            data-repeater-field
                            data-repeater-field="{{ $subKey }}"
                        >
                            @foreach ($subField['options'] ?? [] as $optValue => $optLabel)
                                <option value="{{ $optValue }}" @selected(($subValue ?? '') == $optValue)>{{ $optLabel }}</option>
                            @endforeach
                        </x-admin.select>
                    @elseif ($subType === 'checkbox')
                        <label class="cms-checkbox">
                            <input type="checkbox" name="{{ $subName }}" value="1" @checked(filter_var($subValue, FILTER_VALIDATE_BOOLEAN)) data-repeater-field="{{ $subKey }}">
                            <span>{{ $subField['label'] }}</span>
                        </label>
                    @elseif ($subType === 'number')
                        <x-admin.label :for="$subId">{{ $subField['label'] }}</x-admin.label>
                        <x-admin.field-input
                            id="{{ $subId }}"
                            type="number"
                            name="{{ $subName }}"
                            value="{{ $subValue }}"
                            data-repeater-field
                            data-repeater-field="{{ $subKey }}"
                        />
                    @else
                        <x-admin.label :for="$subId">{{ $subField['label'] }}</x-admin.label>
                        <x-admin.field-input
                            id="{{ $subId }}"
                            type="text"
                            name="{{ $subName }}"
                            value="{{ $subValue }}"
                            data-repeater-field
                            data-repeater-field="{{ $subKey }}"
                            :data-title-source="$subKey === $itemTitle ? true : null"
                            placeholder="{{ $subField['placeholder'] ?? '' }}"
                        />
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</div>
