<?php

namespace App\Services;

class CmsFieldService
{
    public function valueForForm(mixed $raw, array $field): mixed
    {
        $type = $field['type'] ?? 'text';
        $default = $field['default'] ?? null;

        if ($raw === null || $raw === '') {
            $decoded = $default;
        } elseif (in_array($type, ['list', 'links', 'repeater', 'pack_rows', 'pricing', 'json'], true)) {
            $decoded = is_array($raw) ? $raw : json_decode($raw, true);
        } else {
            return $raw;
        }

        return $this->normalizeForForm($decoded ?? $default, $field);
    }

    public function normalizeForForm(mixed $value, array $field): mixed
    {
        $type = $field['type'] ?? 'text';

        if ($type === 'links' && is_array($value)) {
            if (array_is_list($value)) {
                return $value;
            }

            return collect($value)
                ->map(fn ($url, $label) => ['label' => (string) $label, 'url' => (string) $url])
                ->values()
                ->all();
        }

        if ($type === 'pricing' && is_array($value)) {
            if (array_is_list($value)) {
                return $value;
            }

            return collect($value)
                ->map(fn ($gender, $id) => array_merge(['id' => (string) $id], $gender))
                ->values()
                ->all();
        }

        if ($type === 'pack_rows' && is_array($value) && array_is_list($value)) {
            return ['rows' => $value];
        }

        if ($type === 'list' && is_array($value)) {
            return ['items' => array_values($value)];
        }

        if ($type === 'repeater' && is_array($value) && array_is_list($value)) {
            return ['items' => $value];
        }

        return $value;
    }

    public function valueForStorage(mixed $input, array $field, mixed $existingRaw = null): string
    {
        $type = $field['type'] ?? 'text';

        if ($type === 'links') {
            $items = is_array($input) ? ($input['items'] ?? []) : [];
            $assoc = [];

            foreach ($items as $item) {
                $label = trim((string) ($item['label'] ?? ''));
                if ($label !== '') {
                    $assoc[$label] = trim((string) ($item['url'] ?? '#')) ?: '#';
                }
            }

            return json_encode($assoc, JSON_UNESCAPED_UNICODE);
        }

        if ($type === 'pricing') {
            $genders = is_array($input) ? ($input['genders'] ?? []) : [];
            $assoc = [];

            foreach ($genders as $gender) {
                $id = trim((string) ($gender['id'] ?? ''));
                if ($id === '') {
                    continue;
                }

                $assoc[$id] = [
                    'label' => (string) ($gender['label'] ?? ''),
                    'sections' => $this->cleanRepeaterItems($gender['sections'] ?? [], [
                        'item_fields' => [
                            'title' => ['type' => 'text'],
                            'items' => [
                                'type' => 'repeater',
                                'item_fields' => [
                                    'name' => ['type' => 'text'],
                                    'price' => ['type' => 'text'],
                                ],
                            ],
                        ],
                    ]),
                ];
            }

            return json_encode($assoc, JSON_UNESCAPED_UNICODE);
        }

        if ($type === 'pack_rows') {
            $rows = is_array($input) ? ($input['rows'] ?? []) : [];
            $clean = [];

            foreach ($rows as $row) {
                $cells = [];
                foreach ($row['cells'] ?? [] as $cell) {
                    $cellType = $cell['type'] ?? 'text';
                    if ($cellType === 'image') {
                        $cells[] = array_filter([
                            'type' => 'image',
                            'image' => trim((string) ($cell['image'] ?? '')),
                            'alt' => trim((string) ($cell['alt'] ?? '')),
                            'widthClass' => trim((string) ($cell['widthClass'] ?? '')),
                        ], fn ($v) => $v !== '' && $v !== null);
                    } else {
                        $cells[] = array_filter([
                            'type' => 'text',
                            'label' => trim((string) ($cell['label'] ?? '')),
                            'price' => trim((string) ($cell['price'] ?? '')),
                        ], fn ($v) => $v !== '' && $v !== null);
                    }
                }
                if ($cells !== []) {
                    $clean[] = $cells;
                }
            }

            return json_encode($clean, JSON_UNESCAPED_UNICODE);
        }

        if ($type === 'list') {
            $items = is_array($input) ? ($input['items'] ?? []) : [];
            $clean = array_values(array_filter(
                array_map(fn ($item) => is_string($item) ? trim($item) : '', $items),
                fn ($item) => $item !== '',
            ));

            return json_encode($clean, JSON_UNESCAPED_UNICODE);
        }

        if ($type === 'repeater') {
            $items = is_array($input) ? ($input['items'] ?? []) : [];
            $existing = is_string($existingRaw)
                ? (json_decode($existingRaw, true) ?: [])
                : (is_array($existingRaw) ? $existingRaw : []);

            return json_encode(
                $this->cleanRepeaterItems($items, $field, is_array($existing) ? $existing : []),
                JSON_UNESCAPED_UNICODE,
            );
        }

        if ($type === 'json' && is_string($input)) {
            json_decode($input, true, 512, JSON_THROW_ON_ERROR);

            return $input;
        }

        return is_string($input) ? $input : '';
    }

    /**
     * @param  array<int, array<string, mixed>>  $items
     * @param  array<int, array<string, mixed>>  $existingItems
     * @return array<int, array<string, mixed>>
     */
    private function cleanRepeaterItems(array $items, array $field, array $existingItems = []): array
    {
        $schema = $field['item_fields'] ?? [];
        $clean = [];

        foreach ($items as $index => $item) {
            if (! is_array($item)) {
                continue;
            }

            $existing = $existingItems[$index] ?? [];
            $row = [];

            foreach ($schema as $key => $subField) {
                if (! cms_field_editable($subField)) {
                    if (array_key_exists($key, $existing)) {
                        $row[$key] = $existing[$key];
                    }
                    continue;
                }
                $subType = $subField['type'] ?? 'text';
                $value = $item[$key] ?? null;

                if ($subType === 'list') {
                    $listItems = is_array($value) ? ($value['items'] ?? $value) : [];
                    $row[$key] = array_values(array_filter(
                        array_map(fn ($v) => is_string($v) ? trim($v) : '', $listItems),
                        fn ($v) => $v !== '',
                    ));
                } elseif ($subType === 'repeater') {
                    $row[$key] = $this->cleanRepeaterItems(
                        is_array($value) ? ($value['items'] ?? $value) : [],
                        $subField,
                    );
                } elseif ($subType === 'checkbox') {
                    $row[$key] = filter_var($value, FILTER_VALIDATE_BOOLEAN);
                } elseif ($subType === 'number') {
                    $row[$key] = is_numeric($value) ? (int) $value : ($value ?? 0);
                } else {
                    $row[$key] = is_string($value) ? trim($value) : (string) ($value ?? '');
                }
            }

            foreach ($existing as $key => $value) {
                if (! array_key_exists($key, $schema)) {
                    $row[$key] = $value;
                }
            }

            if (collect($row)->filter(fn ($v) => $v !== '' && $v !== [] && $v !== null)->isNotEmpty()) {
                $clean[] = $row;
            }
        }

        return $clean;
    }
}
