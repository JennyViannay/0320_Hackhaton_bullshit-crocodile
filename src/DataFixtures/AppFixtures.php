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

        $excuses = ['Un crocodile est sorti de mes chiottes','J\'avais des galères administratives','J\'ai du faire une mise à jour sur mon ordi'];
      
        foreach ($excuses as $item) {
            $excuse = new Excuse();
            $excuse->setText($item);
            $excuse->setCreatedAt(new DateTime('now'));
            $manager->persist($excuse);
        }

        $users = ['lisa','johnny','sten','jules','aurelien'];
        foreach ($users as $item) {
            $user = new User();
            $user
            ->setUsername($item)
            ->setPassword($this->encoder->encodePassword($user, 'password'))
            ->setAvatar('https://legeekcestchic.eu/wp-content/uploads/2014/12/epic-galerie-la-drole-de-mode-des-annees-80-21.jpg')
            ->setEmail($faker->email)
            ->setRoles(["ROLE_USER"])
            ->setIsVerified(true)
            ->setBirthDate(new DateTime('now - 20 years'))
            ->setComment($faker->paragraph())
            ->setCanBet(true);
            $manager->persist($user);
        }

        $jenny = new User();
            $jenny
            ->setUsername('jenny')
            ->setPassword($this->encoder->encodePassword($jenny, 'password'))
            ->setAvatar('https://legeekcestchic.eu/wp-content/uploads/2014/12/epic-galerie-la-drole-de-mode-des-annees-80-21.jpg')
            ->setEmail($faker->email)
            ->setRoles(["ROLE_ADMIN"])
            ->setIsVerified(true)
            ->setBirthDate(new DateTime('now - 20 years'))
            ->setComment($faker->paragraph())
            ->setCanBet(true);
            $manager->persist($jenny);

        $manager->flush();
    }
}
