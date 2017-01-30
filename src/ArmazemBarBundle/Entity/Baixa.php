<?php

namespace ArmazemBarBundle\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


/**
 * Description of Baixa
 * @ORM\Table(name="baixa")
 * @ORM\Entity()
 */
class Baixa extends BaseEntity
{
    /**
     * @var int
     *
     * @ORM\Column(type="date", nullable=false)
     */
    private $data;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="BaixaBebida", cascade={"all"}, mappedBy="baixa", fetch="EAGER")
     **/
    private $baixaBebidas;


    public function __construct()
    {
        parent::__construct();
        $this->baixaBebidas = new ArrayCollection();
    }

    public function getData()
    {
        return $this->data;
    }

    public function getBaixaBebidas()
    {
        return $this->baixaBebidas;
    }

    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    public function setBaixaBebidas(Collection $baixaBebidas)
    {
        $this->baixaBebidas = $baixaBebidas;
        return $this;
    }

    public function getLabel()
    {
        return $this->id;
    }
    
    public function addBaixaBebida(BaixaBebida $baixaBebida)
    {
        $this->getBaixaBebidas()->add($baixaBebida);
        $baixaBebida->setBaixa($this);
    }
    
    public function removeBaixaBebida(BaixaBebida $baixaBebida)
    {
        
    }
    



}
