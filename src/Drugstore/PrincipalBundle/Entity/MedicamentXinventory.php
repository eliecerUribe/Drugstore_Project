<?php

namespace Drugstore\PrincipalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="medicamentoXinventario")
 */
class MedicamentXinventory
{
	/**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
	protected $id;
	
	/**
	 * @ORM\Column(type="integer")
	 */
	protected $cantidad;
	
	/**
	 * @ORM\Column(type="integer")
	 */
	protected $stockMaximo;
	
	/**
	 * @ORM\Column(type="integer")
	 */
	protected $stockMinimo;
	
	/**
	 * @ORM\ManyToOne(targetEntity="Medicament", inversedBy="inventarios")
	 */ 
	protected $medicamento;
	
	/**
	 * @ORM\ManyToOne(targetEntity="Inventory", inversedBy="medicamentos")
	 */ 
	protected $inventario;
	
	public function __construct()
    {
        $this->inventario = new ArrayCollection();
        $this->medicamento = new ArrayCollection();
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
     * Set cantidad
     *
     * @param integer $cantidad
     * @return MedicamentXinventory
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
     * @return MedicamentXinventory
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
     * @return MedicamentXinventory
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
     * Set medicamento
     *
     * @param \Drugstore\PrincipalBundle\Entity\Medicament $medicamento
     * @return MedicamentXinventory
     */
    public function setMedicamento(\Drugstore\PrincipalBundle\Entity\Medicament $medicamento = null)
    {
        $this->medicamento = $medicamento;

        return $this;
    }

    /**
     * Get medicamento
     *
     * @return \Drugstore\PrincipalBundle\Entity\Medicament 
     */
    public function getMedicamento()
    {
        return $this->medicamento;
    }

    /**
     * Set inventario
     *
     * @param \Drugstore\PrincipalBundle\Entity\Inventory $inventario
     * @return MedicamentXinventory
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
