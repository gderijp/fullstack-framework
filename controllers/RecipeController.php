<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Helpers;
use RedBeanPHP\R;

class RecipeController
{
    private Helpers $helper;
    protected array $recipes;

    public function __construct()
    {
        $this->helper = new Helpers();

        R::setup('mysql:host=localhost;dbname=fullstack_framework', 'bit_academy', 'bit_academy');

        for ($i = 1; $i <= R::count('recipe'); $i++) {
            $this->recipes[] = R::load('recipe', $i);
        }
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
            if ($recipe['id'] === $recipeId) {
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
