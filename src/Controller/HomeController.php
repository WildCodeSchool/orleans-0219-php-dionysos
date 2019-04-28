<?php
/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40
 */

namespace App\Controller;

use App\Model\HomeReviewManager;

class HomeController extends AbstractController
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
        $homeReviewManager = new HomeReviewManager();
        $homeReview = $homeReviewManager->selectHomeReviews();
        return $this->twig->render('Home/index.html.twig', ['homeReview' => $homeReview]);
    }
}
