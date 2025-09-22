<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Helpers;
use App\Controllers\BaseController;
use RedBeanPHP\R;

class RecipeController extends BaseController
{
    private Helpers $helper;
    protected array $recipes;

    public function __construct()
    {
        parent::__construct();
        $this->helper = new Helpers();

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
        if (empty($_GET['id'])) {
            $this->helper->error(404, 'No recipe ID specified');
        }

        $recipeId = $_GET['id'];

        $foundRecipe = $this->getBeanById('recipe', $recipeId);

        if (empty($foundRecipe)) {
            $this->helper->error(404, "No recipe with id {$recipeId} found");
        }

        $this->helper->displayTemplate('recipes/show.twig', [
            'recipe' => $foundRecipe
        ]);
    }
}
