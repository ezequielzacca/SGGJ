<?php

namespace Gremio\SociosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\ORM\EntityRepository;

class GeneraCompraType extends AbstractType
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
            
            
            
        ;
    }
    
    

    public function getName()
    {
        return 'gremio_sociosbundle_generacompra';
    }
}