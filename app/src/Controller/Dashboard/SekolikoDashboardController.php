<?php
/**
 * Julien Rajerison <julienrajerison5@gmail.com>.
 */

namespace App\Controller\Dashboard;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Controller\AbstractBaseController;
use App\Entity\Administrator;
use App\Entity\User;
use App\Helper\HistoryHelper;
use App\Manager\SekolikoEntityManager;
use App\Repository\AdministratorRepository;
use App\Repository\RoomRepository;
use App\Repository\ScolariteRepository;
use App\Repository\StudentRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use App\Entity\Calendar;
use App\Form\CalendarType;
use App\Repository\CalendarRepository;

/**
 * Class SekolikoDashboardController.
 *
 * @Route("/{_locale}/admin")
 */
class SekolikoDashboardController extends AbstractBaseController
{
    /** @var StudentRepository */
    private $studentRepository;


    /** @var UserRepository */
    private $UserRep;


    /** @var RoomRepository */
    private $roomRepository;

    /** @var ScolariteRepository */
    private $profsRepository;

    /** @var AdministratorRepository */
    private $adminRepository;

    /**
     * SekolikoDashboardController constructor.
     *
     * @param EntityManagerInterface       $manager
     * @param SekolikoEntityManager        $entityManager
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param StudentRepository            $studentRepository
     * @param RoomRepository               $roomRepository
     * @param ScolariteRepository          $scolariteRepository
     * @param AdministratorRepository      $administratorRepository
     * @param HistoryHelper|null           $historyHelper
     */
    public function __construct(UserRepository $UserRep, EntityManagerInterface $manager, SekolikoEntityManager $entityManager, UserPasswordEncoderInterface $passwordEncoder, StudentRepository $studentRepository, RoomRepository $roomRepository, ScolariteRepository $scolariteRepository, AdministratorRepository $administratorRepository, HistoryHelper $historyHelper = null)
    {
        parent::__construct($manager, $entityManager, $passwordEncoder, $historyHelper, $UserRep);
        $this->roomRepository = $roomRepository;
        $this->studentRepository = $studentRepository;
        $this->profsRepository = $scolariteRepository;
        $this->adminRepository = $administratorRepository;
        $this->UserRep = $UserRep;
    }

    /**
     * @Route("/dashboard",name="admin_dashboard",methods={"POST","GET"})
     *
     * @return Response
     *
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function dashboardController(Request $request, ManagerRegistry $doctrine, CalendarRepository $Caca): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        
        $em = $doctrine->getManager();

        $requestString = $request->get('q');
        $Evenement = $Caca->findByEvent(1);
        
        $entities =  $this->studentRepository->findAll();
        $ent = array();
        
        for ($i=0; $i < sizeof($entities) -1; $i++) { 
            array_push($ent, $entities[$i]->getUser()->getImatriculation());
        };
        
       

        $form = $this->createForm(SearchType::class);

        $search = $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
           
            $task = $form->getData();

//            c'est pour fixer l'erreur si l'id est 0

            if ($task != null) {
                $koko = $this->UserRep->findByImmatriculation($task);

                if (sizeof($koko) != 0) {

                    $entities = $this->studentRepository->findByUser($koko[0]);


                }
            }
            

            
        }

        return $this->renderForm('admin/content/_dashboard_admin.html.twig', [
            'form' => $form,
            'students' => $this->studentRepository->findAllBySchool($user),
                'profs' => $this->profsRepository->findProfs($user),
                'personels' => $this->profsRepository->findProfs($user, false),
                'rooms' => $this->roomRepository->findBySchoolYear($user, true),
                'admins' => count($this->adminRepository->findBySchoolYear($user)),
                'ents' => $entities,
                'event' => $Evenement
        ]);
        
        return $this->render(
            'admin/content/_dashboard_admin.html.twig',
            [
                'students' => $this->studentRepository->findAllBySchool($user),
                'profs' => $this->profsRepository->findProfs($user),
                'personels' => $this->profsRepository->findProfs($user, false),
                'rooms' => $this->roomRepository->findBySchoolYear($user, true),
                'admins' => count($this->adminRepository->findBySchoolYear($user)),
            ]
        );

        
    }
}
