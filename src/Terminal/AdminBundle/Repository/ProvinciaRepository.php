<?php

namespace Terminal\AdminBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * LocalidadRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProvinciaRepository extends EntityRepository
{
    public function findProvinciasByPaisId($pais_id)
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT p FROM TerminalAdminBundle:Provincia p WHERE p.pais = :id ORDER BY p.nombre ASC'
            )->setParameter('id', $pais_id)->getResult();
    }
}
