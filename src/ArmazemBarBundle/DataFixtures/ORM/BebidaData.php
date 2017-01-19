<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace ArmazemBarBundle\DataFixtures\ORM;

use ArmazemBarBundle\Entity\Bebida;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Description of PedidoData
 *
 * @author Luciano
 */
class BebidaData implements FixtureInterface
{
    
    public function load(ObjectManager $manager)
    {
        $manager->persist(new Bebida("Bebida 1"));
        $manager->persist(new Bebida("Bebida 2"));
        $manager->persist(new Bebida("Bebida 3"));
        $manager->persist(new Bebida("Bebida 4"));
        $manager->persist(new Bebida("Bebida 5"));
        $manager->flush();
    }

    
    
}
