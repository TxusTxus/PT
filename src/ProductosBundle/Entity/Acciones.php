<?php

namespace ProductosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Acciones
 *
 * @ORM\Table(name="acciones")
 * @ORM\Entity(repositoryClass="ProductosBundle\Repository\AccionesRepository")
 */
class Acciones
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="accion", type="string", length=255)
     */
    private $accion;

     /**
     * @ORM\OneToMany(targetEntity="Familia", mappedBy="acciones")
     */
    protected $familia;


     /**
     * Constructor
     */
    public function __construct()
    {
        $this->familia = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

 
    /**
     * Set accion.
     *
     * @param string $accion
     *
     * @return Acciones
     */
    public function setAccion($accion)
    {
        $this->accion = $accion;

        return $this;
    }

    /**
     * Get accion.
     *
     * @return string
     */
    public function getAccion()
    {
        return $this->accion;
    }
    
        
    /**
     * Add familia
     *
     * @param \ProductosBundle\Entity\Familia $familia
     *
     * @return Familia
     */
    public function addFamilia(\ProductosBundle\Entity\Familia $familia)
    {
        $this->familia[] = $familia;

        return $this;
    }

    /**
     * Remove familia
     *
     * @param \ProductosBundle\Entity\Familia $familia
     */
    public function removeFamilia(\ProductosBundle\Entity\Familia $familia)
    {
        $this->familia->removeElement($familia);
    }

    /**
     * Get producto
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFamilia()
    {
        return $this->familia;
    }

    
    function __toString()
    {
        return $this->accion;
    }   
}
