<?php

namespace Drugstore\PrincipalBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="activeIngredient")
 */
class ActiveIngredient
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
	 * @var string $nombre
	 */ 
	protected $nombre;
	
	/**
     * @ORM\OneToMany(targetEntity="MedicamentXactiveIngredient", mappedBy="principioActivo", cascade={"all"} , orphanRemoval=true)
     * */
	protected $mpa;
	
	public function __construct()
	{
		
	}
	
	public function __toString()
	{
		return $this->nombre;
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
     * Add mpa
     *
     * @param \Drugstore\PrincipalBundle\Entity\MedicamentXactiveIngredient $mpa
     * @return ActiveIngredient
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
}
