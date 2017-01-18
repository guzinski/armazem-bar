<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace ArmazemBarBundle\Form;

use ArmazemBarBundle\Entity\Pedido;
use ArmazemBarBundle\Entity\PedidoBebida;
use ArmazemBarBundle\Entity\PedidoProduto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Description of PedidoType
 *
 */
class PedidoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('pedidoProdutos', CollectionType::class, [
            'entry_type'    => PedidoProdutoType::class,
            'by_reference'  => FALSE,
            'allow_add'    => true,
        ]);
        $builder->add('pedidoBebidas', CollectionType::class, [
            'entry_type'    => PedidoBebidaType::class,
            'by_reference'  => FALSE,
            'allow_add'    => true,
        ]);
    }

    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Pedido::class,
        ));
    }
}
