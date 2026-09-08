<?php

return [
    'slug' => 'pricing',
    'label' => 'Preços',
    'url' => '/pricing',
    'fields' => [
        'hero.title_line1' => [
            'section' => 'Hero',
            'label' => 'Título — linha 1',
            'type' => 'text',
            'default' => 'Os',
        ],
        'hero.title_highlight' => [
            'section' => 'Hero',
            'label' => 'Título — destaque',
            'type' => 'text',
            'default' => 'melhores resultados',
        ],
        'hero.title_line2' => [
            'section' => 'Hero',
            'label' => 'Título — linhas 2-3',
            'type' => 'textarea',
            'default' => "no mais curto intervalo\nde tempo",
        ],
        'hero.orbs' => [
            'type' => 'repeater',
            'editable' => false,
            'default' => [
                ['image' => 'pricing-legs.png', 'alt' => 'Depilação laser pernas', 'class' => 'pricing-hero__orb--legs'],
                ['image' => 'pricing-face.png', 'alt' => 'Depilação laser rosto', 'class' => 'pricing-hero__orb--face'],
                ['image' => 'pricing-arm.png', 'alt' => 'Depilação laser axilas', 'class' => 'pricing-hero__orb--arm'],
                ['image' => 'pricing-front.png', 'alt' => 'Depilação laser torso', 'class' => 'pricing-hero__orb--front'],
                ['image' => 'pricing-neck.png', 'alt' => 'Depilação laser pescoço', 'class' => 'pricing-hero__orb--neck'],
                ['image' => 'pricing-back.png', 'alt' => 'Depilação laser costas', 'class' => 'pricing-hero__orb--back'],
            ],
        ],
        'table.data' => [
            'section' => 'Tabela de preços',
            'label' => 'Preços por género e secção',
            'type' => 'pricing',
            'default' => require __DIR__.'/../data/pricing.php',
        ],
    ],
];
