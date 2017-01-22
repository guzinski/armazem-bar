<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace ArmazemBarBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * Description of Produto
 * @ORM\Table(name="produto")
 * @ORM\Entity
 * @UniqueEntity(fields="descricao", message="Já existe um produto cadastrado com essa Descrição")
 * @author Luciano
 */
class Produto extends BaseEntity
{
    
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=150, nullable=false)
     */
    private $descricao;
    
    
    
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
     * @var string
     *
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $ativo = TRUE;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="PedidoProduto", mappedBy="produto")
     **/
    private $pedidoProdutos;
      
    public function __construct($descricao = "", $ativo = TRUE)
    {
        parent::__construct();
        $this->descricao = $descricao;
        $this->ativo = $ativo;
        $this->pedidoProdutos = new ArrayCollection();
    }

    public function getDescricao()
    {
        return $this->descricao;
    }

    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
        return $this;
    }
    
    public function getPedidoProdutos()
    {
        return $this->pedidoProdutos;
    }

    public function setPedidoProdutos(Collection $pedidoProdutos)
    {
        $this->pedidoProdutos = $pedidoProdutos;
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

}
