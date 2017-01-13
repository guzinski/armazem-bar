<?php

namespace ArmazemBarBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of PedidoPrato
 * @ORM\Table(name="pedido_prato")
 * @ORM\Entity
 * @author Luciano
 */
class PedidoPrato extends BaseEntity
{
    /**
     * @var Pedido
     *
     * @ORM\ManyToOne(targetEntity="Pedido", inversedBy="pedidoPratos")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="pedido", referencedColumnName="id")
     * })
     */
    private $pedido;
    
    
    /**
     * @var Prato
     *
     * @ORM\ManyToOne(targetEntity="Prato", inversedBy="pedidoPratos")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="prato", referencedColumnName="id")
     * })
     */
    private $prato;

    
    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    private $quantidade;
    
    
    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=false)
     */
    private $observacoes;

    
    public function getPedido()
    {
        return $this->pedido;
    }

    public function getPrato()
    {
        return $this->prato;
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

    public function setPrato(Prato $prato)
    {
        $this->prato = $prato;
        return $this;
    }

    public function setQuantidade($quantidade)
    {
        $this->quantidade = $quantidade;
        return $this;
    }


    public function getLabel()
    {
        return  $this->getPrato() . " - Quantidade:" . $this->quantidade. " - Observações:".$this->observacoes;
    }

    
    
}
