<?php

namespace Gremio\ProveedoresBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\ORM\EntityRepository;

class EventoType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('razon_social',null,array('label' => 'Nombre del Evento'))
            ->add('cuit',null,array('label' => 'Cuit'))
            ->add('telefono',null,array('label' => 'Telefono'))
            ->add('domicilio',null,array('label' => 'Domicilio'))
            ->add('email',null,array('label' => 'Email'))
            ->add('fecha_vencimiento','date',array('widget'=>'single_text','format'=>'dd/MM/yyyy','label' => 'Fecha de Expiracion'))
            
        ;
    }

    public function getName()
    {
        return 'gremio_proveedoresbundle_proveedortype';
    }
}
