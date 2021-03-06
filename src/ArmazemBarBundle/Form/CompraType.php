<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace ArmazemBarBundle\Form;

use ArmazemBarBundle\Entity\Compra;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Description of CompraType
 *
 * @author Luciano
 */
class CompraType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('compraBebidas', CollectionType::class, [
            'entry_type'    => CompraBebidaType::class,
            'by_reference'  => FALSE,
            'allow_add'    => true,
        ]);
        $builder->add('data', DateType::class, array(
            'widget' => 'single_text',
            'format' => 'dd/MM/yyyy',
        ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Compra::class,
        ));
    }
}
