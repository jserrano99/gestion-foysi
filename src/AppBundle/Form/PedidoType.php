<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class PedidoType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('fecha', DateType::class, array(
                    "label" => 'Fecha',
                    "required" => false,
                    'widget' => 'single_text',
                    'attr' => array(
                        'class' => 'muycorto form-control js-datepicker',
                        'data-date-format' => 'dd-mm-yyyy',
                        'data-class' => 'string')))
                ->add('cliente', EntityType::class, array(
                    'label' => 'Cliente',
                    'class' => 'AppBundle:Cliente',
                    'required' => false,
                    'placeholder' => 'Seleccione Cliente....',
                    'attr' => array("class" => "medio form-control")))
                ->add('nombre', TextType::class, array(
                    'label' => 'Nombre y Apellidos',
                    'required' => false,
                    'mapped' => false,
                    'attr' => array('maxlength' => 255,"class" => "medio form-control")))
                ->add('observaciones', TextType::class, array(
                    'label' => 'Observaciones',
                    'required' => false,
                    'attr' => array('maxlength' => 255,"class" => "form-control")))
                ->add('estadoPedido', EntityType::class, array(
                    'label' => 'Estado',
                    'class' => 'AppBundle:EstadoPedido',
                    'required' => "required",
                    'placeholder' => 'Seleccione Estado del Pedido....',
                    'attr' => array("class" => "medio form-control")))
                ->add('descuento', EntityType::class, array(
                    'label' => '% Descuento',
                    'class' => 'AppBundle:Descuento',
                    'required' => false,
                    'placeholder' => 'Seleccione Descuento....',
                    'attr' => array("class" => "corto form-control")))
                ->add('Guardar', SubmitType::class, array(
                    "attr" => array("class" => "form-submit btn btn-t btn-success")))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Pedido'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'appbundle_pedido';
    }

}
