<?php

namespace Gremio\AbmBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ReparticionType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('Descripcion',null,array('label' => 'Descripcion'))
        ;
    }

    public function getName()
    {
        return 'gremio_abmbundle_reparticiontype';
    }
}
