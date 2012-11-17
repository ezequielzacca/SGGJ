<?php

namespace Gremio\SociosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\ORM\EntityRepository;

class GeneraCombustibleType extends AbstractType
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
            
            ->add('tipo_combustible','choice',array(
                'choices' => array('Nafta Super' => 'Nafta Super', 'Nafta Premium' => 'Nafta Premium'),
                'label' => 'Tipo de Combustible')
            )
           
            
            
        ;
                
                if($options['mostrar_socio']===true){
                    $builder->add('socio');
                }
    }
    
    public function getDefaultOptions(array $options)
    {
        return array(
            'mostrar_socio' => false,
        );
    }

    public function getName()
    {
        return 'gremio_sociosbundle_generaordencompratype';
    }
}