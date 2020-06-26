<?php

namespace App\Controller;

use App\Entity\ExcuseOfTheDay;
use App\Form\ExcuseOfTheDayType;
use App\Repository\BetRepository;
use App\Repository\ExcuseOfTheDayRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/excuse-of-the-day")
 */
class ExcuseOfTheDayController extends AbstractController
{
    /**
     * @Route("/", name="excuse_of_the_day_index", methods={"GET"})
     */
    public function index(ExcuseOfTheDayRepository $excuseOfTheDayRepository): Response
    {
        return $this->render('excuse_of_the_day/index.html.twig', [
            'excuse_of_the_days' => $excuseOfTheDayRepository->findAll(),
        ]);
    }

    /**
     * @Route("/timer", name="excuse_of_the_day_timer")
     */
    public function timeFromNextExcuseOfTheDay(ExcuseOfTheDayRepository $excuseOfTheDayRepository)
    {
        $excuseOfTheDay = $excuseOfTheDayRepository->getDescId();
        return $this->json(['date' => $excuseOfTheDay[0]->getFinishAt()], 200 );
    }

    /**
     * @Route("/new", name="excuse_of_the_day_new", methods={"GET","POST"})
     */
    public function new(Request $request, BetRepository $betRepository): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $excuseOfTheDay = new ExcuseOfTheDay();
        $form = $this->createForm(ExcuseOfTheDayType::class, $excuseOfTheDay);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $excuseOfTheDay->setCreatedAt(new DateTime('now'));
            $excuseOfTheDay->setFinishAt(new DateTime('now + 1 day 09:00:00'));

            $bets = $betRepository->findBy(['excuse' => $excuseOfTheDay->getExcuse()]);
            foreach($bets as $bet){
                $bet->setIsArchived(true);
                $excuseOfTheDay->addBet($bet);
                $excuseOfTheDay->setIsActive(true);
                $entityManager->persist($bet);
            }

            $entityManager->persist($excuseOfTheDay);
            $entityManager->flush();

            return $this->redirectToRoute('excuse_of_the_day_index');
        }

        return $this->render('excuse_of_the_day/new.html.twig', [
            'excuse_of_the_day' => $excuseOfTheDay,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="excuse_of_the_day_show", methods={"GET"})
     */
    public function show(ExcuseOfTheDay $excuseOfTheDay): Response
    {
        return $this->render('excuse_of_the_day/show.html.twig', [
            'excuse_of_the_day' => $excuseOfTheDay,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="excuse_of_the_day_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ExcuseOfTheDay $excuseOfTheDay): Response
    {
        $form = $this->createForm(ExcuseOfTheDayType::class, $excuseOfTheDay);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('excuse_of_the_day_index');
        }

        return $this->render('excuse_of_the_day/edit.html.twig', [
            'excuse_of_the_day' => $excuseOfTheDay,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="excuse_of_the_day_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ExcuseOfTheDay $excuseOfTheDay): Response
    {
        if ($this->isCsrfTokenValid('delete'.$excuseOfTheDay->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($excuseOfTheDay);
            $entityManager->flush();
        }

        return $this->redirectToRoute('excuse_of_the_day_index');
    }
}
