<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LineaPedido
 *
 * @ORM\Table(name="lineas_pedido")
 * @ORM\Entity
 */
class LineaPedido {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var Pedido|null
     *
     * @ORM\ManyToOne(targetEntity="Pedido")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="pedido_id", referencedColumnName="id")
     * })
     */
    private $pedido;

    /**
     * @var Servicio|null
     *
     * @ORM\ManyToOne(targetEntity="Servicio")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="sevicio_id", referencedColumnName="id")
     * })
     */
    private $servicio;

    /**
     * @var integer
     * 
     * @ORM\Column(name="unidades", type="integer", nullable=false)     
     */
    private $unidades;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="fechaSesion", type="datetime", nullable=true)
     */
    private $fechaSesion;

    /**
     * @var string
     *
     * @ORM\Column(name="numeroFoto", type="string",length=50, nullable=true)
     */
    private $numeroFoto;

    /**
     * @var string
     *
     * @ORM\Column(name="observaciones", type="string", length=255, nullable=true)
     */
    private $observaciones;

    /**
     * @var double 
     * 
     * @ORM\Column(name="importeUnitario", type="float", nullable=true)
     * 
     */
    private $importeUnitario;

    /**
     * @var double 
     * 
     * @ORM\Column(name="baseImponible", type="float", nullable=true)
     * 
     */
    private $baseImponible;

    /**
     * @var double 
     * 
     * @ORM\Column(name="totalServicio", type="float", nullable=true)
     * 
     */
    private $totalServicio;

    /**
     * @var double 
     * 
     * @ORM\Column(name="cuotaIVA", type="float", nullable=true)
     * 
     */
    private $cuotaIVA;

    /**
     * @var double 
     * 
     * @ORM\Column(name="descuento", type="float", nullable=true)
     * 
     */
    private $descuento;

    /**
     * @var double 
     * 
     * @ORM\Column(name="totalLinea", type="float", nullable=true)
     * 
     */
    private $totalLinea;

    /*
     * @var string
     */
    private $detalle;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set unidades
     *
     * @param integer $unidades
     *
     * @return LineaPedido
     */
    public function setUnidades($unidades) {
        $this->unidades = $unidades;

        return $this;
    }

    /**
     * Get unidades
     *
     * @return integer
     */
    public function getUnidades() {
        return $this->unidades;
    }

    /**
     * Set pedido
     *
     * @param \AppBundle\Entity\Pedido $pedido
     *
     * @return LineaPedido
     */
    public function setPedido(\AppBundle\Entity\Pedido $pedido = null) {
        $this->pedido = $pedido;

        return $this;
    }

    /**
     * Get pedido
     *
     * @return \AppBundle\Entity\Pedido
     */
    public function getPedido() {
        return $this->pedido;
    }

    /**
     * Set servicio
     *
     * @param \AppBundle\Entity\Servicio $servicio
     *
     * @return LineaPedido
     */
    public function setServicio(\AppBundle\Entity\Servicio $servicio = null) {
        $this->servicio = $servicio;

        return $this;
    }

    /**
     * Get servicio
     *
     * @return \AppBundle\Entity\Servicio
     */
    public function getServicio() {
        return $this->servicio;
    }

    /**
     * Set fechaSesion
     *
     * @param \DateTime $fechaSesion
     *
     * @return LineaPedido
     */
    public function setFechaSesion($fechaSesion) {
        $this->fechaSesion = $fechaSesion;

        return $this;
    }

    /**
     * Get fechaSesion
     *
     * @return \DateTime
     */
    public function getFechaSesion() {
        return $this->fechaSesion;
    }

    /**
     * Set numeroFoto
     *
     * @param integer $numeroFoto
     *
     * @return LineaPedido
     */
    public function setNumeroFoto($numeroFoto) {
        $this->numeroFoto = $numeroFoto;

        return $this;
    }

    /**
     * Get numeroFoto
     *
     * @return integer
     */
    public function getNumeroFoto() {
        return $this->numeroFoto;
    }

    /**
     * Set observaciones
     *
     * @param string $observaciones
     *
     * @return LineaPedido
     */
    public function setObservaciones($observaciones) {
        $this->observaciones = $observaciones;

        return $this;
    }

    /**
     * Get observaciones
     *
     * @return string
     */
    public function getObservaciones() {
        return $this->observaciones;
    }

    public function getDetalle() {
        $this->detalle = $this->unidades . ' ' .
                $this->getServicio()->getDescripcion();
        if ($this->fechaSesion != null) {
            $this->detalle = $this->detalle . ' de fecha ' . $this->fechaSesion->format('d-m-Y');
        }
        if ($this->numeroFoto != null) {
            $this->detalle = $this->detalle . ' Nº Foto: ' . $this->numeroFoto;
        }
        return $this->detalle;
    }

    /**
     * Set importeUnitario
     *
     * @param $importeUnitario
     *
     * @return LineaPedido
     */
    public function setImporteUnitario($importeUnitario) {
        $this->importeUnitario = $importeUnitario;

        return $this;
    }

    /**
     * Get importeUnitario
     *
     * @return double
     */
    public function getImporteUnitario() {
        return $this->importeUnitario;
    }

    /**
     * Set baseImponible
     *
     * @param  $baseImponible
     *
     * @return LineaPedido
     */
    public function setBaseImponible($baseImponible) {
        $this->baseImponible = $baseImponible;

        return $this;
    }

    /**
     * Get baseImponible
     *
     * @return double
     */
    public function getBaseImponible() {
        return $this->baseImponible;
    }

    /**
     * Set cuotaIVA
     *
     * @param $cuotaIVA
     *
     * @return LineaPedido
     */
    public function setCuotaIVA($cuotaIVA) {
        $this->cuotaIVA = $cuotaIVA;

        return $this;
    }

    /**
     * Get cuotaIVA
     *
     * @return double
     */
    public function getCuotaIVA() {
        return $this->cuotaIVA;
    }

    /**
     * Set totalLinea
     *
     * @param double $totalLinea
     *
     * @return LineaPedido
     */
    public function setTotalLinea($totalLinea) {
        $this->totalLinea = $totalLinea;

        return $this;
    }

    /**
     * Get totalLinea
     *
     * @return double
     */
    public function getTotalLinea() {
        return $this->totalLinea;
    }

    public function getTotalServicio() {
        return $this->totalServicio;
    }

    public function getDescuento() {
        return $this->descuento;
    }

    public function setTotalServicio($totalServicio) {
        $this->totalServicio = $totalServicio;
        return $this;
    }

    public function setDescuento($descuento) {
        $this->descuento = $descuento;
        return $this;
    }

}
