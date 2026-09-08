<?php

return [
    'slug' => 'about',
    'label' => 'Sobre Nós',
    'url' => '/about',
    'fields' => [
        'hero.title_line1' => [
            'section' => 'Hero',
            'label' => 'Título — linha 1',
            'type' => 'text',
            'default' => 'Ciência e',
        ],
        'hero.title_highlight' => [
            'section' => 'Hero',
            'label' => 'Título — destaque',
            'type' => 'text',
            'default' => 'tecnologia',
        ],
        'hero.title_line2' => [
            'section' => 'Hero',
            'label' => 'Título — linha 2',
            'type' => 'text',
            'default' => 'em perfeita harmonia',
        ],
        'hero.description' => [
            'section' => 'Hero',
            'label' => 'Descrição',
            'type' => 'textarea',
            'default' => 'As Clínicas Depiderme são um grupo de clínicas médico-estéticas especializadas unicamente em tratamentos de depilação a laser.',
        ],
        'hero.bullets' => [
            'section' => 'Hero',
            'label' => 'Pontos fortes',
            'type' => 'list',
            'add_label' => 'Adicionar ponto',
            'default' => [
                'Protocolos de excelência',
                'Precisão personalizada',
                'Segurança certificada',
            ],
        ],
        'hero.card_text' => [
            'section' => 'Hero',
            'label' => 'Texto do cartão flutuante',
            'type' => 'textarea',
            'default' => 'A Depiderme é um grupo certificado e parceiro oficial da Candela Medical',
        ],
        'hero.image' => [
            'section' => 'Hero',
            'label' => 'Imagem principal',
            'type' => 'image',
            'default' => 'images/about-hero.png',
        ],
        'hero.image_alt' => [
            'editable' => false,
            'default' => 'Tratamento de depilação laser Depiderme',
        ],
        'hero.card_icon' => [
            'editable' => false,
            'default' => 'images/about-card-icon.png',
        ],
        'tech.title' => [
            'section' => 'Tecnologia',
            'label' => 'Título',
            'type' => 'textarea',
            'default' => "Tecnologia e\nequipamentos",
        ],
        'tech.button' => [
            'section' => 'Tecnologia',
            'label' => 'Texto do botão',
            'type' => 'text',
            'default' => 'Mais Sobre Depilação Laser',
        ],
        'tech.items' => [
            'section' => 'Tecnologia',
            'label' => 'Itens',
            'type' => 'repeater',
            'add_label' => 'Adicionar item',
            'item_title' => 'title',
            'item_fields' => [
                'icon' => ['label' => 'Ícone', 'type' => 'image'],
                'title' => ['label' => 'Título', 'type' => 'text'],
                'description' => ['label' => 'Descrição', 'type' => 'textarea'],
            ],
            'default' => [
                [
                    'icon' => 'about-icon-professional.png',
                    'title' => 'Tecnologia médica de vanguarda',
                    'description' => 'Operamos com as plataformas mais avançadas do mercado mundial, garantindo uma precisão absoluta em cada sessão.',
                ],
                [
                    'icon' => 'about-icon-laser.png',
                    'title' => 'Lasers de alta energia e pulso longo',
                    'description' => 'Sistemas revolucionários que atuam diretamente no folículo piloso, entregando a energia necessária com a máxima proteção para a sua pele.',
                ],
                [
                    'icon' => 'about-icon-results.png',
                    'title' => 'Resultados superiores em menos tempo',
                    'description' => 'Equipamentos de última geração que permitem atingir a depilação definitiva num intervalo de tempo mais curto e com maior eficácia.',
                ],
            ],
        ],
        'spaces.title' => [
            'section' => 'Espaços',
            'label' => 'Título',
            'type' => 'textarea',
            'default' => "Espaços\nespecializados",
        ],
        'spaces.description' => [
            'section' => 'Espaços',
            'label' => 'Descrição',
            'type' => 'textarea',
            'default' => 'As Clínicas Depiderme são um grupo de unidades especializadas em depilação por laser, operando com equipamentos próprios.',
        ],
        'spaces.button' => [
            'section' => 'Espaços',
            'label' => 'Texto do botão',
            'type' => 'text',
            'default' => 'Clínicas',
        ],
        'spaces.carousel' => [
            'section' => 'Espaços',
            'label' => 'Carrossel de clínicas',
            'type' => 'repeater',
            'add_label' => 'Adicionar slide',
            'item_title' => 'city',
            'item_fields' => [
                'image' => ['label' => 'Imagem', 'type' => 'image'],
                'city' => ['label' => 'Cidade', 'type' => 'text'],
                'alt' => ['editable' => false, 'default' => ''],
                'object' => ['editable' => false, 'default' => 'object-center'],
            ],
            'default' => [
                ['image' => 'about-shop-leiria.png', 'city' => 'Leiria', 'alt' => 'Clínica Depiderme Leiria', 'object' => 'object-[42%_center]'],
                ['image' => 'about-shop-coimbra.png', 'city' => 'Coimbra', 'alt' => 'Clínica Depiderme Coimbra', 'object' => 'object-center'],
                ['image' => 'about-shop-porto.png', 'city' => 'Porto', 'alt' => 'Clínica Depiderme Porto', 'object' => 'object-center'],
                ['image' => 'clinic-4.png', 'city' => 'Vila Real', 'alt' => 'Clínica Depiderme Vila Real', 'object' => 'object-center'],
                ['image' => 'clinic-2.png', 'city' => 'Viseu', 'alt' => 'Clínica Depiderme Viseu', 'object' => 'object-[72%_center]'],
            ],
        ],
        'professionals.title' => [
            'section' => 'Profissionais',
            'label' => 'Título',
            'type' => 'textarea',
            'default' => "Profissionais\ncertificados",
        ],
        'professionals.paragraphs' => [
            'section' => 'Profissionais',
            'label' => 'Parágrafos',
            'type' => 'list',
            'add_label' => 'Adicionar parágrafo',
            'default' => [
                'As Clínicas Depiderme contam já com mais de 15 anos de experiência na área da depilação laser.',
                'Connosco operam profissionais de saúde e profissionais de estética que, aliados à tecnologia, partilham o seu conhecimento com o objetivo de lhe proporcionar os melhores resultados.',
                'As Clínicas Depiderme contam também com profissionais certificados pela Candela e certificados pela ALTEC (Fototerapia Laser).',
            ],
        ],
        'professionals.image' => [
            'section' => 'Profissionais',
            'label' => 'Imagem',
            'type' => 'image',
            'default' => 'images/about-professional.png',
        ],
        'professionals.image_alt' => [
            'editable' => false,
            'default' => 'Profissional Depiderme certificada',
        ],
        'booking.title' => [
            'section' => 'Marcação',
            'editable' => false,
            'default' => "Faça a sua\nmarcação",
        ],
        'booking.description' => [
            'section' => 'Marcação',
            'editable' => false,
            'default' => 'Connosco operam profissionais de saúde e profissionais de estética que, aliados à tecnologia, partilham o seu conhecimento com o objetivo de lhe proporcionar os melhores resultados.',
        ],
    ],
];
