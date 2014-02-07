<?php

namespace Drugstore\PrincipalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="principio_activo")
 */
class ActiveIngredient
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
	protected $nombre;
	
	/**
	 * @ORM\Column(type="float")
	 */
	protected $miligramos;
	
	/**
	 * @ORM\Column(type="string", length=50)
	 */ 
	protected $efecto;
	
	/**
     * @ORM\ManyToMany(targetEntity="Medicament", mappedBy="principiosActivos")
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
     * Set nombre
     *
     * @param string $nombre
     * @return ActiveIngredient
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
     * Set miligramos
     *
     * @param float $miligramos
     * @return ActiveIngredient
     */
    public function setMiligramos($miligramos)
    {
        $this->miligramos = $miligramos;

        return $this;
    }

    /**
     * Get miligramos
     *
     * @return float 
     */
    public function getMiligramos()
    {
        return $this->miligramos;
    }

    /**
     * Set efecto
     *
     * @param string $efecto
     * @return ActiveIngredient
     */
    public function setEfecto($efecto)
    {
        $this->efecto = $efecto;

        return $this;
    }

    /**
     * Get efecto
     *
     * @return string 
     */
    public function getEfecto()
    {
        return $this->efecto;
    }

    /**
     * Add medicamentos
     *
     * @param \Drugstore\PrincipalBundle\Entity\Medicament $medicamentos
     * @return ActiveIngredient
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
