<?php

namespace Gremio\AbmBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\ORM\EntityRepository;

class RetencionesComercioType extends AbstractType {
	public function buildForm(FormBuilder $builder, array $options) {
		$builder
				->add('proveedor', 'entity_id',
						array('class' => 'GremioProveedoresBundle:Proveedor',))
				->add("proveedor_desc", "text",
						array("property_path" => false, 'label' => 'Proveedor','required'=>false))
				->add('rubro', 'entity',
						array('class' => 'GremioProveedoresBundle:Rubro',
								'label' => 'Rubro',
								'query_builder' => function (
										EntityRepository $er) {
									return $er->createQueryBuilder('r')
											->where('r.fecha_baja IS NULL');
								},))

		;
	}

	public function getName() {
		return 'gremio_abmbundle_retencionescomercio_type';
	}
}
