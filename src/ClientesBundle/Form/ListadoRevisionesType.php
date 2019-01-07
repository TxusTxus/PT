<?php

namespace ClientesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class ListadoRevisionesType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $mes = array("Enero"=>'1',"Febrero"=>'2',"Marzo"=>'3',"Abril"=>'4',"Mayo"=>'5',"Junio"=>'6',"Julio"=>'7',
            "Agosto"=>'8',"Septiembre"=>'9',"Octubre"=>'10',"Noviembre"=>'11',"Diciembre"=>'12');     
        
        $builder->add('fechaDesde', DateType::class, array('label' => 'Fecha desde','required'  => false,'mapped' => false,'widget' => 'single_text'))
                ->add('fechaHasta', DateType::class, array('label' => 'Fecha hasta','required'  => false,'mapped' => false,'widget' => 'single_text'))
                ->add('mes', ChoiceType::class,  array(
                'choices'  => $mes,
                'label' => 'Mes',
                'required'  => false,
                'mapped' => false,
                'attr' => array("onchange" => "javascript:actualizaFechas();")));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ClientesBundle\Entity\Cliente'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'clientesbundle_cliente';
    }


}
