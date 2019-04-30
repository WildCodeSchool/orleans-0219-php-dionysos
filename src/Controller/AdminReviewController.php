<?php
/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40
 */

namespace App\Controller;

use App\Model\AdminReviewManager;

class AdminReviewController extends AbstractController
{
    /**
     * Displays all rows ordered by date
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        //base
        $adminReviewManager = new adminReviewManager();
        $reviews = $adminReviewManager->selectAll();
        //fin base
        //update
        $data = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            foreach ($_POST as $key => $value) {
                $data[$key] = trim($value);
            }
            if (!empty($_POST['online'])) {
                $adminReviewManager -> updateStatus($data);
                header('location:/AdminReview/index/?success=true&id=' . $data['online'] . '#' . $data['online']);
            }
        }
        return $this->twig->render('Admin/review.html.twig', ['reviews' => $reviews, 'review' => $data]);
    }
}
