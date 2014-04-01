<?php

namespace Terminal\AdminBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Terminal\AdminBundle\Entity\Servicio;

class Servicios extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
    
    public function getOrder()
    {
        return 6;
    }    
    
    public function load(ObjectManager $manager)
    {
        $web_dir = $this->container->getParameter('kernel.root_dir').'/../web';
        $phpExcelObject = $this->container->get('phpexcel')->createPHPExcelObject($web_dir.'/uploads/salidas_arribos.xlsx');
        $phpExcelObject->setActiveSheetIndex(0);
        $sheetData = $phpExcelObject->getActiveSheet()->toArray(null,true,true,true);
        
        for($i=3; $i<=count($sheetData); $i++)
        {
            $entidad = new Servicio();
            $entidad->setTipoFrecuencia('dias_semana');
            $entidad->setTipo('salida');
            $empresa = $sheetData[$i]['B'];
            $destino = $sheetData[$i]['C'];
            $dias = $sheetData[$i]['D'];
            $horario = $sheetData[$i]['E'];
            $empresa_entity = $manager->merge($this->getReference($empresa));
            $entidad->setEmpresa($empresa_entity);
            $hora = new \DateTime($horario);
            $entidad->setHora($hora);            
            
            if($this->hasReference('LOC_'.$destino))
            {
                $localidad = $manager->merge($this->getReference('LOC_'.$destino));
                $entidad->setLocalidad($localidad);
                $entidad->setProvincia($localidad->getProvincia());
                $entidad->setPais($localidad->getPais());
            }
            elseif($this->hasReference('PROV_'.$destino))
            {                
                $provincia = $manager->merge($this->getReference('PROV_'.$destino));
                $entidad->setProvincia($provincia);
                $entidad->setPais($provincia->getPais());
            }            
            elseif($this->hasReference('PAIS_'.$destino))
            {   
                $pais = $manager->merge($this->getReference('PAIS_'.$destino));
                $entidad->setPais($provincia->getPais());
            }            
            $entidad->setNombre($destino);
            $fecha = new \DateTime();
            $entidad->setFechaInicial($fecha);            
            if($dias == '')
            {
                $entidad->setLunes(true);
                $entidad->setMartes(true);
                $entidad->setMiercoles(true);
                $entidad->setJueves(true);
                $entidad->setViernes(true);
                $entidad->setSabado(true);
                $entidad->setDomingo(true);
            }
            elseif($dias == 'D, L y Mi')
            {
                $entidad->setLunes(true);
                $entidad->setMartes(false);
                $entidad->setMiercoles(true);
                $entidad->setJueves(false);
                $entidad->setViernes(false);
                $entidad->setSabado(false);
                $entidad->setDomingo(true);
            }
            elseif($dias == 'dia x medio')
            {
                $entidad->setLunes(false);
                $entidad->setMartes(false);
                $entidad->setMiercoles(false);
                $entidad->setJueves(false);
                $entidad->setViernes(false);
                $entidad->setSabado(false);
                $entidad->setDomingo(false);
                $entidad->setTipoFrecuencia('cada_x_dias');
                $entidad->setFrecuencia(2);
            }
            elseif($dias == 'Dom a vie')
            {
                $entidad->setLunes(true);
                $entidad->setMartes(true);
                $entidad->setMiercoles(true);
                $entidad->setJueves(true);
                $entidad->setViernes(true);
                $entidad->setSabado(false);
                $entidad->setDomingo(true);                
            }
            elseif($dias == 'Domingos')
            {
                $entidad->setLunes(false);
                $entidad->setMartes(false);
                $entidad->setMiercoles(false);
                $entidad->setJueves(false);
                $entidad->setViernes(false);
                $entidad->setSabado(false);
                $entidad->setDomingo(true);                
            }
            elseif($dias == 'L Mi V S y D')
            {
                $entidad->setLunes(true);
                $entidad->setMartes(false);
                $entidad->setMiercoles(true);
                $entidad->setJueves(false);
                $entidad->setViernes(true);
                $entidad->setSabado(true);
                $entidad->setDomingo(true);                
            }
            elseif($dias == 'L y V')
            {
                $entidad->setLunes(true);
                $entidad->setMartes(false);
                $entidad->setMiercoles(false);
                $entidad->setJueves(false);
                $entidad->setViernes(true);
                $entidad->setSabado(false);
                $entidad->setDomingo(false);                
            }
            elseif($dias == 'L, J y S')
            {
                $entidad->setLunes(true);
                $entidad->setMartes(false);
                $entidad->setMiercoles(false);
                $entidad->setJueves(true);
                $entidad->setViernes(false);
                $entidad->setSabado(true);
                $entidad->setDomingo(false);                
            }
            elseif($dias == 'L, Ma, Mi y V')
            {
                $entidad->setLunes(true);
                $entidad->setMartes(true);
                $entidad->setMiercoles(true);
                $entidad->setJueves(false);
                $entidad->setViernes(true);
                $entidad->setSabado(false);
                $entidad->setDomingo(false);                
            }
            elseif($dias == 'L, Mi, J y V')
            {
                $entidad->setLunes(true);
                $entidad->setMartes(false);
                $entidad->setMiercoles(true);
                $entidad->setJueves(true);
                $entidad->setViernes(true);
                $entidad->setSabado(false);
                $entidad->setDomingo(false);                
            }
            elseif($dias == 'L, Mi, V y D')
            {
                $entidad->setLunes(true);
                $entidad->setMartes(false);
                $entidad->setMiercoles(true);
                $entidad->setJueves(false);
                $entidad->setViernes(true);
                $entidad->setSabado(false);
                $entidad->setDomingo(true);                
            }
            elseif($dias == 'lun a sab')
            {
                $entidad->setLunes(true);
                $entidad->setMartes(true);
                $entidad->setMiercoles(true);
                $entidad->setJueves(true);
                $entidad->setViernes(true);
                $entidad->setSabado(true);
                $entidad->setDomingo(false);                
            }
            elseif($dias == 'lun a vie')
            {
                $entidad->setLunes(true);
                $entidad->setMartes(true);
                $entidad->setMiercoles(true);
                $entidad->setJueves(true);
                $entidad->setViernes(true);
                $entidad->setSabado(false);
                $entidad->setDomingo(false);                
            }
            elseif($dias == 'lun a vie y dom')
            {
                $entidad->setLunes(true);
                $entidad->setMartes(true);
                $entidad->setMiercoles(true);
                $entidad->setJueves(true);
                $entidad->setViernes(true);
                $entidad->setSabado(false);
                $entidad->setDomingo(true);                
            }
            elseif($dias == 'ma y sa')
            {
                $entidad->setLunes(false);
                $entidad->setMartes(true);
                $entidad->setMiercoles(false);
                $entidad->setJueves(false);
                $entidad->setViernes(false);
                $entidad->setSabado(true);
                $entidad->setDomingo(false);                
            }
            elseif($dias == 'Ma, J y D')
            {
                $entidad->setLunes(false);
                $entidad->setMartes(true);
                $entidad->setMiercoles(false);
                $entidad->setJueves(true);
                $entidad->setViernes(false);
                $entidad->setSabado(false);
                $entidad->setDomingo(true);                
            }
            elseif($dias == 'Ma, J, S')
            {
                $entidad->setLunes(false);
                $entidad->setMartes(true);
                $entidad->setMiercoles(false);
                $entidad->setJueves(true);
                $entidad->setViernes(false);
                $entidad->setSabado(true);
                $entidad->setDomingo(false);                
            }
            elseif($dias == 'Mi y V')
            {
                $entidad->setLunes(false);
                $entidad->setMartes(false);
                $entidad->setMiercoles(true);
                $entidad->setJueves(false);
                $entidad->setViernes(true);
                $entidad->setSabado(false);
                $entidad->setDomingo(false);                
            }
            elseif($dias == 'S y D')
            {
                $entidad->setLunes(false);
                $entidad->setMartes(false);
                $entidad->setMiercoles(false);
                $entidad->setJueves(false);
                $entidad->setViernes(false);
                $entidad->setSabado(true);
                $entidad->setDomingo(true);                
            }
            elseif($dias == 'sab y dom')
            {
                $entidad->setLunes(false);
                $entidad->setMartes(false);
                $entidad->setMiercoles(false);
                $entidad->setJueves(false);
                $entidad->setViernes(false);
                $entidad->setSabado(true);
                $entidad->setDomingo(true);                
            }
            elseif($dias == 'temporada')
            {
                $entidad->setLunes(false);
                $entidad->setMartes(false);
                $entidad->setMiercoles(false);
                $entidad->setJueves(false);
                $entidad->setViernes(false);
                $entidad->setSabado(false);
                $entidad->setDomingo(false);                
            }
            elseif($dias == 'viernes')
            {
                $entidad->setLunes(false);
                $entidad->setMartes(false);
                $entidad->setMiercoles(false);
                $entidad->setJueves(false);
                $entidad->setViernes(true);
                $entidad->setSabado(false);
                $entidad->setDomingo(false);                
            }            
            
            $manager->persist($entidad);   
            $manager->flush();             
        }
        
        //ARRIBOS
        $phpExcelObject->setActiveSheetIndex(1);
        $sheetData = $phpExcelObject->getActiveSheet()->toArray(null,true,true,true);
        
        for($i=3; $i<=count($sheetData); $i++)
        {
            $entidad = new Servicio();
            $entidad->setTipoFrecuencia('dias_semana');
            $entidad->setTipo('arribo');
            $empresa = $sheetData[$i]['B'];
            $destino = $sheetData[$i]['C'];
            $dias = $sheetData[$i]['D'];
            $horario = $sheetData[$i]['E'];
            $empresa_entity = $manager->merge($this->getReference($empresa));
            $entidad->setEmpresa($empresa_entity);
            $hora = new \DateTime($horario);
            $entidad->setHora($hora);            
            
            if($this->hasReference('LOC_'.$destino))
            {
                $localidad = $manager->merge($this->getReference('LOC_'.$destino));
                $entidad->setLocalidad($localidad);
                $entidad->setProvincia($localidad->getProvincia());
                $entidad->setPais($localidad->getPais());
            }
            elseif($this->hasReference('PROV_'.$destino))
            {                
                $provincia = $manager->merge($this->getReference('PROV_'.$destino));
                $entidad->setProvincia($provincia);
                $entidad->setPais($provincia->getPais());
            }            
            elseif($this->hasReference('PAIS_'.$destino))
            {   
                $pais = $manager->merge($this->getReference('PAIS_'.$destino));
                $entidad->setPais($provincia->getPais());
            }            
            $entidad->setNombre($destino);
            $fecha = new \DateTime();
            $entidad->setFechaInicial($fecha);            
            if($dias == '')
            {
                $entidad->setLunes(true);
                $entidad->setMartes(true);
                $entidad->setMiercoles(true);
                $entidad->setJueves(true);
                $entidad->setViernes(true);
                $entidad->setSabado(true);
                $entidad->setDomingo(true);
            }
            elseif($dias == 'D, L y Mi')
            {
                $entidad->setLunes(true);
                $entidad->setMartes(false);
                $entidad->setMiercoles(true);
                $entidad->setJueves(false);
                $entidad->setViernes(false);
                $entidad->setSabado(false);
                $entidad->setDomingo(true);
            }
            elseif($dias == 'dia x medio')
            {
                $entidad->setLunes(false);
                $entidad->setMartes(false);
                $entidad->setMiercoles(false);
                $entidad->setJueves(false);
                $entidad->setViernes(false);
                $entidad->setSabado(false);
                $entidad->setDomingo(false);
                $entidad->setTipoFrecuencia('cada_x_dias');
                $entidad->setFrecuencia(2);
            }
            elseif($dias == 'dom a vie')
            {
                $entidad->setLunes(true);
                $entidad->setMartes(true);
                $entidad->setMiercoles(true);
                $entidad->setJueves(true);
                $entidad->setViernes(true);
                $entidad->setSabado(false);
                $entidad->setDomingo(true);                
            }
            elseif($dias == 'Dom y feriados')
            {
                $entidad->setLunes(false);
                $entidad->setMartes(false);
                $entidad->setMiercoles(false);
                $entidad->setJueves(false);
                $entidad->setViernes(false);
                $entidad->setSabado(false);
                $entidad->setDomingo(true);                
                $entidad->setFeriados(true);                
            }
            elseif($dias == 'Dom y Lun')
            {
                $entidad->setLunes(true);
                $entidad->setMartes(false);
                $entidad->setMiercoles(false);
                $entidad->setJueves(false);
                $entidad->setViernes(false);
                $entidad->setSabado(false);
                $entidad->setDomingo(true);                
            }
            elseif($dias == 'Domingos')
            {
                $entidad->setLunes(false);
                $entidad->setMartes(false);
                $entidad->setMiercoles(false);
                $entidad->setJueves(false);
                $entidad->setViernes(false);
                $entidad->setSabado(false);
                $entidad->setDomingo(true);                
            }
            elseif($dias == 'L Mi V S y D')
            {
                $entidad->setLunes(true);
                $entidad->setMartes(false);
                $entidad->setMiercoles(true);
                $entidad->setJueves(false);
                $entidad->setViernes(true);
                $entidad->setSabado(true);
                $entidad->setDomingo(true);                
            }
            elseif($dias == 'L y V')
            {
                $entidad->setLunes(true);
                $entidad->setMartes(false);
                $entidad->setMiercoles(false);
                $entidad->setJueves(false);
                $entidad->setViernes(true);
                $entidad->setSabado(false);
                $entidad->setDomingo(false);                
            }
            elseif($dias == 'L, Ma y V')
            {
                $entidad->setLunes(true);
                $entidad->setMartes(true);
                $entidad->setMiercoles(false);
                $entidad->setJueves(false);
                $entidad->setViernes(true);
                $entidad->setSabado(false);
                $entidad->setDomingo(false);                
            }
            elseif($dias == 'L, J y S')
            {
                $entidad->setLunes(true);
                $entidad->setMartes(false);
                $entidad->setMiercoles(false);
                $entidad->setJueves(true);
                $entidad->setViernes(false);
                $entidad->setSabado(true);
                $entidad->setDomingo(false);                
            }
            elseif($dias == 'L, Ma, Mi y V')
            {
                $entidad->setLunes(true);
                $entidad->setMartes(true);
                $entidad->setMiercoles(true);
                $entidad->setJueves(false);
                $entidad->setViernes(true);
                $entidad->setSabado(false);
                $entidad->setDomingo(false);                
            }
            elseif($dias == 'L, Ma, Mi, V, S y D')
            {
                $entidad->setLunes(true);
                $entidad->setMartes(true);
                $entidad->setMiercoles(true);
                $entidad->setJueves(false);
                $entidad->setViernes(true);
                $entidad->setSabado(true);
                $entidad->setDomingo(true);                
            }
            elseif($dias == 'L, Mi, V, S y D')
            {
                $entidad->setLunes(true);
                $entidad->setMartes(false);
                $entidad->setMiercoles(true);
                $entidad->setJueves(false);
                $entidad->setViernes(true);
                $entidad->setSabado(true);
                $entidad->setDomingo(true);                
            }            
            elseif($dias == 'lun a sab')
            {
                $entidad->setLunes(true);
                $entidad->setMartes(true);
                $entidad->setMiercoles(true);
                $entidad->setJueves(true);
                $entidad->setViernes(true);
                $entidad->setSabado(true);
                $entidad->setDomingo(false);                
            }
            elseif($dias == 'lun a vie')
            {
                $entidad->setLunes(true);
                $entidad->setMartes(true);
                $entidad->setMiercoles(true);
                $entidad->setJueves(true);
                $entidad->setViernes(true);
                $entidad->setSabado(false);
                $entidad->setDomingo(false);                
            }
            elseif($dias == 'lun a vie y dom')
            {
                $entidad->setLunes(true);
                $entidad->setMartes(true);
                $entidad->setMiercoles(true);
                $entidad->setJueves(true);
                $entidad->setViernes(true);
                $entidad->setSabado(false);
                $entidad->setDomingo(true);                
            }
            elseif($dias == 'lun y feriados')
            {
                $entidad->setLunes(true);
                $entidad->setMartes(false);
                $entidad->setMiercoles(false);
                $entidad->setJueves(false);
                $entidad->setViernes(false);
                $entidad->setSabado(false);
                $entidad->setDomingo(false);                
                $entidad->setFeriados(true);                
            }
            elseif($dias == 'lunes' || $dias == 'Lunes')
            {
                $entidad->setLunes(true);
                $entidad->setMartes(false);
                $entidad->setMiercoles(false);
                $entidad->setJueves(false);
                $entidad->setViernes(false);
                $entidad->setSabado(false);
                $entidad->setDomingo(false);                
            }
            elseif($dias == 'Ma y J')
            {
                $entidad->setLunes(false);
                $entidad->setMartes(true);
                $entidad->setMiercoles(false);
                $entidad->setJueves(true);
                $entidad->setViernes(false);
                $entidad->setSabado(false);
                $entidad->setDomingo(false);                
            }
            elseif($dias == 'Ma, J y D')
            {
                $entidad->setLunes(false);
                $entidad->setMartes(true);
                $entidad->setMiercoles(false);
                $entidad->setJueves(true);
                $entidad->setViernes(false);
                $entidad->setSabado(false);
                $entidad->setDomingo(true);                
            }
            elseif($dias == 'Ma, J, S' || $dias == 'Ma, J y S')
            {
                $entidad->setLunes(false);
                $entidad->setMartes(true);
                $entidad->setMiercoles(false);
                $entidad->setJueves(true);
                $entidad->setViernes(false);
                $entidad->setSabado(true);
                $entidad->setDomingo(false);                
            }
            elseif($dias == 'Ma, J y V')
            {
                $entidad->setLunes(false);
                $entidad->setMartes(true);
                $entidad->setMiercoles(false);
                $entidad->setJueves(true);
                $entidad->setViernes(true);
                $entidad->setSabado(false);
                $entidad->setDomingo(false);                
            }
            elseif($dias == 'Ma, V y D')
            {
                $entidad->setLunes(false);
                $entidad->setMartes(true);
                $entidad->setMiercoles(false);
                $entidad->setJueves(false);
                $entidad->setViernes(true);
                $entidad->setSabado(false);
                $entidad->setDomingo(true);                
            }            
            elseif($dias == 'temporada')
            {
                $entidad->setLunes(false);
                $entidad->setMartes(false);
                $entidad->setMiercoles(false);
                $entidad->setJueves(false);
                $entidad->setViernes(false);
                $entidad->setSabado(false);
                $entidad->setDomingo(false);                
            }                      
            
            $manager->persist($entidad);   
            $manager->flush();             
        }
        
    }
    
    private function starts_with($haystack, $needle)
    {
        return strpos($haystack, $needle) === 0;
    }

}
