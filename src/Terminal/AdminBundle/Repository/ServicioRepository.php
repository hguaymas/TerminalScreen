<?php

namespace Terminal\AdminBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\DBAL\Types\Type;
/**
 * ServicioRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ServicioRepository extends EntityRepository
{
    public function findServiciosXDiasDesactualizados()
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT s FROM TerminalAdminBundle:Servicio s WHERE s.tipoFrecuencia = :tipo AND (s.fechaProxima IS NULL OR s.fechaProxima < :fecha_actual) AND (s.fechaHasta IS NULL OR s.fechaHasta > :fecha_actual)'
            )
                ->setParameter('tipo', 'cada_x_dias')
                ->setParameter('fecha_actual', date_format( new \DateTime(), 'Y-m-d H:i'))
                ->getResult();
    }
    
    public function findServiciosDiaSemanaDesactualizados($dia)
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT s FROM TerminalAdminBundle:Servicio s WHERE s.tipoFrecuencia = :tipo AND (s.fechaProxima IS NULL OR s.fechaProxima < :fecha_actual) AND s.'.$dia.' = 1 AND (s.fechaHasta IS NULL OR s.fechaHasta > :fecha_actual)'
            )
                ->setParameter('tipo', 'dias_semana')                
                ->setParameter('fecha_actual', date_format( new \DateTime(), 'Y-m-d H:i'))
                ->getResult();
    }
    
    public function findServiciosActuales($tipo, $fecha_desde, $fecha_hasta)
    {
        $query = $this->getEntityManager()
            ->createQuery(
                'SELECT s FROM TerminalAdminBundle:Servicio s WHERE s.tipo = :tipo AND s.fechaProxima >= :fecha_desde AND s.fechaProxima <= :fecha_hasta AND (s.fechaHasta IS NULL OR s.fechaHasta >= :fecha) AND (s.feriados = 0 OR (s.feriados = 1 AND :fecha_actual IN (SELECT f.fecha FROM TerminalAdminBundle:Feriado f))) ORDER BY s.hora, s.nombre'
            )
                ->setParameter('tipo', $tipo)
                ->setParameter('fecha', date_format( new \DateTime(), 'Y-m-d H:i'))
                ->setParameter('fecha_actual', date_format( new \DateTime(), 'Y-m-d'))
                ->setParameter('fecha_desde', $fecha_desde)
                ->setParameter('fecha_hasta', $fecha_hasta);
        $query->setMaxResults(10);
        return $query->getResult();        
    }
}
