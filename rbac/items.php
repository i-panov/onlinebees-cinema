<?php
return [
    'admin' => [
        'type' => 1,
        'description' => 'Администратор',
        'children' => [
            'manageFilms',
            'cashier',
        ],
    ],
    'cashier' => [
        'type' => 1,
        'description' => 'Кассир',
        'children' => [
            'manageFilmSessions',
        ],
    ],
    'manageFilms' => [
        'type' => 2,
        'description' => 'Может управлять фильмами',
    ],
    'manageFilmSessions' => [
        'type' => 2,
        'description' => 'Может управлять сеансами фильмамов',
    ],
];
