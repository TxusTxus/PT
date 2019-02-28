<?php

namespace AlbaranesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Albaran
 *
 * @ORM\Table(name="albaran")
 * @ORM\Entity(repositoryClass="AlbaranesBundle\Repository\AlbaranRepository")
 */
class Albaran
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
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="date")
     */
    private $fecha;

    /**
     * @ORM\ManyToOne(targetEntity="ClientesBundle\Entity\Cliente", inversedBy="albaran")
     * @ORM\JoinColumn(name="cliente", referencedColumnName="id")
     */
    private $cliente;

     /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Conceptos", inversedBy="albaran", cascade={"persist", "remove"})
     * @ORM\JoinTable(name="albaran_conceptos",
     *                      joinColumns={@ORM\JoinColumn(name="albaran_id", referencedColumnName="id")},
     *                      inverseJoinColumns={@ORM\JoinColumn(name="concepto_id", referencedColumnName="id")})
     */
    private $concepto;

    /**
     * @var string|null
     *
     * @ORM\Column(name="total", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $total;

    /**
     * @var int|null
     *
     * @ORM\Column(name="IVA", type="integer", nullable=true)
     */
    private $iVA;

    /**
     * @ORM\ManytoOne(targetEntity="ClientesBundle\Entity\TipoPago", inversedBy="albaran")
     * @ORM\JoinColumn(name="TipoPago", referencedColumnName="id")
     */
    private $tipoPago;

    /**
     * @ORM\ManyToOne(targetEntity="TrabajadoresBundle\Entity\Trabajadores", inversedBy="albaran")
     * @ORM\JoinColumn(name="trabajador", referencedColumnName="id")
     */
    private $trabajador;

     /**
     * @var bool
     *
     * @ORM\Column(name="Impreso", type="boolean", nullable=true)
     */
    private $impreso;     

     /**
     * Constructor
     */
    public function __construct()
    {
        $this->concepto = new \Doctrine\Common\Collections\ArrayCollection();
        $this->tipoPago =  new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set fecha.
     *
     * @param \DateTime $fecha
     *
     * @return Albaran
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha.
     *
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set cliente
     *
     * @param \ClientesBundle\Entity\Cliente $cliente
     *
     * @return Albaran
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
     * Set total.
     *
     * @param string $total
     *
     * @return Albaran
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Get total.
     *
     * @return string
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Set iVA.
     *
     * @param string|null $iVA
     *
     * @return Albaran
     */
    public function setIVA($iVA = null)
    {
        $this->iVA = $iVA;

        return $this;
    }

    /**
     * Get iVA.
     *
     * @return string|null
     */
    public function getIVA()
    {
        return $this->iVA;
    }

    /**
     * Set tipoPago
     *
     * @param integer $tipoPago
     *
     * @return Albaran
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
     * Set trabajador.
     *
     * @param int $trabajador
     *
     * @return Albaran
     */
    public function setTrabajador($trabajador)
    {
        $this->trabajador = $trabajador;

        return $this;
    }

    /**
     * Get trabajador.
     *
     * @return int
     */
    public function getTrabajador()
    {
        return $this->trabajador;
    }
    
    
     /**
     * Add concepto
     *
     * @param \AlbaranesBundle\Entity\Conceptos $concepto
     *
     * @return Albaran
     */
    public function addConcepto(\AlbaranesBundle\Entity\Conceptos $concepto)
    {
        $this->concepto[] = $concepto;

        return $this;
    }

    /**
     * Remove concepto
     *
     * @param \AlbaranesBundle\Entity\Conceptos $concepto
     */
    public function removeConcepto(\AlbaranesBundle\Entity\Conceptos $concepto)
    {
        $this->concepto->removeElement($concepto);
    }

    /**
     * Get accion
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getConcepto()
    {
        return $this->concepto;
    }
    
    
     /**
     * Set impreso
     *
     * @param boolean $impreso
     *
     * @return Albaran
     */
    public function setImpreso($impreso)
    {
        $this->impreso = $impreso;
        return $this;
    }
    
    /**
     * Get impreso
     *
     * @return bool
     */
    public function getImpreso()
    {
        return $this->impreso;
    } 
}
