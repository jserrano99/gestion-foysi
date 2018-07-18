<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ejercicio
 *
 * @ORM\Table(name="ejercicio_actual")
 * @ORM\Entity
 */
class EjercicioActual {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

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
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set ejercicio.
     *
     * @param \AppBundle\Entity\Ejercicio|null $ejercicio
     *
     * @return EjercicioActual
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
