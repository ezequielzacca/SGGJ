<?php

namespace Gremio\SociosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\ORM\EntityRepository;

class GeneraEventoType extends AbstractType
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
            ->add('cantidad_cuotas')
            
            
            
        ;
    }
    
    

    public function getName()
    {
        return 'gremio_sociosbundle_generacompra';
    }
}