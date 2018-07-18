<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cliente
 *
 * @ORM\Table(name="clientes",
 *             uniqueConstraints={@ORM\UniqueConstraint(name="nif_uk", columns={"nif"})})
 * 
 * @ORM\Entity
 */
class Cliente {

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
     * @ORM\Column(name="nif", type="string", length=10, nullable=true)
     */
    private $nif;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255, nullable=false)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="apellidos", type="string", length=255, nullable=true)
     */
    private $apellidos;

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

    /**
     * var string 
     * @ORM\Column(name="apenom", type="string", length=255, nullable=true)
     */
    private $apenom;

    /**
     * var string 
     * @ORM\Column(name="nombre_completo", type="string", length=255, nullable=true)
     */
    private $nombreCompleto;

    public function __toString() {
        $this->nombreCompleto = $this->nombre . ' ' . $this->apellidos;
        return $this->nombreCompleto;
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
     * Set nif
     *
     * @param string $nif
     *
     * @return Cliente
     */
    public function setNif($nif) {
        $this->nif = $nif;

        return $this;
    }

    /**
     * Get nif
     *
     * @return string
     */
    public function getNif() {
        return $this->nif;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Cliente
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
     * Set apellidos
     *
     * @param string $apellidos
     *
     * @return Cliente
     */
    public function setApellidos($apellidos) {
        $this->apellidos = $apellidos;

        return $this;
    }

    /**
     * Get apellidos
     *
     * @return string
     */
    public function getApellidos() {
        return $this->apellidos;
    }

    /**
     * Set domicilio
     *
     * @param string $domicilio
     *
     * @return Cliente
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
     * @return Cliente
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
     * @return Cliente
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
     * @return Cliente
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

    /**
     * Set apenom.
     *
     * @param string|null $apenom
     *
     * @return Cliente
     */
    public function setApenom($apenom = null) {
        $this->apenom = $apenom;

        return $this;
    }

    /**
     * Set nombreCompleto.
     *
     * @param string|null $nombreCompleto
     *
     * @return Cliente
     */
    public function setNombreCompleto($nombreCompleto = null) {
        
        $this->nombreCompleto = $nombreCompleto;

        return $this;
    }

    /**
     * Get apenom.
     *
     * @return string|null
     */
    public function getApenom() {
        return $this->apenom;
    }

    /**
     * Get nombreCompleto.
     *
     * @return string|null
     */
    public function getNombreCompleto() {
        return $this->nombreCompleto;
    }

}
