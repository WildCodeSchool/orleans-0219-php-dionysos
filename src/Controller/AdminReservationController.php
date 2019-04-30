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

    public function index()
    {
        //base
        $AdminReservationManager = new AdminReservationManager();
        $reservation = $AdminReservationManager->selectAll();
        //fin base
        //update
        $data = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            foreach ($_POST as $key => $value) {
                $data[$key] = trim($value);
            }
            if (!empty($_POST['online'])) {
                $AdminReservationManager->updateStatus($data);
                header('location:/AdminReview/index/?success=true&id=' . $data['online'] . '#' . $data['online']);
            }
        }
        return $this->twig->render('AdminReservation/index.html.twig', ['reservation' => $reservation, 'reservations'
        => $data]);
    }
}
