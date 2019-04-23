<?php

namespace App\Controller;

use App\Model\DishManager;

class DishController extends AbstractController
{


    /**
     * Display item listing
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


    /**
     * Display item informations specified by $id
     *
     * @param int $id
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function show(int $id)
    {
        $dishManager = new DishManager();
        $dish = $dishManager->selectOneById($id);

        return $this->twig->render('Dish/show.html.twig', ['dish' => $dish]);
    }


    /**
     * Display item edition page specified by $id
     *
     * @param int $id
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function edit(int $id): string
    {
        $dishManager = new DishManager();
        $dish = $dishManager->selectOneById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dish['dish_name'] = $_POST['dish_name'];
            $dishManager->update($dish);
        }

        return $this->twig->render('Dish/edit.html.twig', ['dish' => $dish]);
    }


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
            $dish = [
                'dish_name' => $_POST['dish_name'],
            ];
            $id = $dishManager->insert($dish);
            header('Location:/dish/show/' . $id);
        }

        return $this->twig->render('Dish/add.html.twig');
    }


    /**
     * Handle dish deletion
     *
     * @param int $id
     */
    public function delete(int $id)
    {
        $dishManager = new DishManager();
        $dishManager->delete($id);
        header('Location:/dish/index');
    }
}
