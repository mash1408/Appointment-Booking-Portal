<?php

namespace App\Controller;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\BookingFormType;
use App\Entity\Slot;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\ORM\Mapping\Id;

#[IsGranted('ROLE_USER')]
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
    

    #[Route('/book/{slotid}/{userid}', name: 'book')]
    public function book(Request $request, $slotid, $userid){
        $Slot = new Slot();
        $form = $this->createForm(BookingFormType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $category = $form["category"]->getData();

            
            $entityManager = $this->getDoctrine()->getManager();
            $slots = $entityManager->getRepository(Slot::class)->find($slotid);
            $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['id' => $userid]);
            //dd($user);
            $slots->setCategory($category);
            $slots->setBooked("1");
            $slots->setUser($user);
            $entityManager->persist($slots);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }
        return $this->render('book/book.html.twig', ['booking_form' => $form->createView()]);
    }
}
