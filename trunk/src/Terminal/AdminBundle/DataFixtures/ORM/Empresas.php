<?php

namespace Terminal\AdminBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Terminal\AdminBundle\Entity\Empresa;

class Empresas extends AbstractFixture implements OrderedFixtureInterface
{
    public function getOrder()
    {
        return 2;
    }

    public function load(ObjectManager $manager)
    {
        $empresas = array(
            array('nombre' => 'ALE HNOS'),            
            array('nombre' => 'ALMIRANTE BROWN'),            
            array('nombre' => 'ANDESMAR / TRAMAT'),            
            array('nombre' => 'BALUT'),            
            array('nombre' => 'EL CHAQUEÑO'),            
            array('nombre' => 'EL INDIO'),            
            array('nombre' => 'FLECHA BUS'),            
            array('nombre' => 'FRONTERAS DEL NORTE'),            
            array('nombre' => 'GEMINIS'),            
            array('nombre' => 'JUAREZ'),            
            array('nombre' => 'LA NUEVA CHEVALLIER'),            
            array('nombre' => 'LA NUEVA ESTRELLA'),            
            array('nombre' => 'LA VELOZ DEL NORTE'),            
            array('nombre' => 'MERCOBUS'),            
            array('nombre' => 'NORTE BIS'),            
            array('nombre' => 'PULLMAN BUS'),            
            array('nombre' => 'SOL Y VALLES'),            
            array('nombre' => 'VOSA')            
            
        );
        $i=0;
        foreach($empresas as $empresa)
        {
            $i++;
            
            $entidad = new Empresa();
            $entidad->setNombre($empresa['nombre']);            
            
            $manager->persist($entidad);   
            $manager->flush(); 
            $this->addReference($empresa['nombre'], $entidad);
        }
        
    }

}