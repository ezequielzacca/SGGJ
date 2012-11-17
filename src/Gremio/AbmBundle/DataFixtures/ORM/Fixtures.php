<?php

namespace Gremio\AbmBundle\Fixtures;

use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Gremio\AbmBundle\Entity\Sexo;
use Gremio\AbmBundle\Entity\Localidad;


 

class Fixtures extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
		// create the ROLE_ADMIN role
                $localidad = new Localidad();
                $localidad->setNombre('Oran');
                $localidad->setCodigoPostal(4530);
                $manager->persist($localidad);
                
		
		$manager->flush();
                $this->addReference('localidad',$localidad);
		
		
	}

    public function getOrder()
    {
        return 1; // number in which order to load fixtures
    }
}