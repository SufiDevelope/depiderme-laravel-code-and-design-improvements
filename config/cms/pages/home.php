<?php

return [
    'slug' => 'home',
    'label' => 'Homepage',
    'url' => '/',
    'fields' => [
        'hero.social_proof' => [
            'section' => 'Hero',
            'label' => 'Prova social (avatares)',
            'type' => 'text',
            'default' => '25,000+ Clientes Satisfeitos',
        ],
        'hero.headline_mobile' => [
            'editable' => false,
            'default' => "O futuro da sua\npele começa\ncom a eficácia\nda tecnologia",
        ],
        'hero.headline_desktop' => [
            'section' => 'Hero',
            'label' => 'Título principal',
            'type' => 'textarea',
            'default' => "O futuro da sua pele\ncomeça com a eficácia\nda tecnologia",
        ],
        'hero.tagline' => [
            'section' => 'Hero',
            'label' => 'Tagline inferior',
            'type' => 'text',
            'default' => 'Clínicas de depilação laser',
        ],
        'hero.features' => [
            'section' => 'Hero',
            'label' => 'Características',
            'type' => 'repeater',
            'add_label' => 'Adicionar característica',
            'item_title' => 'title',
            'item_fields' => [
                'icon' => ['label' => 'Ícone', 'type' => 'image'],
                'title' => ['label' => 'Título', 'type' => 'text'],
                'description' => ['label' => 'Descrição', 'type' => 'textarea'],
            ],
            'default' => [
                ['icon' => 'hero-icon-laser.png', 'title' => 'Laser Médico de Classe IV', 'description' => 'Equipamentos próprios com manutenção oficial e suporte de marca Candela.'],
                ['icon' => 'hero-icon-especialistas.png', 'title' => 'Especialistas em Laser', 'description' => 'Equipa de saúde com certificação oficial ALTEC e Candela.'],
                ['icon' => 'hero-icon-tecnologia.png', 'title' => 'Tecnologia de Duplo Laser', 'description' => 'Resultados em pele clara ou escura com tecnologia Alexandrite & Nd:YAG.'],
            ],
        ],
        'leader.headline' => [
            'section' => 'Líder',
            'label' => 'Título',
            'type' => 'textarea',
            'default' => "Líder mundial em\nlaser médico-estético",
        ],
        'leader.description' => [
            'section' => 'Líder',
            'label' => 'Descrição',
            'type' => 'textarea',
            'default' => 'As Clínicas Depiderme são um grupo de clínicas médico-estéticas especializadas unicamente em tratamentos de depilação a laser, operando exclusivamente com laser Alexandrite e Neodímio YAG.',
        ],
        'experience.title' => [
            'section' => 'Experiência',
            'label' => 'Título da secção',
            'type' => 'text',
            'default' => 'Onde a tecnologia encontra a experiência',
        ],
        'experience.cards' => [
            'section' => 'Experiência',
            'label' => 'Cartões',
            'type' => 'repeater',
            'add_label' => 'Adicionar cartão',
            'item_title' => 'button',
            'item_fields' => [
                'title_lines' => ['label' => 'Linhas do título', 'type' => 'list', 'add_label' => 'Adicionar linha', 'item_placeholder' => 'Linha do título'],
                'paragraphs' => ['label' => 'Parágrafos', 'type' => 'list', 'add_label' => 'Adicionar parágrafo'],
                'button' => ['label' => 'Texto do botão', 'type' => 'text'],
                'image' => ['label' => 'Imagem', 'type' => 'image'],
                'image_alt' => ['editable' => false, 'default' => ''],
            ],
            'default' => [
                [
                    'title_lines' => ['Espaços', 'especializados'],
                    'paragraphs' => [
                        'As Clínicas Depiderme são espaços especializados em depilação por laser, operando com equipamentos próprios e utilizando consumíveis oficiais da marca Candela.',
                        'Todos os equipamentos têm contratos de manutenção oficiais sendo executadas verificações periódicas aos mesmos, garantindo assim a máxima segurança para o paciente.',
                    ],
                    'button' => 'Mais Sobre Nós',
                    'image' => 'experience-card-1.png',
                    'image_alt' => 'Receção Depiderme',
                ],
                [
                    'title_lines' => ['Profissionais', 'certificados'],
                    'paragraphs' => [
                        'Connosco operam profissionais de saúde e profissionais de estética que, aliados à tecnologia, partilham o seu conhecimento com o objetivo de lhe proporcionar os melhores resultados. Os equipamentos de última geração, com os quais atuamos, possibilitam-nos oferecer os melhores resultados no mais curto intervalo de tempo.',
                        'As Clínicas Depiderme contam já com mais de 15 anos de experiência na área da depilação a laser.',
                    ],
                    'button' => 'Mais Sobre Nós',
                    'image' => 'experience-card-2.png',
                    'image_alt' => 'Profissional Depiderme',
                ],
                [
                    'title_lines' => ['Tecnologia e', 'equipamentos'],
                    'paragraphs' => [
                        'Na Depiderme – Clínica de Depilação a Laser contamos com as tecnologias mais avançadas para tratar eficazmente todos os pelos indesejados.',
                        'Usamos o laser Alexandrite que trata eficazmente todos os pelos indesejados em pele clara.',
                        'Também utilizamos o laser Neodímio YAG, indicado para tratar pelos em pele morena ou bronzeada.',
                    ],
                    'button' => 'Mais Sobre Depilação Laser',
                    'image' => 'experience-card-3.png',
                    'image_alt' => 'Equipamento Candela',
                ],
            ],
        ],
        'clinics_teaser.title' => [
            'section' => 'Clínicas (teaser)',
            'label' => 'Título',
            'type' => 'text',
            'default' => 'As nossas clínicas',
        ],
        'clinics_teaser.image' => [
            'section' => 'Clínicas (teaser)',
            'label' => 'Imagem principal',
            'type' => 'image',
            'default' => 'images/clinics-store.png',
        ],
        'clinics_teaser.image_alt' => [
            'editable' => false,
            'default' => 'Interior da clínica Depiderme',
        ],
        'clinics_teaser.clinics' => [
            'type' => 'repeater',
            'editable' => false,
            'default' => [
                ['city' => 'Leiria', 'address' => 'Av. Marquês de Pombal nº9 – Loja 25 – Leiria Shopping'],
                ['city' => 'Coimbra', 'address' => 'Av. José Bonifácio nº1C, Centro Empresarial Bonifácio II, Escritório 1'],
                ['city' => 'Viseu', 'address' => 'Av. reitor Abel Salazar, nº9, loja 31'],
                ['city' => 'Vila Real', 'address' => 'Av. Europa, Edifício Encosta do Rio, Loja 1, 5000-557 Vila Real'],
                ['city' => 'Porto', 'address' => 'Avenida da Boavista 1742, 4100 – 116 Porto'],
            ],
        ],
        'packs.title' => [
            'section' => 'Packs',
            'label' => 'Título',
            'type' => 'textarea',
            'default' => "Packs\nPromocionais",
        ],
        'packs.description' => [
            'section' => 'Packs',
            'label' => 'Descrição',
            'type' => 'textarea',
            'default' => 'Connosco operam profissionais de saúde e profissionais de estética que, aliados à tecnologia, partilham o seu conhecimento com o objetivo de lhe proporcionar os melhores resultados.',
        ],
        'packs.link_text' => [
            'section' => 'Packs',
            'label' => 'Texto do link',
            'type' => 'text',
            'default' => 'Ver mais sobre preços',
        ],
        'packs.rows' => [
            'type' => 'pack_rows',
            'editable' => false,
            'default' => [
                [
                    ['type' => 'text', 'label' => 'Axilas + Virilhas', 'price' => '115€'],
                    ['type' => 'image', 'image' => 'pack-arm.png', 'alt' => 'Axilas', 'widthClass' => 'w-[190px] sm:w-[240px] lg:w-[277px]'],
                    ['type' => 'text', 'label' => 'Axilas + Virilhas + Meias pernas', 'price' => '79€'],
                    ['type' => 'image', 'image' => 'pack-legs.png', 'alt' => 'Pernas', 'widthClass' => 'w-[190px] sm:w-[240px] lg:w-[277px]'],
                    ['type' => 'text', 'label' => 'Axilas + Virilhas + Pernas completas', 'price' => '115€'],
                ],
                [
                    ['type' => 'text', 'label' => 'Buço + Mento', 'price' => '37€'],
                    ['type' => 'text', 'label' => 'Virilhas + Pernas completas', 'price' => '115€'],
                    ['type' => 'image', 'image' => 'pack-torax.png', 'alt' => 'Torax', 'widthClass' => 'w-[220px] sm:w-[300px] lg:w-[350px]'],
                    ['type' => 'text', 'label' => 'Costas + Sacro', 'price' => '115€'],
                    ['type' => 'text', 'label' => 'Torax + Abdómen', 'price' => '37€'],
                ],
            ],
        ],
        'booking.title' => [
            'section' => 'Marcação',
            'label' => 'Título',
            'type' => 'textarea',
            'default' => "Faça a sua\nmarcação",
        ],
        'booking.description' => [
            'section' => 'Marcação',
            'label' => 'Descrição',
            'type' => 'textarea',
            'default' => 'Connosco operam profissionais de saúde e profissionais de estética que, aliados à tecnologia, partilham o seu conhecimento com o objetivo de lhe proporcionar os melhores resultados.',
        ],
        'booking.map_image' => [
            'section' => 'Marcação',
            'label' => 'Imagem do mapa',
            'type' => 'image',
            'default' => 'images/booking-map.png',
        ],
        'booking.map_alt' => [
            'editable' => false,
            'default' => 'Mapa de Portugal com localização das clínicas Depiderme',
        ],
        'end.image' => [
            'section' => 'Final',
            'label' => 'Imagem',
            'type' => 'image',
            'default' => 'images/img-end.png',
        ],
        'end.image_alt' => [
            'editable' => false,
            'default' => 'Profissional Depiderme a realizar tratamento laser',
        ],
    ],
];
