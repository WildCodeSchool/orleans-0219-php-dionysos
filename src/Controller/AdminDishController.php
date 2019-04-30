<?php
/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40
 */

namespace App\Controller;

use App\Model\AdminDishManager;

class AdminDishController extends AbstractController
{

    /**
     * Display item creation page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function add()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $adminDishManager = new AdminDishManager();
            $noSupplement = $_POST['sup'];
            if ($_POST['sup'] == 0) {
                $noSupplement = null;
            }
            $dish = [
                'dish_name' => $_POST['dish_name'],
                'category' => $_POST['category'],
                'sup' => $noSupplement,
            ];
            $id = $adminDishManager->insert($dish);
            header('Location:/AdminDish/add');
            exit;
        }

        return $this->twig->render('Admin/Dish/add.html.twig');
    }
}
