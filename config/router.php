<?php

return [
    'api/characters' => 'api/characters/index',
    'api/characters/<id_character:\d+>' => 'api/characters/view',
    'api/characters/<id_character:\d+>/variations' => 'api/character-variations/index',
    'api/classes' => 'api/classes/index',
    'api/elements' => 'api/elements/index',
    'api/races' => 'api/races/index',

    'characters' => 'characters/index',
    'characters/<id_character:\d+>' => 'characters/view',
    'characters/<id_character:\d+>/edit' => 'characters/edit',
    'characters/<id_character:\d+>/update' => 'characters/update',
    'characters/<id_character:\d+>/variations/create' => 'characters/create-variation',
    'characters/<id_character:\d+>/variations/<id_variation:\d+>/comments/create' => 'characters/create-comment',
    'classes' => 'classes/index',
    'elements' => 'elements/index',
    'main' => 'app/test',
    'races' => 'races/index'
];
