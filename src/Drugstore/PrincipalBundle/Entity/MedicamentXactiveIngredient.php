<?php

namespace Drugstore\PrincipalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="m_pa")
 * @ORM\HasLifecycleCallbacks()
 */
class MedicamentXactiveIngredient
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
     * @ORM\ManyToOne(targetEntity="Medicament", inversedBy="mpa")
     * @ORM\JoinColumn(name="medicamento_id", referencedColumnName="id")
     * */
	protected $medicamento;
	
	/**
	 * @ORM\ManyToOne(targetEntity="ActiveIngredient", inversedBy="mpa")
	 * @ORM\JoinColumn(name="pa_id", referencedColumnName="id")
	 * */
	protected $principioActivo;
	
	/*
	  @ññORM\Column(type="float")
	 
	protected $miligramos;*/
	
	public function __construct()
    {
       // $this->principioActivo = new ArrayCollection();
       // $this->medicamento = new ArrayCollection();
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
