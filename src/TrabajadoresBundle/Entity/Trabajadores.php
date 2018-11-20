<?php

namespace TrabajadoresBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trabajadores
 *
 * @ORM\Table(name="trabajadores")
 * @ORM\Entity(repositoryClass="TrabajadoresBundle\Repository\TrabajadoresRepository")
 */
class Trabajadores
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
     * @ORM\Column(name="dni", type="string", length=25)
     */
    private $dni;

    /**
     * @var string
     *
     * @ORM\Column(name="codigo", type="string", length=10)
     */
    private $codigo;

     /**
     * @var string
     *
     * @ORM\Column(name="codigoActivacion", type="string", length=9)
     */
    private $codigoActivacion;
    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @ORM\ManyToOne(targetEntity="EmpresasBundle\Entity\Empresa", inversedBy="trabajadores")
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
     * @var string
     *
     * @ORM\Column(name="observaciones", type="text", nullable=true)
     */
    private $observaciones;
    
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
     * Set dni
     *
     * @param string $dni
     *
     * @return Trabajadores
     */
    public function setDni($dni)
    {
        $this->dni = $dni;

        return $this;
    }

    /**
     * Get dni
     *
     * @return string
     */
    public function getDni()
    {
        return $this->dni;
    }

    /**
     * Set codigo
     *
     * @param string $codigo
     *
     * @return Trabajadores
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * Get codigo
     *
     * @return string
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

        /**
     * Set codigoActivacion
     *
     * @param string $codigoActivacion
     *
     * @return Trabajadores
     */
    public function setCodigoActivacion($codigoActivacion)
    {
        $this->codigoActivacion = $codigoActivacion;

        return $this;
    }

    /**
     * Get codigoActivacion
     *
     * @return string
     */
    public function getCodigoActivacion()
    {
        return $this->codigoActivacion;
    }
    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Trabajadores
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
     * Set empresa
     *
     * @param \EmpresasBundle\Entity\Empresa $empresa
     *
     * @return Trabajadores
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
     * Set baja
     *
     * @param boolean $baja
     *
     * @return Trabajadores
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
}

