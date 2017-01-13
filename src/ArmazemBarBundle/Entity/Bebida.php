<?php

namespace ArmazemBarBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


/**
 * Description of Bebida
 * 
 * @ORM\Table(name="bebida")
 * @ORM\Entity
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
     * @var int
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    private $quantidadeInicial;
    
    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="PedidoBebida", mappedBy="bebida")
     **/
    private $pedidoBebidas;

    
    public function __construct(Collection $pedidoBebidas)
    {
        $this->pedidoBebidas = new ArrayCollection();
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

    
    public function getLabel()
    {
        return $this->descricao;
    }


    

    
    
    
}