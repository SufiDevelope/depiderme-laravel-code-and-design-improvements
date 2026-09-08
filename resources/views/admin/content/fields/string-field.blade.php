@php($inputValue = old('fields.' . $key, $value))

<label class="cms-field__label" for="{{ $fieldId }}">{{ $field['label'] }}</label>
<input
    type="text"
    id="{{ $fieldId }}"
    name="{{ $inputName }}"
    value="{{ $inputValue }}"
    class="cms-input"
    @if (! empty($field['placeholder'])) placeholder="{{ $field['placeholder'] }}" @endif
>
