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
 * Description of Prato
 * @ORM\Table(name="prato")
 * @ORM\Entity
 * @UniqueEntity(fields="descricao", message="Já existe um prato cadastrado com essa Descrição")
 * @author Luciano
 */
class Prato extends BaseEntity
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
     * @var Collection
     * @ORM\OneToMany(targetEntity="PedidoPrato", mappedBy="prato")
     **/
    private $pedidoPratos;
    
    public function __construct()
    {
        parent::__construct();
        $this->pedidoPratos = new ArrayCollection();
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
    
    public function getPedidoPratos()
    {
        return $this->pedidoPratos;
    }

    public function setPedidoPratos(Collection $pedidoPratos)
    {
        $this->pedidoPratos = $pedidoPratos;
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

    public function getLabel()
    {
        return $this->descricao;
    }

}
