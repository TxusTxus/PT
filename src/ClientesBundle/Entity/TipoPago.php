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
    private $tipopago;


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
     * Set tipopago.
     *
     * @param string $tipopago
     *
     * @return TipoPago
     */
    public function setTipopago($tipopago)
    {
        $this->tipopago = $tipopago;

        return $this;
    }

    /**
     * Get tipopago.
     *
     * @return string
     */
    public function getTipopago()
    {
        return $this->tipopago;
    }
}
