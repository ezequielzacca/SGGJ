<?php

namespace Gremio\AbmBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class RetencionesType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('secciones','entity',
            		array(
            			'class' => 'GremioAbmBundle:Seccion',
            			'empty_value' => 'Ninguna',
            			'required'=>false,
            			'label'=>'Seccion'
            		)
            	)
            	->add('reparticiones','entity',
            			array(
            					'class' => 'GremioAbmBundle:Reparticion',
            					'label'=>'Reparticion'
            			)
            	)
            	->add('ordenamiento','choice',array(
                'choices' => array('s.Legajo' => 'Legajo', 's.Num_Documento' => 'Numero de Documento','s.Apellido'=>'Alfabetico'),
                'label' => 'Ordenar por')
            )
            
        ;
    }

    public function getName()
    {
        return 'gremio_abmbundle_retencionestype';
    }
}
