<?php

namespace Terminal\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class ProvinciaType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('descripcion', 'textarea', array('required' => false))
            ->add('pais', 'entity', array(
                    'class' => 'Terminal\AdminBundle\Entity\Pais',
                    'empty_value' => 'Seleccione un pais',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('p')
                            ->orderBy('p.nombre', 'ASC');
                    }
                ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Terminal\AdminBundle\Entity\Provincia'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'provincia';
    }
}
