<?php

namespace ArmazemBarBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use ArmazemBarBundle\Entity\Nivel;
use ArmazemBarBundle\Entity\Permissao;
use ArmazemBarBundle\Entity\Usuario;

/**
 * Description of UsuarioData
 *
 * @author Luciano
 */
class UsuarioData implements FixtureInterface
{
    
    
    public function load(ObjectManager $manager)
    {
        
        $nivel = new Nivel("Administrador");
                
        $nivel->getPermissoes()->add(new Permissao("Usuários", "USUARIO"));
        $nivel->getPermissoes()->add(new Permissao("Pratos", "PRATO"));
        $nivel->getPermissoes()->add(new Permissao("Bebidas", "BEBIDA"));
        $nivel->getPermissoes()->add(new Permissao("Cozinha", "COZINHA"));

        $manager->persist($nivel);
        
        $usuario = new Usuario();
        $usuario->setEmail("lucianoguzinski@gmail.com")
                ->setNome("Luciano Guzinski")
                ->setSenha("123456")
                ->setNivel($nivel);
        
        $manager->persist($usuario);
        $manager->flush();
    }

    
    
    
    
    
}
