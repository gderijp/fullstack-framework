<?php

use RedBeanPHP\R;

require_once 'vendor/autoload.php';

$recipes = [
    [
        'id'    => 1,
        'name'  => 'Pannekoeken',
        'type'  => 'dinner',
        'level' => 'easy',
    ],
    [
        'id'    => 24,
        'name'  => 'Tosti',
        'type'  => 'lunch',
        'level' => 'easy',
    ],
    [
        'id'    => 36,
        'name'  => 'Boeren ommelet',
        'type'  => 'lunch',
        'level' => 'easy',
    ],
    [
        'id'    => 47,
        'name'  => 'Broodje Pulled Pork',
        'type'  => 'lunch',
        'level' => 'hard',
    ],
    [
        'id'    => 5,
        'name'  => 'Hutspot met draadjesvlees',
        'type'  => 'dinner',
        'level' => 'medium',
    ],
    [
        'id'    => 6,
        'name'  => 'Nasi Goreng met Babi ketjap',
        'type'  => 'dinner',
        'level' => 'hard',
    ],
];

R::setup('mysql:host=localhost;dbname=fullstack_framework', 'bit_academy', 'bit_academy');
R::nuke();

$recordAmount = 0;
foreach ($recipes as $recipe) {
    $dbRecipe = R::dispense('recipe');

    $dbRecipe->name = $recipe['name'];
    $dbRecipe->type = $recipe['type'];
    $dbRecipe->level = $recipe['level'];

    $id = R::store($dbRecipe);
}

echo $id . " records inserted" . PHP_EOL;
