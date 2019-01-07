<?php

namespace ClientesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @UniqueEntity(fields="distito", message="el valor no es válido")
 * @UniqueEntity(fields="direccion", message="la direccion ya existe")
 */
/**
 * Direccion
 *
 * @ORM\Table(name="direccion")
 * @ORM\Entity(repositoryClass="ClientesBundle\Repository\DireccionRepository")
 */
class Direccion
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
    * @ORM\ManyToMany(targetEntity="Cliente", mappedBy="direcciones")
    */
    private $cliente;
    
     /**
     * @ORM\OneToMany(targetEntity="\ProductosBundle\Entity\Producto", mappedBy="direccion")
     */
    private $producto;

     /**
     * @ORM\OneToMany(targetEntity="\IncidenciasBundle\Entity\Incidencia", mappedBy="direccion")
     */
    private $incidencia;
    
    /**
     * @var string
     *
     * @ORM\Column(name="direccion", type="string", length=255)
     */
    private $direccion;

    /**
     * @var string
     *
     * @ORM\Column(name="poblacion", type="string", length=255)
     */
    private $poblacion;

    /**
     * @var string
     *
     * @ORM\Column(name="codigoPostal", type="string", length=10)
     */
    private $codigoPostal;

     /**
     * @ORM\ManytoOne(targetEntity="Provincia", inversedBy="direccion")
     * @ORM\JoinColumn(name="provincia", referencedColumnName="id")
     */
    private $provincia;

     /**
     * @ORM\ManytoOne(targetEntity="Distrito", inversedBy="direccion")
     * @ORM\JoinColumn(name="distrito", referencedColumnName="id")
     */
    private $distrito;
    
    /**
     * @var string
     *
     * @ORM\Column(name="telefono", type="string", length=25, nullable=true)
     */
    private $telefono;

    /**
     * @var string
     *
     * @ORM\Column(name="contacto", type="string", length=255, nullable=true)
     */
    private $contacto;

     /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;
    
    /**
     * @var bool
     *
     * @ORM\Column(name="principal", type="boolean", nullable=true)
     */
    private $principal;

     /**
     * @var bool
     *
     * @ORM\Column(name="fiscal", type="boolean", nullable=true)
     */
    private $fiscal;
 
    /**
     * @var string
     *
     * @ORM\Column(name="observaciones", type="text", nullable=true)
     */
    private $observaciones;    




    public function __construct()
    {
        $this->cliente = new \Doctrine\Common\Collections\ArrayCollection();
        $this->producto = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set direccion
     *
     * @param string $direccion
     *
     * @return Direccion
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;

        return $this;
    }

    /**
     * Get direccion
     *
     * @return string
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * Set poblacion
     *
     * @param string $poblacion
     *
     * @return Direccion
     */
    public function setPoblacion($poblacion)
    {
        $this->poblacion = $poblacion;

        return $this;
    }

    /**
     * Get poblacion
     *
     * @return string
     */
    public function getPoblacion()
    {
        return $this->poblacion;
    }

    /**
     * Set codigoPostal
     *
     * @param string $codigoPostal
     *
     * @return Direccion
     */
    public function setCodigoPostal($codigoPostal)
    {
        $this->codigoPostal = $codigoPostal;

        return $this;
    }

     /**
     * Set provincia
     *
     * @param integer $provincia
     *
     * @return Direccion
     */
    public function setProvincia($provincia)
    {
        $this->provincia = $provincia;

        return $this;
    }

    /**
     * Get provincia
     *
     * @return int
     */
    public function getProvincia()
    {
        return $this->provincia;
    }

     /**
     * Set distrito
     *
     * @param integer $distrito
     *
     * @return Direcion
     */
    public function setDistrito($distrito)
    {
        $this->distrito = $distrito;

        return $this;
    }

    /**
     * Get distrito
     *
     * @return int
     */
    public function getDistrito()
    {
        return $this->distrito;
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
     * Set telefono
     *
     * @param string $telefono
     *
     * @return Direccion
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return string
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set contacto
     *
     * @param string $contacto
     *
     * @return Direccion
     */
    public function setContacto($contacto)
    {
        $this->contacto = $contacto;

        return $this;
    }

    /**
     * Get contacto
     *
     * @return string
     */
    public function getContacto()
    {
        return $this->contacto;
    }
    
     /**
     * Set email
     *
     * @param string $email
     *
     * @return Direccion
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
     * @return Direccion
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
     * Add cliente
     *
     * @param \ClientesBundle\Entity\Cliente $cliente
     *
     * @return Direccion
     */
    public function addCliente(\ClientesBundle\Entity\Cliente $cliente)
    {
        $this->cliente[] = $cliente;
        return $this;
    }
    /**
     * Remove cliente
     *
     * @param \ClientesBundle\Entity\Cliente $cliente
     */
    public function removeCliente(\ClientesBundle\Entity\Cliente $cliente)
    {
        $this->cliente->removeElement($cliente);
    }
    /**
     * Get cliente
     *
     * @return ArrayCollection
     */
    public function getCliente()
    {
        return $this->cliente;
    }   

     /**
     * Add producto
     *
     * @param \ProductosBundle\Entity\Producto $producto
     *
     * @return Direccion
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
     * @return ArrayCollection
     */
    public function getProducto()
    {
        return $this->producto;
    }   
    
     /**
     * Set principal
     *
     * @param boolean $principal
     *
     * @return Direccion
     */
    public function setPrincipal($principal)
    {
        $this->principal = $principal;

        return $this;
    }

    /**
     * Get principal
     *
     * @return bool
     */
    public function getPrincipal()
    {
        return $this->principal;
    }

    function __toString()
    {
        return $this->direccion;
    }    
    
}

