<?php

return [
    'languages' => [
        'tm' => 'Türkmençe',
        'en' => 'English',
        'ru' => 'Русский',
    ]
    ,
    'ordering' => [
        'nameAsc' => ['name', 'asc'],
        'nameDesc' => ['name', 'desc'],
        'priceLow' => ['price', 'asc'],
        'priceHigh' => ['price', 'desc'],
        'newest' => ['id', 'desc'],
        'oldest' => ['id', 'asc'],
    ],
    'purchase' => [
        'r' => 'rent_only',
        'a' => 'audiobook',
        'e' => 'electron',
        'ra' => 'rent_and_audiobook',
        're' => 'rent_and_electron',
        'ae' => 'audiobook_and_electron',
        'b' => 'bundle'
    ]
];
