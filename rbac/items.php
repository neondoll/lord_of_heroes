<?php

return [
    'root' => [
        'type' => 1,
        'children' => [
            '/*',
        ],
    ],
    'admin' => [
        'type' => 1,
        'children' => [
            '/app/test/*',
        ],
    ],
    'user' => [
        'type' => 1,
        'children' => [
            '/app/test/index',
        ],
    ],
    '/*' => [
        'type' => 2,
    ],
    '/app/test/*' => [
        'type' => 2,
    ],
    '/app/test/index' => [
        'type' => 2,
    ],
    '/races/index' => [
        'type' => 2,
    ],
    '/characters/index' => [
        'type' => 2,
    ],
    '/elements/index' => [
        'type' => 2,
    ],
];
