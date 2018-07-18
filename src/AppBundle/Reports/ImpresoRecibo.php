<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Reports;

use setasign\Fpdi\Fpdi;

/**
 * Description of ImpresoRecibo
 *
 * @author jluis_local
 */
class ImpresoRecibo extends Fpdi {
    /*
     * @var Recibo
     */

    private $recibo;

    /*
     * @return Recibo
     */

    public function getRecibo() {
        return $this->recibo;
    }

    public function setRecibo($recibo) {
        $this->recibo = $recibo;
        return $this;
    }

    public function __construct($orientation = 'P', $unit = 'mm', $format = 'A4', $Recibo) {
        parent::__construct($orientation, $unit, $format);
        $this->recibo = $Recibo;
        $this->Detalle();
    }

    public function Header() {
        $paginas = $this->setSourceFile('plantillas/PlantillaRecibo.pdf');
        $plantilla = $this->importPage(1, '/MediaBox');
        $this->useTemplate($plantilla);
    }

    public function Detalle() {
        define('EURO', chr(128));
        $this->AddPage();
        $this->Ln(90);
        
        $this->SetFont('arial', 'B', 10);
        $this->Cell(20, 4, ' ', 0, 0, 'L');
        $this->Cell(20, 4, utf8_decode('Número : '), 0, 0, 'L');
        $this->SetFont('arial', '', 10);
        $this->Cell(100, 4, utf8_decode($this->recibo->getNumero() . '/' . $this->recibo->getEjercicio()->getAnyo()), 0, 0, 'L');
        $this->Ln();

        $this->SetFont('arial', 'B', 10);
        $this->Cell(20, 4, ' ', 0, 0, 'L');
        $this->Cell(20, 4, utf8_decode('Fecha : '), 0, 0, 'L');
        $this->SetFont('arial', '', 10);
        $this->Cell(100, 4, utf8_decode($this->recibo->getFecha()->format('d-m-Y')), 0, 0, 'L');
        $this->Ln(38);
        
        $this->SetFont('arial', '', 10);
        
        foreach ($this->recibo->getPedido()->getLineasPedido() as $linea) {
            $this->Cell(85, 5, utf8_decode($linea->getDetalle()), 0, 0, 'R');
            $this->Cell(25, 5, number_format($linea->getTotalServicio(), 2, ',', '.') . ' ' . EURO, 0, 0, 'R');
            $this->Cell(25, 5, number_format($linea->getDescuento(), 2, ',', '.') . ' ' . EURO, 0, 0, 'R');
            $this->Cell(20, 5, number_format($linea->getCuotaIVA(), 2, ',', '.') . ' ' . EURO, 0, 0, 'R');
            $this->Cell(25, 5, number_format($linea->getTotalLinea(), 2, ',', '.') . ' ' . EURO, 0, 0, 'R');
            $this->Ln();
        }
        $lineas = 16 - count($this->recibo->getPedido()->getLineasPedido());
        for ($i = 1; $i < $lineas; $i++) {
            $this->Ln();
        }
        $this->Ln(4);
        $this->Cell(130, 5, ' ', 0, 0, 'L', 0);
        $this->Cell(25, 5, number_format($this->recibo->getPedido()->getTotalServicio(), 2, ',', '.') . ' ' . EURO, 0, 0, 'R');
        $this->Ln(6);
        $this->Cell(130, 5, ' ', 0, 0, 'L', 0);
        $this->Cell(25, 5, number_format($this->recibo->getPedido()->getTotalDescuento(), 2, ',', '.') . ' ' . EURO, 0, 0, 'R');
        $this->Ln(6);
        $this->Cell(130, 5, ' ', 0, 0, 'L', 0);
        $this->Cell(25, 5, number_format($this->recibo->getPedido()->getBaseImponible(), 2, ',', '.') . ' ' . EURO, 0, 0, 'R');
        $this->Ln(6);
        $this->Cell(130, 5, ' ', 0, 0, 'L', 0);
        $this->Cell(25, 5, number_format($this->recibo->getPedido()->getCuotaIVA(), 2, ',', '.') . ' ' . EURO, 0, 0, 'R');
        $this->Ln(6);
        $this->Cell(130, 5, ' ', 0, 0, 'L', 0);
        $this->Cell(25, 5, number_format($this->recibo->getPedido()->getTotalPedido(), 2, ',', '.') . ' ' . EURO, 0, 0, 'R');
        $this->Ln(9);
        
    }

}
