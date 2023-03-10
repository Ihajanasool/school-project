<?php

namespace App\Controller;

use App\Entity\ClassRoom;
use App\Entity\Journal;
use App\Entity\User;
use App\Repository\JournalRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\StudentRepository;
use App\Repository\UserRepository;
use DateTime;
use Symfony\Component\Validator\Constraints\Length;

/**
 * Class CheckoutController.
 *
 * @Route("/{_locale}/presence_eleve")
 */
class CheckoutController extends AbstractController
{
    /**
     *
     * @route ("/presence/eleve/{classe}/{id?}", name = "app_checkout", methods= {"GET", "POST"})
     */

//    #[Route('/presence/eleve/{classe}/{id?}', name: 'app_checkout', methods:["GET", "POST"])]
    public function index(ClassRoom $classe, studentRepository $repository): Response
    {


        $studentList = $repository->findByClassSchoolYearField($this->getUser(), $classe);
        return $this->render('checkout/index.html.twig', [
            'controller_name' => 'CheckoutController',
            'students' => $studentList,
            'classe'=>$classe
        ]);
    }



    /**
     *
     * @route ("/presence/{classe}/zefzef", name = "dede", methods= {"GET", "POST"})
     */

//    #[Route('/presence/{classe}/zefzef', name: 'dede', methods:["GET", "POST"])]
    public function dede(ClassRoom $classe, studentRepository $repository, JournalRepository $JR, EntityManagerInterface $em): Response
    {
        
        
        
        
        $studentList = $JR->findByToday();
        $kiki =array();
        $koko =array();
        $keke =array();
        $i = 0;
        while($i < count($studentList)){
            array_push($kiki, $i);
            $i++;
        }
        
        foreach ($studentList as $entity) {
            
            if (!in_array($entity->getUser(), $keke)) {
                $koko[] = $entity;
                $keke[] = $entity->getUser();
            }
            else {
                $JR->createQueryBuilder('e')
                ->delete()
                ->where('e.id = :id')
                ->setParameter('id', $entity->getId())
                ->getQuery()
                ->execute();
                        
                        
                }
        }
        
        $koko = array_values($koko);

        
        return $this->render('checkout/list.checkout.html.twig', [
            'controller_name' => 'CheckoutController',
            'students' => $koko,
            'classe'=>$classe
        ]);
    }

   

    /**
 * @Route("/update-status", name="update_status", methods={"POST"})
 */
    public function updateStatus(Request $request, UserRepository $repository, EntityManagerInterface $em, JournalRepository $JR)
    {
        $studentId = $request->request->get('studentId');
        $status = $request->request->get('checked');
        
        
        $student = $repository->find($studentId);
        
        $journal = new journal;
        
        if (!$student) {
            
            return new JsonResponse(['error' => 'Student not found'], 405);
            
        }
        $date = new DateTime();
        
        $journal->setStatus($status);
        $journal->setUser($student);
        $journal->setDateChecked($date);
        $em->persist($journal);
        $em->flush();
        
        return new JsonResponse(['message' => 'Student status updated'], 200);
    }

    
}
