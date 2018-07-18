<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class FiltroFechaType extends AbstractType {

	/**
	 * {@inheritdoc}
	 */
	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder->add('rangoFecha', TextType::class, array(
					"label" => 'Rango de Fechas',
					"required" => false,
					"attr" => array("class" => "corto form-control")))
				->add('startDate')
				->add('endDate')
				->add('trimestre', EntityType::class, array(
					'label' => 'Trimestre',
					'class' => 'AppBundle:Trimestre',
					'required' => false,
					'placeholder' => 'Seleccione Trimestre ....',
					'attr' => array("class" => "medio form-control")))
				->add('Guardar', SubmitType::class, array(
					"attr" => array("class" => "form-submit btn btn-t btn-success")))
		;

		$factory = $builder->getFormFactory();

		$ejercicioSubscriber = new AddEjercicioField($factory);
		$builder->addEventSubscriber($ejercicioSubscriber);

		$trimestreSubscriber = new AddTrimestreField($factory);
		$builder->addEventSubscriber($trimestreSubscriber);
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
