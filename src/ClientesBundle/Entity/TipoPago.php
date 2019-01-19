<?php

namespace ClientesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TipoPago
 *
 * @ORM\Table(name="tipo_pago")
 * @ORM\Entity(repositoryClass="ClientesBundle\Repository\TipoPagoRepository")
 */
class TipoPago
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
     * @ORM\Column(name="tipopago", type="string", length=30)
     */
    private $tipoPago;

     /**
     * @ORM\OneToMany(targetEntity="Cliente", mappedBy="tipoPago")
     */
    protected $cliente;

    
     /**
     * Constructor
     */
    public function __construct()
    {
        $this->cliente = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set tipoPago.
     *
     * @param string $tipoPago
     *
     * @return TipoPago
     */
    public function setTipoPago($tipoPago)
    {
        $this->tipoPago = $tipoPago;

        return $this;
    }

    /**
     * Get tipopago.
     *
     * @return string
     */
    public function getTipopago()
    {
        return $this->tipoPago;
    }
    
     /**
     * Add cliente
     *
     * @param \ClientesBundle\Entity\Cliente $cliente
     *
     * @return TipoPago
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
        return $this->tipoPago;
    }   
    
}
