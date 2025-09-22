<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Helpers;

class KitchenController
{
    private Helpers $helper;
    protected array $kitchens = [
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

    public function __construct()
    {
        $this->helper = new Helpers();
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
            if (array_search($kitchenId, $kitchen)) {
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
