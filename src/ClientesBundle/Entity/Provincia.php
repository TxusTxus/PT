<?php

namespace ClientesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Provincia
 *
 * @ORM\Table(name="provincia")
 * @ORM\Entity(repositoryClass="ClientesBundle\Repository\ProvinciaRepository")
 */
class Provincia
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
     * @ORM\Column(name="Provincia", type="string", length=22)
     */
    private $provincia;

     /**
     * @ORM\OneToMany(targetEntity="Cliente", mappedBy="provincia")
     */
    protected $cliente;
    

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
     * Set provincia
     *
     * @param string $provincia
     *
     * @return Provincia
     */
    public function setProvincia($provincia)
    {
        $this->provincia = $provincia;

        return $this;
    }

    /**
     * Get provincia
     *
     * @return string
     */
    public function getProvincia()
    {
        return $this->provincia;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->cliente = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add cliente
     *
     * @param \\ClientesBundle\Entity\Cliente $cliente
     *
     * @return Provincia
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
    public function removeEmpresa(\ClientesBundle\Entity\Cliente $cliente)
    {
        $this->cliente->removeElement($cliente);
    }

    /**
     * Get cliente
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCliente()
    {
        return $this->cliente;
    }
    
    

    function __toString()
    {
        return $this->provincia;
    }

}
