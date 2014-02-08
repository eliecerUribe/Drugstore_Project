<?php

namespace Drugstore\PrincipalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="inventario")
 */
class Inventory
{
	/**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
	protected $id;
	
	/**
	 * @ORM\Column(type="string", length=30)
	 */
	protected $descripcion;
	
	/**
	 * @ORM\Column(type="string", length=30)
	 */
	protected $ubicacion;
	
	/**
	 * @ORM\Column(type="string", length=8)
	 */
	protected $moneda;
	
	/**
	 * @ORM\Column(type="integer")
	 */
	protected $capacidad;
	
	/**
	 * @ORM\Column(type="string", length=30)
	 */
	protected $responsable;
	
	/**
     * @var \Drugstore\PrincipalBundle\Entity\MedicamentXinventory
     * 
     * @ORM\OneToMany(targetEntity="MedicamentXinventory", mappedBy="inventario")
     */
	private $medicamentos;
	
	public function __construct()
	{
		$this->medicamentos = new ArrayCollection();
	}
	
	public function getMedicamentos()
	{
		return $this->Medicamentos;
	}

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
     * Set descripcion
     *
     * @param string $descripcion
     * @return Inventory
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set ubicacion
     *
     * @param string $ubicacion
     * @return Inventory
     */
    public function setUbicacion($ubicacion)
    {
        $this->ubicacion = $ubicacion;

        return $this;
    }

    /**
     * Get ubicacion
     *
     * @return string 
     */
    public function getUbicacion()
    {
        return $this->ubicacion;
    }

    /**
     * Set moneda
     *
     * @param string $moneda
     * @return Inventory
     */
    public function setMoneda($moneda)
    {
        $this->moneda = $moneda;

        return $this;
    }

    /**
     * Get moneda
     *
     * @return string 
     */
    public function getMoneda()
    {
        return $this->moneda;
    }

    /**
     * Set capacidad
     *
     * @param integer $capacidad
     * @return Inventory
     */
    public function setCapacidad($capacidad)
    {
        $this->capacidad = $capacidad;

        return $this;
    }

    /**
     * Get capacidad
     *
     * @return integer 
     */
    public function getCapacidad()
    {
        return $this->capacidad;
    }

    /**
     * Set responsable
     *
     * @param string $responsable
     * @return Inventory
     */
    public function setResponsable($responsable)
    {
        $this->responsable = $responsable;

        return $this;
    }

    /**
     * Get responsable
     *
     * @return string 
     */
    public function getResponsable()
    {
        return $this->responsable;
    }

    /**
     * Add medicamentos
     *
     * @param \Drugstore\PrincipalBundle\Entity\Medicament $medicamentos
     * @return Inventory
     */
    public function addMedicamento(\Drugstore\PrincipalBundle\Entity\Medicament $medicamentos)
    {
        $this->medicamentos[] = $medicamentos;

        return $this;
    }

    /**
     * Remove medicamentos
     *
     * @param \Drugstore\PrincipalBundle\Entity\Medicament $medicamentos
     */
    public function removeMedicamento(\Drugstore\PrincipalBundle\Entity\Medicament $medicamentos)
    {
        $this->medicamentos->removeElement($medicamentos);
    }
}
