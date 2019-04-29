<?php

namespace App\Controller;

use App\Model\DishManager;
use App\Model\CategoryManager;

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
        $dishManager = new DishManager();
        $dishes = $dishManager->selectDish();

        foreach ($dishes as $dish) {
            $dishesWithCategories[$dish['category']][] = $dish;
        }

        $categoryManager = new CategoryManager();
        $categories = $categoryManager->selectAll();


        return $this->twig->render('Dish/index.html.twig', [
            'dishesWithCategories' => $dishesWithCategories,
            'categories' => $categories,
        ]);
    }
}
