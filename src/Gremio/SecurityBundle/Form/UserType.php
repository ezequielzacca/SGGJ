<?php

namespace Gremio\SecurityBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class UserType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('firstName')
            ->add('lastName')
            ->add('email')
            ->add('username')
            ->add('password')
            ->add('salt')
            ->add('createdAt')
            ->add('userRoles')
        ;
    }

    public function getName()
    {
        return 'gremio_securitybundle_usertype';
    }
}
