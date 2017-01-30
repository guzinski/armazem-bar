<?php

namespace ArmazemBarBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * Description of Bebida
 * 
 * @ORM\Table(name="bebida")
 * @ORM\Entity
 * @UniqueEntity(fields="descricao", message="Já existe uma bebida cadastrada com essa Descrição")
 * @author Luciano
 */
class Bebida extends BaseEntity
{
    
    
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=150, nullable=false)
     */
    private $descricao;
    
    /**
     * @var string
     *
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $ativo = TRUE;
    
    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    private $quantidadeInicial;
    
        /**
     * @var float
     *
     * @ORM\Column(type="decimal", scale=2, precision=7, nullable=false)
     */
    private $precoCusto;

    /**
     * @var float
     *
     * @ORM\Column(type="decimal", scale=2, precision=7,  nullable=false)
     */
    private $precoVenda;
    
    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="PedidoBebida", mappedBy="bebida")
     **/
    private $pedidoBebidas;
    
    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="CompraBebida", mappedBy="bebida")
     **/
    private $compraBebidas;
    
    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="BaixaBebida", mappedBy="bebida")
     **/
    private $baixaBebidas;

    
    public function __construct($descricao = "", $ativo = TRUE, $quantidadeInicial = 0, $precoCusto = NULL, $precoVenda = NULL)
    {
        parent::__construct();
        $this->descricao = $descricao;
        $this->ativo = $ativo;
        $this->quantidadeInicial = $quantidadeInicial;
        $this->precoCusto = $precoCusto;
        $this->precoVenda = $precoVenda;
        $this->pedidoBebidas = new ArrayCollection();
        $this->compraBebidas = new ArrayCollection();
        $this->baixaBebidas = new ArrayCollection();
    }

    public function getDescricao()
    {
        return $this->descricao;
    }

    public function getQuantidadeInicial()
    {
        return $this->quantidadeInicial;
    }

    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
        return $this;
    }

    public function setQuantidadeInicial($quantidadeInicial)
    {
        $this->quantidadeInicial = $quantidadeInicial;
        return $this;
    }

    public function getPedidoBebidas()
    {
        return $this->pedidoBebidas;
    }

    public function setPedidoBebidas(Collection $pedidoBebidas)
    {
        $this->pedidoBebidas = $pedidoBebidas;
        return $this;
    }

    public function getAtivo()
    {
        return $this->ativo;
    }

    public function setAtivo($ativo)
    {
        $this->ativo = $ativo;
        return $this;
    }

    
    public function getPrecoCusto()
    {
        return $this->precoCusto;
    }

    public function getPrecoVenda()
    {
        return $this->precoVenda;
    }

    public function setPrecoCusto($precoCusto)
    {
        $this->precoCusto = $precoCusto;
        return $this;
    }

    public function setPrecoVenda($precoVenda)
    {
        $this->precoVenda = $precoVenda;
        return $this;
    }

    public function getLabel()
    {
        return $this->descricao;
    }

    public function getCompraBebidas()
    {
        return $this->compraBebidas;
    }

    public function setCompraBebidas(Collection $compraBebidas)
    {
        $this->compraBebidas = $compraBebidas;
        return $this;
    }
    
    public function getBaixaBebidas()
    {
        return $this->baixaBebidas;
    }

    public function setBaixaBebidas(Collection $baixaBebidas)
    {
        $this->baixaBebidas = $baixaBebidas;
        return $this;
    }
    
    public function getQuantidadeEstoque()
    {
        $quantidade = $this->quantidadeInicial;
        
        foreach ($this->getCompraBebidas() as $compraBebida) {
            /* @var $compraBebida CompraBebida */
            $quantidade += $compraBebida->getQuantidade();
        }
        foreach ($this->getPedidoBebidas() as $pedidoBebida) {
            /* @var $pedidoBebida PedidoBebida */
            $quantidade -= $pedidoBebida->getQuantidade();
        }
        foreach ($this->getBaixaBebidas() as $baixaBebida) {
            /* @var $baixaBebida BaixaBebida */
            $quantidade -= $baixaBebida->getQuantidade();
        }
        
        return $quantidade;
    }

    

    
    
    
}
