<?php

namespace ClientesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cliente
 *
 * @ORM\Table(name="cliente")
 * @ORM\Entity(repositoryClass="ClientesBundle\Repository\ClienteRepository")
 */
class Cliente
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
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="razonSocial", type="string", length=255, nullable=true)
     */
    private $razonSocial;
    
     /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Direccion", inversedBy="cliente", cascade={"persist", "remove"})
     * @ORM\JoinTable(name="cliente_direccion",
     *                      joinColumns={@ORM\JoinColumn(name="cliente_id", referencedColumnName="id")},
     *                      inverseJoinColumns={@ORM\JoinColumn(name="direccion_id", referencedColumnName="id")})
     */
    private $direcciones;

     /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="\ProductosBundle\Entity\Producto", inversedBy="cliente", cascade={"persist", "remove"})
     * @ORM\JoinTable(name="cliente_producto",
     *                      joinColumns={@ORM\JoinColumn(name="cliente_id", referencedColumnName="id")},
     *                      inverseJoinColumns={@ORM\JoinColumn(name="producto_id", referencedColumnName="id")})
     */
    private $productos;
    
     /**
     * @ORM\OneToMany(targetEntity="\IncidenciasBundle\Entity\Incidencia", mappedBy="cliente")
     */
    private $incidencias;
//
//    /**
//     * @var string
//     *
//     * @ORM\Column(name="telefono", type="string", length=25)
//     */
//    private $telefono;
//
//    /**
//     * @var string
//     *
//     * @ORM\Column(name="contacto", type="string", length=255, nullable=true)
//     */
//    private $contacto;
//    
//    /**
//     * @var string
//     *
//     * @ORM\Column(name="direccion", type="string", length=255)
//     */
//    private $direccion;
//
//    /**
//     * @var int
//     *
//     * @ORM\Column(name="poblacion", type="string", length=255)
//     */
//    private $poblacion;
//
//    /**
//     * @ORM\ManytoOne(targetEntity="Provincia", inversedBy="cliente")
//     * @ORM\JoinColumn(name="provincia_id", referencedColumnName="id")
//     */
//    private $provincia;
//
//    /**
//     * @var string
//     *
//     * @ORM\Column(name="codigoPostal", type="string", length=10)
//     */
//    private $codigoPostal;

//    /**
//     * @var string
//     *
//     * @ORM\Column(name="email", type="string", length=255, nullable=true)
//     */
//    private $email;

    /**
     * @ORM\ManytoOne(targetEntity="TipoPago", inversedBy="cliente")
     * @ORM\JoinColumn(name="TipoPago", referencedColumnName="id")
     */
    private $tipoPago;
    
    /**
     * @var string
     *
     * @ORM\Column(name="observaciones", type="text", nullable=true)
     */
    private $observaciones;
    
    /**
     * @ORM\ManyToOne(targetEntity="EmpresasBundle\Entity\Empresa", inversedBy="cliente")
     * @ORM\JoinColumn(name="empresa", referencedColumnName="id")
     */
    private $empresa;

    /**
     * @var bool
     *
     * @ORM\Column(name="baja", type="boolean", nullable=true)
     */
    private $baja;


     /**
     * Constructor
     */
    public function __construct()
    {
        $this->direcciones = new \Doctrine\Common\Collections\ArrayCollection(); 
        $this->productos = new \Doctrine\Common\Collections\ArrayCollection(); 
        $this->incidencias = new \Doctrine\Common\Collections\ArrayCollection(); 
        $this->tipoPago =  new \Doctrine\Common\Collections\ArrayCollection(); 
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
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Cliente
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
     * Set razonSocial
     *
     * @param string razonSocial
     *
     * @return Cliente
     */
    public function setRazonSocial($razonSocial)
    {
        $this->razonSocial = $razonSocial;

        return $this;
    }

    /**
     * Get razonSocial
     *
     * @return string
     */
    public function getRazonSocial()
    {
        return $this->razonSocial;
    }
    
     /**
     * Add image
     *
     * @param Image $direccion
     *
     * @return Post
     */
    public function addDireccion(Direccion $direccion)
    {
        $this->direcciones->add($direccion);

        return $this;
    }

    /**
     * Remove image
     *
     * @param Image $direccion
     */
    public function removeDireccion(Direccion $direccion)
    {
        $this->direcciones->removeElement($direccion);
    }

    /**
     * Get direcciones
     *
     * @return ArrayCollection
     */
    public function getDirecciones()
    {
        return $this->direcciones;
    }    
 
     /**
     * Add image
     *
     * @param Image $producto
     *
     * @return Post
     */
    public function addProducto(\ProductosBundle\Entity\Producto $producto)
    {
        $this->productos->add($producto);

        return $this;
    }

    /**
     * Remove image
     *
     * @param Image $producto
     */
    public function removeProducto(\ProductosBundle\Entity\Producto $producto)
    {
        $this->productos->removeElement($producto);
    }

    /**
     * Get productos
     *
     * @return ArrayCollection
     */
    public function getProductos()
    {
        return $this->productos;
    }  
    

     /**
     * Add image
     *
     * @param Image $incidencias
     *
     * @return Post
     */
    public function addIncidencias(\IncidenciasBundle\Entity\Incidencia $incidencias)
    {
        $this->incidencias->add($incidencias);

        return $this;
    }

    /**
     * Remove image
     *
     * @param Image $incidencias
     */
    public function removeIncidencias(\IncidenciasBundle\Entity\Incidencia $incidencias)
    {
        $this->incidencias->removeElement($incidencias);
    }

    /**
     * Get incidencias
     *
     * @return ArrayCollection
     */
    public function getIncidencias()
    {
        return $this->incidencias;
    }  
    
    /**
     * Set poblacion
     *
     * @param integer $poblacion
     *
     * @return Cliente
     */
    public function setPoblacion($poblacion)
    {
        $this->poblacion = $poblacion;

        return $this;
    }

    /**
     * Get poblacion
     *
     * @return int
     */
    public function getPoblacion()
    {
        return $this->poblacion;
    }

    /**
     * Set tipoPago
     *
     * @param integer $tipoPago
     *
     * @return Cliente
     */
    public function setTipoPago($tipoPago)
    {
        $this->tipoPago = $tipoPago;

        return $this;
    }

    /**
     * Get tipoPago
     *
     * @return int
     */
    public function getTipoPago()
    {
        return $this->tipoPago;
    }

    /**
     * Set codigoPostal
     *
     * @param string $codigoPostal
     *
     * @return Cliente
     */
    public function setCodigoPostal($codigoPostal)
    {
        $this->codigoPostal = $codigoPostal;

        return $this;
    }

    /**
     * Get codigoPostal
     *
     * @return string
     */
    public function getCodigoPostal()
    {
        return $this->codigoPostal;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Cliente
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }
    
    /**
     * Set observaciones
     *
     * @param string $observaciones
     *
     * @return Cliente
     */
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;

        return $this;
    }

    /**
     * Get observaciones
     *
     * @return string
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }
    
    /**
     * Set empresa
     *
     * @param \EmpresasBundle\Entity\Empresa $empresa
     *
     * @return Cliente
     */
    public function setEmpresa(\EmpresasBundle\Entity\Empresa $empresa)
    {
        $this->empresa = $empresa;
        return $this;
    }
    /**
     * Get empresa
     *
     * @return int
     */
    public function getEmpresa()
    {
        return $this->empresa;
    }

    /**
     * Set baja
     *
     * @param boolean $baja
     *
     * @return Cliente
     */
    public function setBaja($baja)
    {
        $this->baja = $baja;

        return $this;
    }

    /**
     * Get baja
     *
     * @return bool
     */
    public function getBaja()
    {
        return $this->baja;
    }
    
    function __toString()
    {
        return $this->nombre;
    }
}

