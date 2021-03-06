<?php

namespace AppBundle\Datatables;

use Sg\DatatablesBundle\Datatable\AbstractDatatable;
use Sg\DatatablesBundle\Datatable\Style;
use Sg\DatatablesBundle\Datatable\Column\Column;
use Sg\DatatablesBundle\Datatable\Column\ActionColumn;
use Sg\DatatablesBundle\Datatable\Column\DateTimeColumn;
use Sg\DatatablesBundle\Datatable\Filter\DateRangeFilter;

class PedidoDatatable extends AbstractDatatable {

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
            'order' => array(array(1, 'desc')),
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
                ->add('fecha', DateTimeColumn::class, array('title' => 'Fecha Pedido', 'width' => '20px',
                    'default_content' => 'No value',
                    'date_format' => 'DD/MM/YYYY',
                    'filter' => array(DateRangeFilter::class, array(
                            'cancel_button' => true,
                        )),
                ))
                ->add('cliente.nombre', Column::class, array('title' => 'Cliente', 'width' => '150px', 'searchable' => true))
                ->add('observaciones', Column::class, array('title' => 'Descripción', 'width' => '450px', 'searchable' => true))
                ->add(null, ActionColumn::class, array(
                    'title' => 'Acciones',
                    'actions' => array(
                        array('route' => 'editPedido',
                            'route_parameters' => array(
                                'id' => 'id'),
                            'label' => 'Editar',
                            'icon' => 'glyphicon glyphicon-edit',
                            'attributes' => array(
                                'rel' => 'tooltip',
                                'title' => 'Imprimir',
                                'class' => 'btn btn-primary btn-xs',
                                'role' => 'button'
                            )
                        ),
                        array('route' => 'generarRecibo',
                            'route_parameters' => array(
                                'pedido_id' => 'id'),
                            'label' => 'Recibo',
                            'icon' => 'glyphicon glyphicon-print',
                            'attributes' => array(
                                'rel' => 'tooltip',
                                'title' => 'Imprimir',
                                'class' => 'btn btn-primary btn-xs',
                                'role' => 'button'
                            )
                        ),
                        array('route' => 'generarFactura',
                            'route_parameters' => array(
                                'pedido_id' => 'id'),
                            'label' => 'Factura',
                            'icon' => 'glyphicon glyphicon-print',
                            'attributes' => array(
                                'rel' => 'tooltip',
                                'title' => 'Imprimir',
                                'class' => 'btn btn-info btn-xs',
                                'role' => 'button'
                            )
                        ),
                        array('route' => 'deletePedido',
                            'route_parameters' => array(
                                'id' => 'id'),
                            'label' => 'Eliminar',
                            'icon' => 'glyphicon glyphicon-trash',
                            'attributes' => array(
                                'rel' => 'tooltip',
                                'title' => 'Eliminar',
                                'class' => 'btn btn-danger btn-xs',
                                'role' => 'button'),
                            'confirm' => true,
                            'confirm_message' => 'Confirmar la Eliminación Pedido de Caja'),
                    )
                ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getEntity() {
        return 'AppBundle\Entity\Pedido';
    }

    /**
     * {@inheritdoc}
     */
    public function getName() {
        return 'pedido_datatable';
    }

}
