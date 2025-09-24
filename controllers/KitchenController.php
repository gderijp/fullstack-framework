<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Helpers;
use App\Controllers\BaseController;
use RedBeanPHP\R;

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

    public function index()
    {
        $this->helper->displayTemplate('kitchens/index.twig', [
            'kitchens' => $this->kitchens
        ]);
    }

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

    public function create(): void
    {
        $this->helper->displayTemplate('kitchens/create.twig', []);
    }

    public function createPost(): void
    {
        $newKitchen = R::dispense('kitchen');

        $newKitchen->name = $_POST['name'];
        $newKitchen->description = $_POST['description'];

        $kitchenId = R::store($newKitchen);

        $_GET['id'] = $kitchenId;
        header('Location: /kitchen/show&id=' . $kitchenId);
        exit();
    }

    public function edit(): void
    {
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

    public function editPost(): void
    {
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