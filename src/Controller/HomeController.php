<?php

namespace App\Controller;
use App\Entity\User;
use App\Entity\Review;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\BookingFormType;
use App\Entity\Slot;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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

        $slots=$this->getDoctrine()->getRepository(Slot::class)->findAll();
        return $this->render('home/calendar.html.twig', [
            'form' => $form->createView(),
            'slots' => $slots
    ]);
    }

    #[Route('/home/{date}', name: 'slotlist')]
    public function index(Request $request, $date = 'date'): Response
    {
        $Slot = new Slot();
        $form = $this->createFormBuilder()
        ->add('category',ChoiceType::class,['choices' => [
            'Haircut' => 'Haircut',
            'Shaving' => 'Shaving',
            'Massage' => 'Massage',
            ],'label' => 'Select your service:',])
        ->add('id', IntegerType::class)
        ->add('save',SubmitType::class)
        ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $userid = $this->getUser()->getId();
            $slotid = $form["id"]->getData();
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

        return $this->render('home/index.html.twig', ['slots' => $slotArray,'booking_form' => $form->createView()]);
    }

    // #[Route('/book/{slotid}/{userid}', name: 'book')]
    // public function book(Request $request, $slotid, $userid){
    //     $Slot = new Slot();
    //     $form = $this->createForm(BookingFormType::class);

    //     $form->handleRequest($request);

    //     if($form->isSubmitted() && $form->isValid())
    //     {
    //         $category = $form["category"]->getData();

            
    //         $entityManager = $this->getDoctrine()->getManager();
    //         $slots = $entityManager->getRepository(Slot::class)->find($slotid);
    //         $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['id' => $userid]);
    //         //dd($user);
    //         $slots->setCategory($category);
    //         $slots->setBooked("1");
    //         $slots->setUser($user);
    //         $entityManager->persist($slots);
    //         $entityManager->flush();

    //         return $this->redirectToRoute('home');
    //     }
    //     return $this->render('book/book.html.twig', ['booking_form' => $form->createView()]);
    // }
    
    #[Route('/reviews', name: 'reviews')]
    public function showReviews(Request $request): Response
    {   
        $userReviewed = null;
        $form = $this->createFormBuilder()
            ->add('rating', IntegerType::class)
            ->add('comment', TextareaType::class)
            ->add('category', ChoiceType::class,['choices' => [
                'Haircut' => 'Haircut',
                'Shaving' => 'Shaving',
                'Massage' => 'Massage',
            ],
            'label' => 'Select a category',])
            ->add('userid', IntegerType::class)
            ->add('save', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);
        if($form->isSubmitted()){
            $uid = $form["userid"]->getData();
            $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['id' => $uid]);

            $userreview = $this->getDoctrine()->getRepository(Review::class)->findOneBy(['user' => $uid]);

            if(!$userreview){
            date_default_timezone_set('Asia/Kolkata');
            $currentDate = date('m/d/Y h:i:s');
            $commented_at = \DateTime::createFromFormat('m/d/Y h:i:s', $currentDate);

            $review = new Review();
            $review->setRating($form["rating"]->getData());
            $review->setComment($form["comment"]->getData());
            $review->setCategory($form["category"]->getData());
            $review->setUser($user);
            $review->setCommentedAt($commented_at);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($review);
            $entityManager->flush();
            }
            else{
                $userReviewed = "You have already sent us your ratings";
            }
        }

        $reviews = $this->getDoctrine()->getRepository(Review::class)->findAll();

        $reviewsArray = [];

        foreach ($reviews as $review) {
            $user = $review->getUser()->getName();
            array_push($reviewsArray, [ $review->getId(),$user, $review->getCommentedAt()->format('Y-m-d H:i:s'), $review->getRating(), $review->getCategory(), $review->getComment()]);
        }
        return $this->render('home/reviews.html.twig',['review_form'=> $form->createView(), 'ratings'=>$reviewsArray, 'hasReviewed'=>$userReviewed]);
    }
    
         
    #[Route('/appointment/{userid}', name: 'appointment')]
    public function appointment(Request $request,$userid)
    /**
     * @Route("/home/appointment/{$userid}", name="appointment")
     */
 {
     
     $userid =$this->getDoctrine()
     ->getRepository(user::class)
     ->findOneBy(['id' => $userid]);

    //  $slots =$this->getDoctrine()
    //  ->getRepository(slot::class)
    //  ->findOneBy(['id' => $slotid]);

    //  $entityManager = $this->getDoctrine()->getManager();
    //  $slotid=$entityManager ->getRepository(Slot::class)
    //                         ->findOneBy(['id'=> $slotid]);

     //  return new Response('username:',$userid->getUsername($userid));
    // $slots = $entityManager->getRepository(Slot::class)->find($slotid);
           
 
    return $this->render('home/appointment.html.twig',['userid'=> $userid]);
 }

}
