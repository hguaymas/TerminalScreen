<?php

namespace Terminal\AdminBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * Usuario
 *
 * @ORM\Table(name="usuarios")
 * @ORM\Entity(repositoryClass="Terminal\AdminBundle\Repository\UsuarioRepository")
 */
class Usuario extends BaseUser implements \Serializable {
       

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=50)
     */
    protected $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="apellido", type="string", length=50)
     */
    protected $apellido;

    
    /**
     * @var string
     *
     * @ORM\Column(name="telefono", type="string", length=50, nullable=true)
     */
    protected $telefono;

       

    function __construct($nombre = null, $apellido = null, $foto = null, $telefono = null) {
        parent::__construct();
        $this->nombre = $nombre;
        $this->apellido = $apellido;        
        $this->telefono = $telefono;
        $this->enabled = true;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Usuario
     */
    public function setNombre($nombre) {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre() {
        return $this->nombre;
    }

    /**
     * Set apellido
     *
     * @param string $apellido
     * @return Usuario
     */
    public function setApellido($apellido) {
        $this->apellido = $apellido;

        return $this;
    }

    /**
     * Get apellido
     *
     * @return string 
     */
    public function getApellido() {
        return $this->apellido;
    }
    

    /**
     * Set telefono
     *
     * @param string $telefono
     * @return Usuario
     */
    public function setTelefono($telefono) {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return string 
     */
    public function getTelefono() {
        return $this->telefono;
    }
    
    public function getNombreCompleto() {
        return $this->nombre . ' ' . $this->apellido;
    }
    

     public function serialize() {
        return serialize(array(
            $this->id,
            $this->nombre,            
            $this->apellido,
            $this->email,
            $this->username            
        ));
    }

    public function unserialize($serialized) {
        list(
            $this->id,
            $this->nombre,            
            $this->apellido,
            $this->email,
            $this->username           
                ) = unserialize($serialized);
    }
}
