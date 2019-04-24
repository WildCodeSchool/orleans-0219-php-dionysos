<?php

namespace App\Controller;

use App\Model\ReviewManager;

class ReviewController extends AbstractController
{

    const EMPTY_FIELD = "Le champ ne peut pas être vide";
    const MAX_LENGTH = 100;
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
     * @param array $cleanPost
     * @return array
     */

    private function checkErrors(array $cleanPost): array
    {
        $errors = [];
        if (empty($cleanPost['name'])) {
            $errors['name'] = self::EMPTY_FIELD;
        } elseif ((strlen($cleanPost['name']) > self::MAX_LENGTH)) {
            $errors['name'] = 'Votre nom de produit ne peut pas être supérieur à ' . self::MAX_LENGTH . 'caractères';
        }
        if (empty($cleanPost['comment'])) {
            $errors['comment'] = self::EMPTY_FIELD;
        }
        if (empty($cleanPost['rating'])) {
            $errors['rating'] = 'Veuillez insérer une note.';
        }
        return $errors;
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
        $cleanPost = [];
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            foreach ($_POST as $key => $value) {
                $cleanPost[$key]=trim($value);
            }
            $errors = $this->checkErrors($cleanPost);
            if (empty($errors)) {
                $reviewManager = new ReviewManager();
                $review = [
                    'name' => $cleanPost['name'],
                    'comment' => $cleanPost['comment'],
                    'rating' => $cleanPost['rating']
                ];
                $reviewManager -> insert($review);
                header('Location:/review/index');
            }
        }
        return $this->twig->render('/Review/add.html.twig', ['errors' => $errors, 'review' => $cleanPost]);
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
        $reviewManager = new ReviewManager();
        $review = $reviewManager->selectOneById($id);
        return $this->twig->render('/Review/show.html.twig', ['review' => $review]);
    }
}
