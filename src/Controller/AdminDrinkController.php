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
            'notification'    => $_GET['notification'] ?? null,
        ]);
    }


    /**
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function add()
    {
        $drinkCategoryManager = new DrinkCategoryManager();
        $categories = $drinkCategoryManager->selectAll();

        $drink = $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $drink = array_map('trim', $_POST);

            $errors = $this->checkErrors($drink, $categories);

            if (empty($errors)) {
                $drinkManager = new DrinkManager();
                $drinkManager->insert($drink);
                header('Location: /adminDrink/index/?notification=edit');
                exit();
            }
        }

        return $this->twig->render('AdminDrink/add.html.twig', [
            'categories' => $categories,
            'drink'      => $drink,
            'errors'     => $errors,
        ]);
    }

    /**
     * @param array $drink
     * @return array
     */
    private function checkErrors(array $drink, array $categories): array
    {
        if (empty($drink['name'])) {
            $errors[] = 'Le nom de la catégorie est obligatoire';
        }

        $maxLength = 255;
        if (!empty($drink['name']) && strlen($drink['name']) > $maxLength) {
            $errors[] = 'Le nom de la catégorie ne doit pas excéder ' . $maxLength . ' caractères';
        }

        if (empty($drink['main_price'])) {
            $errors[] = 'Le prix est obligatoire';
        }

        if (!empty($drink['main_price']) && $drink['main_price'] < 0) {
            $errors[] = 'Le prix doit être supérieur à 0';
        }

        if (!empty($drink['takeaway_price']) && $drink['takeaway_price'] < 0) {
            $errors[] = 'Le prix à emporter doit être supérieur à 0';
        }

        if (empty($drink['drink_type_id'])) {
            $errors[] = 'La categorie est obligatoire';
        }

        if (!empty($drink['drink_type_id']) && !in_array($drink['drink_type_id'], array_column($categories, 'id'))) {
            $errors[] = 'La categorie est obligatoire';
        }

        if (!empty($drink['is_organic']) && !in_array($drink['is_organic'], [0, 1])) {
            $errors[] = 'La valeur "est biologique" doit être vraie ou fausse uniquement';
        }

        return $errors ?? [];
    }
}
