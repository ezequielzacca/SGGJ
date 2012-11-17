<?php

namespace Gremio\AbmBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class SocioType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('Legajo',null,array('label' => 'Numero de Legajo'))
            ->add('reparticion',null,array('label' => 'Reparticion'))
            ->add('Num_Documento',null,array('label' => 'Numero de Documento'))
            ->add('Cuit',null,array('label' => 'Numero de Cuit'))
            ->add('Apellido',null,array('label' => 'Apellido'))
            ->add('Nombres',null,array('label' => 'Nombres'))
            ->add('Domicilio_Laboral',null,array('label' => 'Domicilio Laboral'))
            ->add('Telefono_Laboral',null,array('label' => 'Telefono Laboral'))
            ->add('Numero_Mesa',null,array('label' => 'Numero de Mesa'))
            ->add('Ingreso_Justicia','date',array('widget'=>'single_text','format'=>'dd/MM/yyyy','label' => 'Fecha Ingreso Justicia'))
            ->add('Cbu',null,array('label' => 'Cbu'))
            ->add('Domicilio_Particular',null,array('label' => 'Domicilio Particular'))
            ->add('Telefono_Particular',null,array('label' => 'Telefono Particular'))
            ->add('Email',null,array('label' => 'Email'))
            ->add('Fecha_Nacimiento','date',array('widget'=>'single_text','format'=>'dd/MM/yyyy','label' => 'Fecha de Nacimiento','required'=>false))
            /*->add('localidad','entity_id', array(
                'class' => 'Gremio\AbmBundle\Entity\Localidad',
                'hidden' => false,
                'label' => 'Codigo de la Ciudad',
                'attr' => array('class' => 'identificador')
            
            ))*/
                
            ->add('localidad',null,array('label' => 'Localidad'))
            ->add('tipo_socio',null,array('label' => 'Tipo de Socio'))
            ->add('sexo','choice',array('choices'   => array('Masculino' => 'Masculino', 'Femenino' => 'Femenino'),'label' => 'Sexo'))
            ->add('seccion',null,array('label' => 'Seccion'))
            ->add('margen',null,array('label' => 'Margen'))
        ;
    }

    public function getName()
    {
        return 'gremio_abmbundle_elsociotype';
    }
}
