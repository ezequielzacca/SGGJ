<?php

namespace Gremio\ProveedoresBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\ORM\EntityRepository;

class ProveedorType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('razon_social',null,array('label' => 'Razon Social'))
            ->add('cuit',null,array('label' => 'Cuit'))
            ->add('telefono',null,array('label' => 'Telefono'))
            ->add('domicilio',null,array('label' => 'Domicilio'))
            ->add('email',null,array('label' => 'Email'))
            ->add('cbu',null,array('label' => 'Cbu'))
            ->add('comision',null,array('label' => 'Comision'))
            ->add('gasto',null,array('label' => 'Gasto'))
            ->add('genera_pago',null,array('label' => 'Genera Pago'))
            ->add('informe_banco',null,array('label' => 'Informe por Banco'))
            ->add('rubro','entity',array(
                'class' => 'GremioProveedoresBundle:Rubro',
                'query_builder' => function(EntityRepository $er){
                return $er->getVigentes();
                },
            ))
        ;
    }

    public function getName()
    {
        return 'gremio_proveedoresbundle_proveedortype';
    }
}
