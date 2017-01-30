<?php

namespace ArmazemBarBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Description of Compra
 * @ORM\Table(name="compra")
 * @ORM\Entity()
 */
class Compra extends BaseEntity
{
        
    /**
     * @var int
     *
     * @ORM\Column(type="date", nullable=false)
     */
    private $data;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="CompraBebida", cascade={"all"}, mappedBy="compra", fetch="EAGER")
     **/
    private $compraBebidas;
    
    public function __construct()
    {
        parent::__construct();
        $this->compraBebidas = new ArrayCollection();
    }

    /**
     * 
     * @return \DateTime
     */
    public function getData()
    {
        return $this->data;
    }

    public function getCompraBebidas()
    {
        return $this->compraBebidas;
    }

    public function setData(\DateTime $data)
    {
        $this->data = $data;
        return $this;
    }

    public function setCompraBebidas(Collection $compraBebidas)
    {
        $this->compraBebidas = $compraBebidas;
        return $this;
    }

    public function getLabel()
    {
        return $this->id;
    }
    
    public function addCompraBebida(CompraBebida $compraBebida)
    {
        $this->getCompraBebidas()->add($compraBebida);
        $compraBebida->setCompra($this);
    }
    
    public function removeCompraBebida(CompraBebida $compraBebida)
    {
        
    }
    
}

