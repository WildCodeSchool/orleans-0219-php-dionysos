<?php
/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40
 */

namespace App\Controller;

use App\Model\AdminReservationManager;

class AdminReservationController extends AbstractController
{
    /**
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */

    public function index()
    {
        //base
        $AdminReservationManager = new AdminReservationManager();
        $reservations = $AdminReservationManager->selectAll();

        return $this->twig->render('AdminReservation/index.html.twig', ['reservations' => $reservations, 'reservation'
        ]);
    }

    /**
     * @param int $id
     */
    public function delete(int $id)
    {
        $AdminReservationManager = new AdminReservationManager();
        $AdminReservationManager->delete($id);
        header('Location:/AdminReservation/index');
    }
}
