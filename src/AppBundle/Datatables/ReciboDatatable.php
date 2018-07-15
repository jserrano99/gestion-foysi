<?php

namespace AppBundle\Datatables;

use Sg\DatatablesBundle\Datatable\AbstractDatatable;
use Sg\DatatablesBundle\Datatable\Style;
use Sg\DatatablesBundle\Datatable\Column\Column;
use Sg\DatatablesBundle\Datatable\Column\ActionColumn;
use Sg\DatatablesBundle\Datatable\Filter\SelectFilter;
use Symfony\Component\Intl\NumberFormatter\NumberFormatter;
use Sg\DatatablesBundle\Datatable\Column\DateTimeColumn;
use Sg\DatatablesBundle\Datatable\Filter\DateRangeFilter;

class ReciboDatatable extends AbstractDatatable {

	/**
	 * {@inheritdoc}
	 */
	public function buildDatatable(array $options = array()) {
		$this->language->set(array(
//			'cdn_language_by_locale' => false
			'language' => 'es'
		));

		$this->ajax->set(array());

		$this->options->set(array(
			'classes' => Style::BOOTSTRAP_4_STYLE,
			'stripe_classes' => ['strip1', 'strip2', 'strip3'],
			'individual_filtering' => true,
			'individual_filtering_position' => 'head',
			'order' => array(array(0, 'asc')),
			'order_cells_top' => true,
			'search_in_non_visible_columns' => true,
		));


		$this->features->set(array(
			'auto_width' => false,
			'ordering' => true,
			'length_change' => true
		));

		$this->columnBuilder
				->add('id', Column::class, array('title' => 'Id', 'width' => '20px', 'searchable' => false))
				->add('ejercicio', Column::class, array('title' => 'Ejercicio', 'width' => '80px', 'searchable' => true))
				->add('numero', Column::class, array('title' => 'Número', 'width' => '40px', 'searchable' => true))
				->add('fecha', DateTimeColumn::class, array('title' => 'Fecha Recibo','width' => '90px',
					'default_content' => 'No value',
					'date_format' => 'DD/MM/YYYY'
				))
				->add('pedido.observaciones', Column::class, array('title' => 'Descripción', 'width' => '400px', 'searchable' => true))
				->add(null, ActionColumn::class, array(
					'title' => 'Acciones',
					'actions' => array(
						array('route' => 'generarRecibo',
							'route_parameters' => array(
								'pedido_id' => 'pedido.id'),
							'label' => 'Imprimir',
							'icon' => 'glyphicon glyphicon-print',
							'attributes' => array(
								'rel' => 'tooltip',
								'title' => 'Imprimir',
								'class' => 'btn btn-primary btn-xs',
								'role' => 'button'
							)
						),
						array('route' => 'deleteRecibo',
							'route_parameters' => array(
								'id' => 'id'),
							'label' => 'Eliminar',
							'icon' => 'glyphicon glyphicon-trash',
							'attributes' => array(
								'rel' => 'tooltip',
								'title' => 'Eliminar',
								'class' => 'btn btn-primary btn-xs',
								'role' => 'button'),
							'confirm' => true,
							'confirm_message' => 'Confirmar la Eliminación Recibo de Caja'),
					)
				))
		;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getEntity() {
		return 'AppBundle\Entity\Recibo';
	}

	/**
	 * {@inheritdoc}
	 */
	public function getName() {
		return 'recibo_datatable';
	}

}
