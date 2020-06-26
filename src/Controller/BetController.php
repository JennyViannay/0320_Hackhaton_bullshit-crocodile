<?php

namespace App\Controller;

use App\Entity\Bet;
use App\Entity\Excuse;
use App\Form\BetType;
use App\Form\ExcuseType;
use App\Repository\BetRepository;
use App\Repository\ExcuseOfTheDayRepository;
use App\Service\BetService;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/bet")
 */
class BetController extends AbstractController
{
    /**
     * @Route("/", name="bet_history", methods={"GET"})
     */
    public function index(BetRepository $betRepository, ExcuseOfTheDayRepository $excuseOfTheDayRepository): Response
    {
        $isWinner = false;
        $excuseOfTheDay = $excuseOfTheDayRepository->getDescId();
        $winnerBets = $excuseOfTheDay[0]->getBets();
        foreach($winnerBets as $bet){
            if($bet->getUser() == $this->getUser()) { $isWinner = true; }
        }
       
        return $this->render('bet/index.html.twig', [
            'bets' => $betRepository->findBy(['user' => $this->getUser()]),
            'isWinner' => $isWinner,
            'ofTheDay' => $excuseOfTheDay[0]
        ]);
    }

    /**
     * @Route("/statistic", name="bet_statistic", methods={"GET"})
     */
    public function statistic(BetRepository $betRepository, ExcuseOfTheDayRepository $excuseOfTheDayRepository): Response
    {
        $excuseOfTheDay = $excuseOfTheDayRepository->getDescId();
        
        return $this->render('bet/statistic.html.twig', [
            'bets' => array_reverse($betRepository->findAll()),
            'last10bets' => $betRepository->findLastTenBetsPosted(),
            'ofTheDay' => $excuseOfTheDay[0]
        ]);
    }

    /**
     * @Route("/new", name="bet_new", methods={"GET","POST"})
     */
    public function new(Request $request, BetService $betService): Response
    {
        if ($this->getUser()->getCanBet() === false) {
            return $this->redirectToRoute('home');
        } else {
            $bet = new Bet();
            $form = $this->createForm(BetType::class, $bet);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $this->getUser()->setLastBet($bet);
                $this->getUser()->setCanBet(false);
                $bet->setUser($this->getUser());

                $now = new DateTime('now');
                $interval = new DateTime('now 08:59:00');
                $bet->setCreatedAt($now);

                if($now > $interval){
                    $bet->setFinishAt(new DateTime('now + 1 day 08:59:00'));
                } else {
                    $bet->setFinishAt(new DateTime('now 08:59:00'));
                }
                $bet->setIsArchived(false);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($bet);
                $entityManager->persist($this->getUser());
                $entityManager->flush();
                return $this->redirectToRoute('bet_history');
            }

            return $this->render('bet/new.html.twig', [
                'bet' => $bet,
                'form' => $form->createView(),
                'formExcuse' => $form->createView(),
            ]);
        }
    }

    /**
     * @Route("/{id}", name="bet_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Bet $bet): Response
    {
        if ($this->isCsrfTokenValid('delete' . $bet->getId(), $request->request->get('_token'))) {
            $userBets = $this->getUser()->getBets();
            $this->getUser()->setLastBet($userBets[count($userBets) - 2]);
            $this->getUser()->setCanBet(true);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($this->getUser());
            $entityManager->remove($bet);
            $entityManager->flush();
        }

        return $this->redirectToRoute('bet_history');
    }
}
