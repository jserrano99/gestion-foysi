<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;

class ServicioType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('descripcion', TextType::class, array(
                    "label" => 'descripcion',
                    "required" => true,
                    "attr" => array("class" => "form-control")))
                ->add('importeUnitario', MoneyType::class, array(
                    "label" => 'Importe Unitario (SIN IVA)',
                    "required" => true,
                    "attr" => array("class" => " form-control")))
                ->add('Guardar', SubmitType::class, array(
                    "attr" => array("class" => "form-submit btn btn-t btn-success")))
        ;
    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Servicio'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'appbundle_servicio';
    }

}
