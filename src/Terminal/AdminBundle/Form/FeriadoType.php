<?php

namespace Terminal\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FeriadoType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fecha', 'date', array(
                'required' => true, 
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy'
                ))    
            ->add('descripcion', 'textarea', array('required' => false))
            ->add('nombre')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Terminal\AdminBundle\Entity\Feriado'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'feriado';
    }
}
