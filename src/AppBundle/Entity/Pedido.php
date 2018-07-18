<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pedido
 *
 * @ORM\Table(name="pedidos")
 * @ORM\Entity
 */
class Pedido {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var Cliente
     *
     * @ORM\ManyToOne(targetEntity="Cliente")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="cliente_id", referencedColumnName="id")
     * }) 
     */
    private $cliente;

    /**
     * @var EstadoPedido|null
     *
     * @ORM\ManyToOne(targetEntity="EstadoPedido")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="estado_pedido_id", referencedColumnName="id")
     * })
     */
    private $estadoPedido;

    /**
     * @var Descuento|null
     *
     * @ORM\ManyToOne(targetEntity="Descuento")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="descuento_id", referencedColumnName="id")
     * }) 
     */
    private $descuento;

    /**
     * @var DateTime
     * 
     * @ORM\Column(name="fecha", type="datetime", nullable=false)     
     */
    private $fecha;

    /**
     * @var string
     * 
     * @ORM\Column(name="observaciones", type="string",length=255, nullable=true)     
     */
    private $observaciones;

    /**
     * @var LineaPedido[]|null
     *
     * @ORM\OneToMany(targetEntity="LineaPedido",mappedBy="pedido",cascade={"persist","remove"})
     */
    private $lineasPedido;

    /**
     * @var Factura|null
     *
     * @ORM\OneToOne(targetEntity="Factura", mappedBy="pedido")
     */
    private $factura;

    /**
     * @var Recibo|null
     *
     * @ORM\OneToOne(targetEntity="Recibo", mappedBy="pedido")
     */
    private $recibo;
    /*
     * @var double
     */
    private $baseImponible;

    /*
     * @var double
     */
    private $cuotaIVA;
    /*
     * @var double
     */
    private $totalPedido;

    /*
     * @var double
     */
    private $totalServicio;

    /*
     * @var double
     */
    private $totalDescuento;

    public function __construct($estadoPedido = null) {
        $this->fecha = new \DateTime("now");
        $this->lineasPedido = new \Doctrine\Common\Collections\ArrayCollection();
        $this->estadoPedido = $estadoPedido;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return Pedido
     */
    public function setFecha($fecha) {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime
     */
    public function getFecha() {
        return $this->fecha;
    }

    /**
     * Set cliente
     *
     * @param \AppBundle\Entity\Cliente $cliente
     *
     * @return Pedido
     */
    public function setCliente(\AppBundle\Entity\Cliente $cliente = null) {
        $this->cliente = $cliente;

        return $this;
    }

    /**
     * Get cliente
     *
     * @return \AppBundle\Entity\Cliente
     */
    public function getCliente() {
        return $this->cliente;
    }

    /**
     * Set estadoPedido
     *
     * @param \AppBundle\Entity\EstadoPedido $estadoPedido
     *
     * @return Pedido
     */
    public function setEstadoPedido(\AppBundle\Entity\EstadoPedido $estadoPedido = null) {
        $this->estadoPedido = $estadoPedido;

        return $this;
    }

    /**
     * Get estadoPedido
     *
     * @return \AppBundle\Entity\EstadoPedido|Null
     */
    public function getEstadoPedido() {
        return $this->estadoPedido;
    }

    /**
     * Add lineasPedido
     *
     * @param \AppBundle\Entity\LineaPedido $lineasPedido
     *
     * @return Pedido
     */
    public function addLineasPedido(\AppBundle\Entity\LineaPedido $lineasPedido) {
        $this->lineasPedido[] = $lineasPedido;

        return $this;
    }

    /**
     * Remove lineasPedido
     *
     * @param \AppBundle\Entity\LineaPedido $lineasPedido
     */
    public function removeLineasPedido(\AppBundle\Entity\LineaPedido $lineasPedido) {
        $this->lineasPedido->removeElement($lineasPedido);
    }

    /**
     * Get lineasPedido
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLineasPedido() {
        return $this->lineasPedido;
    }

    public function getBaseImponible() {
        foreach ($this->getLineasPedido() as $linea) {
            $this->baseImponible = $this->baseImponible + $linea->getBaseImponible();
        }
        return $this->baseImponible;
    }

    public function getTotalServicio() {
        foreach ($this->getLineasPedido() as $linea) {
            $this->totalServicio = $this->totalServicio + $linea->getTotalServicio();
        }
        return $this->totalServicio;
    }

    public function getTotalPedido() {
        foreach ($this->getLineasPedido() as $linea) {
            $this->totalPedido = $this->totalPedido + $linea->getTotalLinea();
        }
        return $this->totalPedido;
    }

    public function getCuotaIVA() {
        foreach ($this->getLineasPedido() as $linea) {
            $this->cuotaIVA = $this->cuotaIVA + $linea->getCuotaIVA();
        }
        return $this->cuotaIVA;
    }

    public function getTotalDescuento() {
        foreach ($this->getLineasPedido() as $linea) {
            $this->totalDescuento = $this->totalDescuento + $linea->getDescuento();
        }
        return $this->totalDescuento;
    }

    /**
     * Set observaciones
     *
     * @param string $observaciones
     *
     * @return Pedido
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

    /**
     * Set factura
     *
     * @param \AppBundle\Entity\Factura $factura
     *
     * @return Pedido
     */
    public function setFactura(\AppBundle\Entity\Factura $factura = null) {
        $this->factura = $factura;

        return $this;
    }

    /**
     * Get factura
     *
     * @return \AppBundle\Entity\Factura|null
     */
    public function getFactura() {
        return $this->factura;
    }

    
    
    /**
     * Set recibo
     *
     * @param \AppBundle\Entity\Recibo $recibo
     *
     * @return Pedido
     */
    public function setRecibo(\AppBundle\Entity\Recibo $recibo = null) {
        $this->recibo = $recibo;

        return $this;
    }

    /**
     * Get factura
     *
     * @return \AppBundle\Entity\Recibo|null
     */
    public function getRecibo() {
        return $this->recibo;
    }


    /**
     * Set descuento
     *
     * @param \AppBundle\Entity\Descuento $descuento
     *
     * @return Pedido
     */
    public function setDescuento(\AppBundle\Entity\Descuento $descuento = null)
    {
        $this->descuento = $descuento;

        return $this;
    }

    /**
     * Get descuento
     *
     * @return \AppBundle\Entity\Descuento|null
     */
    public function getDescuento()
    {
        return $this->descuento;
    }
}
