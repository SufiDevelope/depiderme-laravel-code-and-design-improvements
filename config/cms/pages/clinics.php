<?php

return [
    'slug' => 'clinics',
    'label' => 'Clínicas',
    'url' => '/clinics',
    'fields' => [
        'hero.title_line1' => [
            'section' => 'Hero',
            'label' => 'Título — linha 1',
            'type' => 'textarea',
            'default' => "O caminho para uma pele perfeita",
        ],
        'hero.title_highlight' => [
            'section' => 'Hero',
            'label' => 'Título — destaque',
            'type' => 'text',
            'default' => 'começa aqui',
        ],
        'clinics.list' => [
            'section' => 'Clínicas',
            'label' => 'Lista de clínicas',
            'type' => 'repeater',
            'add_label' => 'Adicionar clínica',
            'item_title' => 'city',
            'item_fields' => [
                'city' => ['label' => 'Cidade', 'type' => 'text'],
                'image' => ['label' => 'Imagem principal', 'type' => 'image'],
                'address' => ['label' => 'Morada', 'type' => 'textarea'],
                'phone' => ['label' => 'Telefone', 'type' => 'text'],
                'email' => ['label' => 'Email', 'type' => 'text'],
                'gallery' => ['label' => 'Galeria de fotos', 'type' => 'list', 'item_type' => 'image', 'add_label' => 'Adicionar foto'],
            ],
            'default' => require __DIR__.'/../data/clinics.php',
        ],
    ],
];
