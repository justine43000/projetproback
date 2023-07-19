<?php

namespace App\DataFixtures;

use App\Entity\Activity;
use App\Entity\Calendar;
use App\Entity\Child;
use App\Entity\Event;
use App\Entity\Thematique;
use App\Entity\User;
use DateTime;
use DateTimeInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $userPasswordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }
    public function load(ObjectManager $manager): void
    {
        // Création d'une vingtaine de livres ayant pour titre
        {
            $user = new User();
            $user->setEmail('juju43@gmail.com');
            $user->setRoles(['ROLE_ADMIN']);
            $user->setPassword($this->userPasswordHasher->hashPassword($user, "password"));
            $user->setName('Prevot');
            $manager->persist($user);

            $child = new Child();
            $child->setName('Prisca');
            $child->setBirthdate(new DateTime('02/09/2015'));
            $child->setIdUser($user);
            $manager->persist($child);

            $calendar = new Calendar();
            $calendar->setNiveau('CE1');
            $calendar->setIdChild($child);
            $manager->persist($calendar);



            $activity = new Activity();
            $activity->setName('Français');
            $activity->setExtra(false);
            $manager->persist($activity);

            $thematique = new Thematique();
            $thematique->setName('Les années Lumières');
            $thematique->setDuration(new DateTime('20:00:00'));
            $thematique->setIdActivity($activity);
            $manager->persist($thematique);

            $event = new Event();
            $event->setName('Les années lumières 1/3');
            $event->setEventStart(new DateTime('2023-04-04 08:30:00'));
            $event->setEventEnd(new DateTime('2023-04-04 10:00:00'));
            $event->setIdCalendar($calendar);
            $event->addIdThematique($thematique);
            $manager->persist($event);
        }

        $manager->flush();
    }
}
