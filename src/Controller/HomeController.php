<?php

namespace App\Controller;

use App\Repository\BetRepository;
use App\Repository\ExcuseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(ExcuseRepository $excuseRepository, BetRepository $betRepository)
    {
        $excuses = $excuseRepository->findLastTenExcusesPosted();
        $bets = $betRepository->findLastTenBetsPosted();

        $data = [];
        
        for($i = 0 ; $i < 20 ; $i ++){
            if(!empty($excuses[$i])){
                $data [] = $excuses[$i];
            }
            if(!empty($bets[$i])){
                $data [] = $bets[$i];
            }
        }
        
        return $this->render('home/index.html.twig', [
            'data' => $data
        ]);
    }
}
