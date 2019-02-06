<?php

namespace ProductosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TipoContrato
 *
 * @ORM\Table(name="tipo_contrato")
 * @ORM\Entity(repositoryClass="ProductosBundle\Repository\TipoContratoRepository")
 */
class TipoContrato
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
     * @ORM\Column(name="tipoContrato", type="string", length=255, unique=true)
     */
    private $tipoContrato;


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
     * Set tipoContrato.
     *
     * @param string $tipoContrato
     *
     * @return TipoContrato
     */
    public function setTipoContrato($tipoContrato)
    {
        $this->tipoContrato = $tipoContrato;

        return $this;
    }

    /**
     * Get tipoContrato.
     *
     * @return string
     */
    public function getTipoContrato()
    {
        return $this->tipoContrato;
    }
    
    function __toString()
    {
        return $this->tipoContrato;
    }
}
