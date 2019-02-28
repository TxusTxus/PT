<?php

namespace AlbaranesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\PercentType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class ConceptoType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('cantidad')
                ->add('concepto')
                ->add('precio', MoneyType::class,array('label' => 'Precio',
                        'scale' => 2,
                        'grouping' => true,
                        'required'  => false,
                        'attr'  => array(
                            'data-thousands' =>'.',
                            'data-decimal' =>',',
                            "onchange" => "javascript:marcaCambio();")
                    ));

    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AlbaranesBundle\Entity\Conceptos'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'albaranesbundle_conceptos';
    }


}
