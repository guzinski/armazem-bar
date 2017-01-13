<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace ArmazemBarBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Description of Prato
 * @ORM\Table(name="prato")
 * @ORM\Entity
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
     * @var Collection
     * @ORM\OneToMany(targetEntity="PedidoPrato", mappedBy="prato")
     **/
    private $pedidoPratos;
    
    public function __construct(Collection $pedidoPratos)
    {
        $this->pedidoPratos = new \Doctrine\Common\Collections\ArrayCollection();
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

    

    public function getLabel()
    {
        return $this->descricao;
    }

}
