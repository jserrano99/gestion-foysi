<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;


class LineaPedidoType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('servicio', EntityType::class, array(
                    'label' => 'Servicio',
                    'class' => 'AppBundle:Servicio',
                    'required' => "required",
                    'placeholder' => 'Seleccione Servicio ....',
                    'attr' => array("class" => "medio form-control")))
                ->add('unidades', TextType::class, array(
                    "label" => 'Unidades',
                    "required" => true,
                    "attr" => array("class" => "corto form-control")))
                ->add('fechaSesion', DateType::class, array(
                    "label" => 'Fecha Sesión',
                    "required" => false,
                    'widget' => 'single_text',
                    'attr' => array(
                        'class' => 'corto form-control js-datepicker',
                        'data-date-format' => 'dd-mm-yyyy',
                        'data-class' => 'string')))
                ->add('numeroFoto', TextType::class, array(
                    "label" => 'Nº de Fotografía',
                    "required" => false,
                    "attr" => array("class" => "corto form-control")))
                ->add('observaciones', TextType::class, array(
                    "label" => 'observaciones',
                    "required" => false,
                    "attr" => array("class" => "corto form-control")))
                ->add('Guardar', SubmitType::class, array(
                    "attr" => array("class" => "rigth form-submit btn btn-t btn-success")))
        ;
                
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\LineaPedido'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_lineapedido';
    }


}
