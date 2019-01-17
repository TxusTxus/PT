<?php

namespace PartesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class PartesType extends AbstractType
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
                        'attr' => array("onchange" => "javascript:ponUltimoMantenimiento();"),
                        'required'  => true,
                        'widget' => 'single_text'))
                ->add('fechaEntrada', TimeType::class, array(
                        'label' => 'Hora entrada',
                        'attr' => array("onchange" => "javascript:ponUltimoMantenimiento();"),
                        'required'  => true,
                        'widget' => 'single_text'))
//                ->add('tiempo')
                ->add('material',CheckboxType::class, array('label' => 'Indicar sí se requiere material','required'  => false))
//                ->add('firma')
                ->add('observaciones', TextType::class, array(
                        'label' => 'Observaciones',
                        'required'  => false,));
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
