<?php

namespace ArmazemBarBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


/**
 * Nivel
 * 
 * @ORM\Table(name="nivel")
 * @ORM\Entity
 * @author Luciano
 */
class Nivel
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
     * @var Collection
     * @ORM\OneToMany(targetEntity="Usuario", mappedBy="nivel")
     **/
    private $usuarios;
    
    /**
     * @var Collection
     *
     * @ORM\ManyToMany(targetEntity="Permissao", inversedBy="niveis", cascade={"persist"})
     * @ORM\JoinTable(name="nivel_permissao",
     *   joinColumns={
     *     @ORM\JoinColumn(name="nivel", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="permissao", referencedColumnName="id")
     *   }
     * )
     */
    private $permissoes;


    public function __construct($nome = null)
    {
        if ($nome != null) {
            $this->setNome($nome);
        }
        $this->setUsuarios(new ArrayCollection());
        $this->setPermissoes(new ArrayCollection());
    }
    

    public function getNome()
    {
        return $this->nome;
    }

    public function getUsuarios()
    {
        return $this->usuarios;
    }

    public function getPermissoes()
    {
        return $this->permissoes;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
        return $this;
    }

    public function setUsuarios(Collection $usuarios)
    {
        $this->usuarios = $usuarios;
        return $this;
    }

    public function setPermissoes(Collection $permissoes)
    {
        $this->permissoes = $permissoes;
        return $this;
    }
    
    public function getId()
    {
        return $this->id;
    }

    public function __toString()
    {
        return $this->nome;
    }
    
    public function getRoles()
    {
        $roles = [];
        foreach ($this->getPermissoes() as $permissao) {
            $roles[] = "ROLE_".$permissao->getRole();
        }
        return $roles;
    }



}
