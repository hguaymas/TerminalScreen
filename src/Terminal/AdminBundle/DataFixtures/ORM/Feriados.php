<?php

namespace Terminal\AdminBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Terminal\AdminBundle\Entity\Feriado;

class Feriados extends AbstractFixture implements OrderedFixtureInterface
{
    public function getOrder()
    {
        return 7;
    }

    public function load(ObjectManager $manager)
    {
        $feriados = array(
            array('fecha' => '2014-04-02', 'nombre' => 'Día del Veterano y de los Caídos en la Guerra de Malvinas'),            
            array('fecha' => '2014-04-18', 'nombre' => 'Viernes Santo'),            
            array('fecha' => '2014-05-01', 'nombre' => 'Día del Trabajador')                        
        );
        $i=0;
        foreach($feriados as $feriado)
        {
            $i++;
            
            $entidad = new Feriado();
            $entidad->setFecha(new \DateTime($feriado['fecha']));
            $entidad->setNombre($feriado['nombre']);            
            
            $manager->persist($entidad);   
            $manager->flush();             
        }
        
    }

}