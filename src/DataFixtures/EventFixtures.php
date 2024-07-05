<?php

namespace App\DataFixtures;

use App\Entity\Event;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EventFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $event = new Event();
        $event->setName('My test event');
        $event->setProgram('My test event program');
        $event->setStartDate(new \DateTime());
        $event->setEndDate(new \DateTime());

        $manager->persist($event);
        $manager->flush();
    }
}
