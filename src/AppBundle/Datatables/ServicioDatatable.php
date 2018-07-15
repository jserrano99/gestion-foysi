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
use Sg\DatatablesBundle\Datatable\Column\NumberColumn;

class ServicioDatatable extends AbstractDatatable {

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
		$formatter = new \NumberFormatter("es_ES", \NumberFormatter::CURRENCY);


		$this->columnBuilder
				->add('id', Column::class, array('title' => 'Id', 'width' => '20px', 'searchable' => false))
				->add('descripcion', Column::class, array('title' => 'Descripcion', 'width' => '300px', 'searchable' => true))
				->add('importeUnitario', NumberColumn::class, array('title' => 'Base Imponible',
					'width' => '80px', 'searchable' => false,
					'formatter' => $formatter,
					'use_format_currency' => true, // needed for \NumberFormatter::CURRENCY
					'currency' => 'EUR',
					'orderable' => true,
				))
				->add('cuotaIVA', NumberColumn::class, array('title' => 'Cuota IVA', 'width' => '80px', 'searchable' => false,
					'formatter' => $formatter,
					'use_format_currency' => true, // needed for \NumberFormatter::CURRENCY
					'currency' => 'EUR',
					'orderable' => true,
				))
				->add('importeIVA', NumberColumn::class, array('title' => 'Importe Total', 'width' => '80px', 'searchable' => false,
					'formatter' => $formatter,
					'use_format_currency' => true, // needed for \NumberFormatter::CURRENCY
					'currency' => 'EUR',
					'orderable' => true,
				))
				->add(null, ActionColumn::class, array(
					'title' => 'Acciones',
					'actions' => array(
						array('route' => 'editServicio',
							'route_parameters' => array(
								'id' => 'id'),
							'label' => 'Editar',
							'icon' => 'glyphicon glyphicon-print',
							'attributes' => array(
								'rel' => 'tooltip',
								'title' => 'Editar',
								'class' => 'btn btn-primary btn-xs',
								'role' => 'button'
							)
						),
						array('route' => 'deleteServicio',
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
							'confirm_message' => 'Confirmar la Eliminación Servicio de Caja'),
					)
				))
		;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getEntity() {
		return 'AppBundle\Entity\Servicio';
	}

	/**
	 * {@inheritdoc}
	 */
	public function getName() {
		return 'servicio_datatable';
	}

}
