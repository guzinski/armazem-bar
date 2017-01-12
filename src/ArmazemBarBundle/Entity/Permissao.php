<?php

namespace ArmazemBarBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


/**
 * Permissao
 * @ORM\Table(name="permissao")
 * @ORM\Entity
 * @author Luciano
 */
class Permissao
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=150, nullable=false)
     */
    private $nome;
    
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=150, nullable=false)
     */
    private $role;
    
    /**
     * @var Collection
     *
     * @ORM\ManyToMany(targetEntity="Nivel", mappedBy="permissoes", cascade={"persist"})
     */
    private $niveis;
    
    public function __construct($nome = null, $role = null)
    {
        if ($nome != null) {
            $this->setNome($nome);
        }
        if ($role != null) {
            $this->setRole($role);
        }
        $this->setNiveis(new ArrayCollection());
    }

    public function getRole()
    {
        return $this->role;
    }

    public function getNiveis()
    {
        return $this->niveis;
    }

    public function setRole($role)
    {
        $this->role = $role;
        return $this;
    }

    public function setNiveis(Collection $niveis)
    {
        $this->niveis = $niveis;
        return $this;
    }
    
    public function getNome()
    {
        return $this->nome;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function getLabel()
    {
        return $this->getNome();
    }
    

    function getId()
    {
        return $this->id;
    }

    public function __toString()
    {
        return $this->getLabel();
    }


}
