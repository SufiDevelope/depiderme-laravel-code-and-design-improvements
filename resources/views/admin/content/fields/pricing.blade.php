@php
    $genders = old("fields.{$key}.genders", $value ?? []);
    if (! is_array($genders)) {
        $genders = [];
    }
    $listName = "{$inputName}[genders]";
@endphp

<x-admin.label>{{ $field['label'] }}</x-admin.label>
<div class="cms-pricing" data-pricing>
    <div class="cms-pricing__genders" data-pricing-genders data-pricing-genders="{{ $listName }}">
        @foreach ($genders as $gIndex => $gender)
            <div class="cms-pricing__gender" data-pricing-gender>
                <div class="cms-pricing__gender-head">
                    <div class="cms-pricing__gender-fields">
                        <div>
                            <x-admin.label>Identificador</x-admin.label>
                            <x-admin.field-input type="text" data-pricing-field data-pricing-field="id" name="{{ $listName }}[{{ $gIndex }}][id]" value="{{ $gender['id'] ?? '' }}" placeholder="mulher" />
                        </div>
                        <div>
                            <x-admin.label>Nome no separador</x-admin.label>
                            <x-admin.field-input type="text" data-pricing-field data-pricing-field="label" name="{{ $listName }}[{{ $gIndex }}][label]" value="{{ $gender['label'] ?? '' }}" placeholder="Mulher" />
                        </div>
                    </div>
                </div>

                <div class="cms-pricing__sections" data-pricing-sections>
                    @foreach ($gender['sections'] ?? [] as $sIndex => $section)
                        @include('admin.content.fields.pricing-section', [
                            'listName' => $listName,
                            'gIndex' => $gIndex,
                            'sIndex' => $sIndex,
                            'section' => $section,
                            'open' => $loop->first,
                        ])
                    @endforeach
                </div>

                <button type="button" class="mt-2 inline-flex cursor-pointer items-center gap-1.5 rounded-full border border-dashed border-[#c9b8e8] bg-[#faf8fd] px-3 py-1.5 text-xs font-semibold text-[#5b2b82] hover:bg-[#f3eefb]" data-pricing-section-add>+ Adicionar secção</button>
            </div>
        @endforeach
    </div>

    <template data-pricing-section-template>
        @include('admin.content.fields.pricing-section', [
            'listName' => $listName,
            'gIndex' => '__G__',
            'sIndex' => '__S__',
            'section' => ['title' => '', 'items' => []],
            'open' => true,
        ])
    </template>

    <template data-pricing-item-template>
        @include('admin.content.fields.pricing-item', [
            'listName' => $listName,
            'gIndex' => '__G__',
            'sIndex' => '__S__',
            'iIndex' => '__I__',
            'item' => [],
        ])
    </template>
</div>
