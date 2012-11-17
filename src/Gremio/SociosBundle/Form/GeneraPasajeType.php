<?php

namespace Gremio\SociosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\ORM\EntityRepository;

class GeneraPasajeType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            
            ->add('proveedor','entity_id',array(
                'class' => 'GremioProveedoresBundle:Proveedor',
            ))
            ->add("proveedor_desc",
                "text",
                array(
                    "property_path" => false,
                    'label'=>'Proveedor'
                )
            )
            ->add('importe')

            
            ->add('tipo_viaje','choice',array(
                'choices' => array('Viaje Comun' => 'Viaje Comun', 'Viaje Especial' => 'Viaje Especial'),
                'label' => 'Tipo de Viaje')
            )
            ->add('cantidad_pasajeros','text',array(
                  'label' => 'Cantidad de Pasajeros')
            )
            ->add('origen','text',array(
                  'label' => 'Origen')
            )
            ->add('destino','text',array(
                  'label' => 'Destino')
            )
            
            
        ;
    }

    public function getName()
    {
        return 'gremio_sociosbundle_generapasaje';
    }
}