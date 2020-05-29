<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function index()
    {
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    /**
     * @Route("/detail-permanence", name="detail_permanence")
     */
    public function detailPermanence()
    {

    }

    /**
     * @Route("/echange-permanence", name="echange_permanence")
     */
    public function echangePermanence()
    {

    }
}
