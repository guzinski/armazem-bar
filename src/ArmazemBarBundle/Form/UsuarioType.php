<?php
namespace ArmazemBarBundle\Form;

use ArmazemBarBundle\Entity\Nivel;
use ArmazemBarBundle\Entity\Usuario;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Description of UsuarioType
 *
 * @author Luciano
 */
class UsuarioType extends AbstractType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nome')
            ->add('email', EmailType::class)
            ->add('senha', RepeatedType::class, array(
                    'type' => PasswordType::class,
                    'invalid_message' => "Insira a senha.",
                    'first_options'  => array('label' => 'Senha'),
                    'second_options' => array('label' => 'Confirmar senha'),
                ))
            ->add('nivel', EntityType::class, array(
                'class'         => Nivel::class,
                'placeholder'   => 'Selecione',
                'empty_data'    => null,
                'label'         => 'Nível'
        ));

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Usuario::class,
        ));
    }
}
