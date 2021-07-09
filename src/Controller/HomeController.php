<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\BookingFormType;
use App\Entity\Slot;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\ORM\Mapping\Id;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'home')]
    public function calender(Request $request): Response
    {
        $form = $this->createFormBuilder()
            ->add('slotDate', DateType::class)
            ->add('save', SubmitType::class, ['label' => 'View Slots'])
            ->getForm();

        // Submitting the form
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $date = (string)$form->getData()["slotDate"]->format('Y-m-d');
            return $this->redirectToRoute('slotlist',array('date'=>$date ));
        }

        return $this->render('home/calendar.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/home/{date}', name: 'slotlist')]
    public function index(Request $request, $date = 'date'): Response
    {
        $Slot = new Slot();
       
        $form = $this->createForm(BookingFormType::class, $Slot);
        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            dd($form->getData());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($Slot);
            $entityManager->flush();

            return new Response('Appointment booked....');
        }


        $dateobj =  \DateTime::createFromFormat("Y-m-d",$date);
        $slots = $this->getDoctrine()->getRepository(Slot::class)->findBy(['slot_date' => $dateobj]);
        // return $this->render('home/index.html.twig', [
        //     'controller_name' => 'HomeController',
        // ]);

        $slotArray = [];

        foreach ($slots as $slot) {
            array_push($slotArray, [$slot->getId(),$slot->getSlotDate()->format('Y-m-d'), $slot->getSlotTime()->format('H:i'), $slot->getBooked()]);
        }

        return $this->render('home/index.html.twig', ['slots' => $slotArray, 'booking_form' => $form->createView()]);
    }
}
