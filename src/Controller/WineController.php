<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/10/17
 * Time: 16:07
 * PHP version 7
 */

namespace App\Controller;

use App\Model\WineManager;
use App\Model\WineTypeManager;

/**
 * Class WineController
 *
 */
class WineController extends AbstractController
{


    /**
     * Display wine listing
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        $wineManager = new WineManager();
        $wines = $wineManager->selectWine();

        $winesWithTypes = [];  // initialiser la variable pour eviter un erreur dans le return;

        foreach ($wines as $wine) {
            $winesWithTypes[$wine['type']][] = $wine;
        }

        $wineTypeManager = new WineTypeManager();
        $wineTypes = $wineTypeManager->selectAll();

        return $this->twig->render('Wine/index.html.twig', [
            'wines' => $wines,
            'wineTypes' => $wineTypes,
            'winesWithTypes' => $winesWithTypes,
            ]);
    }
}
