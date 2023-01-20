<?php
/**
 * Julien Rajerison <julienrajerison5@gmail.com>.
 */

namespace App\Controller\Documentation;

use App\Constant\MessageConstant;
use App\Controller\AbstractBaseController;
use App\Entity\Docs;
use App\Entity\User;
use App\Form\DocsType;
use App\Helper\HistoryHelper;
use App\Manager\SekolikoEntityManager;
use App\Repository\DocsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Dompdf\Dompdf;
use Dompdf\Options;

/**
 * Class SekolikoDocsController.
 *
 * @Route("/{_locale}/admin/docs")
 */
class SekolikoDocsController extends AbstractBaseController
{
    /** @var DocsRepository */
    private $docsRepository;

    /**
     * SekolikoDocsController constructor.
     *
     * @param EntityManagerInterface       $manager
     * @param SekolikoEntityManager        $entityManager
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param DocsRepository               $docsRepository
     * @param HistoryHelper|null           $historyHelper
     */
    public function __construct(EntityManagerInterface $manager, SekolikoEntityManager $entityManager, UserPasswordEncoderInterface $passwordEncoder, DocsRepository $docsRepository, HistoryHelper $historyHelper = null)
    {
        parent::__construct($manager, $entityManager, $passwordEncoder, $historyHelper);
        $this->docsRepository = $docsRepository;
    }

    /**
     * @Route("/", name="docs_accueil", methods={"GET"})
     *
     * @return Response
     */
    public function docs()
    {
        $docs = $this->docsRepository->findAll();

        return $this->render('admin/content/Docs/_index.html.twig', ['docs' => $docs]);
    }

    /**
     * @Route("/manage/{id?}",name="create_docs",methods={"POST","GET"})
     *
     * @param Request   $request
     * @param Docs|null $docs
     *
     * @return RedirectResponse|Response
     */
    public function manage(Request $request, Docs $docs = null)
    {
        $docs = $docs ?? new Docs();
        $form = $this->createForm(DocsType::class, $docs);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($this->em->save($docs, $this->getUser(), $form)) {
                $this->addFlash(MessageConstant::SUCCESS_TYPE, MessageConstant::AJOUT_MESSAGE);

                return $this->redirectToRoute('docs_accueil');
            }

            return $this->redirectToRoute('create_docs', ['id' => $docs->getId()]);
        }

        return $this->render('admin/content/Docs/_manage.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/remove/{id}",name="remove_docs",methods={"POST","GET"})
     *
     * @param Docs $docs
     *
     * @return RedirectResponse
     */
    public function removeDocs(Docs $docs)
    {
        if ($this->em->remove($docs)) {
            $this->addFlash(MessageConstant::SUCCESS_TYPE, MessageConstant::SUPPRESSION_MESSAGE);
        } else {
            $this->addFlash(MessageConstant::ERROR_TYPE, MessageConstant::ERROR_MESSAGE);
        }

        return $this->redirectToRoute('docs_accueil');
    }

    /**
     * @Route("/preview/",name="preview",methods={"POST","GET"})
     *
     * @return RedirectResponse|Response
     */

    public function preview()
    {
        //ici je récupère les données dans input
//        $data = $_POST['nomEleve'];

        //ici, je stock les données dans une variable de session
//        session_start();
//        $_SESSION['data'] = $data;

        $docs = $this->docsRepository->findAll();

        return $this->render('admin/content/Docs/previewForm.html.twig', ['docs' => $docs]);
    }


    /**
     * @Route("/test/pdf/",name="test",methods={"POST","GET"})
     *
     * @return RedirectResponse|Response
     */

    public function index(Request $request)
    {
//        dd($request);
        $get = $request->query->all();

        $type = $get['type'];
        $id = $get['id'];

        //ici je récupère les données dans input
        $data = $_POST['nomEleve'];

        //ici, je stock les données dans une variable de session
        session_start();
        $_SESSION['data'] = $data;


        // Configure Dompdf according to your needs
        $pdfOptions = new Options();

        $pdfOptions->set('defaultFont', 'Arial');
        $pdfOptions->set('isRemoteEnabled', 'true');


        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);


        $name = 'Koko';

        // Retrieve the HTML generated in our twig file
        $html = $this->render('admin/content/Docs/test.html.twig', [
            'name' => $name,
            'id' => $id,
            'data'=> $data
        ]);



        // Load HTML to Dompdf
          $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
//        $dompdf->setPaper('A4', 'portrait');


        // Render the HTML as PDF
        $dompdf->render();

        $exportName =$type . '-' . $id . '.pdf';

        // Output the generated PDF to Browser (force download)
        $dompdf->stream($exportName, [
            'Attachment' => false
        ]);

        exit(0);
//      ob_get_clean();


//        return $this->render('admin/content/Docs/test.html.twig');

//        return $this->redirectToRoute('docs_accueil');

//        ***generer un table row

//        $description = $request->request->get('description');
//        $price = $request->request->get('price');
//
//        $newRow = '<tr><td>' . $description . '</td><td>' . $price . '</td></tr>';
//
//        $tableData = $this->get('session')->get('table_data', []);
//        $tableData[] = $newRow;
//        $this->get('session')->set('table_data', $tableData);
//
//        return $this->render('admin/content/Docs/test.html.twig', [
//            'table_data' => $tableData
//        ]);


//        $response->headers->set('Content-Type', 'application/pdf');
//        $response->headers->set('Content-Disposition', 'inline; filename="'.$exportName.'"');
//        $response->setContent($dompdf->output());
//        $response = new Response();
//        return $response;
    }
}



