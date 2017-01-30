<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace ArmazemBarBundle\Form;

use ArmazemBarBundle\Entity\PedidoProduto;
use ArmazemBarBundle\Entity\Produto;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Description of PedidoProdutoType
 *
 */
class PedidoProdutoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('produto', EntityType::class, [
            'placeholder'   => "Selecione",
            'class'         => Produto::class,
            'query_builder' => function (EntityRepository $er) {
                $query = $er->createQueryBuilder('P');
                return $query->andWhere($query->expr()->eq("P.ativo", TRUE))                        
                    ->orderBy('P.descricao', 'ASC');
            },
        ]);
        $builder->add('quantidade', NumberType::class, [
            'attr' => ['placeholder' => "Quantidade", 'class' => "form-control quantidade"],
        ]);
        $builder->add('observacoes', TextareaType::class, [
            'attr' => ['placeholder' => "Descrição", 'class' => "form-control"],
            'required' => false,
        ]);
        $builder->add('valor_unidade', TextType::class, [
            'mapped' => false,
            'attr' => ['class' => "hidden valor_unidade"],
            'required' => false,
        ]);
        $builder->add('valor_total', TextType::class, [
            'mapped' => false,
            'attr' => ['class' => "hidden valor_total"],
            'required' => false,
        ]);
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => PedidoProduto::class,
        ));
    }

    
}
