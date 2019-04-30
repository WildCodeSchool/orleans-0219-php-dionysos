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

class AdminDrinkCategoryController extends AbstractController
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
        $drinkCategoryManager = new DrinkCategoryManager();
        $drinkCategories = $drinkCategoryManager->selectAll();
        return $this->twig->render('AdminDrinkCategory/index.html.twig', ['drinkCategories' => $drinkCategories]);
    }
}
