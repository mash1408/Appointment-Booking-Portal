<?php

namespace App\Controller;
use App\Entity\AdminForm;
use App\Entity\Slot;
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
        // var_dump($adminform->getStartDate()->format('Y:m:d'));//to access start date
        // var_dump($adminform->getEndDate()->format('Y:m:d'));//to access end date
        // var_dump($adminform->getStartTime()->format('G:i'));//to access start Time
        // var_dump($adminform->getEndTime()->format('G:i'));//to access end time
        
        ////////////////////////////////////////////
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
            echo "Start month Has to Less than End Month";
        }
        if($startmonth == $endmonth ){
            if($startday > $endday ){
                //error
                echo "Start Day Has to Less than End Day";
            }
        }
        if($starthrs > $endhrs ){
            //error
            echo "Start Hours Has to Less than End Hours";
        }
        ///////////////////////////////
        
        // var_dump($startday);
        // var_dump($endday);
        // var_dump($endmin);
        // var_dump($endhrs);
        // print_r($endmin);
        $e =$startday;
        for($i = $startmonth ; $i<= $endmonth ;$i++)
        {
            //$i = intval($i);
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
                    //var_dump($j);
                    $start=intval($starthrs*60 + $startmin);
                    $end=intval($endhrs*60 + $endmin);
                    // var_dump($start);
                    //var_dump($j);
                    //var_dump($i);
                    $dte = $j. "-" .$i."-2021";
                    //$dt = strtotime("3 1 2005");
                    $newDate = date("Y-m-d", strtotime($dte));
                    //var_dump($newDate);
                    for($k = $start ; $k<= $end-60 ;$k=$k+70)
                    {
                        //var_dump($k);
                        $slothr=intval($k/60);
                        $slotmin=$k%60;
                        // print_r($slothr);
                        // echo ":";
                        // print_r($slotmin);
                        // echo " ";
                        $dt = $slothr. ":" .$slotmin.":00";
                        $newTime = date("h:i:s", strtotime($dt));
                        $date = \DateTime::createFromFormat('Y-m-d', $newDate);
                        $time = \DateTime::createFromFormat('h:i:s', $newTime);
                        //var_dump($newTime);
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
                    //var_dump($j);
                    $start=intval($starthrs*60 + $startmin);
                    $end=intval($endhrs*60 + $endmin);
                    // var_dump($start);
                    //var_dump($j);//day
                    //var_dump($i);//month
                    $dte = $j. "-" .$i."-2021";
                    $newDate = date("Y-m-d", strtotime($dte));
                    //var_dump($newDate);
                    for($k = $start ; $k<= $end-60 ;$k=$k+70)
                    {
                        //var_dump($k);
                        $slothr=intval($k/60);
                        $slotmin=$k%60;
                        // print_r($slothr);
                        // echo ":";
                        // print_r($slotmin);
                        // echo " ";
                        $dt = $slothr. ":" .$slotmin.":00";
                        $newTime = date("h:i:s", strtotime($dt));
                        $date = \DateTime::createFromFormat('Y-m-d', $newDate);
                        $time = \DateTime::createFromFormat('h:i:s', $newTime);
                        //var_dump($newTime);

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


        ///////////////////////////////////

 
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
        //                      while(st<et)
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
                                              
        //             }
        //                      }
        // //             }
        //  sd=1;
        // }
        // }

        ////////////////////////////
       
    }
        return $this->render('admindashboard/index.html.twig', [
            'adminslot' => $form->createView(),
    ]);
}
}