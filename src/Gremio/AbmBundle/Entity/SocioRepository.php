<?php

namespace Gremio\AbmBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

/**
 * SocioRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SocioRepository extends EntityRepository
{

    public function calcularMargen($socio)
    {
        return $this->getEntityManager()
                ->createQuery("SELECT  s.margen - SUM(c.importe_cuota) as margen FROM GremioSociosBundle:CuotaEmision c 
                    JOIN c.emision e JOIN e.socio s WHERE s.id=?1 AND c.procesada = ?2 
                    AND c.fecha_vencimiento <= ?3 GROUP BY s.id")
                ->setParameter(1,$socio)
                ->setParameter(2, false)
                ->setParameter(3, new \DateTime())
                ->getScalarResult();
    }
    
}