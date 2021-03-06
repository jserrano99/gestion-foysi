<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class ProveedorType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('cif', TextType::class, array(
                    "label" => 'CIF',
                    "required" => true,
                    "attr" => array("class" => "corto form-control")))
                ->add('nombre', TextType::class, array(
                    "label" => 'Nombre',
                    "required" => true,
                    "attr" => array("class" => " form-control")))
                ->add('razonSocial', TextType::class, array(
                    "label" => 'Razón Social',
                    "required" => true,
                    "attr" => array("class" => "form-control")))
                ->add('domicilio', TextType::class, array(
                    "label" => 'Domicilio',
                    "required" => true,
                    "attr" => array("class" => " form-control")))
                ->add('cdpostal', TextType::class, array(
                    "label" => 'Código Postal',
                    "required" => true,
                    "attr" => array("class" => "corto form-control")))
                ->add('movil', TextType::class, array(
                    "label" => 'Teléfono Móvil',
                    "required" => true,
                    "attr" => array("class" => "corto form-control")))
                ->add('email', EmailType::class, array(
                    "label" => 'Correo Electrónico',
                    "required" => true,
                    "attr" => array("class" => " corto form-control")))
                ->add('Guardar', SubmitType::class, array(
                    "attr" => array("class" => "form-submit btn btn-t btn-success")))
        ;
    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Proveedor'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'appbundle_proveedor';
    }

}
