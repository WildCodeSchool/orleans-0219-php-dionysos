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
        //base
        $categoryManager = new categoryManager();
        $categories = $categoryManager->selectAll();
        //fin base
        //update
        $data = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            var_dump($_POST);

            foreach ($_POST as $key => $value) {
                $data[$key] = trim($value);
            }
            if (!empty($_POST['label'])) {
                $categoryManager -> updateLabel($data);
                header('location:/AdminCategory/index/?success=true&id=' . $data['label'] . '#' . $data['label']);
            }
        }
        return $this->twig->render('Admin/Dish/category.html.twig', ['categories' => $categories, 'category' => $data]);
    }
}
