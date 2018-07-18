<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class ServicioType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('descripcion', TextType::class, array(
                    "label" => 'Descripcion del Servicio',
                    "required" => true,
                    "attr" => array("class" => "form-control")))
                ->add('importeUnitario', NumberType::class, array(
                    "label" => 'Importe Unitario (SIN IVA)',
                    "required" => true,
                    "attr" => array("class" => " form-control muycorto")))
				->add('porcentajeIVA', ChoiceType::class, array(
                    "label" => 'Porcentaje IVA',
                    'choices' => array('21%' => 0.21,'SIN IVA' => 0),
                    'required' => true,
                    'disabled' => false,
                    "attr" => array("class" => "form-control muycorto ")))
				->add('cuotaIVA', NumberType::class, array(
                    "label" => 'Cuota IVA',
                    "required" => true,
                    "attr" => array("class" => " form-control muycorto")))
				->add('importeIVA', NumberType::class, array(
                    "label" => 'Importe Unitario (SIN IVA)',
                    "required" => true,
                    "attr" => array("class" => " form-control muycorto")))
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
