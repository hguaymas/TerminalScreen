<?php

namespace Terminal\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Servicio
 *
 * @ORM\Table(name="servicios", indexes={@ORM\Index(name="tipo_idx", columns={"tipo"})})
 * @ORM\Entity(repositoryClass="Terminal\AdminBundle\Repository\ServicioRepository") 
 * @ORM\HasLifecycleCallbacks
 */
class Servicio
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
     * @ORM\Column(name="tipo", type="string", columnDefinition="ENUM('salida', 'arribo')")
     */
    private $tipo;

    /**
     * @ORM\ManyToOne(targetEntity="Empresa")
     */ 
    private $empresa;
    
    /**
     * @ORM\ManyToOne(targetEntity="Localidad")
     * @ORM\JoinColumn(name="localidad_id", referencedColumnName="id", nullable=true)     
     */ 
    private $localidad;

    /**
     * @ORM\ManyToOne(targetEntity="Provincia")
     * @ORM\JoinColumn(name="provincia_id", referencedColumnName="id", nullable=true)     
     */ 
    private $provincia;

    /**
     * @ORM\ManyToOne(targetEntity="Pais")
     * @ORM\JoinColumn(name="pais_id", referencedColumnName="id", nullable=false)     
     */ 
    private $pais;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="hora", type="time")
     */
    private $hora;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo_frecuencia", type="string", columnDefinition="ENUM('dias_semana', 'cada_x_dias')")
     */
    private $tipoFrecuencia;
    
    /**
     * @var string
     *
     * @ORM\Column(name="frecuencia", type="string", length=255, nullable=true)
     */
    private $frecuencia;

    
    /**
     * @var string
     *
     * @ORM\Column(name="lunes", type="boolean", nullable=true)
     */
    private $lunes;
    
    /**
     * @var string
     *
     * @ORM\Column(name="martes", type="boolean", nullable=true)
     */
    private $martes;
    
    /**
     * @var string
     *
     * @ORM\Column(name="miercoles", type="boolean", nullable=true)
     */
    private $miercoles;
    
    /**
     * @var string
     *
     * @ORM\Column(name="jueves", type="boolean", nullable=true)
     */
    private $jueves;
    
    /**
     * @var string
     *
     * @ORM\Column(name="viernes", type="boolean", nullable=true)
     */
    private $viernes;
    
    /**
     * @var string
     *
     * @ORM\Column(name="sabado", type="boolean", nullable=true)
     */
    private $sabado;
    
    /**
     * @var string
     *
     * @ORM\Column(name="domingo", type="boolean", nullable=true)
     */
    private $domingo;
    
    /**
     * @var string
     *
     * @ORM\Column(name="feriados", type="boolean", nullable=true)
     */
    private $feriados;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_inicial", type="date")
     */
    private $fechaInicial;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_proxima", type="datetime", nullable=true)
     */
    private $fechaProxima;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_hasta", type="datetime", nullable=true)
     */
    private $fechaHasta;
    
    /**
     * @var string
     *
     * @ORM\Column(name="plataforma", type="string", length=255, nullable=true)
     */
    private $plataforma;
    
    /**
     * @var string
     *
     * @ORM\Column(name="estado", type="string", columnDefinition="ENUM('embarcando', 'cancelado', 'demorado', 'plataforma', 'espera', 'consultar')", nullable=true)
     */
    private $estado;
        
    public static $dias_semana = array(
        1 => 'lunes', 
        2 => 'martes', 
        3 => 'miercoles', 
        4 => 'jueves', 
        5 => 'viernes', 
        6 => 'sabado', 
        0 => 'domingo'
        );
    public static $dias_semana_method = array(
        1 => 'Lunes', 
        2 => 'Martes', 
        3 => 'Miercoles', 
        4 => 'Jueves', 
        5 => 'Viernes', 
        6 => 'Sabado', 
        0 => 'Domingo'
        );
    public static $dias_semana_text = array(
        'Lunes' => 'Lun', 
        'Martes' => 'Mar', 
        'Miercoles' => 'Mié', 
        'Jueves' => 'Jue', 
        'Viernes' => 'Vie', 
        'Sabado' => 'Sáb', 
        'Domingo' => 'Dom',
        'Feriados' => 'Feriados'
        );
    public static $estados_text = array(
        'embarcando' => array('texto' => 'Embarcando', 'color' => 'info'),
        'cancelado' => array('texto' => 'Cancelado', 'color' => 'warning'), 
        'demorado' => array('texto' => 'Demorado', 'color' => 'important'), 
        'plataforma' => array('texto' => 'En plataforma', 'color' => 'success'), 
        'espera' => array('texto' => 'En espera', 'color' => ''), 
        'consultar' => array('texto' => 'Consultar Cía.', 'color' => 'inverse')
        );
    public static $tipos_frecuencia = array('dias_semana' => 'Días de la semana','cada_x_dias' => 'Cada X días');
    public static $tipos_servicio = array('salida' => 'Salida', 'arribo' => 'Arribo');
    
    function __construct() {
        $this->tipo = 'salida';
        $this->tipoFrecuencia = 'dias_semana';
        $this->lunes = true;
        $this->martes = true;
        $this->miercoles = true;
        $this->jueves = true;
        $this->viernes = true;           
        $this->sabado = true;           
        $this->domingo = true;           
        $this->feriados = false;           
        $this->estado = 'espera';           
    }

    
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
     * @return Servicio
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
     * Set tipo
     *
     * @param string $tipo
     * @return Servicio
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return string 
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set localidad
     *
     * @param integer $localidad
     * @return Servicio
     */
    public function setLocalidad($localidad)
    {
        $this->localidad = $localidad;

        return $this;
    }

    /**
     * Get localidad
     *
     * @return integer 
     */
    public function getLocalidad()
    {
        return $this->localidad;
    }

    /**
     * Set provincia
     *
     * @param integer $provincia
     * @return Servicio
     */
    public function setProvincia($provincia)
    {
        $this->provincia = $provincia;

        return $this;
    }

    /**
     * Get provincia
     *
     * @return integer 
     */
    public function getProvincia()
    {
        return $this->provincia;
    }

    /**
     * Set pais
     *
     * @param integer $pais
     * @return Servicio
     */
    public function setPais($pais)
    {
        $this->pais = $pais;

        return $this;
    }

    /**
     * Get pais
     *
     * @return integer 
     */
    public function getPais()
    {
        return $this->pais;
    }

    /**
     * Set hora
     *
     * @param \DateTime $hora
     * @return Servicio
     */
    public function setHora($hora)
    {
        $this->hora = $hora;

        return $this;
    }

    /**
     * Get hora
     *
     * @return \DateTime 
     */
    public function getHora()
    {
        return $this->hora;
    }

    /**
     * Set frecuencia
     *
     * @param string $frecuencia
     * @return Servicio
     */
    public function setFrecuencia($frecuencia)
    {
        $this->frecuencia = $frecuencia;

        return $this;
    }

    /**
     * Get frecuencia
     *
     * @return string 
     */
    public function getFrecuencia()
    {
        return $this->frecuencia;
    }

    /**
     * Set fechaInicial
     *
     * @param \DateTime $fechaInicial
     * @return Servicio
     */
    public function setFechaInicial($fechaInicial)
    {
        $this->fechaInicial = $fechaInicial;

        return $this;
    }

    /**
     * Get fechaInicial
     *
     * @return \DateTime 
     */
    public function getFechaInicial()
    {
        return $this->fechaInicial;
    }

    /**
     * Set fechaProxima
     *
     * @param \DateTime $fechaProxima
     * @return Servicio
     */
    public function setFechaProxima($fechaProxima)
    {
        $this->fechaProxima = $fechaProxima;

        return $this;
    }

    /**
     * Get fechaProxima
     *
     * @return \DateTime 
     */
    public function getFechaProxima()
    {
        return $this->fechaProxima;
    }

    /**
     * Set tipoFrecuencia
     *
     * @param string $tipoFrecuencia
     * @return Servicio
     */
    public function setTipoFrecuencia($tipoFrecuencia)
    {
        $this->tipoFrecuencia = $tipoFrecuencia;

        return $this;
    }

    /**
     * Get tipoFrecuencia
     *
     * @return string 
     */
    public function getTipoFrecuencia()
    {
        return $this->tipoFrecuencia;
    }

    /**
     * Set fechaHasta
     *
     * @param \DateTime $fechaHasta
     * @return Servicio
     */
    public function setFechaHasta($fechaHasta)
    {
        $this->fechaHasta = $fechaHasta;

        return $this;
    }

    /**
     * Get fechaHasta
     *
     * @return \DateTime 
     */
    public function getFechaHasta()
    {
        return $this->fechaHasta;
    }    
    
    public function getTipoServicioText()
    {
        return self::$tipos_servicio[$this->getTipo()];
    }
    
    public function getTipoFrecuenciaText()
    {
        return self::$tipos_frecuencia[$this->getTipoFrecuencia()];
    }
    
    public function getFrecuenciaText()
    {
        $result = '';
        if($this->getTipoFrecuencia() === 'dias_semana')
        {
            
            foreach(self::$dias_semana_text as $index => $text)
            {
                $method = 'get'.$index;
                if($this->{$method}() == true){
                    $result .= $text.($index != 'Feriados' ? ', ' : '');
                }                
            }
            $result = rtrim($result, ', ');
        }
        elseif($this->getTipoFrecuencia() === 'cada_x_dias')
        {
            $result = 'Cada '.$this->getFrecuencia().' días';
        }
        return $result;
    }
    
    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function prePersistProcess() {        
        if($this->getTipoFrecuencia() === 'cada_x_dias')
        {
            $this->setLunes(false);
            $this->setMartes(false);
            $this->setMiercoles(false);
            $this->setJueves(false);
            $this->setViernes(false);
            $this->setSabado(false);
            $this->setDomingo(false);
            $this->setFeriados(false);
        }
        $fecha_hasta = $this->getFechaHasta();
        if($fecha_hasta)
        {
            $fecha_format = $fecha_hasta->format('Y-m-d');
            $this->setFechaHasta(new \DateTime($fecha_format.' '.$this->getHora()));
        }
    }

    /**
     * Set lunes
     *
     * @param boolean $lunes
     * @return Servicio
     */
    public function setLunes($lunes)
    {
        $this->lunes = $lunes;

        return $this;
    }

    /**
     * Get lunes
     *
     * @return boolean 
     */
    public function getLunes()
    {
        return $this->lunes;
    }

    /**
     * Set martes
     *
     * @param boolean $martes
     * @return Servicio
     */
    public function setMartes($martes)
    {
        $this->martes = $martes;

        return $this;
    }

    /**
     * Get martes
     *
     * @return boolean 
     */
    public function getMartes()
    {
        return $this->martes;
    }

    /**
     * Set miercoles
     *
     * @param boolean $miercoles
     * @return Servicio
     */
    public function setMiercoles($miercoles)
    {
        $this->miercoles = $miercoles;

        return $this;
    }

    /**
     * Get miercoles
     *
     * @return boolean 
     */
    public function getMiercoles()
    {
        return $this->miercoles;
    }

    /**
     * Set jueves
     *
     * @param boolean $jueves
     * @return Servicio
     */
    public function setJueves($jueves)
    {
        $this->jueves = $jueves;

        return $this;
    }

    /**
     * Get jueves
     *
     * @return boolean 
     */
    public function getJueves()
    {
        return $this->jueves;
    }

    /**
     * Set viernes
     *
     * @param boolean $viernes
     * @return Servicio
     */
    public function setViernes($viernes)
    {
        $this->viernes = $viernes;

        return $this;
    }

    /**
     * Get viernes
     *
     * @return boolean 
     */
    public function getViernes()
    {
        return $this->viernes;
    }

    /**
     * Set sabado
     *
     * @param boolean $sabado
     * @return Servicio
     */
    public function setSabado($sabado)
    {
        $this->sabado = $sabado;

        return $this;
    }

    /**
     * Get sabado
     *
     * @return boolean 
     */
    public function getSabado()
    {
        return $this->sabado;
    }

    /**
     * Set domingo
     *
     * @param boolean $domingo
     * @return Servicio
     */
    public function setDomingo($domingo)
    {
        $this->domingo = $domingo;

        return $this;
    }

    /**
     * Get domingo
     *
     * @return boolean 
     */
    public function getDomingo()
    {
        return $this->domingo;
    }

    /**
     * Set feriado
     *
     * @param boolean $feriado
     * @return Servicio
     */
    public function setFeriados($feriados)
    {
        $this->feriados = $feriados;

        return $this;
    }

    /**
     * Get feriado
     *
     * @return boolean 
     */
    public function getFeriados()
    {
        return $this->feriados;
    }

    /**
     * Set empresa
     *
     * @param \Terminal\AdminBundle\Entity\Empresa $empresa
     * @return Servicio
     */
    public function setEmpresa(\Terminal\AdminBundle\Entity\Empresa $empresa = null)
    {
        $this->empresa = $empresa;

        return $this;
    }

    /**
     * Get empresa
     *
     * @return \Terminal\AdminBundle\Entity\Empresa 
     */
    public function getEmpresa()
    {
        return $this->empresa;
    }

    /**
     * Set plataforma
     *
     * @param string $plataforma
     * @return Servicio
     */
    public function setPlataforma($plataforma)
    {
        $this->plataforma = $plataforma;

        return $this;
    }

    /**
     * Get plataforma
     *
     * @return string 
     */
    public function getPlataforma()
    {
        return $this->plataforma;
    }

    /**
     * Set estado
     *
     * @param string $estado
     * @return Servicio
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return string 
     */
    public function getEstado()
    {
        return $this->estado;
    }
    
    public static function getEstadosJson()
    {
        $response = array();
        foreach(self::$estados_text as $clave => $estado)
        {
            $response[$clave] = $estado['texto'];
        }
        return json_encode($response);
    }
    
    public function getEstadoTexto()
    {        
        return self::$estados_text[$this->getEstado()]['texto'];
    }
    
    public function getEstadoColor()
    {        
        return self::$estados_text[$this->getEstado()]['color'];
    }
}
