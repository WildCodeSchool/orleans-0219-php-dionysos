<?php
/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40
 */

namespace App\Controller;

use App\Model\CategoryManager;
use App\Model\DishManager;
use App\Model\MenuManager;

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
            $dishManager = new DishManager();


            $noSupplement = $_POST['sup'];
            if ($_POST['sup'] == 0) {
                $noSupplement = null;
            }
            $dish = [
                'dish_name' => $_POST['dish_name'],
                'category' => $_POST['category'],
                'sup' => $noSupplement,
            ];
            $id = $dishManager->insert($dish);
            header('Location:/AdminDish/add');
            exit;
        }
        $categoryManager = new CategoryManager();
        $categories = $categoryManager->selectAll();

        return $this->twig->render('Admin/Dish/add.html.twig', ['categories' => $categories,]);
    }

    public function index()
    {
        $dishManager = new DishManager();
        $dishes = $dishManager->selectDish();

        $dishesWithCategories = [];  // initialiser la variable pour eviter un erreur dans le return;

        foreach ($dishes as $dish) {
            $dishesWithCategories[$dish['category']][] = $dish;
        }

        $categoryManager = new CategoryManager();
        $categories = $categoryManager->selectAll();

        $menuManager = new MenuManager();
        $menus = $menuManager->selectAll();

        return $this->twig->render('Admin/Dish/index.html.twig', [
            'dishesWithCategories' => $dishesWithCategories,
            'categories' => $categories,
            'menus' => $menus,
            'dishes' => $dishes,
        ]);
    }

    public function show(int $id)
    {
        $dishManager = new DishManager();
        $dish = $dishManager->selectOneById($id);

        return $this->twig->render('Admin/Dish/show.html.twig', ['dish' => $dish]);
    }

    public function delete(int $id)
    {
        $DishManager = new DishManager();
        $DishManager->delete($id);
        header('Location:/AdminDish/index');
        exit;
    }
}
