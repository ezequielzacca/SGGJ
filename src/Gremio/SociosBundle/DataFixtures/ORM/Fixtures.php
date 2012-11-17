<?php

namespace Gremio\SociosBundle\Fixtures;

use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Gremio\SociosBundle\Entity\TipoEmision;

 

class Fixtures extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
		// create the ROLE_ADMIN role
                $tipo = new TipoEmision();
                $tipo->setDescripcion('Vale de Compras');
                
                $manager->persist($tipo);
                $manager->flush();
                }

    public function getOrder()
    {
        return 5; // number in which order to load fixtures
    }
}