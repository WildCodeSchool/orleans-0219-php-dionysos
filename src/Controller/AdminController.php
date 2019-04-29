<?php
/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40
 */

namespace App\Controller;

use App\Model\AdminReviewManager;

class AdminController extends AbstractController
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
        return $this->twig->render('Admin/index.html.twig');
    }

    /**
     * Displays all rows ordered by date
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function adminGuestBook()
    {
        $adminReviewManager = new adminReviewManager();
        $reviews = $adminReviewManager->selectAllAdminReviews();
        return $this->twig->render('Admin/guestbook.html.twig', ['reviews' => $reviews]);
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
        header('Location: Admin/guestbook.html.twig');
    }
}
