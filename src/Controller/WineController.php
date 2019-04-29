<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/10/17
 * Time: 16:07
 * PHP version 7
 */

namespace App\Controller;

use App\Model\WhiteWineManager;
use App\Model\RedWineManager;
use App\Model\RoseWineManager;

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
        $whiteWineManager = new WhiteWineManager();
        $whiteWines = $whiteWineManager->selectAll();

        $redWineManager = new RedWineManager();
        $redWines = $redWineManager->selectAll();

        $roseWineManager = new RoseWineManager();
        $roseWines = $roseWineManager->selectAll();

        return $this->twig->render('Wine/index.html.twig', [
            'whiteWines' => $whiteWines,
            'redWines' => $redWines,
            'roseWines' => $roseWines,
            ]);
    }
}
