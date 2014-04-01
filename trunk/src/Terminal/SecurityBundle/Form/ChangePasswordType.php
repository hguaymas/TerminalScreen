<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Terminal\SecurityBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;

class ChangePasswordType extends AbstractType
{    

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $constraint = new UserPassword();
        $builder->add('username');
        $builder->add('current_password', 'password', array(
            'label' => 'Contraseña actual',
            'mapped' => false,
            'constraints' => $constraint,
            'required' => true
        ));
        $builder->add('plainPassword', 'repeated', array(
            'type' => 'password',
            'invalid_message' => 'Las contraseñas ingresadas no coinciden',
            'required' => true
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Terminal\AdminBundle\Entity\Usuario',
            'intention'  => 'change_password',
        ));
    }

    public function getName()
    {
        return 'change_password';
    }
}
