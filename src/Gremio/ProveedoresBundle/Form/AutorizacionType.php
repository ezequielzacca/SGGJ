<?php

namespace Gremio\ProveedoresBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class AutorizacionType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('id','text',array('label' => 'Codigo de Barras'))
            
                ;
    }
    
    public function getName()
    {
        return 'proveedor_autorizacion';
    }
}
