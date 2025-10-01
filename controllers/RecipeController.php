<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Helpers;
use App\Controllers\BaseController;
use RedBeanPHP\R;

/**
 * Controller for all the recipes found in the database
 */
class RecipeController extends BaseController
{
    private Helpers $helper;
    protected array $recipes;
    private array $kitchens;
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
        // set up connection to db
        parent::__construct();

        $this->helper = new Helpers();

        // add recipes
        for ($i = 1; $i <= R::count('recipe'); $i++) {
            $this->recipes[] = R::load('recipe', $i);
        }

        // add kitchens
        for ($i = 1; $i <= R::count('kitchen'); $i++) {
            $this->kitchens[] = R::load('kitchen', $i);
        }
    }

    /**
     * Show index template with list of all recipes
     *
     * @return void
     */
    public function index(): void
    {
        $this->helper->displayTemplate('recipes/index.twig', [
            'recipes' => $this->recipes
        ]);
    }

    /**
     * If id is passed as second slug, show view including all recipe information
     *
     * @return void
     */
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
            'recipe' => $foundRecipe,
            'kitchen' => $this->getBeanById('kitchen', $foundRecipe->kitchen_id)
        ]);
    }

    /**
     *  Show view for user to create a recipe
     *
     * @return void
     */
    public function create(): void
    {
        $this->helper->displayTemplate('recipes/create.twig', [
            'types' => self::TYPES,
            'difficulties' => self::DIFFICULTIES,
            'kitchens' => $this->kitchens,
        ]);
    }

    /**
     * Store recipe in the database
     *
     * @return void
     * @throws \RedBeanPHP\RedException\SQL
     */
    public function createPost(): void
    {
        $newRecipe = R::dispense('recipe');

        $newRecipe->name = $_POST['name'];
        $newRecipe->type = $_POST['type'];
        $newRecipe->level = $_POST['level'];
        $newRecipe->kitchen_id = $_POST['kitchen'];

        $recipeId = R::store($newRecipe);

        $_GET['id'] = $recipeId;
        header('Location: /kitchen/show&id=' . $_POST['kitchen']);
        exit();
    }

    /**
     *  If recipeId is specified as slug, display update form to user
     *
     * @return void
     */
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
            'kitchen' => $this->getBeanById('kitchen', $foundRecipe->kitchen_id),
            'kitchens' => $this->kitchens,
            'types' => self::TYPES,
            'difficulties' => self::DIFFICULTIES,
        ]);
    }

    /**
     * alter recipe's info
     *
     * @return void
     * @throws \RedBeanPHP\RedException\SQL
     */
    public function editPost(): void
    {
        $editRecipe = R::dispense('recipe');

        $editRecipe->id = $_GET['id'];
        $editRecipe->name = $_POST['name'];
        $editRecipe->type = $_POST['type'];
        $editRecipe->level = $_POST['level'];
        $editRecipe->kitchen_id = $_POST['kitchen'];

        $editRecipeId = R::store($editRecipe);

        $_GET['id'] = $editRecipeId;
        header('Location: /recipe/show&id=' . $editRecipeId);
        exit();
    }
}
