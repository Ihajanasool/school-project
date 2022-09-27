<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Calendar;
use App\Form\CalendarType;
use App\Repository\CalendarRepository;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;

class ApiController extends AbstractController
{
    #[Route('/api', name: 'app_api')]
    public function index(): Response
    {
        return $this->render('api/index.html.twig', [
            'controller_name' => 'ApiController',
        ]);
    }
 /**
     * @Route("/api/{id}/edit", name="api_event_edit", methods={"PUT"})
     *
     * 
     */
    
    public function majEvent(?Calendar $Calendar, Request $request, ManagerRegistry $doctrine, $id): Response
    {
        
        var_dump($request->getContent());
        $dodo = json_decode($request->getContent());
        
        var_dump($dodo->title);
        if(
            
            isset($dodo->title) && !empty($dodo->title) &&
            isset($dodo->start) && !empty($dodo->start) &&
            isset($dodo->description) && !empty($dodo->description) &&
            isset($dodo->backgroundColor) && !empty($dodo->backgroundColor) &&
            isset($dodo->borderColor) && !empty($dodo->borderColor) &&
            isset($dodo->textColor) && !empty($dodo->textColor) 
           
        ){
            
            $code = 200;
            if(!$Calendar){
                $Calendar = new Calendar;

                $code = 201;
            }

            $Calendar->setTitle($dodo->title);
            $Calendar->setDescription($dodo->description);
            $Calendar->setStart(new DateTime($dodo->start));
            if($dodo->allDay){
                $Calendar->setEnd(new DateTime($dodo->start));
            }
            else{
                $Calendar->setEnd(new DateTime($dodo->end));
            }
            $Calendar->setAllDay($dodo->allDay);
            $Calendar->setBackgroundColor($dodo->backgroundColor);
            $Calendar->setBorderColor($dodo->borderColor);
            $Calendar->setTextColor($dodo->textColor);
            $Calendar->setEvenement($dodo->evenement);  

            $em = $doctrine->getManager();
            $em->persist($Calendar);
            $em->flush();


            return new Response("OK", $code);
        }else{

             return $this->render('api/index.html.twig'); 
        }
        return $this->render('api/index.html.twig', [
            'controller_name' => 'ApiController',
        ]);
    }
}
