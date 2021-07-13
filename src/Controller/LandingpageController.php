<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LandingpageController extends AbstractController
{
    #[Route('/', name: 'landingpage')]
    public function index(): Response
    {
        return $this->render('landingpage/index.html.twig', [
            'controller_name' => 'LandingpageController',
        ]);
    }
}
