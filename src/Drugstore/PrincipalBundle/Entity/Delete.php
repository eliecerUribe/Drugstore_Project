<?php

namespace Drugstore\PrincipalBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="baja_medicamento")
 */
class Delete
{
	/**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
	protected $id;
	
	/**
	 * @ORM\Column(type="string", length=10)
	 */
	protected $codMedicamento;
	
	/**
	 * @ORM\Column(type="string", length=20)
	 */
	protected $nombreMedicamento;
	
	/**
	 * @ORM\Column(type="string", length=10)
	 */
	protected $causa;
	
	/**
     * @ORM\Column(type="date")
     */
	protected $fecha;
	
	/**
	 * @ORM\Column(type="integer")
	 */
	protected $cantidad;

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
     * Set idInventario
     *
     * @param integer $idInventario
     * @return Deletion
     */
    public function setIdInventario($idInventario)
    {
        $this->idInventario = $idInventario;

        return $this;
    }

    /**
     * Get idInventario
     *
     * @return integer 
     */
    public function getIdInventario()
    {
        return $this->idInventario;
    }

    /**
     * Set nombreMedicamento
     *
     * @param string $nombreMedicamento
     * @return Deletion
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
     * Set causa
     *
     * @param string $causa
     * @return Deletion
     */
    public function setCausa($causa)
    {
        $this->causa = $causa;

        return $this;
    }

    /**
     * Get causa
     *
     * @return string 
     */
    public function getCausa()
    {
        return $this->causa;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return Deletion
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime 
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set cantidad
     *
     * @param integer $cantidad
     * @return Deletion
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
     * Set codMedicamento
     *
     * @param string $codMedicamento
     * @return Delete
     */
    public function setCodMedicamento($codMedicamento)
    {
        $this->codMedicamento = $codMedicamento;

        return $this;
    }

    /**
     * Get codMedicamento
     *
     * @return string 
     */
    public function getCodMedicamento()
    {
        return $this->codMedicamento;
    }
}
