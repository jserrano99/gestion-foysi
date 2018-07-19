<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use AppBundle\Form\EventListener\EjercicioEventSuscriber;
use AppBundle\Form\EventListener\TrimestreEventSuscriber;

class FiltroFechaType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $factory = $builder->getFormFactory();

        
        $builder->addEventSubscriber(new EjercicioEventSuscriber())
                ->addEventSubscriber(new TrimestreEventSuscriber())
                ->add('rangoFecha', TextType::class, array(
                    "label" => 'Rango de Fechas',
                    "required" => false,
                    "attr" => array("class" => "corto form-control")))
                ->add('startDate', \Symfony\Component\Form\Extension\Core\Type\HiddenType::class)
                ->add('endDate', \Symfony\Component\Form\Extension\Core\Type\HiddenType::class)
                ->add('ejercicio', EntityType::class, array(
                    'label' => 'Ejercicio',
                    'class' => 'AppBundle:Ejercicio',
                    'required' => false,
                    'placeholder' => ' Seleccione Ejercicio ... ',
                    'attr' => array("class" => "medio form-control")))
                ->add('Guardar', SubmitType::class, array(
                    "attr" => array("class" => "form-submit btn btn-t btn-success")))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array());
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'appbundle_filtroFecha';
    }

}
