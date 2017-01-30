<?php

namespace ArmazemBarBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of BaixaBebida
 * @ORM\Table(name="baixa_bebida")
 * @ORM\Entity
 */
class BaixaBebida extends BaseEntity
{
    
    /**
     * @var Bebida
     *
     * @ORM\ManyToOne(targetEntity="Bebida", inversedBy="baixaBebidas",  fetch="EAGER")
     * @ORM\JoinColumn(name="bebida", referencedColumnName="id", nullable=false)
     */
    private $bebida;
    
    /**
     * @var Baixa
     *
     * @ORM\ManyToOne(targetEntity="Baixa", inversedBy="baixaBebidas")
     * @ORM\JoinColumn(name="baixa", referencedColumnName="id", nullable=false)
     */
    private $baixa;
    
    
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

    public function getBaixa()
    {
        return $this->baixa;
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

    public function setBaixa(Baixa $baixa)
    {
        $this->baixa = $baixa;
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
