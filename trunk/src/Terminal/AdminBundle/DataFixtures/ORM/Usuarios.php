<?php

namespace Terminal\AdminBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Terminal\AdminBundle\Entity\Usuario;

class Usuarios extends AbstractFixture implements OrderedFixtureInterface
{
    public function getOrder()
    {
        return 1;
    }

    public function load(ObjectManager $manager)
    {
        $usuarios = array(
            array('username' => 'hguaymas', 'password' => 'hguaymas', 'nombre' => 'Hernan', 'apellido' => 'Guaymás', 'email' => 'hguaymas@gmail.com', 'roles' => array('ROLE_USER')),            
            array('username' => 'rlevin', 'password' => 'rlevin', 'nombre' => 'Rubén', 'apellido' => 'Levin', 'email' => 'capocha_79@hotmail.com.ar', 'roles' => array('ROLE_ADMIN', 'ROLE_USER')),                        
        );
        $i=0;
        foreach($usuarios as $usuario)
        {
            $i++;
            
            $entidad = new Usuario();
            $entidad->setUsername($usuario['username']);
            $entidad->setPlainPassword($usuario['password']);
            $entidad->setNombre($usuario['nombre']);
            $entidad->setApellido($usuario['apellido']);
            $entidad->setEmail($usuario['email']);
            $entidad->setEnabled(true);
            $entidad->setRoles($usuario['roles']);
            
            $manager->persist($entidad);   
            $manager->flush(); 
            $this->addReference($usuario['username'], $entidad);
        }
        
    }

}