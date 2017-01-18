<?php

namespace ArmazemBarBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


/**
 * Description of Pedido
 * @ORM\Table(name="pedido")
 * @ORM\Entity
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
     * @ORM\OneToMany(targetEntity="PedidoProduto", mappedBy="pedido")
     **/
    private $pedidoProdutos;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="PedidoBebida", mappedBy="pedido")
     **/
    private $pedidoBebidas;
    
    public function __construct(Collection $pedidoProdutos, Collection $pedidoBebida)
    {
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
    
}
