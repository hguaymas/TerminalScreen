<?php

namespace Terminal\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EditUsuarioType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('email')
            //->add('password')
            ->add('nombre')
            ->add('apellido')
            ->add('telefono')                
            ->add('enabled', 'checkbox', array('required' => false))                
        ;                        
        
        $builder->add('roles', 'choice', array(
            'expanded' => true,
            'multiple' => true,
            'choices'   => array('ROLE_ADMIN' => 'Administrador', 'ROLE_USER' => 'Usuario'),
            'required'  => true,
        ));
    }    
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Terminal\AdminBundle\Entity\Usuario'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'terminal_adminbundle_usuario';
    }
}
