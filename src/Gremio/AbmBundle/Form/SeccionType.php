<?php

namespace Gremio\AbmBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class SeccionType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('Descripcion',null,array('label' => 'Descripcion'))
            ->add('Domicilio',null,array('label' => 'Domicilio'))
            ->add('Telefono',null,array('label' => 'Telefono'))
            ->add('localidad',null,array('label' => 'Localidad'))
        ;
    }

    public function getName()
    {
        return 'gremio_abmbundle_secciontype';
    }
}
