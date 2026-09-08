<?php

return [
    'slug' => 'laserderme',
    'label' => 'Laserderme',
    'url' => '/laserderme',
    'fields' => [
        'hero.marquee_text' => [
            'editable' => false,
            'default' => 'Laserderme',
        ],
        'hero.image' => [
            'section' => 'Hero',
            'label' => 'Imagem do produto',
            'type' => 'image',
            'default' => 'images/cream_hero_page.png',
        ],
        'hero.image_alt' => [
            'editable' => false,
            'default' => 'Laserderme Creme by Depiderme',
        ],
        'intro.title' => [
            'section' => 'Introdução',
            'label' => 'Título',
            'type' => 'text',
            'default' => 'Laserderme',
        ],
        'intro.rotator_words' => [
            'section' => 'Introdução',
            'label' => 'Palavras rotativas (separadas por vírgula)',
            'type' => 'text',
            'default' => 'Hidrata,Estimula,Regenera,Acelera,Fortalece',
        ],
        'intro.description' => [
            'section' => 'Introdução',
            'label' => 'Descrição',
            'type' => 'textarea',
            'default' => 'O LASERDERME® é um conjunto de polipeptídeos e citoquinas extraído do soro do leite que atua no processo enzimático e acelera a regeneração cutânea.',
        ],
        'intro.banner_image' => [
            'section' => 'Introdução',
            'label' => 'Imagem do banner',
            'type' => 'image',
            'default' => 'images/laserderme-banner.png',
        ],
        'intro.banner_alt' => [
            'editable' => false,
            'default' => 'Laserderme Creme by Depiderme',
        ],
        'factors.title' => [
            'section' => 'Factores',
            'label' => 'Título',
            'type' => 'textarea',
            'default' => '5 complexos factores de crescimento',
        ],
        'factors.items' => [
            'section' => 'Factores',
            'label' => 'Factores de crescimento',
            'type' => 'repeater',
            'add_label' => 'Adicionar factor',
            'item_title' => 'code',
            'item_fields' => [
                'code' => ['label' => 'Código (ex: EGF)', 'type' => 'text'],
                'image' => ['label' => 'Imagem', 'type' => 'image'],
                'image_side' => ['editable' => false, 'default' => 'right'],
                'description' => ['label' => 'Descrição', 'type' => 'textarea'],
            ],
            'default' => [
                [
                    'code' => 'EGF',
                    'image' => 'laserderme-egf.png',
                    'image_side' => 'right',
                    'image_class' => 'w-[clamp(170px,30vw,320px)] lg:w-[320px]',
                    'stage_class' => '',
                    'label_class' => '',
                    'description' => 'O Fator de Crescimento Epidérmico (EGF)
aumenta a proliferação de células epiteliais para
melhorar a cicatrização de feridas e
queimaduras. Ativa a hialuronana sintase 2, uma
enzima envolvida na síntese de ácido hialurónico
que restaura a hidratação da pele.',
                ],
                [
                    'code' => 'IGF-1',
                    'image' => 'laserderme-igf-1.png',
                    'image_side' => 'right',
                    'image_class' => 'w-[clamp(160px,28vw,300px)] lg:w-[300px]',
                    'stage_class' => '',
                    'label_class' => '',
                    'description' => 'O Fator de Crescimento semelhante à Insulina-1
(IGF-1) estimula a proliferação de fibroblastos
que sintetizam componentes da matriz da pele,
incluindo colagénio e elastina.',
                ],
                [
                    'code' => 'FGF',
                    'image' => 'laserderme-fgf.png',
                    'image_side' => 'left',
                    'image_class' => 'w-[clamp(175px,32vw,330px)] lg:w-[330px]',
                    'stage_class' => '',
                    'label_class' => '',
                    'description' => 'Fator de Crescimento dos Fibroblatos (FGF) está
envolvido na proliferação celular, diferenciação,
migração de células da pele e na formação de
vasos sanguíneos. Este fator é libertado ao longo
do processo de reparação.',
                ],
                [
                    'code' => 'IGF-1',
                    'image' => 'laserderme-igf-1-alt.png',
                    'image_side' => 'left',
                    'image_class' => 'w-[clamp(150px,26vw,280px)] lg:w-[280px]',
                    'stage_class' => 'items-start',
                    'label_class' => 'mt-5 max-lg:mt-0 lg:mt-10',
                    'description' => 'O Fator de Crescimento semelhante à Insulina-1
(IGF-1) estimula a proliferação de fibroblastos
que sintetizam componentes da matriz da pele,
incluindo colagénio e elastina.',
                ],
                [
                    'code' => 'TGF',
                    'image' => 'laserderme-tgf.png',
                    'image_side' => 'right',
                    'image_class' => 'w-[clamp(165px,29vw,310px)] lg:w-[310px]',
                    'stage_class' => '',
                    'label_class' => '',
                    'description' => 'Fatores de crescimento transformador (TGF) são
um grupo de fatores de crescimento com várias
funções que afetam a proliferação, adesão e
diferenciação celular.',
                ],
            ],
        ],
        'cta.gallery_headline' => [
            'section' => 'CTA',
            'label' => 'Título da galeria',
            'type' => 'text',
            'default' => 'Criteriosamente pensado para a sua pele',
        ],
        'cta.footer_text' => [
            'section' => 'CTA',
            'label' => 'Texto inferior',
            'type' => 'textarea',
            'default' => "Disponível apenas para compra presencialmente\nnas clínicas Depiderme",
        ],
        'cta.faces' => [
            'type' => 'list',
            'editable' => false,
            'default' => [
                'laserderme-face-1.png',
                'laserderme-face-2.png',
                'laserderme-face-3.png',
                'laserderme-face-4.png',
                'laserderme-face-5.png',
            ],
        ],
        'cta.tube_image' => [
            'editable' => false,
            'default' => 'images/laserderme-tube.png',
        ],
        'cta.box_image' => [
            'editable' => false,
            'default' => 'images/laserderme-box.png',
        ],
    ],
];
