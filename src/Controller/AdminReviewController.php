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
        $adminReviewManager = new adminReviewManager();
        $reviews = $adminReviewManager->selectAllAdminReviews();
        return $this->twig->render('Admin/review.html.twig', ['reviews' => $reviews]);
    }

    /**
     * Handle item deletion
     *
     * @param int $id
     */

    public function delete(int $id)
    {
        $adminReviewManager = new adminReviewManager();
        $adminReviewManager ->delete($id);
        header('Location: Admin/review.html.twig');
    }

    /**
     * @param int $id, int $online
     *
     */

    public function online(int $id, int $online)
    {
        $adminReviewManager = new adminReviewManager();
        $adminReviewManager ->online($id, $online);
        header('Location: Admin/review.html.twig');
    }

}
