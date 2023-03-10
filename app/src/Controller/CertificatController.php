<?php

namespace App\Controller;

use App\Constant\MessageConstant;
use App\Form\CertificatType;

use App\Repository\CertificatRepository;
use App\Entity\Certificat;
use App\Entity\Student;

//use http\Env\Request;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Routing\Annotation\Route;

use Dompdf\Dompdf;
use Dompdf\Options;

/**
 * Class CertificatController.
 *
 * @Route("/{_locale}/admin/docs/certificat")
 */

class CertificatController extends AbstractController
{
    /**
     * @Route("/", name="certificat"), methods={"GET" , "POST"})
     */
    public function index(
        Request $request,
        CertificatRepository $certificatRepository
    ): Response {
        //        $get = $request->query->all();

        //        $type = $get['type'];
        //        $id = $get['id'];

        //this function Finds the last Certificate saved in Database
        $data = $certificatRepository->findByLastDate();

        function GenId()
        {
            $id = substr(
                str_shuffle(
                    '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
                ),
                0,
                10
            );
            return $id;
        }

        $id = GenId();

        $pdfOptions = new Options();

        // Configure Dompdf according to your needs
        $pdfOptions->set('defaultFront', 'Arial');
        $pdfOptions->set('isRemoteEnabled', 'true');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        // Retrieve the HTML generated in our twig file

        //

        $html = $this->render('admin/content/Docs/certificat/index.html.twig', [
            'controller_name' => 'CertificatController',
            'certificats' => $data,
            //            'name' => $name,
            //            'id' => $id,
        ]);
        //
        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        //        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        $exportName = $id . '.pdf';

        // Output the generated PDF to Browser (force download)
        $dompdf->stream($exportName, [
            'Attachment' => false,
        ]);

        exit(0);
        //        ob_get_clean();
    }

    /**
     * @Route("/create_certificat", name="create_certificat")
     */
    public function create(
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        // dd($students);
        $certificat = new Certificat();

        $form = $this->createForm(CertificatType::class, $certificat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $certificat->setNom($data->getNom());
            $certificat->setPrenom($data->getPrenom());
            $certificat->setDateNaissance($data->getDateNaissance());
            $certificat->setDateCertificat($data->getDateCertificat());
            $certificat->setStudent($data->getStudent());

            $entityManager->persist($certificat);
            $entityManager->flush();

            return $this->redirectToRoute('certificat', [
                'certificats' => $certificat,
            ]);
        }

        return $this->render('admin/content/Docs/certificat/create.html.twig', [
            'controller_name' => 'CertificatController',
            'form' => $form->createView(),
        ]);
    }
}
