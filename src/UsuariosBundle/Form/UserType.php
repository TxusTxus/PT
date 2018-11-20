<?php

namespace UsuariosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class UserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('username', TextType::class, array('label' => 'Usuario'))
                ->add('nombre', TextType::class, array('label' => 'Nombre'))
                ->add('plainPassword', RepeatedType::class, array(
                    'type'              => PasswordType::class,
                    'first_options'     => array('label' => 'Contraseña'),
                    'second_options'    => array('label' => 'Repita contraseña')))
                // ->add('roles')
                ->add('empresa', EntityType::class, array(
                    'class' => 'EmpresasBundle:Empresa',
                    'label' => 'Empresa'
                ));
        
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'UsuariosBundle\Entity\User'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'usuariosbundle_user';
    }


}
