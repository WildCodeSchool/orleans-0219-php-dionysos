<?php

namespace App\Controller;

use App\Model\DishManager;

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
        $dish = $dishManager->selectAll();

        return $this->twig->render('Dish/index.html.twig', ['dish' => $dish]);
    }


}
