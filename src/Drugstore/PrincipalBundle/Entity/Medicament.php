<?php

namespace Drugstore\PrincipalBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="medicamento")
 */
class Medicament
{
	/**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
	
	/**
	 * @ORM\Column(type="string", length=8)
	 */
    protected $numSerie;

	/**
	 * @ORM\Column(type="string", length=30)
	 */ 
    protected $nombre;

	/**
	 * @ORM\Column(type="string", length=10)
	 */
    protected $precioUnitario;
    
    /**
	 * @ORM\Column(type="string", length=10)
	 */
    protected $numDosis;
    
    /**
	 * @ORM\Column(type="string", length=20)
	 */
    protected $laboratorio;
    
    /**
	 * @ORM\Column(type="string", length=10)
	 */
    protected $numLote;
    
    /**
     * @ORM\Column(type="date")
     */
    protected $fechaEmision;
    
    /**
     * @ORM\Column(type="date")
     */
    protected $fechaVencimiento;
    
    /**
	 * @ORM\Column(type="string", length=20)
	 */
    protected $tipoPresentacion;
    
    /**
     * @var \Drugstore\PrincipalBundle\Entity\MedicamentXactiveIngredient
     * 
     * @ORM\OneToMany(targetEntity="MedicamentXactiveIngredient", mappedBy="medicamento")
     * @ORM\OrderBy({"id" = "ASC"})
     */
    private $principiosActivos;
    
    /**
     * @var \Drugstore\PrincipalBundle\Entity\MedicamentXinventory
     * 
     * @ORM\OneToMany(targetEntity="MedicamentXinventory", mappedBy="medicamento")
     * @ORM\OrderBy({"id" = "ASC"})
     */
    private $inventarios;
    
    protected $miligramos;
 
    // ...
 
    public function getMiligramos()
    {
        return $this->miligramos;
    }
 
    /*public function setmedicamentXactiveIngredient(MedicamentXactiveIngredient $medicamentXactiveIngredient = null)
    {
        $this->medicamentXactiveIngredient = $medicamentXactiveIngredient;
    }*/
    
    public function setMiligramos($miligramos)
    {
        $this->miligramos = $miligramos;

        return $this;
    }
    
    public function __construct()
    {
        $this->principiosActivos = new ArrayCollection();
        $this->inventarios = new ArrayCollection();
    }
	
	public function getPrincipiosActivos()
	{
		return $this->principiosActivos;
	}
	
	public function setPrincipiosActivos($principiosActivos)
	{
		$this->principiosActivos = $principiosActivos;
		
		return $this;
	}
	
	public function getInventarios()
	{
		return $this->inventarios;
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
     * Set numSerie
     *
     * @param string $numSerie
     * @return Medicament
     */
    public function setNumSerie($numSerie)
    {
        $this->numSerie = $numSerie;

        return $this;
    }

    /**
     * Get numSerie
     *
     * @return string 
     */
    public function getNumSerie()
    {
        return $this->numSerie;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Medicament
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set precioUnitario
     *
     * @param string $precioUnitario
     * @return Medicament
     */
    public function setPrecioUnitario($precioUnitario)
    {
        $this->precioUnitario = $precioUnitario;

        return $this;
    }

    /**
     * Get precioUnitario
     *
     * @return string 
     */
    public function getPrecioUnitario()
    {
        return $this->precioUnitario;
    }

    /**
     * Set numDosis
     *
     * @param integer $numDosis
     * @return Medicament
     */
    public function setNumDosis($numDosis)
    {
        $this->numDosis = $numDosis;

        return $this;
    }

    /**
     * Get numDosis
     *
     * @return integer 
     */
    public function getNumDosis()
    {
        return $this->numDosis;
    }

    /**
     * Set laboratorio
     *
     * @param string $laboratorio
     * @return Medicament
     */
    public function setLaboratorio($laboratorio)
    {
        $this->laboratorio = $laboratorio;

        return $this;
    }

    /**
     * Get laboratorio
     *
     * @return string 
     */
    public function getLaboratorio()
    {
        return $this->laboratorio;
    }

    /**
     * Set numLote
     *
     * @param string $numLote
     * @return Medicament
     */
    public function setNumLote($numLote)
    {
        $this->numLote = $numLote;

        return $this;
    }

    /**
     * Get numLote
     *
     * @return string 
     */
    public function getNumLote()
    {
        return $this->numLote;
    }

    /**
     * Set fechaEmision
     *
     * @param \DateTime $fechaEmision
     * @return Medicament
     */
    public function setFechaEmision($fechaEmision)
    {
        $this->fechaEmision = $fechaEmision;

        return $this;
    }

    /**
     * Get fechaEmision
     *
     * @return \DateTime 
     */
    public function getFechaEmision()
    {
        return $this->fechaEmision;
    }

    /**
     * Set fechaVencimiento
     *
     * @param \DateTime $fechaVencimiento
     * @return Medicament
     */
    public function setFechaVencimiento($fechaVencimiento)
    {
        $this->fechaVencimiento = $fechaVencimiento;

        return $this;
    }

    /**
     * Get fechaVencimiento
     *
     * @return \DateTime 
     */
    public function getFechaVencimiento()
    {
        return $this->fechaVencimiento;
    }

    /**
     * Set tipoPresentacion
     *
     * @param string $tipoPresentacion
     * @return Medicament
     */
    public function setTipoPresentacion($tipoPresentacion)
    {
        $this->tipoPresentacion = $tipoPresentacion;

        return $this;
    }

    /**
     * Get tipoPresentacion
     *
     * @return string 
     */
    public function getTipoPresentacion()
    {
        return $this->tipoPresentacion;
    }

    /**
     * Add inventarios
     *
     * @param \Drugstore\PrincipalBundle\Entity\Inventory $inventarios
     * @return Medicament
     */
    public function addInventario(\Drugstore\PrincipalBundle\Entity\Inventory $inventarios)
    {
        $this->inventarios[] = $inventarios;

        return $this;
    }

    /**
     * Remove inventarios
     *
     * @param \Drugstore\PrincipalBundle\Entity\Inventory $inventarios
     */
    public function removeInventario(\Drugstore\PrincipalBundle\Entity\Inventory $inventarios)
    {
        $this->inventarios->removeElement($inventarios);
    }

    /**
     * Add principiosActivos
     *
     * @param \Drugstore\PrincipalBundle\Entity\ActiveIngredient $principiosActivos
     * @return Medicament
     */
    public function addPrincipiosActivo(\Drugstore\PrincipalBundle\Entity\ActiveIngredient $principiosActivos)
    {
        $this->principiosActivos[] = $principiosActivos;

        return $this;
    }

    /**
     * Remove principiosActivos
     *
     * @param \Drugstore\PrincipalBundle\Entity\ActiveIngredient $principiosActivos
     */
    public function removePrincipiosActivo(\Drugstore\PrincipalBundle\Entity\ActiveIngredient $principiosActivos)
    {
        $this->principiosActivos->removeElement($principiosActivos);
    }
}
