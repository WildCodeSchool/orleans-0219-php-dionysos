<?php

namespace App\Controller;

use App\Model\CategoryManager;

class AdminCategoryController extends AbstractController
{

    /**
     * Display home page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        $categoryManager = new categoryManager();
        $categories = $categoryManager->selectAll();
        return $this->twig->render('Admin/Dish/category.html.twig', ['categories' => $categories]);
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
        $categoryManager = new CategoryManager();
        $categories = $categoryManager->selectAll();
        $cleanPost = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            foreach ($_POST as $key => $value) {
                $cleanPost[$key]=trim($value);
            }
            $category = [
                'name' => $cleanPost['name'],
                'display_order' => $cleanPost['display_order'],
                'price' => $cleanPost['price'],
                'label' => $cleanPost['label'],
            ];
            $categoryManager->insert($category);
            $categoryManager->changeOrder($category['display_order']);

            //header('Location:/AdminCategory/add');
            //exit;
        }
        return $this->twig->render('Admin/Dish/add_category.html.twig', ['categories' => $categories,
            'category' => $cleanPost]);
    }
}
