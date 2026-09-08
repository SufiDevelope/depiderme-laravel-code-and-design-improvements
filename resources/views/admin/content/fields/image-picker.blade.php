@php
    $pickerId = $inputId ?? ('picker-' . Str::slug($inputName));
    $hasImage = is_string($value) && $value !== '';
    $previewUrl = $hasImage ? admin_asset_url($value) : '';
@endphp

<div class="cms-img-picker" data-img-picker>
    <input
        type="hidden"
        id="{{ $pickerId }}"
        name="{{ $inputName }}"
        value="{{ old(str_replace(['[', ']'], ['.', ''], $inputName), $value) }}"
        data-img-input
        @if (! empty($repeaterField)) data-repeater-field="{{ $repeaterField }}" @endif
        @if (! empty($dataField)) data-field="{{ $dataField }}" @endif
    >

    <div class="cms-img-picker__frame" data-img-frame>
        @if ($hasImage)
            <img src="{{ $previewUrl }}" alt="" class="cms-img-picker__img" data-img-preview>
            <div class="cms-img-picker__actions">
                <button type="button" class="cms-img-picker__btn" data-img-replace>Substituir</button>
                <button type="button" class="cms-img-picker__btn cms-img-picker__btn--ghost" data-img-remove>Remover</button>
            </div>
        @else
            <button type="button" class="cms-img-picker__empty" data-img-replace>
                <span class="cms-img-picker__empty-icon">+</span>
                <span>Escolher imagem</span>
            </button>
        @endif
    </div>
</div>
