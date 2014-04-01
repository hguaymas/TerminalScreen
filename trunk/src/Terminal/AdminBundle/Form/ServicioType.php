<?php

namespace Terminal\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
use Terminal\AdminBundle\Entity\Servicio;

class ServicioType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('tipo', 'choice', array(
                'expanded' => true,
                'choices' => array(                    
                    'salida' => 'Salida', 
                    'arribo' => 'Arribo'
                )
            ))
            ->add('hora')
            ->add('tipoFrecuencia', 'choice', array(
                'expanded' => true,
                'choices' => array(                    
                    'dias_semana' => 'Días de la semana', 
                    'cada_x_dias' => 'Cada x días'
                )
            ))
            ->add('frecuencia')
            ->add('plataforma')
            ->add('lunes', 'checkbox', array('required' => false))
            ->add('martes', 'checkbox', array('required' => false))
            ->add('miercoles', 'checkbox', array('required' => false))
            ->add('jueves', 'checkbox', array('required' => false))
            ->add('viernes', 'checkbox', array('required' => false))
            ->add('sabado', 'checkbox', array('required' => false))
            ->add('domingo', 'checkbox', array('required' => false))
            ->add('feriados', 'checkbox', array('required' => false))
            ->add('fechaInicial', 'date', array(
                'required' => true, 
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy'
                ))            
            ->add('fechaHasta', 'date', array(
                'required' => false,
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy'
                ))
            ->add('localidad', 'entity', array(
                    'required' => false,
                    'class' => 'Terminal\AdminBundle\Entity\Localidad',
                    'empty_value' => 'Seleccione una localidad',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('l')
                            ->orderBy('l.nombre', 'ASC');
                    }
                ))
            ->add('provincia', 'entity', array(
                    'required' => false,
                    'class' => 'Terminal\AdminBundle\Entity\Provincia',
                    'empty_value' => 'Seleccione una provincia',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('p')
                            ->orderBy('p.nombre', 'ASC');
                    }
                ))
            ->add('pais', 'entity', array(
                    'class' => 'Terminal\AdminBundle\Entity\Pais',
                    'empty_value' => 'Seleccione un pais',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('p')
                            ->orderBy('p.nombre', 'ASC');
                    }
                ))
            ->add('empresa', 'entity', array(
                    'required' => true,
                    'class' => 'Terminal\AdminBundle\Entity\Empresa',
                    'empty_value' => 'Seleccione una Empresa',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('e')
                            ->orderBy('e.nombre', 'ASC');
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
            'data_class' => 'Terminal\AdminBundle\Entity\Servicio'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'servicio';
    }
}
