<?php

namespace EmpresasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Empresa
 *
 * @ORM\Table(name="empresa")
 * @ORM\Entity(repositoryClass="EmpresasBundle\Repository\EmpresaRepository")
 */
class Empresa
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
     * @ORM\Column(name="nombre", type="string", length=255, unique=true)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="imagen", type="string", length=255, nullable=true)
     */
    private $imagen;
    
     /**
     * @ORM\ManyToOne(targetEntity="Estado", inversedBy="empresa")
     * @ORM\JoinColumn(name="estado", referencedColumnName="id")
     */
    private $estado;

    /**
     * @ORM\OneToMany(targetEntity="UsuariosBundle\Entity\User", mappedBy="empresa")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="ClientesBundle\Entity\Cliente", mappedBy="empresa")
     */
    private $cliente;

    /**
     * @ORM\OneToMany(targetEntity="TrabajadoresBundle\Entity\Trabajadores", mappedBy="empresa")
     */
    private $trabajadores;


    
    
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
     * @return Empresa
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
     * Set imagen
     *
     * @param string $imagen
     *
     * @return Empresa
     */
    public function setImagen($imagen)
    {
        $this->imagen = $imagen;

        return $this;
    }

    /**
     * Get imagen
     *
     * @return string
     */
    public function getImagen()
    {
        return $this->imagen;
    }

    
    /**
     * Set estado.
     *
     * @param \EmpresasBundle\Entity\Estado|null $estado
     *
     * @return Empresa
     */
    public function setEstado(\EmpresasBundle\Entity\Estado $estado = null)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado.
     *
     * @return \EmpresasBundle\Entity\Estado|null
     */
    public function getEstado()
    {
        return $this->estado;
    }
    
    
    function __toString()
    {
        return $this->nombre;
    }
}

