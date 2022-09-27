<?php

namespace App\Controller\Assiduite;

use App\Constant\MessageConstant;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\AssiduiteType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Assiduite;
use App\Repository\AssiduiteRepository;
use DateTime;
use App\Entity\User;
use App\Repository\UserRepository;

class AssiduiteController extends AbstractController
{
    /**
     * @Route("/assiduite/create", name="assiduite")
     */
    public function index(Request $request, EntityManagerInterface $em, Assiduite $assiduite = null)
    {
        
        $assiduite = $assiduite ?? new Assiduite();

        $form = $this->createForm(AssiduiteType::class, $assiduite);
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            $data = $request->request->all();
            $type = $form->getData();
            
            
            $montantt = 10000;
            $date = new DateTime();
            $assiduite->setStatus($type->getStatus());
            $assiduite->setMotif($type->getMotif());
            $assiduite->setDate($date);
            
            $assiduite->setUser($type->getUser());
            
            $em->persist($assiduite);
            $em->flush();
            
            
            return $this->redirectToRoute('admin_dashboard');
        }
        
        return $this->renderForm('assiduite/index.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * @Route("/assiduite", name="assiduide_liste")
     */

//    #[Route('/assiduité', name: 'assiduide_liste')]
    public function liste(AssiduiteRepository $repository)
    {
        $manisa = 0;
        $sortie = 0;
        $benefice = 0;
        $presence = $repository->findAll();
        
        
        return $this->render(
            'assiduite/assid_liste.html.twig',
            [
                'presence' => $presence, 
                'total'  =>   array($manisa),
                'sortie' => array($sortie),
                'benefices' => array($benefice)
            ]
        );
    }


}
