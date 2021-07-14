<?php

namespace App\Controller;
use App\Entity\AdminForm;
use App\Entity\Slot;
use App\Entity\Review;
use App\Entity\User;
use App\Form\AdminSlotsType;
use Doctrine\Common\Collections\Expr\Value;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Form\Extension\HttpFoundation\HttpFoundationExtension;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;

#[IsGranted('ROLE_ADMIN')]
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
        $startmonth=intval($adminform->getStartDate()->format('m'));
        $startday=intval($adminform->getStartDate()->format('d'));
        
        $endmonth=intval($adminform->getEndDate()->format('m'));
        $endday=intval($adminform->getEndDate()->format('d'));
        $starthrs=intval($adminform->getStartTime()->format('G'));
        $endhrs=intval($adminform->getEndTime()->format('G'));
        $startmin=intval($adminform->getStartTime()->format('i'));
        $endmin=intval($adminform->getEndTime()->format('i'));
        


        if($startmonth > $endmonth ){
            //error
            echo "<div class='bg-red-500 p-3 text-bold'>Start month Has to Less than End Month</div>";
        }
        if($startmonth == $endmonth ){
            if($startday > $endday ){
                //error
                echo "<div class='bg-red-500 p-3 text-bold'>Start Day Has to Less than End Day</div>";
            }
        }
        if($starthrs > $endhrs ){
            //error
            echo "<div class='bg-red-500 p-3 text-bold'>Start Hours Has to Less than End Hours</div>";
        }
        $e =$startday;
        for($i = $startmonth ; $i<= $endmonth ;$i++)
        {
            if($i==01||$i==03||$i==05||$i==7||$i==8||$i==10||$i==12)
            {
                $a = 31;
            }
            elseif($i == 2){
                $a = 28;
            }
            else{
                $a = 30;
            }
            
            if($i == $endmonth)
            {   
                for($j = $e ; $j<=$endday ;$j++)
                { 
                    $start=intval($starthrs*60 + $startmin);
                    $end=intval($endhrs*60 + $endmin);
                    $dte = $j. "-" .$i."-2021";
                    //$dt = strtotime("3 1 2005");
                    $newDate = date("Y-m-d", strtotime($dte));
                    //var_dump($newDate);
                    for($k = $start ; $k<= $end-60 ;$k=$k+70)
                    {
                        $slothr=intval($k/60);
                        $slotmin=$k%60;
                        $dt = $slothr. ":" .$slotmin.":00";
                        $newTime = date("G:i:s", strtotime($dt));
                        $date = \DateTime::createFromFormat('Y-m-d', $newDate);
                        $time = \DateTime::createFromFormat('G:i:s', $newTime);
                        //print_r($time);
                        $slot = new Slot();
                        $slot->setSlotDate($date);
                        $slot->setSlotTime($time);
                        $slot->setBooked('0');
                        $entityManager = $this->getDoctrine()->getManager();
                        $entityManager->persist($slot);
                        $entityManager->flush();
                    }
                }
            }else{
                for($j = $e ; $j<=$a ;$j++)
                { 
                    $e = 1;
                    $start=intval($starthrs*60 + $startmin);
                    $end=intval($endhrs*60 + $endmin);
                    $dte = $j. "-" .$i."-2021";
                    $newDate = date("Y-m-d", strtotime($dte));
                    for($k = $start ; $k<= $end-60 ;$k=$k+70)
                    {
                        $slothr=intval($k/60);
                        $slotmin=$k%60;
                        $dt = $slothr. ":" .$slotmin.":00";
                        $newTime = date("G:i:s", strtotime($dt));
                        $date = \DateTime::createFromFormat('Y-m-d', $newDate);
                        $time = \DateTime::createFromFormat('G:i:s', $newTime);
                        $slot = new Slot();
                        $slot->setSlotDate($date);
                        $slot->setSlotTime($time);
                        $slot->setBooked('0');
                        $entityManager = $this->getDoctrine()->getManager();
                        $entityManager->persist($slot);
                        $entityManager->flush();
                    }
                }
            }
            
        }
        /////////////////////////////
        // Online C++ compiler to run C++ program online


        // for(i=sm;i<=em;i++)
        // { //months qith 31 days
        //     if(i==em){
        //         myvar=ed;
        //     }else if(i==1||i==3||i==5||i==7||i==8||i==10||i==12){
        //         myvar=31;
        //     }
        //     else if(i==2||i==4||i==6|i==9||i==11){
        //         myvar=30;
        //     }
        //         for(int k=sd;k<=myvar;k++){
        //             
        //             int st=(st*100)+smin,et=(eh*100)+emin;
        //              
        //       while(st<et)
        //      {      
        //         if(st+100<et)
        //            cout<<"::::"<<st;
        //            st=st+100;
        //            if(st%100>=51){
        //                // cout<<""
        //                remaining_time=60-st%100;
        //                int temp=st/100;
        //                temp=(temp*100)+100;
        //                st=(temp+remaining_time);
        //            }
        //            else{
                    
        //                st=st+10; 
        //                if(st%100==60){
        //                    int temp=st/100;
        //                    temp=(temp*100)+100;
        //                    st=temp;
        //                }
        //            }
        //            // cout<<"------------::::"<<st<<endl;
        //    }             
        //  }
        //  }
        // }
        //  sd=1;
        // }
        // }

        ////////////////////////////
       
    }
    //get all the slots from db
    $slots=$this->getDoctrine()->getRepository(Slot::class)->findAll();
    $reviews=$this->getDoctrine()->getRepository(Review::class)->findAll();
    $slotArray =  array();
    $reviewArray =  array();
    foreach ($reviews as $review) {
        if($review->getUser() == NULL)
            $userid= NULL;
        else
        $userid = $review->getUser()->getName();
       
        $object = (object) [
            'id' => $review->getId(),
            'comments' => $review->getId(),
            'user' => $review->getId(),
            'rating' => $review->getRating(),
            'comment_time' => $review->getCommentedAt()->format('Y-m-d H:i:s'),
            
    ];
        array_push($reviewArray,$object);
    }
    

    foreach ($slots as $slot) {
        if($slot->getUser() == NULL)
            $userid= NULL;
        else
        $userid = $slot->getUser()->getName();
       
        $object = (object) [
            'id' => $slot->getId(),
            'booked' => $slot->getBooked(),
            'slotdate' => $slot->getSlotDate()->format('Y-m-d'),
            'slottime' => $slot->getSlotTime()->format('h:i:s'),
            'category' => $slot->getCategory(),
            'user' => $userid,
    ];
        array_push($slotArray,$object);
    }
   
        return $this->render('admindashboard/index.html.twig', [
            'adminslot' => $form->createView(),
            'slots' => $slotArray,
            'reviews' => $reviewArray
    ]);
}
#[Route('/slots/{date}', name: 'getSlots')]
public function getSlots(Request $request,$date='date'){
    $dateobj =  \DateTime::createFromFormat("Y-m-d",$date);
    $slots = $this->getDoctrine()->getRepository(Slot::class)->findBy(['slot_date' => $dateobj]);
    $slotArray =  array();
    
    foreach ($slots as $slot) {
        if($slot->getUser() == NULL)
            $userid= NULL;
        else
        $userid = $slot->getUser()->getName();
       
  
        $object = (object) [
            'id' => $slot->getId(),
            'booked' => $slot->getBooked(),
            'slotdate' => $slot->getSlotDate()->format('Y-m-d'),
            'slottime' => $slot->getSlotTime()->format('H:i:s'),
            'category' => $slot->getCategory(),
            'user' => $userid,
    ];
        array_push($slotArray,$object);
    }
    $response=new Response();
        $response->setContent(json_encode($slotArray));
        return $response;
}
#[Route('/delete/{id}', name: 'deleteSlot')]

public function delete(Request $request,$id){
    $slot = new Slot();
    $slot= $this->getDoctrine()->getRepository(Slot::class) ->find($id);
    // get current date and time
    $dateNow= date('Y-m-d');
    $time= date('H:i:s');
    $timeNow= date('H:i:s',strtotime("+30 minutes"));
    $previousHours=  $dateNow == $slot->getSlotDate()->format('Y-m-d') && $time > $slot->getSlotTime()->format('H:i:s');
    
    if($slot->getBooked()){
        $response=new Response();
        $response->setContent(json_encode([
            'status' => 300,
            'message' => 'booked slot'
        ]));
        return $response;

    }
    if($dateNow < $slot->getSlotDate()->format('Y-m-d') || $dateNow == $slot->getSlotDate()->format('Y-m-d') && $timeNow < $slot->getSlotTime()->format('H:i:s') ){
        
                    $entityManager= $this->getDoctrine()->getManager();
                    $entityManager->remove($slot);
                    $entityManager->flush();
                    $response=new Response();
                    $response->setContent(json_encode([
                        'status' => 200,
                        'message' => 'delete successful of slot with id '.$id
                    ]));
                    return $response;
    
    
     }
     else{
                    $response=new Response();

                    if($dateNow > $slot->getSlotDate()->format('Y-m-d'))
                            $response->setContent(json_encode([
                                'status' => 400,
                                'message' => "Unable to delete the previous day's slots"
                            ]));
                    else if($previousHours){
                            $response->setContent(json_encode([
                                'status' => 400,
                                'message' => "Please dont delete previous hours slot. Don't even think about it!!"
                            ]));
                    }
                    else
                            $response->setContent(json_encode([
                                'status' => 400,
                                'message' => 'Unable to delete after the 30 minutes gap'
                            ]));
                    return $response;

     }

}
}