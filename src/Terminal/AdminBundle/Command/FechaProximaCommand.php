<?php
namespace Terminal\AdminBundle\Command;
 
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Terminal\AdminBundle\Entity\Servicio;
 
class FechaProximaCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('terminal:update_fecha')
            ->setDescription('Actualiza la fecha de próxima aparición del servicio teniendo en cuenta su frecuencia configurada');
            //->addArgument('my_argument', InputArgument::OPTIONAL, 'Argument description');
    }
 
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        $servicios_xdias = $em->getRepository('TerminalAdminBundle:Servicio')->findServiciosXDiasDesactualizados();                                
        $output->writeln('SERVICIOS A ACTUALIZAR: '.count($servicios_xdias));
        foreach($servicios_xdias as $sxd)
        {        
            $fecha = null;
            if(!$sxd->getFechaProxima())
            {
                $output->writeln('SERVICIO: '.$sxd->getNombre().' sin fecha proxima');                
                $fecha_full = $sxd->getFechaInicial()->format('Y-m-d').' '.$sxd->getHora()->format('H:i');
                $fecha = new \DateTime($fecha_full);
            }
            else
            {
                $output->writeln('SERVICIO: '.$sxd->getNombre().' con fecha proxima '.$sxd->getFechaProxima()->format('d/m/Y H:i'));                
                $fecha = $sxd->getFechaProxima();                
            }
            $cant = $sxd->getFrecuencia();            
            $fecha_actualizada = $fecha->add(new \DateInterval('P'.$cant.'D'))->format('Y-m-d H:i');
            $sxd->setFechaProxima(new \DateTime($fecha_actualizada));
            $sxd->setEstado('espera');                                                
            $sxd->setPlataforma($sxd->getEmpresa()->getPlataformas());                                                
            //$em->persist($sxd);            
            $output->writeln('SERVICIO: '.$sxd->getNombre().' actualizado a fecha proxima '.$sxd->getFechaProxima()->format('d/m/Y H:i'));                
        }                    
        $em->flush();        
        
        $em = $this->getContainer()->get('doctrine')->getManager();
        $dayofweek = date('w');
        $servicios_dias_semana = $em->getRepository('TerminalAdminBundle:Servicio')->findServiciosDiaSemanaDesactualizados(Servicio::$dias_semana[$dayofweek]);
        $output->writeln('SERVICIOS A ACTUALIZAR X DIA DE SEMANA: '.count($servicios_dias_semana));
        $fecha_actual = new \DateTime();
        $fecha_format = $fecha_actual->format('Y-m-d');
        
        $hace_dos_horas = $fecha_actual->sub(new \DateInterval('PT2H'));
        foreach($servicios_dias_semana as $sds)
        {   
            $hora_format = $sds->getHora()->format('H:i');
            $fecha_hora_servicio = new \DateTime($fecha_format.' '.$hora_format);
            $fecha = null;
            if($fecha_hora_servicio < $hace_dos_horas)
            {
                for($i=$dayofweek+1; $i<=6; $i++)
                {
                    $method = 'get'.Servicio::$dias_semana_method[$i];
                    if($sds->{$method}() == true)
                    {
                        $fecha_calculo = new \DateTime($fecha_format.' '.$sds->getHora()->format('H:i'));
                        $fecha = date_add($fecha_calculo, date_interval_create_from_date_string($i-$dayofweek.' days'));
                        $sds->setFechaProxima($fecha);                                                
                        $sds->setEstado('espera');                                                
                        //$em->persist($sds);            
                        $output->writeln('SERVICIO: '.$sds->getNombre().' actualizado a fecha proxima '.$sds->getFechaProxima()->format('d/m/Y H:i'));                
                        break;
                    }
                }
            }
            else {
                $sds->setFechaProxima(new \DateTime($fecha_format.' '.$sds->getHora()->format('H:i')));
                $sds->setEstado('espera');                                                
                $output->writeln('SERVICIO: '.$sds->getNombre().' actualizado a fecha proxima '.$sds->getFechaProxima()->format('d/m/Y H:i'));
            }
        }                    
        $em->flush();
    }
}