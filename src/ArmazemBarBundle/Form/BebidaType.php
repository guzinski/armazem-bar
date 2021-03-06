<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace ArmazemBarBundle\Form;

use ArmazemBarBundle\Entity\Bebida;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Description of BebidaType
 *
 * @author Luciano
 */
class BebidaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('descricao', TextType::class, [
            'attr' => ['placeholder' => "Ex. Coca-Cola 600ml"]
        ]);
        $builder->add('precoCusto', MoneyType::class, array('currency' => 'BRL', 'grouping' => true));
        $builder->add('precoVenda', MoneyType::class, array('currency' => 'BRL', 'grouping' => true));
        $builder->add('quantidadeInicial', NumberType::class);
        $builder->add('ativo', CheckboxType::class, array(
            'required' => false,
        ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Bebida::class,
        ));
    }
}
