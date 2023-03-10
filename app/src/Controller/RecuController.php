<?php

namespace App\Controller;

use App\Constant\MessageConstant;
use App\Form\RecuType;
use App\Repository\DescriptionRepository;
use App\Repository\RecuRepository;
use App\Entity\Recu;
use App\Entity\Description;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;

use PHPUnit\Util\Json;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

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
    public function index(Request $request, DescriptionRepository $repository, RecuRepository $recuRepository): Response
    {
        $descriptions = $repository->findAll();
        $recus = $recuRepository->findAll();

//        $price = $repository->findBy(['Type' => 'price']);

        return $this->render('admin/content/Docs/recu/indexRecu.html.twig', [
            'descriptions' => $descriptions,
            'recus' => $recus,
//            'price' => $price
        ]);
    }

    /**
     * @Route("/print_recu/{id}", name="print_recu")
     */
    public function print(Request $request, $id, DescriptionRepository $repository, RecuRepository $recuRepository): Response
    {
        $recu = $recuRepository->findOneBy(["id" => $id]);
        $descriptions = $recu->getDescriptions();
        dump($recu->getDescriptions());
        $total = 0;

        for ($i = 0; $i < count($descriptions); $i++){
            $total += $descriptions[$i]->getPrices();
        }

//        $price = $repository->findBy(['Type' => 'price']);

        return $this->render('admin/content/Docs/recu/print_recu.html.twig', [
            'descriptions' => $descriptions,

            'total' => $total,
            "recu" => $recu
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
            $koko = new Recu();
            dump($data);


            for ($i = 1; $i <= count($form->get("descriptions")->getData()); $i++){
                $Description = new Description;
                $Description->setPrices($form->get("descriptions")->getData()[$i]["price"]);
                $Description->setLabel($form->get("descriptions")->getData()[$i]["label"]);
//                dump($Description);

                $entityManager->persist($Description);

                $koko->addDescription($Description);

            }

            $koko->setPrice(1);
            $koko->setDescription("descri");
            $koko->setDate($form->getData()->getDate());
            $koko->setNom($data->getNom());
            $koko->setPrenom($data->getPrenom());
//            dump($koko);

            $entityManager->persist($koko);
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
