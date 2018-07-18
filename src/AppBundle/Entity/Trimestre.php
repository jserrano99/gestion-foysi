<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ejercicio
 *
 * @ORM\Table(name="trimestres")
 * @ORM\Entity
 */
class Trimestre {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=255, nullable=false)
     */
    private $descripcion;

    /**
     * @var datetime
     *
     * @ORM\Column(name="fc_inicio", type="datetime", nullable=false)
     */
    private $fcInicio;

    /**
     * @var datetime
     *
     * @ORM\Column(name="fc_fin", type="datetime", nullable=false)
     */
    private $fcFin;

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
     * Get id.
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set descripcion.
     *
     * @param string $descripcion
     *
     * @return Ejercicio
     */
    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion.
     *
     * @return string
     */
    public function getDescripcion() {
        return $this->descripcion;
    }

    /**
     * Set fcInicio.
     *
     * @param \DateTime $fcInicio
     *
     * @return Ejercicio
     */
    public function setFcInicio($fcInicio) {
        $this->fcInicio = $fcInicio;

        return $this;
    }

    /**
     * Get fcInicio.
     *
     * @return \DateTime
     */
    public function getFcInicio() {
        return $this->fcInicio;
    }

    /**
     * Set fcFin.
     *
     * @param \DateTime $fcFin
     *
     * @return Ejercicio
     */
    public function setFcFin($fcFin) {
        $this->fcFin = $fcFin;

        return $this;
    }

    /**
     * Get fcFin.
     *
     * @return \DateTime
     */
    public function getFcFin() {
        return $this->fcFin;
    }


    /**
     * Set ejercicio.
     *
     * @param \AppBundle\Entity\Ejercicio|null $ejercicio
     *
     * @return Trimestre
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
    
    public function __toString() {
        return $this->descripcion;
    }
}
