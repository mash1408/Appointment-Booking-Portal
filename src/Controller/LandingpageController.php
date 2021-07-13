<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class LandingpageController extends AbstractController
{
    // public function index(): Response
    // {
    //     return $this->render('landingpage/index.html.twig', [
    //         'controller_name' => 'LandingpageController',
    //     ]);
    // }
    private UrlGeneratorInterface $urlGenerator;
    
    #[Route('/', name: 'landingpage')]
    public function new():Response
    {
        // if ($this->isGranted('ROLE_ADMIN')){
        //     return $this->redirectToRoute('admindashboard');
        // }
        // elseif($this->isGranted('ROLE_USER')){
        //     return $this->redirectToRoute('home');
        // }
        // else{
        return $this->render('landingpage/index.html.twig', [
            'controller_name' => 'LandingpageController',
        ]);
    // }
    }
}
