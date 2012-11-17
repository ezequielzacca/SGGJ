<?php

namespace Gremio\ProveedoresBundle\Fixtures;

use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Gremio\ProveedoresBundle\Entity\Proveedor;
use Gremio\ProveedoresBundle\Entity\Cajero;


 

class Fixtures extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
		// create the ROLE_ADMIN role
                $proveedor = new Proveedor();
                $proveedor->setCbu('123456');
                $proveedor->setComision(50);
                $proveedor->setCuit('23352612839');
                $proveedor->setCuotasComercio(12);
                $proveedor->setDomicilio('Lerma 587');
                $proveedor->setEmail('ezequielzacca@gmail.com');
                $proveedor->setGasto(50);
                $proveedor->setRazonSocial('Tienda De Pruebita');
                $proveedor->setTelefono('4222264');
                $manager->persist($proveedor);
                $manager->flush();
                $cajero = new Cajero();
                $cajero->setApellido('Encinas');
                $cajero->setCreatedAt(new \DateTime());
                $cajero->setNombres('Rodolfo');
                $cajero->setEmail('ezequielzacca@gmail.com');
                $cajero->setProveedor($proveedor);
                $manager->persist($cajero);
                $manager->flush();
                }

    public function getOrder()
    {
        return 4; // number in which order to load fixtures
    }
}