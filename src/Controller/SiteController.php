<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SiteController extends AbstractController
{

    /**
     * @Route("/", name="homepage", options={"sitemapped" = true})
     */
    public function index(): Response
    {
        return $this->render('site/index.html.twig', [
            'controller_name' => 'SiteController',
        ]);
    }

       /**
     * @Route("/agb", name="agbs")
     */
    public function agb(): Response
    {
        return $this->render('site/agb.html.twig', [
            'controller_name' => 'SiteController',
        ]);
    }

       /**
     * @Route("/imprint", name="imprint")
     */
    public function imprint(): Response
    {
        return $this->render('site/imprint.html.twig', [
            'controller_name' => 'SiteController',
        ]);
    }


}
