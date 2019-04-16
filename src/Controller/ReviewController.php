<?php

namespace App\Controller;

use App\Model\ReviewManager;

class ReviewController extends AbstractController
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
        $reviewManager = new ReviewManager();
        $review = $reviewManager->selectAll();
        return $this->twig->render('Review/index.html.twig', ['review' => $review]);
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
            $reviewManager  = new ReviewManager();
            $review = [
                'name' => $_POST['name'],
                'comment' => $_POST['name'],
                'rating' => $_POST['rating']
            ];
            $reviewManager ->insert($review);
            header('Location:/review/add');
        }
        return $this->twig->render('/Review/add.html.twig');
    }
}
