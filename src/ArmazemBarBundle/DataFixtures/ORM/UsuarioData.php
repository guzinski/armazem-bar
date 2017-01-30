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
        
        $adm = new Nivel("Administrador");
        $cozinha = new Nivel("Cozinha");
        $cozinhap = new Permissao("Cozinha", "COZINHA");
                
        $adm->getPermissoes()->add(new Permissao("Usuários", "USUARIO"));
        $adm->getPermissoes()->add(new Permissao("Produtos", "PRODUTO"));
        $adm->getPermissoes()->add(new Permissao("Bebidas", "BEBIDA"));
        $adm->getPermissoes()->add($cozinhap);
        $adm->getPermissoes()->add(new Permissao("Compras", "COMPRA"));
        $adm->getPermissoes()->add(new Permissao("Pedidos", "PEDIDO"));
        $adm->getPermissoes()->add(new Permissao("Baixa", "BAIXA"));
        $cozinha->getPermissoes()->add($cozinhap);

        $manager->persist($cozinha);
        $manager->persist($adm);
        
        $usuario = new Usuario();
        $usuario->setEmail("lucianoguzinski@gmail.com")
                ->setNome("Luciano Guzinski")
                ->setSenha("123456")
                ->setNivel($adm);
        
        $cozinhau = new Usuario();
        $cozinhau->setEmail("cozinha@teste.com")
                ->setNome("Perfil de Cozinha")
                ->setSenha("123456")
                ->setNivel($cozinha);
        
        $manager->persist($usuario);
        $manager->persist($cozinhau);
        $manager->flush();
    }

    
    
    
    
    
}
