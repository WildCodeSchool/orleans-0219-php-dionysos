<?php

namespace App\Controller;

use App\Model\BookManager;

class BookController extends AbstractController
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
        $bookManager = new BookManager();
        $reviews = $bookManager->selectAll();
        return $this->twig->render('Book/index.html.twig',['reviews' => $reviews]);
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
            $bookManager = new BookManager();
            $review = [
                'name' => $_POST['name'],
                'comment' => $_POST['name'],
                'rating' => $_POST['rating'],
            ];
            $id = $bookManager->insert($review);
            header('Location:Book/show/'.$id);

        }
        return $this->twig->render('Book/index.html.twig');
    }

}
