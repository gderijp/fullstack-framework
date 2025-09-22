<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Helpers;

class RecipeController
{
    private Helpers $helper;
    protected array $recipes = [
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

    public function __construct()
    {
        $this->helper = new Helpers();
    }

    public function index(): void
    {
        $this->helper->displayTemplate('recipes/index.twig', [
            'recipes' => $this->recipes
        ]);
    }

    public function show(): void
    {
        $recipeId = $_GET['id'];

        foreach ($this->recipes as $recipe) {
            if (array_search($recipeId, $recipe)) {
                $foundRecipe = $recipe;
            }
        }

        if (empty($_GET['id'])) {
            $this->helper->error(404, 'No recipe ID specified');
        } elseif (empty($foundRecipe)) {
            $this->helper->error(404, "No recipe with id {$recipeId} found");
        }

        $this->helper->displayTemplate('recipes/show.twig', [
            'recipe' => $foundRecipe
        ]);
    }
}
