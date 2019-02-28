<?php

namespace AlbaranesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Conceptos
 *
 * @ORM\Table(name="conceptos")
 * @ORM\Entity(repositoryClass="AlbaranesBundle\Repository\ConceptosRepository")
 */
class Conceptos
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
     * @ORM\Column(name="concepto", type="string", length=255)
     */
    private $concepto;

    /**
     * @var int
     *
     * @ORM\Column(name="cantidad", type="integer")
     */
    private $cantidad;

    /**
     * @var string|null
     *
     * @ORM\Column(name="precio", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $precio;

     /**
     * @ORM\OneToMany(targetEntity="Albaran", mappedBy="concepto")
     */
    protected $albaran;


     /**
     * Constructor
     */
    public function __construct()
    {
        $this->albaran = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set concepto.
     *
     * @param string $concepto
     *
     * @return Conceptos
     */
    public function setConcepto($concepto)
    {
        $this->concepto = $concepto;

        return $this;
    }

    /**
     * Get concepto.
     *
     * @return string
     */
    public function getConcepto()
    {
        return $this->concepto;
    }

    /**
     * Set cantidad.
     *
     * @param int $cantidad
     *
     * @return Conceptos
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    /**
     * Get cantidad.
     *
     * @return int
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * Set precio.
     *
     * @param string|null $precio
     *
     * @return Conceptos
     */
    public function setPrecio($precio = null)
    {
        $this->precio = $precio;

        return $this;
    }

    /**
     * Get precio.
     *
     * @return string|null
     */
    public function getPrecio()
    {
        return $this->precio;
    }
    
    
            
    /**
     * Add albaran
     *
     * @param \AlbaranesBundle\Entity\Albaran $albaran
     *
     * @return Conceptos
     */
    public function addAlbaran(\AlbaranesBundle\Entity\Albaran $albaran)
    {
        $this->albaran[] = $albaran;

        return $this;
    }

    /**
     * Remove albaran
     *
     * @param \AlbaranesBundle\Entity\Albaran $albaran
     */
    public function removeAlbaran(\AlbaranesBundle\Entity\Albaran $albaran)
    {
        $this->albaran->removeElement($albaran);
    }

    /**
     * Get albaran
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAlbaran()
    {
        return $this->albaran;
    }

    
    function __toString()
    {
        return $this->concepto;
    }   
}
