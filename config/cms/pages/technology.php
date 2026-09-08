<?php

return [
    'slug' => 'technology',
    'label' => 'Depilação Laser',
    'url' => '/technology',
    'fields' => [
        'hero.title_line1' => [
            'section' => 'Hero',
            'label' => 'Título — linha 1',
            'type' => 'text',
            'default' => 'Avanço',
        ],
        'hero.title_highlight' => [
            'section' => 'Hero',
            'label' => 'Título — destaque',
            'type' => 'text',
            'default' => 'tecnológico',
        ],
        'hero.title_line2' => [
            'section' => 'Hero',
            'label' => 'Título — linhas 2-3',
            'type' => 'textarea',
            'default' => "para\nresultados seguros e\neficazes",
        ],
        'hero.description' => [
            'section' => 'Hero',
            'label' => 'Descrição',
            'type' => 'textarea',
            'default' => 'Antes de iniciar tratamento é feita uma anamnese do paciente e um teste de reação cutânea. Trata-se de uma consulta que poderá realizar gratuitamente. Caso não se verifique nenhuma contra-indicação poderá dar início às sessões.',
        ],
        'hero.gallery' => [
            'section' => 'Hero',
            'label' => 'Galeria de passos',
            'type' => 'repeater',
            'add_label' => 'Adicionar imagem',
            'item_title' => 'alt',
            'item_fields' => [
                'image' => ['label' => 'Imagem', 'type' => 'image'],
                'alt' => ['label' => 'Descrição', 'type' => 'text'],
                'height' => ['editable' => false, 'default' => 295],
                'mobileHeight' => ['editable' => false, 'default' => 200],
            ],
            'default' => [
                ['image' => 'tech-hero-1.png', 'height' => 295, 'mobileHeight' => 200, 'alt' => 'Profissional Depiderme em consulta'],
                ['image' => 'tech-hero-2.png', 'height' => 437, 'mobileHeight' => 296, 'alt' => 'Preparação da zona de tratamento'],
                ['image' => 'tech-hero-3.png', 'height' => 344, 'mobileHeight' => 233, 'alt' => 'Marcação antes do procedimento'],
                ['image' => 'tech-hero-4.png', 'height' => 436, 'mobileHeight' => 296, 'alt' => 'Tratamento laser com proteção ocular'],
                ['image' => 'tech-hero-5.png', 'height' => 295, 'mobileHeight' => 200, 'alt' => 'Aplicação de gel condutor'],
            ],
        ],
        'diagnosis.title' => [
            'section' => 'Diagnóstico',
            'label' => 'Título',
            'type' => 'textarea',
            'default' => "Consulta de\ndiagnóstico",
        ],
        'diagnosis.paragraph_1' => [
            'section' => 'Diagnóstico',
            'label' => 'Parágrafo 1',
            'type' => 'textarea',
            'default' => 'Antes de qualquer procedimento é feita uma análise das características do pêlo e da pele bem como da sua aptidão ao laser. Posteriormente, executa-se a remoção do pelo (com lâmina) na área que se pretende tratar, de modo a que o máximo de energia laser chegue à raiz do mesmo.',
        ],
        'diagnosis.paragraph_2' => [
            'section' => 'Diagnóstico',
            'label' => 'Parágrafo 2',
            'type' => 'textarea',
            'default' => 'São selecionados os parâmetros de energia adequados a cada paciente em particular. O laser é aplicado sobre a pele, com a potência selecionada e realiza-se então o tratamento.',
        ],
        'diagnosis.image' => [
            'section' => 'Diagnóstico',
            'label' => 'Imagem',
            'type' => 'image',
            'default' => 'images/experience-card-2.png',
        ],
        'diagnosis.image_alt' => [
            'editable' => false,
            'default' => 'Consulta de diagnóstico Depiderme',
        ],
        'diagnosis.cta' => [
            'section' => 'Diagnóstico',
            'label' => 'Texto do botão',
            'type' => 'text',
            'default' => 'Fazer Marcação',
        ],
        'equipment.title' => [
            'section' => 'Equipamento',
            'label' => 'Título',
            'type' => 'text',
            'default' => 'Tecnologia',
        ],
        'equipment.intro' => [
            'section' => 'Equipamento',
            'label' => 'Introdução',
            'type' => 'textarea',
            'default' => 'O GentleMax Pro Plus é a mais avançada tecnologia em depilação a laser, um dispositivo de uso dermatológico (Classe IV), aprovado pela FDA.',
        ],
        'equipment.paragraph_1' => [
            'section' => 'Equipamento',
            'label' => 'Parágrafo 1',
            'type' => 'textarea',
            'default' => 'Este sistema é um revolucionário laser que congrega a tecnologia Alexandrite, indicado para peles claras, e Nd-Yag, adequado para peles escuras. Consiste num disparo largo e alta energia, emite um feixe de luz que penetra a pele até ao folículo piloso, onde é absorvido.',
        ],
        'equipment.paragraph_2' => [
            'section' => 'Equipamento',
            'label' => 'Parágrafo 2',
            'type' => 'textarea',
            'default' => 'A energia laser transforma-se em calor e destrói a célula germinativa do pêlo, assim como os vasos que o nutrem, sem lesar os tecidos.',
        ],
        'equipment.cert_image' => [
            'section' => 'Equipamento',
            'label' => 'Imagem de certificações',
            'type' => 'image',
            'default' => 'images/tech-cert-logos.png',
        ],
        'equipment.cert_alt' => [
            'editable' => false,
            'default' => 'Certificações CE, FDA e TÜV SÜD',
        ],
        'equipment.gallery' => [
            'section' => 'Equipamento',
            'label' => 'Galeria',
            'type' => 'repeater',
            'add_label' => 'Adicionar imagem',
            'item_title' => 'alt',
            'item_fields' => [
                'image' => ['label' => 'Imagem', 'type' => 'image'],
                'alt' => ['label' => 'Descrição', 'type' => 'text'],
            ],
            'default' => [
                ['image' => 'experience-card-3.png', 'alt' => 'Interface do equipamento GentleMax Pro Plus'],
                ['image' => 'about-space-2.png', 'alt' => 'Profissional Depiderme com aplicador laser'],
                ['image' => 'about-space-1.png', 'alt' => 'Tratamento laser Depiderme'],
            ],
        ],
        'faq.title' => [
            'section' => 'FAQ',
            'label' => 'Título',
            'type' => 'textarea',
            'default' => "Perguntas\nFrequentes",
        ],
        'faq.items' => [
            'section' => 'FAQ',
            'label' => 'Perguntas e respostas',
            'type' => 'repeater',
            'add_label' => 'Adicionar pergunta',
            'item_title' => 'question',
            'item_fields' => [
                'question' => ['label' => 'Pergunta', 'type' => 'text'],
                'answer' => ['label' => 'Respostas', 'type' => 'list', 'add_label' => 'Adicionar parágrafo'],
                'open' => ['editable' => false, 'default' => false],
            ],
            'default' => [
                [
                    'question' => 'Qual a duração do tratamento?',
                    'answer' => [
                        'A duração de cada sessão varia consoante a zona a tratar. Pode durar entre 10 minutos e 2 horas, dependendo da extensão da área e das características do pêlo.',
                        'O tempo total do tratamento depende também do número de sessões necessárias, que é definido após a consulta de diagnóstico.',
                    ],
                    'open' => true,
                ],
                [
                    'question' => 'Quantas sessões são necessárias?',
                    'answer' => [
                        'O número de sessões varia de acordo com o tipo de pele, cor e espessura do pêlo, bem como a zona a tratar. Em média, são necessárias entre 6 a 10 sessões para obter resultados definitivos.',
                    ],
                    'open' => false,
                ],
                [
                    'question' => 'É considerado um tratamento seguro?',
                    'answer' => [
                        'Sim. Utilizamos equipamentos médicos de Classe IV, com manutenção oficial e profissionais certificados. Antes de iniciar, é realizada uma consulta de diagnóstico e teste de reação cutânea.',
                    ],
                    'open' => false,
                ],
                [
                    'question' => 'Que precauções se devem tomar?',
                    'answer' => [
                        'Evite exposição solar intensa antes e depois das sessões. Não deve depilar com cera ou pinça entre tratamentos — apenas lâmina. Siga sempre as recomendações do profissional que acompanha o seu tratamento.',
                    ],
                    'open' => false,
                ],
            ],
        ],
        'booking.title' => [
            'editable' => false,
            'default' => "Faça a sua\nmarcação",
        ],
        'booking.description' => [
            'editable' => false,
            'default' => 'Connosco operam profissionais de saúde e profissionais de estética que, aliados à tecnologia, partilham o seu conhecimento com o objetivo de lhe proporcionar os melhores resultados.',
        ],
    ],
];
