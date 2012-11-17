<?php

namespace Gremio\AbmBundle\Fixtures;

use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Gremio\AbmBundle\Entity\Socio;
use Gremio\AbmBundle\Entity\TipoSocio;
use Gremio\AbmBundle\Entity\UsuarioGremio;


 

class Fixtures2 extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
		
        $tipo_socio = new TipoSocio();
        $tipo_socio->setDescripcion('Activo');
        $manager->persist($tipo_socio);
        
        $usuariogremio = new UsuarioGremio();
        $usuariogremio->setApellido('Manzur');
        $usuariogremio->setNombres('Gustavo');
        $usuariogremio->setDomicilio('Lerma 587');
        $usuariogremio->setEmail('gustavo.manzur@netsecom.com.ar');
        $usuariogremio->setFechaNacimiento(new \DateTime('today'));
        $usuariogremio->setNumDocumento('35123456');
        $usuariogremio->setSexo('Masculino');
        $manager->persist($usuariogremio);
        
        
        $socio = new Socio();
		$socio->setLegajo(1234576);
		$socio->setNumDocumento('35105176');
		$socio->setCuit('233352612839');
		$socio->setNombres('Ezequiel');
		$socio->setApellido('Zacca');
		$socio->setDomicilioLaboral('Lacroze 1147');
		$socio->setTelefonoLaboral('4242424');
		$socio->setSexo('Masculino');
		$socio->setNumeroMesa(26);
		$socio->setIngresoJusticia(new \DateTime());
		$socio->setCbu('123456789');
		$socio->setDomicilioParticular('Lacroze 1147');
		$socio->setTelefonoParticular('45612345');
		$socio->setEmail('ezequiel.zacca@netsecom.com.ar');
		$socio->setFechaNacimiento(new \DateTime());
		$socio->setLocalidad($manager->merge($this->getReference('localidad')));
                $socio->setMargen(1500);
		$manager->persist($socio);
                
                $socio2 = new Socio();
                $socio2->setLegajo(1234577);
		$socio2->setNumDocumento('35261283');
		$socio2->setCuit('233352612839');
		$socio2->setNombres('Noelia');
		$socio2->setApellido('Encinas');
		$socio2->setDomicilioLaboral('Lacroze 1147');
		$socio2->setTelefonoLaboral('4242424');
		$socio2->setSexo('Femenino');
		$socio2->setNumeroMesa(26);
		$socio2->setIngresoJusticia(new \DateTime());
		$socio2->setCbu('123456789');
		$socio2->setDomicilioParticular('Lacroze 1147');
		$socio2->setTelefonoParticular('45612345');
		$socio2->setEmail('noe_505@hotmail.com');
		$socio2->setFechaNacimiento(new \DateTime());
		$socio2->setLocalidad($manager->merge($this->getReference('localidad')));
                $socio2->setMargen(2400);
		$manager->persist($socio2);
                
		
		$manager->flush();
		
		
	}

    public function getOrder()
    {
        return 2; // number in which order to load fixtures
    }
}