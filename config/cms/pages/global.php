<?php

return [
    'slug' => 'global',
    'label' => 'Global',
    'url' => null,
    'fields' => [
        'site.phone' => [
            'section' => 'Contactos',
            'label' => 'Telefone',
            'type' => 'text',
            'default' => '+351 244 000 000',
        ],
        'site.email' => [
            'section' => 'Contactos',
            'label' => 'Email',
            'type' => 'text',
            'default' => 'info@depiderme.pt',
        ],
        'site.instagram' => [
            'section' => 'Redes sociais',
            'label' => 'Instagram',
            'type' => 'text',
            'default' => '#',
            'hint' => 'URL completa do perfil Instagram.',
        ],
        'site.facebook' => [
            'section' => 'Redes sociais',
            'label' => 'Facebook',
            'type' => 'text',
            'default' => '#',
            'hint' => 'URL completa do perfil Facebook.',
        ],
        'navbar.desktop_links' => [
            'type' => 'links',
            'editable' => false,
            'default' => [
                'Sobre Nós' => '/about',
                'Depilação Laser' => '/technology',
                'Preços' => '/pricing',
                'Laserderme' => '/laserderme',
                'Clínicas' => '/clinics',
            ],
        ],
        'navbar.paginas_links' => [
            'type' => 'links',
            'editable' => false,
            'default' => [
                'Home' => '/',
                'Sobre nós' => '/about',
                'Depilação Laser' => '/technology',
                'Preços' => '/pricing',
                'Laserderme' => '/laserderme',
                'Todas Clinicas' => '/clinics',
            ],
        ],
        'navbar.clinicas_links' => [
            'type' => 'links',
            'editable' => false,
            'default' => [
                'Leiria' => '/clinics#clinica-leiria',
                'Coimbra' => '/clinics#clinica-coimbra',
                'Viseu' => '/clinics#clinica-viseu',
                'Vila Real' => '/clinics#clinica-vila-real',
                'Porto' => '/clinics#clinica-porto',
            ],
        ],
        'navbar.contact_label' => [
            'section' => 'Menu',
            'label' => 'Botão Contactos',
            'type' => 'text',
            'default' => 'Contactos',
        ],
        'navbar.booking_label' => [
            'section' => 'Menu',
            'label' => 'Botão Fazer Marcação',
            'type' => 'text',
            'default' => 'Fazer Marcação',
        ],
        'navbar.booking_label_mobile' => [
            'section' => 'Menu',
            'label' => 'Botão Marcação (telemóvel)',
            'type' => 'text',
            'default' => 'Marcar',
        ],
        'navbar.language_short' => [
            'editable' => false,
            'default' => 'PT',
        ],
        'navbar.language_full' => [
            'editable' => false,
            'default' => 'Português',
        ],
        'footer.headline' => [
            'section' => 'Rodapé',
            'label' => 'Frase principal',
            'type' => 'textarea',
            'default' => 'O futuro da sua pele começa com a eficácia da tecnologia',
        ],
        'footer.contact_button' => [
            'section' => 'Rodapé',
            'label' => 'Botão Contacte-Nos',
            'type' => 'text',
            'default' => 'Contacte-Nos',
        ],
        'footer.booking_button' => [
            'section' => 'Rodapé',
            'label' => 'Botão Fazer Marcação',
            'type' => 'text',
            'default' => 'Fazer Marcação',
        ],
        'footer.paginas_links' => [
            'type' => 'links',
            'editable' => false,
            'default' => [
                'Home' => '#',
                'Sobre Nós' => '#',
                'Depilação Laser' => '/technology',
                'Preços' => '/pricing',
                'Laserderme' => '/laserderme',
                'Clínicas' => '/clinics',
            ],
        ],
        'footer.clinicas_links' => [
            'type' => 'links',
            'editable' => false,
            'default' => [
                'Leiria' => '#',
                'Coimbra' => '#',
                'Viseu' => '#',
                'Vila Real' => '#',
                'Porto' => '#',
            ],
        ],
        'footer.social_links' => [
            'type' => 'links',
            'editable' => false,
            'default' => [
                'Instagram' => '#',
                'Facebook' => '#',
            ],
        ],
        'footer.paginas_title' => [
            'section' => 'Rodapé',
            'label' => 'Título da coluna Páginas',
            'type' => 'text',
            'default' => 'Paginas',
        ],
        'footer.clinicas_title' => [
            'section' => 'Rodapé',
            'label' => 'Título da coluna Clínicas',
            'type' => 'text',
            'default' => 'Clinicas',
        ],
        'footer.socials_title' => [
            'section' => 'Rodapé',
            'label' => 'Título da coluna Redes sociais',
            'type' => 'text',
            'default' => 'Socials',
        ],
    ],
];
