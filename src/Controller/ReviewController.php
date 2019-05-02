<?php

namespace App\Controller;

use App\Model\ReviewManager;

class ReviewController extends AbstractController
{

    const EMPTY_FIELD = "Le champ ne peut pas être vide";
    const MAX_LENGTH_NAME = 30;
    const MAX_LENGTH = 130;
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
        } elseif ((strlen($cleanPost['name']) > self::MAX_LENGTH_NAME)) {
            $errors['name'] = 'Votre nom ne peut pas être supérieur à ' . self::MAX_LENGTH . 'caractères';
        }
        if (empty($cleanPost['comment'])) {
            $errors['comment'] = self::EMPTY_FIELD;
        } elseif ((strlen($cleanPost['comment']) > self::MAX_LENGTH)) {
            $errors['comment'] = 'Votre commentaire ne peut pas être supérieur à ' . self::MAX_LENGTH . 'caractères';
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
        $reviewAllManager = new ReviewManager();
        $reviewAll = $reviewAllManager->selectAllReviews();
        $cleanPost = [];
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            foreach ($_POST as $key => $value) {
                $cleanPost[$key]=trim($value);
            }
            $errors = $this->checkErrors($cleanPost);
            if (empty($errors)) {
                $reviewManager = new ReviewManager();
                $cleanReview = [
                    'name' => $cleanPost['name'],
                    'comment' => $cleanPost['comment'],
                    'rating' => $cleanPost['rating']
                ];
                $reviewManager -> insert($cleanReview);
                header('Location:/review/add/?success=true');
                exit();
            }
        }
        return $this->twig->render('/Review/add.html.twig', [
            'errors' => $errors,
            'cleanReview' => $cleanPost,
            'reviewAll' => $reviewAll,
            'get' => $_GET]);
    }
}
