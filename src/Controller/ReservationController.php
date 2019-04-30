<?php

namespace App\Controller;

use App\Model\ReservationManager;
use Nette\Utils\DateTime;

class ReservationController extends AbstractController
{
    const EMPTY_FIELD = "* Veuillez compléter ce champ";
    const FIELD_EMAIL = "* L'email n'est pas valide !";
    const FIELD_DATE = "* La date de réservation doit être postérieure ou égal à aujourd'hui !";

    /**
     * Display home page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */

    /**
     * @param array $cleanPost
     * @return array
     */

    private function checkErrors(array $cleanPost): array
    {
        $errors = [];
        if (empty($cleanPost['name'])) {
            $errors['name'] = self::EMPTY_FIELD;
        }
        if (empty($cleanPost['email'])) {
            $errors['email'] = self::FIELD_EMAIL;
        } elseif (!filter_var($cleanPost['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = self::FIELD_EMAIL;
        }
        if (empty($cleanPost['phone'])) {
            $errors['phone'] = self::EMPTY_FIELD;
        }
        $today = date("Y-m-d");
        $date = $cleanPost['date'];
        if (empty($cleanPost['date'])) {
            $errors['date'] = self::EMPTY_FIELD;
        } elseif ($date < $today) {
            $errors['date'] = self::FIELD_DATE;
            $date = DateTime::createFromFormat('Y-m-d', $cleanPost['date']);
        } elseif ($date && $date->format('Y-m-d') !==  $cleanPost['date']) {
            $errors['date'] = "*Le format de date n'est pas valide !";
        }
        $nbPeople = $cleanPost['nbPeople'];
        if (empty($cleanPost['nbPeople'])) {
            $errors['nbPeople'] = self::EMPTY_FIELD;
        } elseif ($nbPeople < 0 or $nbPeople > 22) {
            $errors['nbPeople'] = '*Veuillez choisir une valeure comprise entre 0 et 22 !';
        }
        if (empty($cleanPost['appointment'])) {
            $errors['appointment'] = self::EMPTY_FIELD;
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
                $cleanPost[$key] = trim($value);
            }
            $errors = $this->checkErrors($cleanPost);
            if (empty($errors)) {
                $reservationManager = new ReservationManager();
                $reservation = $cleanPost;
                $reservationManager->insert($reservation);
                header('Location:/Reservation/success');
                exit();
            }
        }
        return $this->twig->render('/Reservation/add.html.twig', ['errors' => $errors, 'reservation' => $cleanPost]);
    }

    /**
     * Display home page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function success()
    {
        return $this->twig->render('Reservation/success.html.twig');
    }
}
