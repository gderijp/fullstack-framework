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
    private const TYPES = [
        'Breakfast',
        'Lunch',
        'Dinner',
    ];
    private const DIFFICULTIES = [
        'Easy',
        'Medium',
        'Hard',
    ];

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

    public function create(): void
    {
        $this->helper->displayTemplate('recipes/create.twig', [
            'types' => self::TYPES,
            'difficulties' => self::DIFFICULTIES,
        ]);
    }

    public function createPost(): void
    {
        $newRecipe = R::dispense('recipe');

        $newRecipe->name = $_POST['name'];
        $newRecipe->type = $_POST['type'];
        $newRecipe->level = $_POST['level'];

        $recipeId = R::store($newRecipe);

        $_GET['id'] = $recipeId;
        header('Location: /recipe/show&id=' . $recipeId);
        exit();
    }

    public function edit(): void
    {
        if (empty($_GET['id'])) {
            $this->helper->error(404, 'No recipe ID specified');
        }

        $recipeId = $_GET['id'];

        $foundRecipe = $this->getBeanById('recipe', $recipeId);

        if (empty($foundRecipe)) {
            $this->helper->error(404, "No recipe with id {$recipeId} found");
        }

        $this->helper->displayTemplate('recipes/edit.twig', [
            'recipe' => $foundRecipe,
            'types' => self::TYPES,
            'difficulties' => self::DIFFICULTIES,
        ]);
    }

    public function editPost(): void
    {
        $editRecipe = R::dispense('recipe');

        $editRecipe->id = $_GET['id'];
        $editRecipe->name = $_POST['name'];
        $editRecipe->type = $_POST['type'];
        $editRecipe->level = $_POST['level'];

        $editRecipeId = R::store($editRecipe);

        $_GET['id'] = $editRecipeId;
        header('Location: /recipe/show&id=' . $editRecipeId);
        exit();
    }
}
