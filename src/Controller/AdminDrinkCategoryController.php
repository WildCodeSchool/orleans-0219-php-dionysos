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

        return $this->twig->render('AdminDrinkCategory/index.html.twig', [
            'drinkCategories' => $drinkCategories,
            'notification'         => $_GET['notification'] ?? null,
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
        $drinkCategory = $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $drinkCategory['name'] = trim($_POST['name']);
            $errors = $this->checkErrors($drinkCategory);

            if (empty($errors)) {
                $drinkCategoryManager->insert($drinkCategory);
                header('Location: /adminDrinkCategory/index/?notification=edit');
                exit();
            }
        }

        return $this->twig->render('AdminDrinkCategory/add.html.twig', [
            'drinkCategory' => $drinkCategory,
            'errors'        => $errors,
        ]);
    }

    /**
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $drinkCategoryId = (int)trim($_POST['id']);
            $drinkCategoryManager = new DrinkCategoryManager();
            $drinkCategoryManager->delete($drinkCategoryId);
            header('Location: /adminDrinkCategory/index/?notification=delete');
            exit();
        }
    }


    /**
     * @param int $id
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function edit(int $id)
    {
        $drinkCategoryManager = new DrinkCategoryManager();
        $drinkCategory = $drinkCategoryManager->selectOneById($id);
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $drinkCategory['name'] = trim($_POST['name']);
            $errors = $this->checkErrors($drinkCategory);

            if (empty($errors)) {
                $drinkCategoryManager->update($drinkCategory);
                header('Location: /adminDrinkCategory/index/?notification=edit');
                exit();
            }
        }

        return $this->twig->render('AdminDrinkCategory/edit.html.twig', [
            'drinkCategory' => $drinkCategory,
            'errors'        => $errors,
        ]);
    }

    /**
     * @param array $drinkCategory
     * @return array
     */
    private function checkErrors(array $drinkCategory): array
    {
        if (empty($drinkCategory['name'])) {
            $errors[] = 'Le nom de la catégorie est obligatoire';
        }

        $maxLength = 150;
        if (!empty($drinkCategory['name']) && strlen($drinkCategory['name']) > $maxLength) {
            $errors[] = 'Le nom de la catégorie ne doit pas excéder ' . $maxLength . ' caractères';
        }

        return $errors ?? [];
    }
}
