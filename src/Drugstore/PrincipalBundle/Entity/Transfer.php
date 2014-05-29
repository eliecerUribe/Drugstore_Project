<?php

namespace Drugstore\PrincipalBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="traspaso_medicamento")
 */
class Transfer
{
	/**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
	protected $id;
	
	/**
	 * @ORM\Column(type="string", length=20)
	 */
	protected $idMedicamento;
	
	/**
	 * @ORM\Column(type="string", length=20)
	 */
	protected $nombreMedicamento;
	
	/**
	 * @ORM\Column(type="integer")
	 */
	protected $cantidad;
	
	/**
	 * @ORM\Column(type="string", length=20)
	 */
	protected $unidadCedente;
	
	/**
	 * @ORM\Column(type="string", length=20)
	 */
	protected $unidadDestino;
	
	/**
     * @ORM\Column(type="date")
     */
	protected $fechaTraspaso;
	
	/**
     * @ORM\Column(type="text")
     */
	protected $observaciones;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * Set nombreMedicamento
     *
     * @param string $nombreMedicamento
     * @return Transfer
     */
    public function setNombreMedicamento($nombreMedicamento)
    {
        $this->nombreMedicamento = $nombreMedicamento;

        return $this;
    }

    /**
     * Get nombreMedicamento
     *
     * @return string 
     */
    public function getNombreMedicamento()
    {
        return $this->nombreMedicamento;
    }

    /**
     * Set cantidad
     *
     * @param integer $cantidad
     * @return Transfer
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    /**
     * Get cantidad
     *
     * @return integer 
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * Set unidadCedente
     *
     * @param string $unidadCedente
     * @return Transfer
     */
    public function setUnidadCedente($unidadCedente)
    {
        $this->unidadCedente = $unidadCedente;

        return $this;
    }

    /**
     * Get unidadCedente
     *
     * @return string 
     */
    public function getUnidadCedente()
    {
        return $this->unidadCedente;
    }

    /**
     * Set unidadDestino
     *
     * @param string $unidadDestino
     * @return Transfer
     */
    public function setUnidadDestino($unidadDestino)
    {
        $this->unidadDestino = $unidadDestino;

        return $this;
    }

    /**
     * Get unidadDestino
     *
     * @return string 
     */
    public function getUnidadDestino()
    {
        return $this->unidadDestino;
    }

    /**
     * Set fechaTraspaso
     *
     * @param \DateTime $fechaTraspaso
     * @return Transfer
     */
    public function setFechaTraspaso($fechaTraspaso)
    {
        $this->fechaTraspaso = $fechaTraspaso;

        return $this;
    }

    /**
     * Get fechaTraspaso
     *
     * @return \DateTime 
     */
    public function getFechaTraspaso()
    {
        return $this->fechaTraspaso;
    }

    /**
     * Set observaciones
     *
     * @param string $observaciones
     * @return Transfer
     */
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;

        return $this;
    }

    /**
     * Get observaciones
     *
     * @return string 
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }

    /**
     * Set idMedicamento
     *
     * @param integer $idMedicamento
     * @return Transfer
     */
    public function setIdMedicamento($idMedicamento)
    {
        $this->idMedicamento = $idMedicamento;

        return $this;
    }

    /**
     * Get idMedicamento
     *
     * @return integer 
     */
    public function getIdMedicamento()
    {
        return $this->idMedicamento;
    }
}
