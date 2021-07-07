<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdmindashboardController extends AbstractController
{
    #[Route('/admindashboard', name: 'admindashboard')]
    public function index(): Response
    {
        return $this->render('admindashboard/index.html.twig', [
            'controller_name' => 'AdmindashboardController',
        ]);
    }
}
