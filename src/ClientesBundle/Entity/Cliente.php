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
     * @ORM\Column(name="telefono", type="string", length=25)
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
     * @ORM\Column(name="direccion", type="string", length=255)
     */
    private $direccion;

    /**
     * @var int
     *
     * @ORM\Column(name="poblacion", type="string", length=255)
     */
    private $poblacion;

    /**
     * @ORM\ManytoOne(targetEntity="Provincia", inversedBy="cliente")
     * @ORM\JoinColumn(name="provincia_id", referencedColumnName="id")
     */
    private $provincia;

    /**
     * @var string
     *
     * @ORM\Column(name="codigoPostal", type="string", length=10)
     */
    private $codigoPostal;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;
    
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
     * Set telefono
     *
     * @param string $telefono
     *
     * @return Cliente
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
     * @return Cliente
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
     * Set direccion
     *
     * @param string $direccion
     *
     * @return Cliente
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
     * Set provincia
     *
     * @param integer $provincia
     *
     * @return Cliente
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
}

