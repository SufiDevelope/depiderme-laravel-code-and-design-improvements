<x-admin.label :for="$fieldId">{{ $field['label'] }}</x-admin.label>
@include('admin.content.fields.image-picker', [
    'inputName' => $inputName,
    'inputId' => $fieldId,
    'value' => old('fields.' . $key, $value),
    'media' => $media,
    'siteImages' => $siteImages ?? [],
])
