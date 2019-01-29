<?php

namespace PartesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\PercentType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class PartesEditType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('trabajador', EntityType::class, array(
                    'class' => 'TrabajadoresBundle:Trabajadores',
                    'required'  => true,
                    'label' => 'Técnico',
                    'attr' => array("onchange" => "javascript:marcaCambio();")))
                ->add('fechaParte', DateType::class, array(
                        'label' => 'Fecha visita',
                        'attr' => array("onchange" => "javascript:marcaCambio();"),
                        'required'  => true,
                        'widget' => 'single_text'))
                ->add('fechaEntrada', TimeType::class, array(
                        'label' => 'Hora entrada',
                        'attr' => array("onchange" => "javascript:marcaCambio();"),
                        'required'  => true,
                        'widget' => 'single_text'))
//                ->add('tiempo')
                ->add('material',CheckboxType::class, array(
                        'label' => 'Indicar sí se requiere material',
                        'required'  => false,
                        'attr' => array("onchange" => "javascript:marcaCambio();"),
                    ))
                ->add('cobrar',CheckboxType::class, array(
                        'label' => 'Indicar sí se cobra directamente al cliente',
                        'required'  => false,
                        'attr' => array("onchange" => "javascript:marcaCambio();"),
                    ))
                ->add('importe', MoneyType::class,array('label' => 'Importe',
                        'scale' => 2,
                        'grouping' => true,
                        'required'  => false,
                        'attr'  => array(
                            'data-thousands' =>'.',
                            'data-decimal' =>',',
                            "onchange" => "javascript:marcaCambio();")
                    ))
                ->add('IVA',PercentType::class,array('label' => '% IVA',
                        'required'  => false,
                        'attr'  => array("onchange" => "javascript:marcaCambio();")
                    ))
//                ->add('firma')
                ->add('observaciones', TextareaType::class, array(
                        'label' => 'Observaciones',
                        'required'  => false, 
                        'attr' => array(
                            'rows' => '5',
                            'cols' => '10',
                            "onchange" => "javascript:marcaCambio();")
                    ))
                ->add('save', SubmitType::class, array(
                    'label' => 'Modificar',
                    'attr'  => array(
                        "onchange" => "javascript:desmarcaCambio();",
                        "class" => "btn btn-primary"),
                    ))
                 ->add('eliminar', SubmitType::class, array(
                     'label' => 'Eliminar',
                     'attr'  => array(
                        "onchange" => "javascript:desmarcaCambio();",
                        "class" => "btn btn-primary"),
                    ))
                ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PartesBundle\Entity\Partes'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'partesbundle_partes';
    }


}
