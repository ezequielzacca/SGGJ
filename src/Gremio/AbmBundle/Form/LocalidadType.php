<?php

namespace Gremio\AbmBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class LocalidadType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('Nombre',null,array('label' => 'Nombre'))
            ->add('Codigo_Postal',null,array('label' => 'Codigo Postal'))
        ;
    }

    public function getName()
    {
        return 'gremio_abmbundle_localidadtype';
    }
}
