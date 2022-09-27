<?php

namespace App\Controller;

use App\Entity\Fourniture;
use App\Entity\Room;
use App\Form\FournitureType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Constant\MessageConstant;
use App\Repository\FournitureRepository;
use DateTime;

class FournitureController extends AbstractController
{
    /**
     *
     * @route("fourniture", name="app_fourniture", methods={"POST","GET"})
     */

//    #[Route('/fourniture', name: 'app_fourniture')]
    public function index(FournitureRepository $repo): Response
    {
        $koko = $repo->findAll();

        return $this->render('fourniture/index.html.twig', [
            'koko' => $koko,

        ]);
    }

    /**
     *
     * @route("fourniture/manage", name="create_fourniture", methods={"POST","GET"})
     */

    #[Route('/fourniture/manage', name: 'create_fourniture')]
    public function manage(Request $request, EntityManagerInterface $em, Fourniture $fourniture = null): Response
    {

        $fourniture = $fourniture ?? new Fourniture;
        $form = $this->createForm(
            FournitureType::class,
            $fourniture
        );
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $data = $request->request->all();
            $type = $form->getData();


            $montantt = 10000;
            $date = new DateTime();
            $fourniture->setName($type->getName());
            $fourniture->setNumber($type->getNumber());

            $fourniture->setDateInsert($date);
            $fourniture->setRoom($type->getRoom());


            $em->persist($fourniture);
            $em->flush();

            $this->addFlash(MessageConstant::SUCCESS_TYPE, MessageConstant::AJOUT_MESSAGE);
            return $this->redirectToRoute('app_fourniture');
        }
        return $this->renderForm('fourniture/_fourniture_manage.html.twig', [
            'form' => $form,
        ]);


    }
}
