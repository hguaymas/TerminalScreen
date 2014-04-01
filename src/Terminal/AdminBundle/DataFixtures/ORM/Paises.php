<?php

namespace Terminal\AdminBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Terminal\AdminBundle\Entity\Pais;

class Paises extends AbstractFixture implements OrderedFixtureInterface
{
    public function getOrder()
    {
        return 3;
    }

    public function load(ObjectManager $manager)
    {
        $paises = array(
            array('nombre' => 'ARGENTINA'),            
            array('nombre' => 'BOLIVIA'),            
            array('nombre' => 'CHILE')                        
        );
        $i=0;
        foreach($paises as $pais)
        {
            $i++;
            
            $entidad = new Pais();
            $entidad->setNombre($pais['nombre']);            
            
            $manager->persist($entidad);   
            $manager->flush(); 
            $this->addReference('PAIS_'.$pais['nombre'], $entidad);
        }
        
    }

}