<?php

namespace ArmazemBarBundle\Entity;


use Doctrine\ORM\Mapping as ORM;


/**
 * Description of Comprabebida
 * @ORM\Table(name="compra_bebida")
 * @ORM\Entity
 */
class CompraBebida extends BaseEntity
{
    
    
    /**
     * @var Bebida
     *
     * @ORM\ManyToOne(targetEntity="Bebida", inversedBy="compraBebidas",  fetch="EAGER")
     * @ORM\JoinColumn(name="bebida", referencedColumnName="id", nullable=false)
     */
    private $bebida;
    
    /**
     * @var Compra
     *
     * @ORM\ManyToOne(targetEntity="Compra", inversedBy="compraBebidas")
     * @ORM\JoinColumn(name="compra", referencedColumnName="id", nullable=false)
     */
    private $compra;
    
    
    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    private $quantidade;
    
    public function getBebida()
    {
        return $this->bebida;
    }

    public function getCompra()
    {
        return $this->compra;
    }

    public function getQuantidade()
    {
        return $this->quantidade;
    }

    public function setBebida(Bebida $bebida)
    {
        $this->bebida = $bebida;
        return $this;
    }

    public function setCompra(Compra $compra)
    {
        $this->compra = $compra;
        return $this;
    }

    public function setQuantidade($quantidade)
    {
        $this->quantidade = $quantidade;
        return $this;
    }


    public function getLabel()
    {
        return "Descrição: ". $this->getBebida()->getDescricao(); " - Quantidade: ". $this->getQuantidade();
    }

    
    
}
