<?php

namespace Gremio\AbmBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * BajaRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class BajaRepository extends EntityRepository
{
    public function findDelSocio($socio)
    {
        return $this->getEntityManager()->createQuery('SELECT b FROM GremioAbmBundle:Baja b 
            WHERE b.fecha_cancela_baja IS NULL 
            AND b.fecha_baja IS NOT NULL
            AND b.socio = ?1')
            ->setParameter(1, $socio)
            ->getResult();
    }
}