<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace ArmazemBarBundle\Form;

use ArmazemBarBundle\Entity\PedidoBebida;
use Doctrine\ORM\EntityRepository;
use Proxies\__CG__\ArmazemBarBundle\Entity\Bebida;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Description of Pedidobebida
 *
 */
class PedidoBebidaType extends AbstractType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('bebida', EntityType::class, [
            'placeholder'   => "Selecione a Bebida",
            'class'         => Bebida::class,
            'query_builder' => function (EntityRepository $er) {
                $query = $er->createQueryBuilder('B');
                return $query->andWhere($query->expr()->eq("B.ativo", TRUE))                        
                    ->orderBy('B.descricao', 'ASC');
            },
        ]);
        $builder->add('quantidade', NumberType::class, [
            'attr' => ['placeholder' => "Quantidade"],
        ]);
    }
   
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => PedidoBebida::class,
        ));
    }
}