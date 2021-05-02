<?php

return [
    'api/characters' => 'api/characters/index',
    'api/characters/<id_character:\d+>' => 'api/characters/view',
    'api/elements' => 'api/elements/index',
    'api/races' => 'api/races/index',

    'characters' => 'characters/index',
    'characters/<id_character:\d+>' => 'characters/view',
    'characters/<id_character:\d+>/edit' => 'characters/edit',
    'characters/<id_character:\d+>/update' => 'characters/update',
    'elements' => 'elements/index',
    'main' => 'app/test',
    'races' => 'races/index'
];
