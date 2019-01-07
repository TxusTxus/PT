<?php

namespace ClientesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;


class ClienteType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nombre', TextType::class, array('label' => 'Nombre','attr' => array("onchange" => "javascript:marcaCambio();")))
                ->add('razonSocial', TextType::class, array('label' => 'Razón social','attr' => array("onchange" => "javascript:marcaCambio();")))
                ->add('observaciones', TextareaType::class, array(
                    'label' => 'Observaciones', 
                    'required' => false,
                    'attr' => array(
                        'rows' => '5',
                        'cols' => '10',                      
                        "onchange" => "javascript:marcaCambio();")));
                // La empresa es añadida desde el contoller
                
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
