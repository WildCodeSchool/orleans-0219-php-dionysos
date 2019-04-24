<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/10/17
 * Time: 16:07
 * PHP version 7
 */

namespace App\Controller;

use App\Model\PictureManager;

/**
 * Class ItemController
 *
 */
class PictureController extends AbstractController
{


    /**
     * Display item listing
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        $pictureManager = new PictureManager();
        $pictures = $pictureManager->selectAll();

        return $this->twig->render('Picture/index.html.twig', [
            'pictures' => $pictures
        ]);
    }
}
