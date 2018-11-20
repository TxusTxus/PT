<?php

namespace ClientesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ClienteType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nombre', TextType::class, array('label' => 'Nombre','attr' => array("onchange" => "javascript:marcaCambio();")))
                ->add('telefono', TextType::class, array('label' => 'Teléfono','attr' => array("onchange" => "javascript:marcaCambio();")))
                ->add('contacto', TextType::class, array('label' => 'Contacto','attr' => array("onchange" => "javascript:marcaCambio();")))
                ->add('direccion', TextType::class, array('label' => 'Dirección','attr' => array("onchange" => "javascript:marcaCambio();")))
                ->add('poblacion', TextType::class, array('label' => 'Población','attr' => array("onchange" => "javascript:marcaCambio();")))
                ->add('provincia', EntityType::class, array(
                    'class' => 'ClientesBundle:Provincia',
                    'label' => 'Provincia',
                    'attr' => array("onchange" => "javascript:marcaCambio();")))
                
                ->add('codigoPostal', TextType::class, array('label' => 'Código Postal','attr' => array("onchange" => "javascript:marcaCambio();")))
                ->add('email', TextType::class, array('label' => 'Correo electrónico','attr' => array("onchange" => "javascript:marcaCambio();")))
                ->add('observaciones', TextareaType::class, array(
                    'label' => 'Observaciones', 
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
