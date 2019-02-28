<?php

namespace AlbaranesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\PercentType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class AlbaranType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('fecha', DateType::class, array(
                        'label' => 'Fecha',
                        'attr' => array("onchange" => "javascript:marcaCambio();"),
                        'required'  => true,
                        'widget' => 'single_text'))
                ->add('cliente')
                ->add('total', MoneyType::class,array('label' => 'Total',
                        'scale' => 2,
                        'grouping' => true,
                        'required'  => false,
                        'attr'  => array(
                            'data-thousands' =>'.',
                            'value' => '0',
                            'data-decimal' =>',',
                            "onchange" => "javascript:marcaCambio();")
                    ))
                ->add('iVA',PercentType::class,array('label' => '% IVA',
                        'required'  => false,
                        'attr'  => array("onchange" => "javascript:marcaCambio();", 'value' => '21')
                    ))
                ->add('tipoPago')
                ->add('trabajador');
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AlbaranesBundle\Entity\Albaran'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'albaranesbundle_albaran';
    }


}
