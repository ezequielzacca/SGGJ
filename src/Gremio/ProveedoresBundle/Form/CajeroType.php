<?php

namespace Gremio\ProveedoresBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class CajeroType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('apellido',null,array('label' => 'Apellido'))
            ->add('nombres',null,array('label' => 'Nombres'))
            ->add('numero_documento',null,array('label' => 'Numero de Documento'))
            ->add('email',null,array('label' => 'Email'))
           // ->add('created_at')
           // ->add('username')
           // ->add('password')
           // ->add('salt')
            ->add('proveedor',null,array('label' => 'Proveedor'))
        ;
    }

    public function getName()
    {
        return 'gremio_proveedoresbundle_cajerotype';
    }
}
