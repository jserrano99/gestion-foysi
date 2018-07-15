<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Reports;

use setasign\Fpdi\Fpdi;

/**
 * Description of ImpresoFactura
 *
 * @author jluis_local
 */
class ImpresoFactura extends Fpdi {
    /*
     * @var Factura
     */

    private $factura;

    /*
     * @return Factura
     */

    public function getFactura() {
        return $this->factura;
    }

    public function setFactura($factura) {
        $this->factura = $factura;
        return $this;
    }

    public function __construct($orientation = 'P', $unit = 'mm', $format = 'A4', $Factura) {
        parent::__construct($orientation, $unit, $format);
        $this->factura = $Factura;
        $this->Detalle();
    }

    public function Header() {
        $paginas = $this->setSourceFile('plantillas/PlantillaFactura.pdf');
        $plantilla = $this->importPage(1, '/MediaBox');
        $this->useTemplate($plantilla);
    }

    public function Detalle() {
        define('EURO', chr(128));
        $this->AddPage();
        $this->Ln(53);
        
        $this->SetFont('arial', 'B', 10);
        $this->Cell(20, 4, ' ', 0, 0, 'L');
        $this->Cell(20, 4, utf8_decode('Número : '), 0, 0, 'L');
        $this->SetFont('arial', '', 10);
        $this->Cell(100, 4, utf8_decode($this->factura->getNumero() . '/' . $this->factura->getEjercicio()), 0, 0, 'L');
        $this->Ln();

        $this->SetFont('arial', 'B', 10);
        $this->Cell(20, 4, ' ', 0, 0, 'L');
        $this->Cell(20, 4, utf8_decode('Fecha : '), 0, 0, 'L');
        $this->SetFont('arial', '', 10);
        $this->Cell(100, 4, utf8_decode($this->factura->getFecha()->format('d-m-Y')), 0, 0, 'L');
        $this->Ln(28);
        
        $this->SetFont('arial', 'B', 10);
        $this->Cell(20, 4, ' ', 0, 0, 'L');
        $this->Cell(20, 4, 'Nombre : ', 0, 0, 'L');
        $this->SetFont('arial', '', 10);
        $this->Cell(100, 4, utf8_decode($this->factura->getPedido()->getCliente()->getNombreCompleto()), 0, 0, 'L');
        $this->Ln();
        
        $this->SetFont('arial', 'B', 10);
        $this->Cell(20, 4, ' ', 0, 0, 'L');
        $this->Cell(20, 4, 'NIF: ', 0, 0, 'L');
        $this->SetFont('arial', '', 10);
        $this->Cell(100, 4, utf8_decode($this->factura->getPedido()->getCliente()->getNIF()), 0, 0, 'L');
        $this->Ln();
        
        $this->SetFont('arial', 'B', 10);
        $this->Cell(20, 4, ' ', 0, 0, 'L');
        $this->Cell(20, 4, 'Domicilio :', 0, 0, 'L');
        $this->SetFont('arial', '', 10);
        $this->Cell(100, 4, utf8_decode($this->factura->getPedido()->getCliente()->getDomicilio()), 0, 0, 'L');
        $this->Ln();
        $this->SetFont('arial', 'B', 10);
        $this->Cell(20, 4, ' ', 0, 0, 'L');
        $this->Cell(20, 4, 'Email :', 0, 0, 'L');
        $this->SetFont('arial', '', 10);
        $this->Cell(50, 4, utf8_decode($this->factura->getPedido()->getCliente()->getEmail()), 0, 0, 'L');
        $this->SetFont('arial', 'B', 10);
        $this->Cell(20, 4, utf8_decode('Teléfono : '), 0, 0, 'L');
        $this->SetFont('arial', '', 10);
        $this->Cell(40, 4, utf8_decode($this->factura->getPedido()->getCliente()->getMovil()), 0, 0, 'L');
        $this->Ln();
        
        $this->Ln(35);
        $this->SetFont('arial', '', 10);
        
        foreach ($this->factura->getPedido()->getLineasPedido() as $linea) {
            $this->Cell(85, 5, utf8_decode($linea->getDetalle()), 0, 0, 'R');
            $this->Cell(25, 5, number_format($linea->getTotalServicio(), 2, ',', '.') . ' ' . EURO, 0, 0, 'R');
            $this->Cell(25, 5, number_format($linea->getDescuento(), 2, ',', '.') . ' ' . EURO, 0, 0, 'R');
            $this->Cell(20, 5, number_format($linea->getCuotaIVA(), 2, ',', '.') . ' ' . EURO, 0, 0, 'R');
            $this->Cell(25, 5, number_format($linea->getTotalLinea(), 2, ',', '.') . ' ' . EURO, 0, 0, 'R');
            $this->Ln();
        }
        $lineas = 16 - count($this->factura->getPedido()->getLineasPedido());
        for ($i = 1; $i < $lineas; $i++) {
            $this->Ln();
        }
        $this->Ln(4);
        $this->Cell(130, 5, ' ', 0, 0, 'L', 0);
        $this->Cell(25, 5, number_format($this->factura->getPedido()->getTotalServicio(), 2, ',', '.') . ' ' . EURO, 0, 0, 'R');
        $this->Ln(6);
        $this->Cell(130, 5, ' ', 0, 0, 'L', 0);
        $this->Cell(25, 5, number_format($this->factura->getPedido()->getTotalDescuento(), 2, ',', '.') . ' ' . EURO, 0, 0, 'R');
        $this->Ln(6);
        $this->Cell(130, 5, ' ', 0, 0, 'L', 0);
        $this->Cell(25, 5, number_format($this->factura->getPedido()->getBaseImponible(), 2, ',', '.') . ' ' . EURO, 0, 0, 'R');
        $this->Ln(6);
        $this->Cell(130, 5, ' ', 0, 0, 'L', 0);
        $this->Cell(25, 5, number_format($this->factura->getPedido()->getCuotaIVA(), 2, ',', '.') . ' ' . EURO, 0, 0, 'R');
        $this->Ln(6);
        $this->Cell(130, 5, ' ', 0, 0, 'L', 0);
        $this->Cell(25, 5, number_format($this->factura->getPedido()->getTotalPedido(), 2, ',', '.') . ' ' . EURO, 0, 0, 'R');
        $this->Ln(9);
        
    }

}
