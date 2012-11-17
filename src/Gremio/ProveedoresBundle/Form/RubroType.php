<?php

namespace Gremio\ProveedoresBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class RubroType extends AbstractType {

    public function buildForm(FormBuilder $builder, array $options) {
        $builder
                ->add('descripcion', null, array('label' => 'Descripcion'))
        ;
    }

    public function getName() {
        return 'gremio_proveedoresbundle_rubrotype';
    }

}
