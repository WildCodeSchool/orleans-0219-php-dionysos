<?php
/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40
 */

namespace App\Controller;

use App\Model\AdminReviewManager;
use App\Model\DrinkCategoryManager;
use App\Model\DrinkManager;

class AdminDrinkController extends AbstractController
{
    /**
     * Displays all rows ordered by date
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        $drinkManager = new DrinkManager();
        $drinks = $drinkManager->selectAllWithCategories();

        return $this->twig->render('AdminDrink/index.html.twig', [
            'drinkCategories' => $drinks,
            'notification'         => $_GET['notification'] ?? null,
        ]);
    }
}
