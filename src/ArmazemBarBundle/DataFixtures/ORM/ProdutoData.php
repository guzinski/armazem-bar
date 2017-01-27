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
        $manager->persist(new Produto("Produto 1", TRUE, 3.50, 6));
        $manager->persist(new Produto("Produto 2", TRUE, 4.25, 8));
        $manager->persist(new Produto("Produto 3", TRUE, 3.75, 7.49));
        $manager->persist(new Produto("Produto 4", TRUE, 2.3, 4.2));
        $manager->persist(new Produto("Produto 5", TRUE, 2.85, 3.45));
        $manager->flush();
    }

    
    
}
