<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Slot;
use Doctrine\ORM\Mapping\Id;

class HomeController extends AbstractController
{
    #[Route('/home/{date}', name: 'home')]
    public function index($date = 'date'): Response
    {
        $dateobj =  \DateTime::createFromFormat("Y-m-d",$date);
        $slots = $this->getDoctrine()->getRepository(Slot::class)->findBy(['slot_date' => $dateobj]);
        // return $this->render('home/index.html.twig', [
        //     'controller_name' => 'HomeController',
        // ]);

        $slotArray = [];

        foreach ($slots as $slot) {
            array_push($slotArray, [$slot->getId(),$slot->getSlotDate()->format('Y-m-d'), $slot->getSlotTime()->format('H:i'), $slot->getBooked()]);
        }

        return $this->render('home/index.html.twig', ['slots' => $slotArray]);
    }
}
