<?php
/**
 * Julien Rajerison <julienrajerison5@gmail.com>.
 **/

namespace App\Controller\User;

use App\Constant\MessageConstant;
use App\Constant\RoleConstant;
use App\Controller\AbstractBaseController;
use App\Entity\Scolarite;
use App\Entity\ScolariteType;
use App\Repository\ScolariteRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping\Id;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ScolariteController.
 *
 * @Route("/{_locale}/admin/scolarite")
 */
class ScolariteController extends AbstractBaseController
{
    /**
     * @Route("/list/{type}",name="scolarite_list")
     *
     * @param ScolariteRepository $repository
     * @param ScolariteType       $type
     *
     * @return Response
     */
    public function list(ScolariteRepository $repository, UserRepository $userRepository, ScolariteType $type)
    {
        $user = $userRepository->findAll();
        $varProf = "ROLE_PROFS";
        $varSecretaire = "ROLE_SECRETAIRE";
        $koko = $userRepository->findbyTypeRole($varProf);
        $kiki = $userRepository->findbyTypeRole($varSecretaire);
        
        return $this->render(
            'admin/content/Scolarite/scolarite/_list_scolarite.html.twig',
            [
                'scolarites' => $repository->findBySchoolYear($this->getUser(), $type),
                'types' => $type,
                'eleve' => $koko,
                'secretaire' => $kiki
            ]
        );
    }

    public function SecretaireList(ScolariteRepository $repository, UserRepository $userRepository, ScolariteType $type)
    {

    }

   

    /**
     * @param Request        $request
     * @param ScolariteType  $type
     * @param Scolarite|null $scolarite
     *
     * @return Response
     *
     * @Route("/manage/{type}/{id?}",name="scolarite_manage")
     */
    public function manage(Request $request, ScolariteType $type, Scolarite $scolarite = null)
    {
        $scolarite = $scolarite ?? new Scolarite();
        $form = $this->createForm(\App\Form\ScolariteType::class, $scolarite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $scolarite->setType($type);
            $this->beforeScolaritePersist($scolarite, $form, $type);
            
            if ($this->em->save($scolarite, $this->getUser(), $form)) {
                $this->addFlash(MessageConstant::SUCCESS_TYPE, MessageConstant::AJOUT_MESSAGE);

                return $this->redirectToRoute('scolarite_list', ['type' => $type->getId()]);
            }

            $this->addFlash(MessageConstant::ERROR_TYPE, MessageConstant::ERROR_MESSAGE);

            return $this->redirectToRoute(
                'scolarite_manage',
                [
                    'type' => $type->getId(),
                    'id' => $scolarite->getId() ?? null,
                ]
            );
        }

        return $this->render(
            'admin/content/Scolarite/scolarite/_scolarite_manage.html.twig',
            [
                'type' => $type,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @param Scolarite     $scolarite
     * @param FormInterface $form
     * @param ScolariteType $type
     *
     * @return Scolarite
     */
    public function beforeScolaritePersist(Scolarite $scolarite, FormInterface $form, ScolariteType $type)
    {
        $re = '/prof/mi';
        $isProfessor = preg_match_all($re, $type->getLibelle(), $matches, PREG_SET_ORDER, 0);
        $scolarite->getUser()->setRoles([
            RoleConstant::ROLE_SEKOLIKO[$isProfessor ? 'Professeur' : 'Secretaire'],
        ]);

        $plainPassword = $this->passencoder->encodePassword(
            $scolarite->getUser(),
            $form->get('user')->getData()->getPassword()
        );
        $scolarite->getUser()->setPassword($plainPassword);

        return $scolarite;
    }

 /**
     * 
     *
     * @Route("/details/{id}",name="scolarite_user_details")
     *
     * 
     * @param Scolarite $scolarite
     * 
     * @return Response
     */
    public function details(Request $request, $id, ScolariteRepository $repository) : Response
    {
        

        // var_dump($id);

//        var_dump($id);


        $koko = $repository->findOneBy(['user' => $id]);
        
        return $this->render(
            'admin/content/Scolarite/scolarite/_details.html.twig',
            [
                'personel' => $koko,
            ]
        );
    }

    /**
     * @param Scolarite $scolarite
     *
     * @Route("/remove/{id}",name="scolarite_remove")
     *
     * @return RedirectResponse
     */

    
    public function remove(UserRepository $userRepository, $id, Scolarite $scolarite, ScolariteRepository $repository)
    {

        $type = $scolarite->getType()->getId();
        $type = $repository->findOneBy(['user' => $id]);

        if ($this->em->remove($scolarite)) {

            $this->addFlash(MessageConstant::SUCCESS_TYPE, MessageConstant::SUPPRESSION_MESSAGE);
        } else {
            $this->addFlash(MessageConstant::ERROR_TYPE, MessageConstant::ERROR_MESSAGE);
        }

        return $this->redirectToRoute('scolarite_list', ['type' => $type]);
    }
}
