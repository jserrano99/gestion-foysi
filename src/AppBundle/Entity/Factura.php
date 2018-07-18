<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Factura
 *
 * @ORM\Table(name="facturas")
 * @ORM\Entity
 */
class Factura {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var Pedido
     * 
     * @ORM\OneToOne(targetEntity="Pedido", inversedBy="factura")
     */
    private $pedido;

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
     * @var Ejercicio
     *
     * @ORM\ManyToOne(targetEntity="Ejercicio")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ejercicio_id", referencedColumnName="id")
     * }) 
     */
    private $ejercicio;

    /**
     * @var integer
     * 
     * @ORM\Column(name="numero", type="integer", nullable=false)     
     */
    private $numero;

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
     * @return Factura
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
     * Set observaciones
     *
     * @param string $observaciones
     *
     * @return Factura
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
     * Set pedido
     *
     * @param \AppBundle\Entity\Pedido $pedido
     *
     * @return Factura
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
     * Set numero
     *
     * @param integer $numero
     *
     * @return Factura
     */
    public function setNumero($numero) {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get numero
     *
     * @return integer
     */
    public function getNumero() {
        return $this->numero;
    }


    /**
     * Set ejercicio.
     *
     * @param \AppBundle\Entity\Ejercicio|null $ejercicio
     *
     * @return Factura
     */
    public function setEjercicio(\AppBundle\Entity\Ejercicio $ejercicio = null)
    {
        $this->ejercicio = $ejercicio;

        return $this;
    }

    /**
     * Get ejercicio.
     *
     * @return \AppBundle\Entity\Ejercicio|null
     */
    public function getEjercicio()
    {
        return $this->ejercicio;
    }
}
