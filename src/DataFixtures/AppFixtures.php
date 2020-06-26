<?php

namespace App\DataFixtures;

use App\Entity\Bet;
use App\Entity\Excuse;
use App\Entity\User;
use App\Repository\ExcuseRepository;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        $excuses = [];

        for ($i = 0; $i < 10; $i++) {
            $excuse = new Excuse();
            $excuse->setText($faker->paragraph())->setCreatedAt(new DateTime('now'));
            $manager->persist($excuse);
            $excuses[] = $excuse;
        }

        for ($i = 0; $i < 5; $i++) {
            $user = new User();
            $user
            ->setUsername($faker->userName)
            ->setPassword($this->encoder->encodePassword($user, 'password'))
            ->setAvatar('https://legeekcestchic.eu/wp-content/uploads/2014/12/epic-galerie-la-drole-de-mode-des-annees-80-21.jpg')
            ->setEmail($faker->email)
            ->setRoles(["ROLE_USER"])
            ->setIsVerified(true)
            ->setBirthDate(new DateTime('now - 20 years'))
            ->setComment($faker->paragraph())
            ->setCanBet(true);

            $bet = new Bet();
            $bet->setCreatedAt(new DateTime('now'));
            $bet->setFinishAt(new DateTime('now + 1 day 00:01:00'));
            $bet->setUser($user);
            $bet->setExcuse($faker->randomElement($excuses));
            $bet->setIsArchived(false);
            $user->setLastBet($bet);

            $manager->persist($bet);
            $manager->persist($user);
        }

        

        $manager->flush();
    }
}
