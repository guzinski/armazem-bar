<?php

namespace ArmazemBarBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of PedidoProduto
 * @ORM\Table(name="pedido_produto")
 * @ORM\Entity
 * @author Luciano
 */
class PedidoProduto extends BaseEntity
{
    /**
     * @var Pedido
     *
     * @ORM\ManyToOne(targetEntity="Pedido", inversedBy="pedidoProdutos")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="pedido", referencedColumnName="id")
     * })
     */
    private $pedido;
    
    
    /**
     * @var Produto
     *
     * @ORM\ManyToOne(targetEntity="Produto", inversedBy="pedidoProdutos", fetch="EAGER")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="produto", referencedColumnName="id")
     * })
     */
    private $produto;

    
    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    private $quantidade;
    
    
    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $observacoes;

    /**
     * 
     * @return Pedido
     */
    public function getPedido()
    {
        return $this->pedido;
    }

    /**
     * 
     * @return Produto
     */
    public function getProduto()
    {
        return $this->produto;
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

    public function setProduto(Produto $produto)
    {
        $this->produto = $produto;
        return $this;
    }

    public function setQuantidade($quantidade)
    {
        $this->quantidade = $quantidade;
        return $this;
    }

    public function getObservacoes()
    {
        return (string) $this->observacoes;
    }

    public function setObservacoes($observacoes)
    {
        $this->observacoes = $observacoes;
        return $this;
    }

    
    public function getLabel()
    {
        return  $this->getProduto() . " - Quantidade:" . $this->quantidade. " - Observações:".$this->observacoes;
    }

    
    
}
