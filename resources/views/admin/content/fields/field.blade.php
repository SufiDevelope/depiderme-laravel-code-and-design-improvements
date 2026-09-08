@php
    $fieldId = 'field-' . Str::slug($key);
    $inputName = "fields[{$key}]";
    $value = $field['value'] ?? '';
@endphp

<div class="cms-field">
    @switch($field['type'])
        @case('textarea')
            @include('admin.content.fields.textarea', compact('key', 'field', 'fieldId', 'inputName', 'value'))
            @break

        @case('image')
            @include('admin.content.fields.image', compact('key', 'field', 'fieldId', 'inputName', 'value', 'media', 'siteImages'))
            @break

        @case('list')
            @include('admin.content.fields.list', compact('key', 'field', 'fieldId', 'inputName', 'value', 'media', 'siteImages'))
            @break

        @case('links')
            @include('admin.content.fields.links', compact('key', 'field', 'fieldId', 'inputName', 'value'))
            @break

        @case('repeater')
            @include('admin.content.fields.repeater', compact('key', 'field', 'fieldId', 'inputName', 'value', 'media', 'siteImages'))
            @break

        @case('pack_rows')
            @include('admin.content.fields.pack-rows', compact('key', 'field', 'fieldId', 'inputName', 'value', 'media', 'siteImages'))
            @break

        @case('pricing')
            @include('admin.content.fields.pricing', compact('key', 'field', 'fieldId', 'inputName', 'value'))
            @break

        @default
            @include('admin.content.fields.string-field', compact('key', 'field', 'fieldId', 'inputName', 'value'))
    @endswitch
</div>
