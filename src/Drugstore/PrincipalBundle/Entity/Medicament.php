<?php

namespace Drugstore\PrincipalBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Drugstore\PrincipalBundle\Entity\MedicamentXactiveIngredient;

/**
 * @ORM\Entity
 * @ORM\Table(name="medicament_")
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
	 * @ORM\Column(type="string", length=10)
	 * @Assert\NotBlank()
	 * @var integer $precioUnitario
	 */
    protected $precioUnitario;
    
    /**
     * @ORM\OneToMany(targetEntity="MedicamentXactiveIngredient", mappedBy="medicamento", cascade={"all"}, orphanRemoval=true)
     * */
    protected $mpa;
    
    protected $principiosActivos;

    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->mpa = new \Doctrine\Common\Collections\ArrayCollection();
        $this->principiosActivos = new \Doctrine\Common\Collections\ArrayCollection();
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
}
