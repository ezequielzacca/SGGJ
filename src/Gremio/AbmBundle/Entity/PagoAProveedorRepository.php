<?php

namespace Gremio\AbmBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * PagoAProveedorRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PagoAProveedorRepository extends EntityRepository {
	public function findPendientes($proveedor = null) {
		$em = $this->getEntityManager();
		$qb = $em->createQueryBuilder();

		$qb->select('p')->from('GremioAbmBundle:PagoAProveedor', 'p')
				->where('p.importe>0')->andWhere('p.pagado = :falso');
		if ($proveedor) {
			$qb->andWhere('p.proveedor = :proveedor')
					->setParameter('proveedor', $proveedor);
		}

		$qb->groupBy('p')->setParameter('falso', false);

		$query = $qb->getQuery();
		try {
			return $query->getResult();
		} catch (\Doctrine\ORM\NoResultException $e) {

			return array();
		}
	}

	public function findImporteAPagar($proveedor) {
		$em = $this->getEntityManager();
		$qb = $em->createQueryBuilder();

		$qb->select('sum(p.importe)')
				->from('GremioAbmBundle:PagoAProveedor', 'p')
				->where('p.importe>0')->andWhere('p.pagado = :falso')
				->andWhere('p.proveedor=:proveedor')->groupBy('p')
				->setParameter('falso', false)
				->setParameter('proveedor', $proveedor);

		$query = $qb->getQuery();
		try {
			return $query->getSingleScalarResult();
		} catch (\Doctrine\ORM\NoResultException $e) {

			return 0;
		}
	}
}
