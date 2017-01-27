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
        $manager->persist(new Bebida("Bebida 1", TRUE, 0, 1.2, 2.4));
        $manager->persist(new Bebida("Bebida 2", TRUE, 0, 1.7, 3.45));
        $manager->persist(new Bebida("Bebida 3", TRUE, 0, 1.62, 3.2));
        $manager->persist(new Bebida("Bebida 4", TRUE, 0, 2.15, 4.55));
        $manager->persist(new Bebida("Bebida 5", TRUE, 0, 2.35, 4.15));
        $manager->flush();
    }

    
    
}
