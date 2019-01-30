<?php

namespace IncidenciasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Incidencia
 *
 * @ORM\Table(name="incidencia")
 * @ORM\Entity(repositoryClass="IncidenciasBundle\Repository\IncidenciaRepository")
 */
class Incidencia
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
     * @ORM\ManyToOne(targetEntity="\ClientesBundle\Entity\Cliente", inversedBy="incidencia")
     * @ORM\JoinColumn(name="cliente", referencedColumnName="id")
     */
    private $cliente;

    /**
     * @ORM\ManyToOne(targetEntity="\ClientesBundle\Entity\Direccion", inversedBy="incidencia")
     * @ORM\JoinColumn(name="direccion", referencedColumnName="id")
     */
    private $direccion;

    /**
     * @ORM\ManyToOne(targetEntity="\ProductosBundle\Entity\Producto", inversedBy="incidencia")
     * @ORM\JoinColumn(name="producto", referencedColumnName="id")
     */
    private $producto;

     /**
     * @ORM\ManyToOne(targetEntity="\TrabajadoresBundle\Entity\Trabajadores", inversedBy="incidencia")
     * @ORM\JoinColumn(name="tecnico", referencedColumnName="id")
     */
    private $tecnico;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="date", nullable=true)
     */
    private $fecha;

     /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaResuelta", type="date", nullable=true)
     */
    private $fechaResuelta;
    
    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=255)
     */
    private $descripcion;

    /**
     * @var string
     *
     * @ORM\Column(name="importe", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $importe;

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
     * Set cliente
     *
     * @param integer $cliente
     *
     * @return Incidencia
     */
    public function setCliente($cliente)
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
     * Set direccion
     *
     * @param integer $direccion
     *
     * @return Incidencia
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
     * Set producto
     *
     * @param integer $producto
     *
     * @return Incidencia
     */
    public function setProducto($producto)
    {
        $this->producto = $producto;

        return $this;
    }

    /**
     * Get producto
     *
     * @return int
     */
    public function getProducto()
    {
        return $this->producto;
    }

        /**
     * Set tecnico
     *
     * @param integer $tecnico
     *
     * @return Incidencia
     */
    public function setTecnico($tecnico)
    {
        $this->tecnico = $tecnico;

        return $this;
    }

    /**
     * Get tecnico
     *
     * @return int
     */
    public function getTecnico()
    {
        return $this->tecnico;
    }
    
    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return Incidencia
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

     /**
     * Set fechaResuelta
     *
     * @param \DateTime $fechaResuelta
     *
     * @return Incidencia
     */
    public function setFechaResuelta($fechaResuelta)
    {
        $this->fechaResuelta = $fechaResuelta;

        return $this;
    }

    /**
     * Get fechaResuelta
     *
     * @return \DateTime
     */
    public function getFechaResuelta()
    {
        return $this->fechaResuelta;
    }
    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return Incidencia
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set importe
     *
     * @param string $importe
     *
     * @return Incidencia
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
     * Set planificada
     *
     * @param boolean $planificada
     *
     * @return Incidencia
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
    
    function __toString()
    {
        return $this->nombre;
    }    
    
    /**
     * Set observaciones
     *
     * @param string $observaciones
     *
     * @return Incidencia
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

