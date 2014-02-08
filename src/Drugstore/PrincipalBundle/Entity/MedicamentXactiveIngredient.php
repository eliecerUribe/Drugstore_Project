<?php

namespace Drugstore\PrincipalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="medicamentoXprincipioActivo")
 */
class MedicamentXactiveIngredient
{
	/**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
	protected $id;
	
	/**
	 * @ORM\Column(type="float")
	 */
	protected $miligramos;
	
	/**
     * @ORM\ManyToOne(targetEntity="Medicament", inversedBy="principiosActivos")
     */
	protected $medicamento;
	
	/**
	 * @ORM\ManyToOne(targetEntity="ActiveIngredient", inversedBy="medicamentos")
	 */
	protected $principioActivo;
	
	public function __construct()
    {
        $this->principioActivo = new ArrayCollection();
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
     * Set miligramos
     *
     * @param float $miligramos
     * @return MedicamentXactiveIngredient
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
     * Set medicamento
     *
     * @param \Drugstore\PrincipalBundle\Entity\Medicament $medicamento
     * @return MedicamentXactiveIngredient
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
     * Set principioActivo
     *
     * @param \Drugstore\PrincipalBundle\Entity\ActiveIngredient $principioActivo
     * @return MedicamentXactiveIngredient
     */
    public function setPrincipioActivo(\Drugstore\PrincipalBundle\Entity\ActiveIngredient $principioActivo = null)
    {
        $this->principioActivo = $principioActivo;

        return $this;
    }

    /**
     * Get principioActivo
     *
     * @return \Drugstore\PrincipalBundle\Entity\ActiveIngredient 
     */
    public function getPrincipioActivo()
    {
        return $this->principioActivo;
    }
}
