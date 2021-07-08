<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class BookingController extends AbstractController
{
    #[Route('/booking', name: 'booking')]
    public function index(Request $request): Response
    {
        
        $form = $this->createFormBuilder()
            ->add('slotDate', DateType::class)
            ->add('save', SubmitType::class, ['label' => 'View Slots'])
            ->getForm();

        // Submitting the form
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $date = (string)$form->getData()["slotDate"]->format('Y-m-d');
            return $this->redirectToRoute('home',array('date'=>$date ));
        }

        return $this->render('booking/calendar.html.twig', [
            'controller_name' => 'BookingController',
            'form' => $form->createView()
        ]);
    }
}
