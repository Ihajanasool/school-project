<?php

namespace App\Controller;

use App\Constant\MessageConstant;
use App\Form\RecuType;
use App\Repository\RecuRepository;
use App\Entity\Recu;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class RecuController.
 *
 * @Route("/{_locale}/admin/docs/recu")
 */
class RecuController extends AbstractController
{
    /**
     * @Route("/", name="recu")
     */
    public function index(): Response
    {
        return $this->render('admin/content/Docs/recu/indexRecu.html.twig', [
            'controller_name' => 'RecuController',
        ]);
    }

    /**
     * @Route("/create_recu", name="create_recu")
     */

    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $recu = new Recu();
        $form = $this->createForm(RecuType::class, $recu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $data = $form->getData();
            $recu->setNom($data->getNom());
            $recu->setPrenom($data->getPrenom());
            $recu->setDate($data->getDate());
            $recu->setDescription($data->getDescription());
            $recu->setPrice($data->getPrice());

            $entityManager->persist($recu);
            $entityManager->flush();

            return $this->redirectToRoute('recu', [
                'recus' => $recu
            ]);


        }

        return $this->render('admin/content/Docs/recu/createRecu.html.twig', [
            'controller_name' => 'RecuController',
            'form' => $form->createView()
        ]);
    }
}
