<?php

namespace ClientesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Distrito
 *
 * @ORM\Table(name="distrito")
 * @ORM\Entity(repositoryClass="ClientesBundle\Repository\DistritoRepository")
 */
class Distrito
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
     * @ORM\Column(name="distrito", type="string", length=255, unique=true)
     */
    private $distrito;

    /**
     * @var string
     *
     * @ORM\Column(name="observacion", type="string", length=255, nullable=true)
     */
    private $observacion;


     /**
     * @ORM\OneToMany(targetEntity="Direccion", mappedBy="distrito")
     */
    protected $direccion;    
 
    
     /**
     * Constructor
     */
    public function __construct()
    {
        $this->direccion = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    function __toString()
    {
        return $this->distrito;
    }
    
    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set distrito
     *
     * @param string $distrito
     *
     * @return Distrito
     */
    public function setDistrito($distrito)
    {
        $this->distrito = $distrito;

        return $this;
    }

    /**
     * Get distrito
     *
     * @return string
     */
    public function getDistrito()
    {
        return $this->distrito;
    }

    /**
     * Set observacion
     *
     * @param string $observacion
     *
     * @return Distrito
     */
    public function setObservacion($observacion)
    {
        $this->observacion = $observacion;

        return $this;
    }

    /**
     * Get observacion
     *
     * @return string
     */
    public function getObservacion()
    {
        return $this->observacion;
    }
    
    


    /**
     * Add direccion
     *
     * @param \ClientesBundle\Entity\Direccion $direccion
     *
     * @return Distrito
     */
    public function addDireccion(\ClientesBundle\Entity\Direccion $direccion)
    {
        $this->direccion[] = $direccion;

        return $this;
    }

    /**
     * Remove direccion
     *
     * @param \ClientesBundle\Entity\Direccion $direccion
     */
    public function removeDireccion(\ClientesBundle\Entity\Direccion $direccion)
    {
        $this->direccion->removeElement($direccion);
    }

    /**
     * Get direccion
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDireccion()
    {
        return $this->direccion;
    }
    
}

