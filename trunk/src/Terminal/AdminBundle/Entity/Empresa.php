<?php

namespace Terminal\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Empresa
 *
 * @ORM\Table(name="empresas")
 * @ORM\Entity
 */
class Empresa
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=500, nullable=true)
     */
    private $descripcion;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono", type="string", length=50, nullable=true)
     */
    private $telefono;

    /**
     * @var string
     *
     * @ORM\Column(name="plataformas", type="string", length=50, nullable=true)
     */
    private $plataformas;

    /**
     * @var string
     *
     * @ORM\Column(name="boleterias", type="string", length=50, nullable=true)
     */
    private $boleterias;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Empresa
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return Empresa
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set telefono
     *
     * @param string $telefono
     * @return Empresa
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return string 
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set plataformas
     *
     * @param string $plataformas
     * @return Empresa
     */
    public function setPlataformas($plataformas)
    {
        $this->plataformas = $plataformas;

        return $this;
    }

    /**
     * Get plataformas
     *
     * @return string 
     */
    public function getPlataformas()
    {
        return $this->plataformas;
    }

    /**
     * Set boleterias
     *
     * @param string $boleterias
     * @return Empresa
     */
    public function setBoleterias($boleterias)
    {
        $this->boleterias = $boleterias;

        return $this;
    }

    /**
     * Get boleterias
     *
     * @return string 
     */
    public function getBoleterias()
    {
        return $this->boleterias;
    }
    
    public function __toString() {
        return $this->getNombre();
    }
}
