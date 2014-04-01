<?php

namespace Drugstore\PrincipalBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Drugstore\PrincipalBundle\Entity\MedicamentXactiveIngredient;

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
     * 
     * @var integer $id
     */
    protected $id;

	/**
	 * @ORM\Column(type="string", length=30)
	 * @Assert\NotBlank()
	 * @var string $nombre
	 */ 
    protected $nombre;
    
    /**
	 * @ORM\Column(type="string", length=8)
	 */
    protected $numSerie;

	/**
	 * @ORM\Column(type="string", length=10)
	 * @Assert\NotBlank()
	 * @var integer $precioUnitario
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
	 * @ORM\Column(type="integer")
	 */
	protected $cantidad;
	
	/**
	 * @ORM\Column(type="integer")
	 * @Assert\NotBlank()
	 */
	protected $stockMaximo;
	
	/**
	 * @ORM\Column(type="integer")
	 * @Assert\NotBlank()
	 */
	protected $stockMinimo;
    
    /**
     * @ORM\OneToMany(targetEntity="MedicamentXactiveIngredient", mappedBy="medicamento", cascade={"all"}, orphanRemoval=true)
     * */
    protected $mpa;
    
    /**
     * @ORM\ManyToOne(targetEntity="Inventory")
     * @ORM\JoinColumn(name="inventario_id", referencedColumnName="id")
     * */
    protected $inventario;
    
    protected $principiosActivos;

    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->mpa = new \Doctrine\Common\Collections\ArrayCollection();
        $this->principiosActivos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->inventarios = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    public function __toString()
    {
        return $this->nombre;
    }
    
    public function getPrincipiosActivos()
    {
        $principiosActivos = new ArrayCollection();
        
        foreach($this->mpa as $p)
        {
            $principiosActivos[] = $p->getPrincipioActivo();
        }

        return $principiosActivos;
    }

    public function setPrincipiosActivos($principiosActivos)
    {
        foreach($principiosActivos as $p)
        {
            $mpa = new MedicamentXactiveIngredient();

            $mpa->setMedicamento($this);
            $mpa->setPrincipioActivo($p);

            $this->addMpa($mpa);
        }

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
     * Set id
     *
     * @return integer 
     */
    public function setId($id)
    {
        $this->id = $id;
        
        return $this;
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
     * Add mpa
     *
     * @param \Drugstore\PrincipalBundle\Entity\MedicamentXactiveIngredient $mpa
     * @return Medicament
     */
    public function addMpa(\Drugstore\PrincipalBundle\Entity\MedicamentXactiveIngredient $mpa)
    {
        $this->mpa[] = $mpa;

        return $this;
    }

    /**
     * Remove mpa
     *
     * @param \Drugstore\PrincipalBundle\Entity\MedicamentXactiveIngredient $mpa
     */
    public function removeMpa(\Drugstore\PrincipalBundle\Entity\MedicamentXactiveIngredient $mpa)
    {
        $this->mpa->removeElement($mpa);
    }

    /**
     * Get mpa
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMpa()
    {
        return $this->mpa;
    }
    
    /**
     * Set mpa
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function setMpa($mpa)
    {
        return $this->mpa = $mpa;
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
     * Set numDosis
     *
     * @param string $numDosis
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
     * @return string 
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
     * Set cantidad
     *
     * @param integer $cantidad
     * @return Medicament
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
     * Set stockMaximo
     *
     * @param integer $stockMaximo
     * @return Medicament
     */
    public function setStockMaximo($stockMaximo)
    {
        $this->stockMaximo = $stockMaximo;

        return $this;
    }

    /**
     * Get stockMaximo
     *
     * @return integer 
     */
    public function getStockMaximo()
    {
        return $this->stockMaximo;
    }

    /**
     * Set stockMinimo
     *
     * @param integer $stockMinimo
     * @return Medicament
     */
    public function setStockMinimo($stockMinimo)
    {
        $this->stockMinimo = $stockMinimo;

        return $this;
    }

    /**
     * Get stockMinimo
     *
     * @return integer 
     */
    public function getStockMinimo()
    {
        return $this->stockMinimo;
    }

    /**
     * Set inventarios
     *
     * @param \Drugstore\PrincipalBundle\Entity\Inventory $inventarios
     * @return Medicament
     */
    public function setInventarios(\Drugstore\PrincipalBundle\Entity\Inventory $inventarios = null)
    {
        $this->inventarios = $inventarios;

        return $this;
    }

    /**
     * Get inventarios
     *
     * @return \Drugstore\PrincipalBundle\Entity\Inventory 
     */
    public function getInventarios()
    {
        return $this->inventarios;
    }

    /**
     * Set inventario
     *
     * @param \Drugstore\PrincipalBundle\Entity\Inventory $inventario
     * @return Medicament
     */
    public function setInventario(\Drugstore\PrincipalBundle\Entity\Inventory $inventario = null)
    {
        $this->inventario = $inventario;

        return $this;
    }

    /**
     * Get inventario
     *
     * @return \Drugstore\PrincipalBundle\Entity\Inventory 
     */
    public function getInventario()
    {
        return $this->inventario;
    }
}
