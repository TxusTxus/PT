<?php

namespace IncidenciasBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IncidenciaEditType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('fecha', DateType::class, array(
                        'label' => 'Fecha',
                        'disabled' => true,
                        'attr' => array("onchange" => "javascript:marcaCambio();"),
                        'widget' => 'single_text'))
                ->add('descripcion', TextareaType::class, array('label' => 'Descripción', 'attr' => array('rows' => '1', 'cols' => '10',"onchange" => "javascript:marcaCambio();")))
                ->add('importe', MoneyType::class,array('label' => 'Importe',
                        'scale' => 2,
                        'grouping' => true,
                        'required'  => false,
                        'attr'  => array(
                            'data-thousands' =>'.',
                            'data-decimal' =>',',
                            "onchange" => "javascript:marcaCambio();")
                    ))
                ->add('observaciones', TextareaType::class, array(
                    'label' => 'Observaciones', 
                    'attr' => array('rows' => '5', 'cols' => '10',"onchange" => "javascript:marcaCambio();"), 
                    'required'=>false));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'IncidenciasBundle\Entity\Incidencia'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'incidenciasbundle_incidencia';
    }


}
