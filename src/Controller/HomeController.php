<?php

namespace App\Controller;

use App\Repository\BetRepository;
use App\Repository\ExcuseOfTheDayRepository;
use App\Repository\ExcuseRepository;
use App\Service\BetService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(ExcuseRepository $excuseRepository, BetRepository $betRepository, ExcuseOfTheDayRepository $excuseOfTheDayRepository, BetService $betService)
    {
        $excuseOfTheDay = $excuseOfTheDayRepository->getDescId();
        $excuses = $excuseRepository->findLastTenExcusesPosted();
        $bets = $betRepository->findLastTenBetsPosted();

        $data = [];

        if($betService->checkUserCanBet($this->getUser())){
            return $this->redirectToRoute('bet_new');
        }
        
        for($i = 0 ; $i < 20 ; $i ++){
            if(!empty($excuses[$i])){
                $data [] = $excuses[$i];
            }
            if(!empty($bets[$i])){
                $data [] = $bets[$i];
            }
        }
        
        return $this->render('home/index.html.twig', [
            'data' => $data,
            'ofTheDay' => $excuseOfTheDay ? $excuseOfTheDay[0] : null
        ]);
    }
}
