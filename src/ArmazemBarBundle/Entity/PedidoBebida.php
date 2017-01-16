<?php

namespace ArmazemBarBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of PedidoBebida
 * @ORM\Table(name="pedido_bebida")
 * @ORM\Entity
 * @author Luciano
 */
class PedidoBebida extends BaseEntity
{
    
    /**
     * @var Pedido
     *
     * @ORM\ManyToOne(targetEntity="Pedido", inversedBy="pedidoBebidas")
     * @ORM\JoinColumn(name="pedido", referencedColumnName="id", nullable=false)
     */
    private $pedido;
    
    
    /**
     * @var Prato
     *
     * @ORM\ManyToOne(targetEntity="Bebida", inversedBy="pedidoBebidas")
     * @ORM\JoinColumn(name="prato", referencedColumnName="id", nullable=false)
     */
    private $bebida;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    private $quantidade = 0;

    
    public function getPedido()
    {
        return $this->pedido;
    }

    public function getBebida()
    {
        return $this->bebida;
    }

    public function getQuantidade()
    {
        return $this->quantidade;
    }

    public function setPedido(Pedido $pedido)
    {
        $this->pedido = $pedido;
        return $this;
    }

    public function setBebida(Prato $bebida)
    {
        $this->bebida = $bebida;
        return $this;
    }

    public function setQuantidade($quantidade)
    {
        $this->quantidade = $quantidade;
        return $this;
    }

    
    public function getLabel()
    {
        return $this->getBebida() . " - Quantidade:" . $this->quantidade;
    }

    
    
}
