<?php

namespace App\Controller;

use App\Model\DishManager;
use App\Model\CategoryManager;
use App\Model\DrinkCategoryManager;
use App\Model\DrinkManager;
use App\Model\MenuManager;

class DishController extends AbstractController
{


    /**
     * Display dish listing
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        // get menus (formules)
        $menuManager = new MenuManager();
        $menus = $menuManager->selectAll();

        // get dishes
        $dishManager = new DishManager();
        $dishes = $dishManager->selectDish();

        $dishesWithCategories = [];  // initialiser la variable pour eviter un erreur dans le return;

        foreach ($dishes as $dish) {
            $dishesWithCategories[$dish['category']][] = $dish;
        }

        $categoryManager = new CategoryManager();
        $dishCategories = $categoryManager->selectAll();

        // get drinks
        $drinkManager = new DrinkManager();
        $drinks = $drinkManager->selectAll();
        $drinksWithCategories = [];

        foreach ($drinks as $drink) {
            $drinksWithCategories[$drink['drink_type_id']][] = $drink;
        }

        $drinkCategoryManager = new DrinkCategoryManager();
        $drinkCategories = $drinkCategoryManager->selectAll();


        return $this->twig->render('Dish/index.html.twig', [
            'dishesWithCategories' => $dishesWithCategories,
            'dishCategories' => $dishCategories,
            'drinksWithCategories' => $drinksWithCategories,
            'drinkCategories' => $drinkCategories,
            'menus' => $menus,
        ]);
    }
}
