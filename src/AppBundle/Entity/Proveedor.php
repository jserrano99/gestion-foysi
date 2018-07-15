<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Proveedor
 *
 * @ORM\Table(name="proveedores",
 *             uniqueConstraints={@ORM\UniqueConstraint(name="cif_uk", columns={"cif"})})
 * 
 * @ORM\Entity
 */
class Proveedor {

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
     * @ORM\Column(name="cif", type="string", length=10, nullable=false)
     */
    private $cif;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255, nullable=false)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="razonSocial", type="string", length=255, nullable=false)
     */
    private $razonSocial;

    /**
     * @var string
     *
     * @ORM\Column(name="domicilio", type="string", length=255, nullable=true)
     */
    private $domicilio;

    /**
     * @var string
     *
     * @ORM\Column(name="cdpostal", type="string", length=5, nullable=true)
     */
    private $cdpostal;

    /**
     * @var string
     *
     * @ORM\Column(name="movil", type="string", length=9, nullable=true)
     */
    private $movil;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;

    
    public function __toString() {
        return $this->razonSocial;
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
     * Set cif
     *
     * @param string $cif
     *
     * @return Proveedor
     */
    public function setCif($cif) {
        $this->cif = $cif;

        return $this;
    }

    /**
     * Get cif
     *
     * @return string
     */
    public function getCif() {
        return $this->cif;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Proveedor
     */
    public function setNombre($nombre) {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre() {
        return $this->nombre;
    }

    /**
     * Set razonSocial
     *
     * @param string $razonSocial
     *
     * @return Proveedor
     */
    public function setRazonSocial($razonSocial) {
        $this->razonSocial = $razonSocial;

        return $this;
    }

    /**
     * Get razonSocial
     *
     * @return string
     */
    public function getRazonSocial() {
        return $this->razonSocial;
    }

    /**
     * Set domicilio
     *
     * @param string $domicilio
     *
     * @return Proveedor
     */
    public function setDomicilio($domicilio) {
        $this->domicilio = $domicilio;

        return $this;
    }

    /**
     * Get domicilio
     *
     * @return string
     */
    public function getDomicilio() {
        return $this->domicilio;
    }

    /**
     * Set cdpostal
     *
     * @param string $cdpostal
     *
     * @return Proveedor
     */
    public function setCdpostal($cdpostal) {
        $this->cdpostal = $cdpostal;

        return $this;
    }

    /**
     * Get cdpostal
     *
     * @return string
     */
    public function getCdpostal() {
        return $this->cdpostal;
    }

    /**
     * Set movil
     *
     * @param string $movil
     *
     * @return Proveedor
     */
    public function setMovil($movil) {
        $this->movil = $movil;

        return $this;
    }

    /**
     * Get movil
     *
     * @return string
     */
    public function getMovil() {
        return $this->movil;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Proveedor
     */
    public function setEmail($email) {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail() {
        return $this->email;
    }

}
