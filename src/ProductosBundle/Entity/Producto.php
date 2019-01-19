<?php

namespace ProductosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Producto
 *
 * @ORM\Table(name="producto")
 * @ORM\Entity(repositoryClass="ProductosBundle\Repository\ProductoRepository")
 */
class Producto
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
     * @ORM\Column(name="modelo", type="string", length=255)
     */
    private $modelo;

    /**
    * @ORM\ManyToMany(targetEntity="\ClientesBundle\Entity\Cliente", mappedBy="productos")
    */
    private $cliente;

    /**
     * @ORM\ManyToOne(targetEntity="\ClientesBundle\Entity\Direccion", inversedBy="producto")
     * @ORM\JoinColumn(name="direccion", referencedColumnName="id")
     */
    private $direccion;

     /**
     * @ORM\OneToMany(targetEntity="\IncidenciasBundle\Entity\Incidencia", mappedBy="producto")
     */
    private $incidencia;
    
    /**
    * @ORM\ManyToMany(targetEntity="\PartesBundle\Entity\Partes", mappedBy="producto")
    */
    private $parte;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="instalacion", type="date", nullable=true)
     */
    private $instalacion;

    /**
     * @var int
     *
     * @ORM\Column(name="periodicidad", type="integer", nullable=true)
     */
    private $periodicidad;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaNuevoMantenimiento", type="date", nullable=true)
     */
    private $fechaNuevoMantenimiento;
    
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaMantenimiento", type="date", nullable=true)
     */
    private $fechaMantenimiento;

     /**
     * @var decimal
     *
     * @ORM\Column(name="base", type="decimal",precision = 3, scale=2)
     */
    private $base;

     /**
     * @var decimal
     *
     * @ORM\Column(name="IVA", type="decimal",precision = 3, scale=2)
     */
    private $IVA;
    
     /**
     * @var bool
     *
     * @ORM\Column(name="Baja", type="boolean", nullable=true)
     */
    private $baja; 

     /**
     * @var bool
     *
     * @ORM\Column(name="Premium", type="boolean", nullable=true)
     */
    private $premium;
    
    /**
     * @var string
     *
     * @ORM\Column(name="observaciones", type="string", length=255, nullable=true)
     */
    private $observaciones;

    /**
     * @var bool
     *
     * @ORM\Column(name="planificada", type="boolean", nullable=true)
     */
    private $planificada;     
    

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
     * Set modelo
     *
     * @param string $modelo
     *
     * @return Producto
     */
    public function setModelo($modelo)
    {
        $this->modelo = $modelo;

        return $this;
    }

    /**
     * Get modelo
     *
     * @return string
     */
    public function getModelo()
    {
        return $this->modelo;
    }

     /**
     * Set direccion
     *
     * @param integer $direccion
     *
     * @return Producto
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
     * Set instalacion
     *
     * @param \DateTime $instalacion
     *
     * @return Producto
     */
    public function setInstalacion($instalacion)
    {
        $this->instalacion = $instalacion;

        return $this;
    }

    /**
     * Get instalacion
     *
     * @return \DateTime
     */
    public function getInstalacion()
    {
        return $this->instalacion;
    }

    /**
     * Set periodicidad
     *
     * @param integer $periodicidad
     *
     * @return Producto
     */
    public function setPeriodicidad($periodicidad)
    {
        $this->periodicidad = $periodicidad;

        return $this;
    }

    /**
     * Get periodicidad
     *
     * @return int
     */
    public function getPeriodicidad()
    {
        return $this->periodicidad;
    }

    /**
     * Set fechaMantenimiento
     *
     * @param \DateTime $fechaMantenimiento
     *
     * @return Producto
     */
    public function setFechaMantenimiento($fechaMantenimiento)
    {
        $this->fechaMantenimiento = $fechaMantenimiento;

        return $this;
    }

    /**
     * Get fechaMantenimiento
     *
     * @return \DateTime
     */
    public function getFechaMantenimiento()
    {
        return $this->fechaMantenimiento;
    }
    /**
     * Set fechaNuevoMantenimiento
     *
     * @param \DateTime $fechaNuevoMantenimiento
     *
     * @return Producto
     */
    public function setFechaNuevoMantenimiento($fechaNuevoMantenimiento)
    {
        $this->fechaNuevoMantenimiento = $fechaNuevoMantenimiento;

        return $this;
    }

    /**
     * Get fechaNuevoMantenimiento
     *
     * @return \DateTime
     */
    public function getFechaNuevoMantenimiento()
    {
        return $this->fechaNuevoMantenimiento;
    }
    
     /**
     * Set baja
     *
     * @param boolean $baja
     *
     * @return Producto
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
    
  

     /**
     * Set premium
     *
     * @param boolean $premium
     *
     * @return Producto
     */
    public function setPremium($premium)
    {
        $this->premium = $premium;
        return $this;
    }
   

    /**
     * Get premium
     *
     * @return bool
     */
    public function getPremium()
    {
        return $this->premium;
    }  

     /**
     * Set base
     *
     * @param decimal $base
     *
     * @return Producto
     */
    public function setBase($base)
    {
        $this->base = $base;
        return $this;
    }
   

    /**
     * Get base
     *
     * @return decimal
     */
    public function getBase()
    {
        return $this->base;
    }  

     /**
     * Set IVA
     *
     * @param decimal $IVA
     *
     * @return Producto
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
     * Set observaciones
     *
     * @param string $observaciones
     *
     * @return Producto
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
     * Set planificada
     *
     * @param boolean $planificada
     *
     * @return Producto
     */
    public function setPlanificada($planificada)
    {
        $this->planificada = $planificada;

        return $this;
    }

    /**
     * Get planificada
     *
     * @return bool
     */
    public function getPlanificada()
    {
        return $this->planificada;
    }
    
     /**
     * Add cliente
     *
     * @param \ClientesBundle\Entity\Cliente $cliente
     *
     * @return Producto
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
    
        function __toString()
    {
        return $this->modelo;
    }
}

