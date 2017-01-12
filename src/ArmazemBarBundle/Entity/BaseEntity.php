<?php

namespace ArmazemBarBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * Description of BaseEntity
 *
 * @author Luciano
 */
abstract class BaseEntity
{
    
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;
    
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="data_cadastro", type="datetime", nullable=false)
     */
    protected $dataCadastro;
    
    public function __construct()
    {
        $this->setDataCadastro(new \DateTime("now"));
    }
    
    public function getId()
    {
        return $this->id;
    }

    abstract function getLabel();

    public function __toString()
    {
        return $this->getLabel();
    }
    
    public function getDataCadastro()
    {
        return $this->dataCadastro;
    }

    public function setDataCadastro(\DateTime $dataCadastro)
    {
        $this->dataCadastro = $dataCadastro;
        return $this;
    }


    
}
