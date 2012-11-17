<?php

namespace Gremio\AbmBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class UsuarioPasswordType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('password', 'repeated', array(
                  'type' => 'password',
                  'invalid_message' => 'Las dos contraseñas deben coincidir',
                'first_name' => 'Nueva Contraseña',
                                     'second_name' => 'Repetir Nueva Contraseña'
                  
                  ))
    ;
    }

    public function getName()
    {
        return 'gremio_abmbundle_sociopasswordtype';
    }
}

