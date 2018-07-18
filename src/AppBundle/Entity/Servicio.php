<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Servicio
 *
 * @ORM\Table(name="servicios")
 * @ORM\Entity
 */
class Servicio {

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
     * @var double
     *
     * @ORM\Column(name="importeUnitario", type="float", nullable=false)
     */
    private $importeUnitario;

	/**
     * @var double
     *
     * @ORM\Column(name="porcentajeIVA", type="float", nullable=false)
     */
    private $porcentajeIVA;
    /**
     * @var double
     *
     * @ORM\Column(name="cuotaIVA", type="float", nullable=false)
     */
    private $cuotaIVA;

    /**
     * @var double
     *
     * @ORM\Column(name="importeIVA", type="float", nullable=false)
     */
    private $importeIVA;

    /**
     * Get id
     * 
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return Servicio
     */
    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion() {
        return $this->descripcion;
    }

    /**
     * Set importeUnitario
     *
     * @param  $importeUnitario
     *
     * @return Servicio
     */
    public function setImporteUnitario($importeUnitario) {
        $this->importeUnitario = $importeUnitario;

        return $this;
    }

    /**
     * Get importeUnitario
     *
     * @return \double
     */
    public function getImporteUnitario() {
        return $this->importeUnitario;
    }

    /**
     * Set importeIVA.
     *
     * @param float $importeIVA
     *
     * @return Servicio
     */
    public function setImporteIVA($importeIVA) {
        $this->importeIVA = $importeIVA;

        return $this;
    }

    /**
     * Get importeIVA.
     *
     * @return float
     */
    public function getImporteIVA() {
        return $this->importeIVA;
    }

    public function __toString() {
        return $this->descripcion;
    }


    /**
     * Set cuotaIVA
     *
     * @param float $cuotaIVA
     *
     * @return Servicio
     */
    public function setCuotaIVA($cuotaIVA)
    {
        $this->cuotaIVA = $cuotaIVA;

        return $this;
    }

    /**
     * Get cuotaIVA
     *
     * @return float
     */
    public function getCuotaIVA()
    {
        return $this->cuotaIVA;
    }

    /**
     * Set porcentajeIVA.
     *
     * @param float $porcentajeIVA
     *
     * @return Servicio
     */
    public function setPorcentajeIVA($porcentajeIVA)
    {
        $this->porcentajeIVA = $porcentajeIVA;

        return $this;
    }

    /**
     * Get porcentajeIVA.
     *
     * @return float
     */
    public function getPorcentajeIVA()
    {
        return $this->porcentajeIVA;
    }
}
