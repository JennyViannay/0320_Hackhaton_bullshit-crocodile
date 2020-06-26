<?php

namespace App\Service;

use App\Entity\Bet;
use App\Entity\User;
use App\Repository\BetRepository;
use App\Repository\ExcuseOfTheDayRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

class BetService 
{
    private $em;
    private $excuseOfTheDayRepository;
    private $betRepository;

    public function __construct(EntityManagerInterface $em, ExcuseOfTheDayRepository $excuseOfTheDayRepository, BetRepository $betRepository)
    {
        $this->em = $em;
        $this->excuseOfTheDayRepository = $excuseOfTheDayRepository;
        $this->betRepository = $betRepository;
    }

    public function checkUserCanBet(User $user)
    {
        $lastUserBet = $user->getLastBet();
        $interval = new DateTime('now');
        if($lastUserBet->getFinishAt() < $interval ){
            $user->setCanBet(false);
        } else {
            $user->setCanBet(true);
        }
        $this->em->persist($user);
        $this->em->flush();
    }

    public function archiveBet($bets)
    {
        foreach($bets as $bet){
            if($bet->getFinishAt() < new DateTime('now')){
                $bet->setIsArchived(true);
            }
            $this->em->persist($bet);
        }
        $this->em->flush();
    }

    public function getBetOfTheDay()
    {
        return $this->excuseOfTheDayRepository->findOneBy(['is_active' => true]);
    }
}