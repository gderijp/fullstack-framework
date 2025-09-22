<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Helpers;
use RedBeanPHP\R;

class KitchenController
{
    private Helpers $helper;
    protected array $kitchens = [];

    public function __construct()
    {
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
        $kitchenId = $_GET['id'];

        foreach ($this->kitchens as $kitchen) {
            // if (array_search($kitchenId, $kitchen)) {
            // }
            if ($kitchen['id'] === $kitchenId) {
                $foundKitchen = $kitchen;
            }
        }

        if (empty($_GET['id'])) {
            $this->helper->error(404, 'No kitchen ID specified');
        } elseif (empty($foundKitchen)) {
            $this->helper->error(404, "No kitchens with id {$kitchenId} found");
        }

        $this->helper->displayTemplate('kitchens/show.twig', [
            'kitchen' => $foundKitchen
        ]);
    }
}
