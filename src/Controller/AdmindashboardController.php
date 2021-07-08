<?php

namespace App\Controller;
use App\Entity\AdminForm;
use App\Form\AdminSlotsType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\HttpFoundation\HttpFoundationExtension;
use Symfony\Component\Routing\Annotation\Route;

class AdmindashboardController extends AbstractController
{
    #[Route('/admindashboard', name: 'admindashboard')]
    // public function index(): Response
    // {
    //     return $this->render('admindashboard/index.html.twig', [
    //         'controller_name' => 'AdmindashboardController',
    //     ]);
    // }
    public function new(Request $request): Response
    {
    // creates a task object and initializes some data for this example
    $adminform = new AdminForm();
    $form = $this->createFormBuilder($adminform)
        ->add('start_date', DateType::class)
        ->add('end_date', DateType::class)
        ->add('start_time', TimeType::class)
        ->add('end_time', TimeType::class)
        ->add('save', SubmitType::class)
        ->getForm();
    $request = Request::createFromGlobals();
    $form->handleRequest($request);
    $data=0;
    if ($form->isSubmitted()) {
        var_dump($adminform->getStartDate()->format('Y:m:d'));//to access start date
        var_dump($adminform->getEndDate()->format('Y:m:d'));//to access end date
        var_dump($adminform->getStartTime()->format('G:i'));//to access start date
        var_dump($adminform->getEndTime()->format('G:i'));







        
    }
        return $this->render('admindashboard/index.html.twig', [
            'adminslot' => $form->createView(),
    ]);
    }
// ///////////////////////////
}