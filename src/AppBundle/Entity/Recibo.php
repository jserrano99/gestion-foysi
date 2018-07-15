<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Recibo
 *
 * @ORM\Table(name="recibos")
 * @ORM\Entity
 */
class Recibo {

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
     * @ORM\OneToOne(targetEntity="Pedido", inversedBy="recibo")
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
     * @var integer
     * 
     * @ORM\Column(name="ejercicio", type="integer", nullable=false)     
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
     * @return Recibo
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
     * @return Recibo
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
     * @return Recibo
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
     * Set ejercicio
     *
     * @param integer $ejercicio
     *
     * @return Recibo
     */
    public function setEjercicio($ejercicio) {
        $this->ejercicio = $ejercicio;

        return $this;
    }

    /**
     * Get ejercicio
     *
     * @return integer
     */
    public function getEjercicio() {
        return $this->ejercicio;
    }


    /**
     * Set numero
     *
     * @param integer $numero
     *
     * @return Recibo
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get numero
     *
     * @return integer
     */
    public function getNumero()
    {
        return $this->numero;
    }
}
