@php($inputValue = old('fields.' . $key, $value))

<label class="cms-field__label" for="{{ $fieldId }}">{{ $field['label'] }}</label>
<textarea
    id="{{ $fieldId }}"
    name="{{ $inputName }}"
    rows="{{ $field['rows'] ?? 4 }}"
    class="cms-textarea"
>{{ $inputValue }}</textarea>
@if (($field['hint'] ?? null) || ($field['type'] ?? '') === 'textarea')
    <p class="cms-field__hint">{{ $field['hint'] ?? 'Usa Enter para quebras de linha.' }}</p>
@endif
