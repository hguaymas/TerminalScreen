<?php

namespace Terminal\AdminBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Terminal\AdminBundle\Entity\Provincia;

class Provincias extends AbstractFixture implements OrderedFixtureInterface
{
    public function getOrder()
    {
        return 4;
    }

    public function load(ObjectManager $manager)
    {
        $provincias = array(            
            array('nombre' => 'BUENOS AIRES', 'pais' => 'ARGENTINA'),                        
            array('nombre' => 'CATAMARCA', 'pais' => 'ARGENTINA'),                        
            array('nombre' => 'CHACO', 'pais' => 'ARGENTINA'),                        
            array('nombre' => 'CHUBUT', 'pais' => 'ARGENTINA'),                        
            array('nombre' => 'CÓRDOBA', 'pais' => 'ARGENTINA'),                        
            array('nombre' => 'CORRIENTES', 'pais' => 'ARGENTINA'),                        
            array('nombre' => 'ENTRE RÍOS', 'pais' => 'ARGENTINA'),                        
            array('nombre' => 'FORMOSA', 'pais' => 'ARGENTINA'),                        
            array('nombre' => 'JUJUY', 'pais' => 'ARGENTINA'),                        
            array('nombre' => 'LA PAMPA', 'pais' => 'ARGENTINA'),                        
            array('nombre' => 'LA RIOJA', 'pais' => 'ARGENTINA'),                        
            array('nombre' => 'MENDOZA', 'pais' => 'ARGENTINA'),                        
            array('nombre' => 'MISIONES', 'pais' => 'ARGENTINA'),                        
            array('nombre' => 'NEUQUÉN', 'pais' => 'ARGENTINA'),                        
            array('nombre' => 'RIO NEGRO', 'pais' => 'ARGENTINA'),                        
            array('nombre' => 'SALTA', 'pais' => 'ARGENTINA'),                        
            array('nombre' => 'SAN LUIS', 'pais' => 'ARGENTINA'),                        
            array('nombre' => 'SAN JUAN', 'pais' => 'ARGENTINA'),                        
            array('nombre' => 'SANTA CRUZ', 'pais' => 'ARGENTINA'),                        
            array('nombre' => 'SANTA FÉ', 'pais' => 'ARGENTINA'),                        
            array('nombre' => 'SANTIAGO DEL ESTERO', 'pais' => 'ARGENTINA'),                        
            array('nombre' => 'TARIJA', 'pais' => 'BOLIVIA'),                        
            array('nombre' => 'TIERRA DEL FUEGO', 'pais' => 'ARGENTINA'),                        
            array('nombre' => 'TUCUMÁN', 'pais' => 'ARGENTINA'),                        
            
        );
        $i=0;
        foreach($provincias as $provincia)
        {
            $i++;
            
            $entidad = new Provincia();
            $entidad->setNombre($provincia['nombre']);            
            $pais = $manager->merge($this->getReference('PAIS_'.$provincia['pais']));
            $entidad->setPais($pais);                    
            $manager->persist($entidad);   
            $manager->flush(); 
            $this->addReference('PROV_'.$provincia['nombre'], $entidad);
        }
        
    }

}