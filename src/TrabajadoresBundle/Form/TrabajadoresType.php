<?php

namespace TrabajadoresBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class TrabajadoresType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('dni', TextType::class, array('label' => 'DNI/NIE'))
                ->add('codigo', TextType::class, array('label' => 'Código'))
                ->add('nombre', TextType::class, array('label' => 'Nombre'));
//                ->add('empresa', EntityType::class, array(
//                    'class' => 'EmpresasBundle:Empresa',
//                    'label' => 'Empresa'
//                ));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TrabajadoresBundle\Entity\Trabajadores'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'trabajadoresbundle_trabajadores';
    }


}
