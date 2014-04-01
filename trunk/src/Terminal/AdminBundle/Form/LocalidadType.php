<?php

namespace Terminal\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class LocalidadType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('codPostal')
            ->add('provincia', 'entity', array(
                    'class' => 'Terminal\AdminBundle\Entity\Provincia',
                    'empty_value' => 'Seleccione una provincia',
                    'property' => 'nombreCompuesto',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('p')
                                ->leftJoin('p.pais', 'pa')
                            ->addOrderBy('pa.nombre', 'ASC')
                            ->addOrderBy('p.nombre', 'ASC');
                    }
                ))
            ->add('descripcion', 'textarea', array('required' => false))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Terminal\AdminBundle\Entity\Localidad'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'localidad';
    }
}
