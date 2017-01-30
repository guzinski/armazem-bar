<?php

namespace ArmazemBarBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


/**
 * Description of Pedido
 * @ORM\Table(name="pedido")
 * @ORM\Entity(repositoryClass="ArmazemBarBundle\Repository\PedidoRepository")
 * @author Luciano
 */
class Pedido extends BaseEntity
{
    const FILA = "F";
    const PRODUCAO = "P";
    const CONCLUIDO = "C";
        
    /**
     * @var string
     * @ORM\Column(type="string", columnDefinition="ENUM('F', 'P', 'C')", nullable=false)
     */
    private $situacao = self::FILA;
    
    /**
     * @var boolean
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $cancelado = FALSE;
    
    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="PedidoProduto", cascade={"all"},  mappedBy="pedido", fetch="EAGER")
     **/
    private $pedidoProdutos;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="PedidoBebida", cascade={"all"},  mappedBy="pedido", fetch="EAGER")
     **/
    private $pedidoBebidas;
    
    public function __construct()
    {
        parent::__construct();
        $this->pedidoProdutos = new ArrayCollection();
        $this->pedidoBebidas = new ArrayCollection();
    }

        public function getSituacao()
    {
        return $this->situacao;
    }

    public function getCancelado()
    {
        return $this->cancelado;
    }

    public function getPedidoProdutos()
    {
        return $this->pedidoProdutos;
    }

    public function getPedidoBebidas()
    {
        return $this->pedidoBebidas;
    }

    public function setSituacao($situacao)
    {
        $this->situacao = $situacao;
        return $this;
    }

    public function setCancelado($cancelado)
    {
        $this->cancelado = $cancelado;
        return $this;
    }

    public function setPedidoProdutos(Collection $pedidoProdutos)
    {
        $this->pedidoProdutos = $pedidoProdutos;
        return $this;
    }

    public function setPedidoBebidas(Collection $pedidoBebida)
    {
        $this->pedidoBebidas = $pedidoBebida;
        return $this;
    }
    
    public function getLabel()
    {
        return $this->id;
    }

    public function addPedidoProduto(PedidoProduto $pedidoProduto)
    {
        $this->getPedidoProdutos()->add($pedidoProduto);
        $pedidoProduto->setPedido($this);
    }
    
    public function removePedidoProduto(PedidoProduto $pedidoProduto)
    {
        
    }
    
    public function addPedidoBebida(PedidoBebida $pedidoBebida)
    {
        $this->getPedidoBebidas()->add($pedidoBebida);
        $pedidoBebida->setPedido($this);
    }
    
    public function removePedidoBebida(PedidoBebida $pedidoProduto)
    {
        
    }
    
    
    public function getStringSituacao()
    {
        if ($this->cancelado) {
            return "Cancelado";
        }
        if ($this->situacao == self::CONCLUIDO) {
            return "Concluído";
        }
        if ($this->situacao == self::FILA) {
            return "Na Fila";
        }
        if ($this->situacao == self::PRODUCAO) {
            return "Em Produção";
        }
        
    }
    
    public function getHtmlSituacao()
    {
        if ($this->cancelado) {
            return "<button class=\"btn btn-danger\">Cancelado</button>";
        }
        if ($this->situacao == self::CONCLUIDO) {
            return "<button class=\"btn btn-success\">Concluído</button>";
        }
        if ($this->situacao == self::FILA) {
            return "<button class=\"btn btn-warning\">Na Fila</button>";
        }
        if ($this->situacao == self::PRODUCAO) {
            return "<button class=\"btn btn-primary\">Em Produção</button>";
        }
        
    }

    public function getValorTotal()
    {
        $valor = 0;
        foreach ($this->getPedidoBebidas() as $bebidasPedido) {
            /* @var $bebidasPedido PedidoBebida */
            $valor += $bebidasPedido->getBebida()->getPrecoVenda()*$bebidasPedido->getQuantidade();
        }
        foreach ($this->getPedidoProdutos() as $produtosPedido) {
            /* @var $produtosPedido PedidoProduto */
            $valor += $produtosPedido->getProduto()->getPrecoVenda()*$produtosPedido->getQuantidade();
        }
        
        return $valor;
    }
    
}
