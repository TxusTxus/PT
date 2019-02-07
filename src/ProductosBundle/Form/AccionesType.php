<?php

namespace ProductosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AccionesType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('accion', TextareaType::class, array(
                    'label' => 'Acción', 
                    'attr' => array('rows' => '3', 'cols' => '10',"onchange" => "javascript:marcaCambio();"), 
                    'required'=>false));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ProductosBundle\Entity\Acciones'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'productosbundle_aciones';
    }


}
