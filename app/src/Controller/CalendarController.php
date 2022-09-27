<?php

namespace App\Controller;

use App\Entity\Calendar;
use App\Form\CalendarType;
use App\Repository\CalendarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 *
 * @route("/calendar")
 */

#[Route('/calendar')]
class CalendarController extends AbstractController
{
    /**
     *
     * @route("/", name="app_calendar_index", methods={"GET"})
     */

//    #[Route('/', name: 'app_calendar_index', methods: ['GET'])]
    public function index(CalendarRepository $calendarRepository): Response
    {
        return $this->render('calendar/index.html.twig', [
            'calendars' => $calendarRepository->findAll(),
        ]);
    }


    
    /**
     * @route("/ShowCalendar", name="app_calendar_calendrier", methods={"GET"})
     *
     **/

//    #[Route('/ShowCalendar', name: 'app_calendar_calendrier', methods: ['GET'])]

    public function ShowCalendar(CalendarRepository $calendarRepository): Response
    {
        $koko = $calendarRepository->findAll();

        $array = [];

        foreach($koko as $kokos){
            $array[] = [
                'id' => $kokos->getId(),
                'start' => $kokos->getStart()->format('Y-m-d H:i:s'),
                'end' => $kokos->getEnd()->format('Y-m-d H:i:s'),
                'title' => $kokos->getTitle(),
                'description' => $kokos->getDescription(),
                'backgroundColor' => $kokos->getBackgroundColor(),
                'borderColor' => $kokos->getBorderColor(),
                'textColor' => $kokos->getTextColor(),
                'allDay' => $kokos->isAllDay(),
                'evenement' => $kokos->isEvenement(),
            ];
        }
        $data = json_encode($array);
        return $this->render('calendar/calendar_admin.html.twig', compact('data'));
    }

    /**
     * @route("/new", name="app_calendar_new", methods={"POST","GET"})
     */

//    #[Route('/new', name: 'app_calendar_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CalendarRepository $calendarRepository): Response
    {
        $calendar = new Calendar();
        $form = $this->createForm(CalendarType::class, $calendar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $calendarRepository->add($calendar, true);

            return $this->redirectToRoute('app_calendar_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('calendar/new.html.twig', [
            'calendar' => $calendar,
            'form' => $form,
        ]);
    }

    /**
     * @route("/{id}", name="app_calendar_show", methods={"GET"})
     */

//    #[Route('/{id}', name: 'app_calendar_show', methods: ['GET'])]
    public function show(Calendar $calendar): Response
    {
        return $this->render('calendar/show.html.twig', [
            'calendar' => $calendar,
        ]);
    }

    /**
     * @route("/{id}/edit", name="app_calendar_edit", methods={"POST","GET"})
     */

//    #[Route('/{id}/edit', name: 'app_calendar_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Calendar $calendar, CalendarRepository $calendarRepository): Response
    {
        $form = $this->createForm(CalendarType::class, $calendar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $calendarRepository->add($calendar, true);

            return $this->redirectToRoute('app_calendar_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('calendar/edit.html.twig', [
            'calendar' => $calendar,
            'form' => $form,
        ]);
    }

    /**
     *
     * @route("/{id}", name="app_calendar_delete", methods={"POST"})
     */

//    #[Route('/{id}', name: 'app_calendar_delete', methods: ['POST'])]
    public function delete(Request $request, Calendar $calendar, CalendarRepository $calendarRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$calendar->getId(), $request->request->get('_token'))) {
            $calendarRepository->remove($calendar, true);
        }

        return $this->redirectToRoute('app_calendar_index', [], Response::HTTP_SEE_OTHER);
    }
}
