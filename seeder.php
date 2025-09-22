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

$kitchens = [
    [
        'id' => 1,
        'name' => 'Franse keuken',
        'description' => 'De Franse keuken is een internationaal gewaardeerde keuken met een lange traditie. Deze 
            keuken wordt gekenmerkt door een zeer grote diversiteit, zoals dat ook wel gezien wordt in de Chinese 
            keuken en Indische keuken.',
    ],
    [
        'id' => 2,
        'name' => 'Chinese keuken',
        'description' => 'De Chinese keuken is de culinaire traditie van China en de Chinesen die in de diaspora 
            leven, hoofdzakelijk in Zuid-Oost-Azië. Door de grootte van China en de aanwezigheid van vele volkeren met 
            eigen culturen, door klimatologische afhankelijkheden en regionale voedselbronnen zijn de variaties groot.',
    ],
    [
        'id' => 3,
        'name' => 'Hollandse keuken',
        'description' => 'De Nederlandse keuken is met name geïnspireerd door het landbouwverleden van Nederland.
             Alhoewel de keuken per streek kan verschillen en er regionale specialiteiten bestaan, zijn er voor 
             Nederland typisch geachte gerechten. Nederlandse gerechten zijn vaak relatief eenvoudig en voedzaam, 
             zoals pap, Goudse kaas, pannenkoek, snert en stamppot.',
    ],
    [
        'id' => 4,
        'name' => 'Mediterraans',
        'description' => 'De mediterrane keuken is de keuken van het Middellandse Zeegebied en bestaat onder 
            andere uit de tientallen verschillende keukens uit Marokko,Tunesie, Spanje, Italië, Albanië en Griekenland 
            en een deel van het zuiden van Frankrijk (zoals de Provençaalse keuken en de keuken van Roussillon).',
    ],
];

R::setup('mysql:host=localhost;dbname=fullstack_framework', 'bit_academy', 'bit_academy');
R::nuke();

// add recipes
foreach ($recipes as $recipe) {
    $dbRecipe = R::dispense('recipe');

    $dbRecipe->name = $recipe['name'];
    $dbRecipe->type = $recipe['type'];
    $dbRecipe->level = $recipe['level'];

    $recipeId = R::store($dbRecipe);
}

// add kitchens
foreach ($kitchens as $kitchen) {
    $dbKitchen = R::dispense('kitchen');

    $dbKitchen->name = $kitchen['name'];
    $dbKitchen->description = $kitchen['description'];

    $kitchenId = R::store($dbKitchen);
}

echo $recipeId . " recipes inserted" . PHP_EOL;
echo $kitchenId . " kitchens inserted" . PHP_EOL;
