<?php

$pages = [];

foreach (glob(__DIR__.'/cms/pages/*.php') as $file) {
    $page = require $file;
    $pages[$page['slug']] = [
        'label' => $page['label'],
        'url' => $page['url'] ?? null,
        'fields' => $page['fields'],
    ];
}

return [
    'page_order' => [
        'home',
        'about',
        'technology',
        'pricing',
        'clinics',
        'laserderme',
        'contact',
    ],
    'pages' => $pages,
];
