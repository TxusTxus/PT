<?php

namespace ProductosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PercentType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ProductoType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // transforma las direcciones del cliente para el desplegable de direcciones.
        $configDirecciones = array();
        if(isset($options['direcciones']) && count($options['direcciones'])>0){
            foreach ($options['direcciones'] as $value1) {
                $configDirecciones[$value1->getDireccion()] = $value1->getId(); 
            }
         }   
        $builder->add('instalacion', DateType::class, array(
                        'label' => 'Fecha instalación',
                        'attr' => array("onchange" => "javascript:ponUltimoMantenimiento();"),
                        'required'  => false,
                        'widget' => 'single_text'))
                ->add('periodicidad', TextType::class, array('label' => 'Periodicidad (días)','attr' => array("onchange" => "javascript:calculaFechaMantenimiento();")))
                ->add('fechaMantenimiento', DateType::class, array('label' => 'Último mantenimiento',
                    'required'  => false,
                    'widget' => 'single_text',
                    'attr' => array("onchange" => "javascript:calculaFechaMantenimiento();")))
                ->add('seleccionDireccion',ChoiceType::class, array(
                    'label'     => 'Dirección',
                    'choices'   =>  $configDirecciones,
                    'required'  => false,
                    'mapped'    => false))
                ->add('fechaNuevoMantenimiento', DateType::class, array('label' => 'Próximo mantenimiento','required'  => false,'widget' => 'single_text'))
                ->add('modelo', TextType::class, array('label' => 'Modelo','attr' => array("onchange" => "javascript:marcaCambio();")))
                ->add('premium',CheckboxType::class, array('required'  => false))
                ->add('base', MoneyType::class,array('label' => 'Base',
                        'scale' => 2,
                        'grouping' => true,
                        'required'  => false,
                        'attr'  => array(
                            'data-thousands' =>'.',
                            'data-decimal' =>',')
                    ))
                ->add('IVA',PercentType::class,array('label' => '% IVA',
                        'required'  => false
                    ))
                ->add('observaciones', TextareaType::class, array(
                    'label' => 'Observaciones', 
                    'required' => false,
                    'attr' => array(
                        'rows' => '3',
                        'cols' => '10',                      
                        "onchange" => "javascript:marcaCambio();")));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ProductosBundle\Entity\Producto',
            'direcciones' => null
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'productosbundle_producto';
    }


}
