<?php

namespace Terminal\AdminBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Terminal\AdminBundle\Entity\Localidad;

class Localidades extends AbstractFixture implements OrderedFixtureInterface
{
    public function getOrder()
    {
        return 5;
    }

    public function load(ObjectManager $manager)
    {
        $localidades = array(            
            array('nombre' => 'AGUAS BLANCAS', 'provincia' => 'SALTA'),                        
            array('nombre' => 'APOLINARIO SARAVIA', 'provincia' => 'SALTA'),                        
            array('nombre' => 'BAHIA BLANCA', 'provincia' => 'BUENOS AIRES'),                        
            array('nombre' => 'CACHI', 'provincia' => 'SALTA'),                        
            array('nombre' => 'CAFAYATE', 'provincia' => 'SALTA'),                        
            array('nombre' => 'CAPITAL FEDERAL', 'provincia' => 'BUENOS AIRES'),                        
            array('nombre' => 'CALETA OLIVIA', 'provincia' => 'SANTA CRUZ'),                        
            array('nombre' => 'CLORINDA - FORMOSA', 'provincia' => 'FORMOSA'),                        
            array('nombre' => 'CLORINDA', 'provincia' => 'FORMOSA'),                        
            array('nombre' => 'EL BORDO', 'provincia' => 'SALTA'),                        
            array('nombre' => 'EL TALA', 'provincia' => 'SALTA'),                        
            array('nombre' => 'FORMOSA - LAS LOMITAS', 'provincia' => 'FORMOSA'),                        
            array('nombre' => 'GUACHIPAS', 'provincia' => 'SALTA'),                        
            array('nombre' => 'GÜEMES', 'provincia' => 'SALTA'),                        
            array('nombre' => 'HUMAHUACA', 'provincia' => 'JUJUY'),                        
            array('nombre' => 'IGUAZÚ - CORRIENTES', 'provincia' => 'MISIONES'),                        
            array('nombre' => 'JOAQUÍN V. GONZALEZ', 'provincia' => 'SALTA'),                        
            array('nombre' => 'LA NORIA - AVELLANEDA', 'provincia' => 'BUENOS AIRES'),                        
            array('nombre' => 'LA PLATA', 'provincia' => 'BUENOS AIRES'),                        
            array('nombre' => 'LA POMA', 'provincia' => 'SALTA'),                        
            array('nombre' => 'LOS ROSALES', 'provincia' => 'SALTA'),                        
            array('nombre' => 'LÍMITE ROSALES', 'provincia' => 'SALTA'),                        
            array('nombre' => 'LURACATAO', 'provincia' => 'SALTA'),                        
            array('nombre' => 'MAR DEL PLATA - TUCUMÁN', 'provincia' => 'BUENOS AIRES'),                        
            array('nombre' => 'MENDOZA - TUCUMÁN', 'provincia' => 'MENDOZA'),                        
            array('nombre' => 'TUCUMÁN - MENDOZA', 'provincia' => 'TUCUMÁN'),                        
            array('nombre' => 'MAR DEL PLATA', 'provincia' => 'BUENOS AIRES'),                        
            array('nombre' => 'METAN', 'provincia' => 'SALTA'),                        
            array('nombre' => 'MOLINOS', 'provincia' => 'SALTA'),                        
            array('nombre' => 'NEUQUÉN - TUCUMÁN', 'provincia' => 'NEUQUÉN'),                        
            array('nombre' => 'ORAN', 'provincia' => 'SALTA'),                        
            array('nombre' => 'PALERMO', 'provincia' => 'SALTA'),                        
            array('nombre' => 'PARANÁ - TUCUMÁN', 'provincia' => 'ENTRE RÍOS'),                        
            array('nombre' => 'QUEBRACHAL', 'provincia' => 'SALTA'),                        
            array('nombre' => 'LA QUIACA', 'provincia' => 'JUJUY'),                        
            array('nombre' => 'RÍO GALLEGOS', 'provincia' => 'SANTA CRUZ'),                                    
            array('nombre' => 'RIVADAVIA', 'provincia' => 'SALTA'),                                    
            array('nombre' => 'ROSARIO DE LA FRONTERA', 'provincia' => 'SALTA'),                                    
            array('nombre' => 'ROSARIO DE SANTA FÉ - TUCUMÁN', 'provincia' => 'SANTA FÉ'),                                    
            array('nombre' => 'ROSARIO DE SANTA FÉ', 'provincia' => 'SANTA FÉ'),                                    
            array('nombre' => 'SALVADOR MAZZA', 'provincia' => 'SALTA'),                                                
            array('nombre' => 'SAN CARLOS', 'provincia' => 'SALTA'),                                                
            array('nombre' => 'SAN ANTONIO DE LOS COBRES', 'provincia' => 'SALTA'),                                                
            array('nombre' => 'SANTA MARÍA DE CATAMARCA', 'provincia' => 'CATAMARCA'),                                                
            array('nombre' => 'TARTAGAL', 'provincia' => 'SALTA')                                               
            
        );
        $i=0;
        foreach($localidades as $localidad)
        {
            $i++;
            
            $entidad = new Localidad();
            $entidad->setNombre($localidad['nombre']);            
            $provincia = $manager->merge($this->getReference('PROV_'.$localidad['provincia']));
            $entidad->setProvincia($provincia);                    
            $entidad->setPais($provincia->getPais());                    
            $manager->persist($entidad);   
            $manager->flush(); 
            $this->addReference('LOC_'.$localidad['nombre'], $entidad);
        }
        
    }

}