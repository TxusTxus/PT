<?php

namespace PartesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Partes
 *
 * @ORM\Table(name="partes")
 * @ORM\Entity(repositoryClass="PartesBundle\Repository\PartesRepository")
 */
class Partes
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

//    /**
//     * @ORM\ManyToOne(targetEntity="EmpresasBundle\Entity\Empresa", inversedBy="parte")
//     * @ORM\JoinColumn(name="empresa", referencedColumnName="id")
//     */
//    private $empresa;
    
     /**
     * @var int
     *
     * @ORM\Column(name="empresa", type="integer")
     */   
    private $empresa;

    /**
     * @ORM\ManyToOne(targetEntity="ClientesBundle\Entity\Cliente", inversedBy="parte")
     * @ORM\JoinColumn(name="cliente", referencedColumnName="id")
     */
    private $cliente;

    /**
     * @ORM\ManyToOne(targetEntity="TrabajadoresBundle\Entity\Trabajadores", inversedBy="parte")
     * @ORM\JoinColumn(name="trabajador", referencedColumnName="id")
     */
    private $trabajador;

    /**
     * @ORM\ManyToOne(targetEntity="ClientesBundle\Entity\Direccion", inversedBy="parte")
     * @ORM\JoinColumn(name="direccion", referencedColumnName="id")
     */
    private $direccion;    
    
    
     /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="\ProductosBundle\Entity\Producto", inversedBy="parte", cascade={"persist", "remove"})
     * @ORM\JoinTable(name="parte_productos",
     *                      joinColumns={@ORM\JoinColumn(name="parte_id", referencedColumnName="id")},
     *                      inverseJoinColumns={@ORM\JoinColumn(name="producto_id", referencedColumnName="id")})
     */
    private $producto;      
    

    /**
     * @var string
     *
     * @ORM\Column(name="importe", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $importe;

     /**
     * @var decimal
     *
     * @ORM\Column(name="IVA", type="decimal",precision = 3, scale=2)
     */
    private $IVA;
    
    /**
     * @var \Date
     *
     * @ORM\Column(name="fechaParte", type="date")
     */
    private $fechaParte;

    /**
     * @var \Time
     *
     * @ORM\Column(name="fechaEntrada", type="time")
     */
    private $fechaEntrada;

    /**
     * @var \Time
     *
     * @ORM\Column(name="fechaSalida", type="time", nullable=true)
     */
    private $fechaSalida;

    /**
     * @var string
     *
     * @ORM\Column(name="tiempo", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $tiempo;

    /**
     * @var bool
     *
     * @ORM\Column(name="material", type="boolean", nullable=true)
     */
    private $material;

    /**
     * @var bool
     *
     * @ORM\Column(name="cobrar", type="boolean", nullable=true)
     */
    private $cobrar;    
    
    /**
     * @var bool
     *
     * @ORM\Column(name="incidencia", type="integer", nullable=true)
     */
    private $incidencia;    
    
    /**
     * @var string
     *
     * @ORM\Column(name="firma", type="string", length=255, nullable=true)
     */
    private $firma;

    /**
     * @var string
     *
     * @ORM\Column(name="observaciones", type="string", length=255, nullable=true)
     */
    private $observaciones;


     /**
     * @var bool
     *
     * @ORM\Column(name="terminado", type="boolean", nullable=true)
     */
    private $terminado;
    
    
     /**
     * Constructor
     */
    public function __construct()
    {
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
     * Set empresa
     *
     * @param int $empresa
     *
     * @return Cliente
     */
    public function setEmpresa($empresa)
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
     * Set cliente
     *
     * @param \ClientesBundle\Entity\Cliente $cliente
     *
     * @return Partes
     */
    public function setCliente(\ClientesBundle\Entity\Cliente $cliente)
    {
        $this->cliente = $cliente;

        return $this;
    }

    /**
     * Get cliente
     *
     * @return int
     */
    public function getCliente()
    {
        return $this->cliente;
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
        $this->producto->add($producto);

        return $this;
    }

    /**
     * Remove image
     *
     * @param Image $producto
     */
    public function removeProducto(\ProductosBundle\Entity\Producto $producto)
    {
        $this->producto->removeElement($producto);
    }

    /**
     * Get productos
     *
     * @return ArrayCollection
     */
    public function getProducto()
    {
        return $this->producto;
    }  
    

    /**
     * Set importe
     *
     * @param string $importe
     *
     * @return Partes
     */
    public function setImporte($importe)
    {
        $this->importe = $importe;

        return $this;
    }

    /**
     * Get importe
     *
     * @return string
     */
    public function getImporte()
    {
        return $this->importe;
    }

     /**
     * Set IVA
     *
     * @param decimal $IVA
     *
     * @return Partes
     */
    public function setIVA($IVA)
    {
        $this->IVA = $IVA;
        return $this;
    }
   

    /**
     * Get IVA
     *
     * @return decimal
     */
    public function getIVA()
    {
        return $this->IVA;
    }  
    
    /**
     * Set trabajador
     *
     * @param \trabajadoresBundle\Entity\Trabajadores $trabajador
     *
     * @return Partes
     */
    public function setTrabajador($trabajador)
    {
        $this->trabajador = $trabajador;

        return $this;
    }

    /**
     * Get trabajador
     *
     * @return int
     */
    public function getTrabajador()
    {
        return $this->trabajador;
    }
    
    /**
     * Set direccion
     *
     * @param integer $direccion
     *
     * @return Partes
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;

        return $this;
    }

    /**
     * Get direccion
     *
     * @return int
     */
    public function getDireccion()
    {
        return $this->direccion;
    }
    


    /**
     * Set fechaParte
     *
     * @param \DateTime $fechaParte
     *
     * @return Partes
     */
    public function setFechaParte($fechaParte)
    {
        $this->fechaParte = $fechaParte;

        return $this;
    }

    /**
     * Get fechaParte
     *
     * @return \DateTime
     */
    public function getFechaParte()
    {
        return $this->fechaParte;
    }

    /**
     * Set fechaEntrada
     *
     * @param \DateTime $fechaEntrada
     *
     * @return Partes
     */
    public function setFechaEntrada($fechaEntrada)
    {
        $this->fechaEntrada = $fechaEntrada;

        return $this;
    }

    /**
     * Get fechaEntrada
     *
     * @return \DateTime
     */
    public function getFechaEntrada()
    {
        return $this->fechaEntrada;
    }

    /**
     * Set fechaSalida
     *
     * @param \DateTime $fechaSalida
     *
     * @return Partes
     */
    public function setFechaSalida($fechaSalida)
    {
        $this->fechaSalida = $fechaSalida;

        return $this;
    }

    /**
     * Get fechaSalida
     *
     * @return \DateTime
     */
    public function getFechaSalida()
    {
        return $this->fechaSalida;
    }

    /**
     * Set tiempo
     *
     * @param string $tiempo
     *
     * @return Partes
     */
    public function setTiempo($tiempo)
    {
        $this->tiempo = $tiempo;

        return $this;
    }

    /**
     * Get tiempo
     *
     * @return string
     */
    public function getTiempo()
    {
        return $this->tiempo;
    }

    /**
     * Set material
     *
     * @param boolean $material
     *
     * @return Partes
     */
    public function setMaterial($material)
    {
        $this->material = $material;

        return $this;
    }

    /**
     * Get material
     *
     * @return bool
     */
    public function getMaterial()
    {
        return $this->material;
    }

     /**
     * Set terminado
     *
     * @param boolean $terminado
     *
     * @return Partes
     */
    public function setTerminado($terminado)
    {
        $this->terminado = $terminado;

        return $this;
    }

    /**
     * Get terminado
     *
     * @return bool
     */
    public function getTerminado()
    {
        return $this->terminado;
    }
    
     /**
     * Set cobrar
     *
     * @param boolean $cobrar
     *
     * @return Partes
     */
    public function setCobrar($cobrar)
    {
        $this->cobrar = $cobrar;

        return $this;
    }

    /**
     * Get cobrar
     *
     * @return bool
     */
    public function getCobrar()
    {
        return $this->cobrar;
    }
    
    
    /**
     * Set incidencia
     *
     * @param intefer $incidencia
     *
     * @return Partes
     */
    public function setIncidencia($incidencia)
    {
        $this->incidencia = $incidencia;

        return $this;
    }

    /**
     * Get incidencia
     *
     * @return int
     */
    public function getIncidencia()
    {
        return $this->incidencia;
    }    
    
    /**
     * Set firma
     *
     * @param string $firma
     *
     * @return Partes
     */
    public function setFirma($firma)
    {
        $this->firma = $firma;

        return $this;
    }

    /**
     * Get firma
     *
     * @return string
     */
    public function getFirma()
    {
        return $this->firma;
    }

    /**
     * Set observaciones
     *
     * @param string $observaciones
     *
     * @return Partes
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
}
