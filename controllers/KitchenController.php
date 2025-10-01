<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Helpers;
use App\Controllers\BaseController;
use RedBeanPHP\R;

/**
 * Controller for all the kitchens found in the database
 */
class KitchenController extends BaseController
{
    private Helpers $helper;
    protected array $kitchens = [];

    public function __construct()
    {
        parent::__construct();
        $this->helper = new Helpers();

        for ($i = 1; $i <= R::count('kitchen'); $i++) {
            $this->kitchens[] = R::load('kitchen', $i);
        }
    }

    /**
     * Show index template with list of all kitchens
     *
     * @return void
     */
    public function index()
    {
        $this->helper->displayTemplate('kitchens/index.twig', [
            'kitchens' => $this->kitchens
        ]);
    }

    /**
     * If id is passed as second slug, show view including all kitchen information
     *
     * @return void
     */
    public function show()
    {
        if (empty($_GET['id'])) {
            $this->helper->error(404, 'No kitchen ID specified');
        }

        $kitchenId = $_GET['id'];

        $foundKitchen = $this->getBeanById('kitchen', $kitchenId);

        if (empty($foundKitchen)) {
            $this->helper->error(404, "No kitchen with id {$kitchenId} found");
        }

        // add recipes with same kitchen_id
        $foundRecipes = R::find('recipe', "kitchen_id = $kitchenId");

        $this->helper->displayTemplate('kitchens/show.twig', [
            'kitchen' => $foundKitchen,
            'recipes' => $foundRecipes,
        ]);
    }

    /**
     * Show view for user to create a kitchen
     *
     * @return void
     */
    public function create(): void
    {
        $this->authorizeUser();

        $this->helper->displayTemplate('kitchens/create.twig', []);
    }

    /**
     * Store kitchen in the database
     *
     * @return void
     * @throws \RedBeanPHP\RedException\SQL
     */
    public function createPost(): void
    {
        $this->authorizeUser();

        $newKitchen = R::dispense('kitchen');

        $newKitchen->name = $_POST['name'];
        $newKitchen->description = $_POST['description'];

        $kitchenId = R::store($newKitchen);

        $_GET['id'] = $kitchenId;
        header('Location: /kitchen/show&id=' . $kitchenId);
        exit();
    }

    /**
     * If kitchenId is specified as slug, display update form to user
     *
     * @return void
     */
    public function edit(): void
    {
        $this->authorizeUser();

        if (empty($_GET['id'])) {
            $this->helper->error(404, 'No kitchen ID specified');
        }

        $kitchenId = $_GET['id'];

        $foundKitchen = $this->getBeanById('kitchen', $kitchenId);

        if (empty($foundKitchen)) {
            $this->helper->error(404, "No kitchen with id {$kitchenId} found");
        }

        $this->helper->displayTemplate('kitchens/edit.twig', [
            'kitchen' => $foundKitchen
        ]);
    }

    /**
     * Alter kitchen's info
     *
     * @return void
     * @throws \RedBeanPHP\RedException\SQL
     */
    public function editPost(): void
    {
        $this->authorizeUser();

        $editKitchen = R::dispense('kitchen');

        $editKitchen->id = $_GET['id'];
        $editKitchen->name = $_POST['name'];
        $editKitchen->description = $_POST['description'];

        $editKitchenId = R::store($editKitchen);

        $_GET['id'] = $editKitchenId;
        header('Location: /kitchen/show&id=' . $editKitchenId);
        exit();
    }
}