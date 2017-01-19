<?php

namespace ArmazemBarBundle\DataFixtures\ORM;

use ArmazemBarBundle\Entity\Produto;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Description of ProdutoData
 *
 * @author Luciano
 */
class ProdutoData implements FixtureInterface
{
    
    public function load(ObjectManager $manager)
    {
        $manager->persist(new Produto("Produto 1"));
        $manager->persist(new Produto("Produto 2"));
        $manager->persist(new Produto("Produto 3"));
        $manager->persist(new Produto("Produto 4"));
        $manager->persist(new Produto("Produto 5"));
        $manager->flush();
    }

    
    
}
