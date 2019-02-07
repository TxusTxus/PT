<?php

namespace ProductosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Familia
 *
 * @ORM\Table(name="familia")
 * @ORM\Entity(repositoryClass="ProductosBundle\Repository\FamiliaRepository")
 */
class Familia
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
     * @ORM\Column(name="familia", type="string", length=255, unique=true)
     */
    private $familia;

//    /**
//     * @var string|null
//     *
//     * @ORM\Column(name="acciones", type="string", length=255, nullable=true)
//     */
//    private $acciones;

     /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Acciones", inversedBy="familia", cascade={"persist", "remove"})
     * @ORM\JoinTable(name="familia_accion",
     *                      joinColumns={@ORM\JoinColumn(name="familia_id", referencedColumnName="id")},
     *                      inverseJoinColumns={@ORM\JoinColumn(name="accion_id", referencedColumnName="id")})
     */
    private $accion;
     /**
     * @ORM\OneToMany(targetEntity="Producto", mappedBy="familia")
     */
    protected $producto; 

    
     /**
     * Constructor
     */
    public function __construct()
    {
        $this->producto = new \Doctrine\Common\Collections\ArrayCollection();
        $this->accion = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set familia.
     *
     * @param string $familia
     *
     * @return Familia
     */
    public function setFamilia($familia)
    {
        $this->familia = $familia;

        return $this;
    }

    /**
     * Get familia.
     *
     * @return string
     */
    public function getFamilia()
    {
        return $this->familia;
    }

//    /**
//     * Set acciones.
//     *
//     * @param string|null $acciones
//     *
//     * @return Familia
//     */
//    public function setAcciones($acciones = null)
//    {
//        $this->acciones = $acciones;
//
//        return $this;
//    }
//
//    /**
//     * Get acciones.
//     *
//     * @return string|null
//     */
//    public function getAcciones()
//    {
//        return $this->acciones;
//    }
    
    /**
     * Add producto
     *
     * @param \ProductosBundle\Entity\Producto $producto
     *
     * @return Familia
     */
    public function addProducto(\ProductosBundle\Entity\Producto $producto)
    {
        $this->producto[] = $producto;

        return $this;
    }

    /**
     * Remove producto
     *
     * @param \ProductosBundle\Entity\Producto $producto
     */
    public function removeProducto(\ProductosBundle\Entity\Producto $producto)
    {
        $this->producto->removeElement($producto);
    }

    /**
     * Get producto
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProducto()
    {
        return $this->producto;
    }

    /**
     * Add accion
     *
     * @param \ProductosBundle\Entity\Accion $accion
     *
     * @return Familia
     */
    public function addAccion(\ProductosBundle\Entity\Acciones $accion)
    {
        $this->accion[] = $accion;

        return $this;
    }

    /**
     * Remove accion
     *
     * @param \ProductosBundle\Entity\Accion $accion
     */
    public function removeAccion(\ProductosBundle\Entity\Acciones $accion)
    {
        $this->accion->removeElement($accion);
    }

    /**
     * Get accion
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAccion()
    {
        return $this->accion;
    }
    
    
    function __toString()
    {
        return $this->familia;
    }
}
