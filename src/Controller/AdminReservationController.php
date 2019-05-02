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
        $adminReservationManager = new AdminReservationManager();
        $reservations = $adminReservationManager->selectAll();
        return $this->twig->render('AdminReservation/index.html.twig', [
            'reservations' => $reservations,
            'reservation'
        ]);
    }


    public function delete()
    {
        $id = trim($_POST['id']);
        $adminReservationManager = new AdminReservationManager();
        $reservation = $adminReservationManager->selectOneById($id);
        $adminReservationManager->delete($id);

        $this->sendMail($reservation, false);

        header('Location:/AdminReservation/index');
        exit();
    }

    private function sendMail(array $reservation, bool $success)
    {
        $transport = (new \Swift_SmtpTransport(APP_MAIL_HOST, APP_MAIL_PORT, APP_MAIL_ENCRYPTION));
        $transport->setUsername(APP_MAIL_USER);
        $transport->setPassword(APP_MAIL_PWD);
        $mailer = new \Swift_Mailer($transport);
        $message = new \Swift_Message();
        $message->setSubject('Message de ' . $reservation['email']);
        $message->setFrom([APP_MAIL_USER => 'Chez Dionysos']);
        $message->setTo([$reservation['email'] => $reservation['name']]);
        $message->setBody($this->twig->render(
            'Email/reservation.html.twig',
            [
                'reservation' => $reservation,
                'success' => $success,
            ]
        ), 'text/html');
        $mailer->send($message);
    }

    /**
     * @param int $id
     */
    public function updateValidate()
    {
        $id = trim($_POST['id']);
        $adminReservationManager = new AdminReservationManager();
        $reservation = $adminReservationManager->selectOneById($id);
        $adminReservationManager->updateValidate($id);

        $this->sendMail($reservation, true);

        header('Location:/AdminReservation/index');
        exit();
    }
}
