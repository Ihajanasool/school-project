<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Student;
use App\Entity\User;
use App\Entity\Scolarite;
use App\Entity\PresenceEleve;
use App\Repository\StudentRepository;
use App\Form\PresenceEleveType;
use App\Repository\UserRepository;
use App\Repository\ScolariteRepository;
use App\Repository\ClassRoomRepository;
use App\Repository\PresenceEleveRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use App\Constant\MessageConstant;


class PresenceEleveController extends AbstractController
{
    #[Route('/presence/eleve/{id}', name: 'app_presence_eleve', methods:["GET", "POST"])]
    public function Check(PresenceEleveRepository $presence, EntityManagerInterface $em, Request $request, PresenceEleve $PresenceEleve = null, StudentRepository $StdRepo, $id, UserRepository $UserRepo, ScolariteRepository $ScoRepo, ClassRoomRepository $classRepo): Response
    {
        
        $PresenceEleve = $PresenceEleve ?? new PresenceEleve;
        $koko = array();
        $form = $this->createForm(
            PresenceEleveType::class,
            $PresenceEleve
        );
        
        $user = $UserRepo->findOneBy(["id" => $id]);
        $prof = $ScoRepo->findByUser($user);
        $classroom = $classRepo->findOneBy(["id" => $prof[0]->getClassRoom()]);
        $kiki = array();
        $eleve = $StdRepo->findByClassroom($classroom);
        $pre = $presence->findAll();
        
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            var_dump(sizeof($eleve));
            for ($i = 0; $i < sizeof($eleve); $i++) {
                array_push($kiki, $eleve[$i]->getUser());
            };
            
           
            $data = $request->request->all();
            $type = $form->getData();
            
            
            $date = new DateTime();
             
            
            if (in_array($type->getUser() , $kiki)){
                
                $PresenceEleve->setMotif("Mbola tsisy");
                $PresenceEleve->setDate($date);
                $PresenceEleve->setStatus($data["presence_eleve"]["status"]);
                $PresenceEleve->setUser($type->getUser());
                
                
                $em->persist($PresenceEleve);
                $em->flush();
                $this->addFlash(MessageConstant::SUCCESS_TYPE, MessageConstant::AJOUT_MESSAGE);
                    return $this->renderForm('presence_eleve/index.html.twig', [
                        'user' => $prof,
                        'classroom' => $classroom,
                        'eleve' => $eleve,
                        'form' => $form
                    ]);
            }
            $this->addFlash(MessageConstant::ERROR_TYPE, MessageConstant::DONOTBELONG);
            
        }
        
        return $this->renderForm('presence_eleve/index.html.twig', [
            'user' => $prof,
            'classroom' => $classroom,
            'eleve' => $eleve,
            'form' => $form
        ]);
    }
    #[Route('/presence/liste', name: 'liste_presence_eleve', methods:["GET", "POST"])]
    public function liste(PresenceEleveRepository $repository): Response
    {
        $date = new DateTime('tomorrow');
        
        $date22 = new DateTime();
        $date1 = $date22->format("Y-m-d h:m:s");
        $date->setDate(2022, 8, 29);

        $datetest3 =  $date->format("Y-m-d h:m:s");
        $koko = $repository->findAll();
        
        $date2 = $date22->format("Y-m-d") . " 00:00:00.000000";
        
        $presence = $repository->findByToday($date2, $date1);
        
        return $this->render(
            'presence_eleve/liste.html.twig',
            [
                'presence' => $presence, 
                
            ]
        );
    }
}
