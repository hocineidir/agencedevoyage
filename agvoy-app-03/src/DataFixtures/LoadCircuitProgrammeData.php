<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\ProgrammationCircuit;

class LoadCircuitProgrammeData extends Fixture implements DependentFixtureInterface
{
	public function load(ObjectManager $manager)
	{
		$circuit=$this->getReference('andalousie-circuit');
		
		$circuitp = new ProgrammationCircuit();
		$date = new \DateTime('2000-02-03');
		$circuitp->setDateDepart($date);
		$circuitp->setNombrePersonnes(34);
		$circuitp->setPrix(500);
		$circuit->addProgrammationCircuit($circuitp);
		$manager->persist($circuitp);
		$manager->persist($circuit);
		
		$circuit=$this->getReference('idf-circuit');
		
		$circuitp= new ProgrammationCircuit();
		$date = new \DateTime('2018-04-05');
		$circuitp->setDateDepart($date);
		$circuitp->setNombrePersonnes(56);
		$circuitp->setPrix(700);
		$circuit->addProgrammationCircuit($circuitp);
		$manager->persist($circuitp);
		$manager->persist($circuit);
		
		$manager->flush();
	}

	public function getDependencies()
	{
	    return array(
	        LoadCircuitData::class,
	    );
	}
}