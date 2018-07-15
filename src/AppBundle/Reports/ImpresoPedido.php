<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Reports;

use AppBundle\Entity\Pedido;
use setasign\Fpdi\Fpdi;
use NumberFormatter;

/**
 * Description of ImpresoPedido
 *
 * @author jluis_local
 */
class ImpresoPedido extends Fpdi {
    /*
     * @var Pedido
     */

    private $pedido;

    /*
     * @return Pedido
     */

    public function getPedido() {
        return $this->pedido;
    }

    public function setPedido($pedido) {
        $this->pedido = $pedido;
        return $this;
    }

    public function __construct($orientation = 'P', $unit = 'mm', $format = 'A4', $Pedido) {
        parent::__construct($orientation, $unit, $format);
        $this->pedido = $Pedido;
        $this->Detalle();
    }

    public function Header() {
        $paginas = $this->setSourceFile('plantillas/PlantillaPedido.pdf');
        $plantilla = $this->importPage(1, '/MediaBox');
        $this->useTemplate($plantilla);
    }

    public function Detalle() {
        define('EURO', chr(128));
        $this->AddPage();
        $this->Ln(58);
        $this->SetFont('arial', 'B', 10);
        $this->Cell(20, 4, ' ', 0, 0, 'L');
        $this->Cell(16, 4, 'Nombre: ', 0, 0, 'L');
        $this->SetFont('arial', '', 10);
        $this->Cell(100, 4, utf8_decode($this->pedido->getCliente()->getNombreCompleto()), 0, 0, 'L');
        $this->Ln(40);
        $this->Cell(20, 4, ' ', 0, 0, 'L');
        $this->SetFont('arial', 'B', 10);
        $this->Cell(13, 4, 'Fecha :', 0, 0, 'L');
        $this->SetFont('arial', '', 10);
        $this->Cell(20, 4, utf8_decode($this->pedido->getFecha()->format('d-m-Y')), 0, 0, 'L');
        $this->Ln();
        $linea1= substr($this->pedido->getObservaciones(), 0, 90);
        $linea2= substr($this->pedido->getObservaciones(), 92, 90);
        $linea3= substr($this->pedido->getObservaciones(), 181, 255);
        $this->Cell(20, 4, ' ', 0, 0, 'L');
        $this->Cell(110, 4, utf8_decode($linea1),0, 0, 'L');
        $this->Ln();
        $this->Cell(20, 4, ' ', 0, 0, 'L');
        $this->Cell(110, 4, utf8_decode($linea2),0, 0, 'L');
        $this->Ln();
        $this->Cell(20, 4, ' ', 0, 0, 'L');
        $this->Cell(110, 4, utf8_decode($linea3),0, 0, 'L');
        $this->Ln(35);
        $this->SetFont('arial', '', 10);
        foreach ($this->pedido->getLineasPedido() as $linea) {
            $this->Cell(100, 5, utf8_decode($linea->getDetalle()), 0, 0, 'R');
            $importe = $linea->getServicio()->getImporteIVA();
            $unidades = $linea->getUnidades();
            $importeTotal = $importe * $linea->getUnidades();
            $this->Cell(25, 5, number_format($importe, 2, ',', '.') . ' ' . EURO, 0, 0, 'R');
            $this->Cell(20, 5, $unidades, 0, 0, 'C');
            $this->Cell(25, 5, number_format($importeTotal, 2, ',', '.') . ' ' . EURO, 0, 0, 'R');
            $this->Ln();
        }
        $lineas = 16 - count($this->pedido->getLineasPedido());
        for ($i = 1; $i < $lineas; $i++) {
            $this->Ln();
        }
        $this->Ln(4);
        $this->Cell(137, 5, ' ', 0, 0, 'L', 0);
        $this->Cell(25, 5, number_format($this->pedido->getTotalServicio()+$this->pedido->getCuotaIVA(), 2, ',', '.') . ' ' . EURO, 0, 0, 'R');
        $this->Ln(6);
        $this->Cell(137, 5, ' ', 0, 0, 'L', 0);
        $this->Cell(25, 5, number_format($this->pedido->getTotalDescuento(), 2, ',', '.') . ' ' . EURO, 0, 0, 'R');
        $this->Ln(6);
        $this->Cell(137, 5, ' ', 0, 0, 'L', 0);
        $this->Cell(25, 5, number_format($this->pedido->getTotalPedido(), 2, ',', '.') . ' ' . EURO, 0, 0, 'R');
        
    }

}
