<?php

namespace App\DataFixtures;

use App\Entity\Project;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 10; $i++) {
            $project = new Project();
            $project->setProjectName('Project ' . $i);
            $project->setDateOfStart(new \DateTime('now'));
            $project->setTeamSize(rand(5, 20));

            $manager->persist($project);
        }

        $manager->flush();
    }
}
