<?php

namespace Gremio\SociosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Gremio\SociosBundle\Entity\Emision
 *
 * @ORM\Table(name="emision")
 * @ORM\Entity(repositoryClass="Gremio\SociosBundle\Entity\EmisionRepository")
 */
class Emision {
	/**
	 * @var integer $id
	 *
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @var float $importe
	 *
	 * @ORM\Column(name="importe", type="decimal", scale="2")
	 */
	private $importe;

	/**
	 * @var datetime $fecha_emision
	 *
	 * @ORM\Column(name="fecha_emision", type="datetime")
	 */
	private $fecha_emision;

	/**
	 * @var string $usuario_emision
	 *
	 * @ORM\Column(name="usuario_emision", type="string", length=50)
	 */
	private $usuario_emision;

	/**
	 * @var string $usuario_anulacion
	 *
	 * @ORM\Column(name="usuario_anulacion", type="string", length=50, nullable="true")
	 */
	private $usuario_anulacion;

	/**
	 * @var datetime $fecha_anulacion
	 *
	 * @ORM\Column(name="fecha_anulacion", type="datetime", nullable="true")
	 */
	private $fecha_anulacion;

	/**
	 * @var string $codigo_aprovacion
	 *
	 * @ORM\Column(name="codigo_aprovacion", type="string", length=255, nullable="true")
	 */
	private $codigo_aprovacion;
	
	
	/**
	 * @var datetime $fecha_aprovacion
	 *
	 * @ORM\Column(name="fecha_aprovacion", type="datetime",nullable="true")
	 */
	
	private $fecha_aprovacion;

	/**
	 * @var datetime $fecha_validez
	 *
	 * @ORM\Column(name="fecha_validez", type="datetime")
	 */
	private $fecha_validez;

	/**
	 * @var integer $cuotas
	 *
	 * @ORM\Column(name="cantidad_cuotas", type="integer",nullable=true)
	 */
	private $cantidad_cuotas;

	/**
	 * @ORM\ManyToOne(targetEntity="TipoEmision")
	 * @ORM\JoinColumn(name="tipo_emision_id", referencedColumnName="id") 
	 */

	private $tipo_emision;

	/**
	 * @ORM\ManyToOne(targetEntity="Gremio\AbmBundle\Entity\Socio")
	 * @ORM\JoinColumn(name="socio_id", referencedColumnName="id") 
	 */

	private $socio;

	/**
	 * @ORM\ManyToOne(targetEntity="Gremio\ProveedoresBundle\Entity\Proveedor", inversedBy="emisiones")
	 * @ORM\JoinColumn(name="proveedor_id", referencedColumnName="id") 
	 */

	private $proveedor;

	/**
	 * @ORM\OneToMany(targetEntity="CuotaEmision", mappedBy="emision")
	 * 
	 */
	protected $cuotas;

	/**
	 * @ORM\Column(name="tipo_combustible",type="string",nullable="true")
	 *  
	 */
	protected $tipo_combustible;

	/**
	 * @ORM\Column(name="tipo_viaje",type="string",nullable="true")
	 *  
	 */
	protected $tipo_viaje;

	/**
	 * @ORM\Column(name="origen",type="string",nullable="true")
	 *  
	 */
	protected $origen;

	/**
	 * @ORM\Column(name="destino",type="string",nullable="true")
	 *  
	 */
	protected $destino;

	/**
	 * @ORM\Column(name="cantidad_pasajeros",type="integer",nullable="true")
	 *  
	 */
	protected $cantidad_pasajeros;

	public function __construct() {
		$this->cuotas = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set importe
     *
     * @param decimal $importe
     */
    public function setImporte($importe)
    {
        $this->importe = $importe;
    }

    /**
     * Get importe
     *
     * @return decimal 
     */
    public function getImporte()
    {
        return $this->importe;
    }

    /**
     * Set fecha_emision
     *
     * @param datetime $fechaEmision
     */
    public function setFechaEmision($fechaEmision)
    {
        $this->fecha_emision = $fechaEmision;
    }

    /**
     * Get fecha_emision
     *
     * @return datetime 
     */
    public function getFechaEmision()
    {
        return $this->fecha_emision;
    }

    /**
     * Set usuario_emision
     *
     * @param string $usuarioEmision
     */
    public function setUsuarioEmision($usuarioEmision)
    {
        $this->usuario_emision = $usuarioEmision;
    }

    /**
     * Get usuario_emision
     *
     * @return string 
     */
    public function getUsuarioEmision()
    {
        return $this->usuario_emision;
    }

    /**
     * Set usuario_anulacion
     *
     * @param string $usuarioAnulacion
     */
    public function setUsuarioAnulacion($usuarioAnulacion)
    {
        $this->usuario_anulacion = $usuarioAnulacion;
    }

    /**
     * Get usuario_anulacion
     *
     * @return string 
     */
    public function getUsuarioAnulacion()
    {
        return $this->usuario_anulacion;
    }

    /**
     * Set fecha_anulacion
     *
     * @param datetime $fechaAnulacion
     */
    public function setFechaAnulacion($fechaAnulacion)
    {
        $this->fecha_anulacion = $fechaAnulacion;
    }

    /**
     * Get fecha_anulacion
     *
     * @return datetime 
     */
    public function getFechaAnulacion()
    {
        return $this->fecha_anulacion;
    }

    /**
     * Set codigo_aprovacion
     *
     * @param string $codigoAprovacion
     */
    public function setCodigoAprovacion($codigoAprovacion)
    {
        $this->codigo_aprovacion = $codigoAprovacion;
    }

    /**
     * Get codigo_aprovacion
     *
     * @return string 
     */
    public function getCodigoAprovacion()
    {
        return $this->codigo_aprovacion;
    }

    /**
     * Set fecha_aprovacion
     *
     * @param datetime $fechaAprovacion
     */
    public function setFechaAprovacion($fechaAprovacion)
    {
        $this->fecha_aprovacion = $fechaAprovacion;
    }

    /**
     * Get fecha_aprovacion
     *
     * @return datetime 
     */
    public function getFechaAprovacion()
    {
        return $this->fecha_aprovacion;
    }

    /**
     * Set fecha_validez
     *
     * @param datetime $fechaValidez
     */
    public function setFechaValidez($fechaValidez)
    {
        $this->fecha_validez = $fechaValidez;
    }

    /**
     * Get fecha_validez
     *
     * @return datetime 
     */
    public function getFechaValidez()
    {
        return $this->fecha_validez;
    }

    /**
     * Set cantidad_cuotas
     *
     * @param integer $cantidadCuotas
     */
    public function setCantidadCuotas($cantidadCuotas)
    {
        $this->cantidad_cuotas = $cantidadCuotas;
    }

    /**
     * Get cantidad_cuotas
     *
     * @return integer 
     */
    public function getCantidadCuotas()
    {
        return $this->cantidad_cuotas;
    }

    /**
     * Set tipo_combustible
     *
     * @param string $tipoCombustible
     */
    public function setTipoCombustible($tipoCombustible)
    {
        $this->tipo_combustible = $tipoCombustible;
    }

    /**
     * Get tipo_combustible
     *
     * @return string 
     */
    public function getTipoCombustible()
    {
        return $this->tipo_combustible;
    }

    /**
     * Set tipo_viaje
     *
     * @param string $tipoViaje
     */
    public function setTipoViaje($tipoViaje)
    {
        $this->tipo_viaje = $tipoViaje;
    }

    /**
     * Get tipo_viaje
     *
     * @return string 
     */
    public function getTipoViaje()
    {
        return $this->tipo_viaje;
    }

    /**
     * Set origen
     *
     * @param string $origen
     */
    public function setOrigen($origen)
    {
        $this->origen = $origen;
    }

    /**
     * Get origen
     *
     * @return string 
     */
    public function getOrigen()
    {
        return $this->origen;
    }

    /**
     * Set destino
     *
     * @param string $destino
     */
    public function setDestino($destino)
    {
        $this->destino = $destino;
    }

    /**
     * Get destino
     *
     * @return string 
     */
    public function getDestino()
    {
        return $this->destino;
    }

    /**
     * Set cantidad_pasajeros
     *
     * @param integer $cantidadPasajeros
     */
    public function setCantidadPasajeros($cantidadPasajeros)
    {
        $this->cantidad_pasajeros = $cantidadPasajeros;
    }

    /**
     * Get cantidad_pasajeros
     *
     * @return integer 
     */
    public function getCantidadPasajeros()
    {
        return $this->cantidad_pasajeros;
    }

    /**
     * Set tipo_emision
     *
     * @param Gremio\SociosBundle\Entity\TipoEmision $tipoEmision
     */
    public function setTipoEmision(\Gremio\SociosBundle\Entity\TipoEmision $tipoEmision)
    {
        $this->tipo_emision = $tipoEmision;
    }

    /**
     * Get tipo_emision
     *
     * @return Gremio\SociosBundle\Entity\TipoEmision 
     */
    public function getTipoEmision()
    {
        return $this->tipo_emision;
    }

    /**
     * Set socio
     *
     * @param Gremio\AbmBundle\Entity\Socio $socio
     */
    public function setSocio(\Gremio\AbmBundle\Entity\Socio $socio)
    {
        $this->socio = $socio;
    }

    /**
     * Get socio
     *
     * @return Gremio\AbmBundle\Entity\Socio 
     */
    public function getSocio()
    {
        return $this->socio;
    }

    /**
     * Set proveedor
     *
     * @param Gremio\ProveedoresBundle\Entity\Proveedor $proveedor
     */
    public function setProveedor(\Gremio\ProveedoresBundle\Entity\Proveedor $proveedor)
    {
        $this->proveedor = $proveedor;
    }

    /**
     * Get proveedor
     *
     * @return Gremio\ProveedoresBundle\Entity\Proveedor 
     */
    public function getProveedor()
    {
        return $this->proveedor;
    }

    /**
     * Add cuotas
     *
     * @param Gremio\SociosBundle\Entity\CuotaEmision $cuotas
     */
    public function addCuotaEmision(\Gremio\SociosBundle\Entity\CuotaEmision $cuotas)
    {
        $this->cuotas[] = $cuotas;
    }

    /**
     * Get cuotas
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getCuotas()
    {
        return $this->cuotas;
    }
}