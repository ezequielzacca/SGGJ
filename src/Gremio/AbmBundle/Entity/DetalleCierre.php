<?php

namespace Gremio\AbmBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Gremio\AbmBundle\Entity\DetalleCierre
 *
 * @ORM\Table(name="detallecierre")
 * @ORM\Entity(repositoryClass="Gremio\AbmBundle\Entity\DetalleCierreRepository")
 */
class DetalleCierre
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $numero_cuota
     *
     * @ORM\Column(name="numero_cuota", type="string", length=255,nullable="true")
     */
    private $numero_cuota;
	
    /**
     * 
     * @ORM\Column(name="tipo_detalle",type="string",nullable="true")
     */
    private $tipo_detalle;
    
    /**
     * @var decimal $importe_cuota
     *
     * @ORM\Column(name="importe_cuota", type="decimal")
     */
    private $importe_cuota;

    /**
     * @ORM\ManyToOne(targetEntity="Gremio\SociosBundle\Entity\CuotaEmision")
     * @ORM\JoinColumn(name="cuota_id", referencedColumnName="id") 
     */
    private $cuota;
    
    /**
     * @ORM\ManyToOne(targetEntity="Gremio\AbmBundle\Entity\Socio")
     * @ORM\JoinColumn(name="socio_id", referencedColumnName="id")
     */
    private $socio;
    
    /**
     * @ORM\ManyToOne(targetEntity="Gremio\AbmBundle\Entity\Reparticion")
     * @ORM\JoinColumn(name="reparticion_id", referencedColumnName="id")
     */
    private $reparticion;
    
    
    /**
     * @ORM\ManyToOne(targetEntity="Gremio\AbmBundle\Entity\Cierre")
     * @ORM\JoinColumn(name="cierre_id", referencedColumnName="id")
     */
    private $cierre;

    


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
     * Set numero_cuota
     *
     * @param string $numeroCuota
     */
    public function setNumeroCuota($numeroCuota)
    {
        $this->numero_cuota = $numeroCuota;
    }

    /**
     * Get numero_cuota
     *
     * @return string 
     */
    public function getNumeroCuota()
    {
        return $this->numero_cuota;
    }

    /**
     * Set importe_cuota
     *
     * @param decimal $importeCuota
     */
    public function setImporteCuota($importeCuota)
    {
        $this->importe_cuota = $importeCuota;
    }

    /**
     * Get importe_cuota
     *
     * @return decimal 
     */
    public function getImporteCuota()
    {
        return $this->importe_cuota;
    }

    /**
     * Set legajo
     *
     * @param bigint $legajo
     */
    public function setLegajo($legajo)
    {
        $this->legajo = $legajo;
    }

    /**
     * Get legajo
     *
     * @return bigint 
     */
    public function getLegajo()
    {
        return $this->legajo;
    }

    /**
     * Set codigo_proveedor
     *
     * @param bigint $codigoProveedor
     */
    public function setCodigoProveedor($codigoProveedor)
    {
        $this->codigo_proveedor = $codigoProveedor;
    }

    /**
     * Get codigo_proveedor
     *
     * @return bigint 
     */
    public function getCodigoProveedor()
    {
        return $this->codigo_proveedor;
    }

    /**
     * Set codigo_seccion
     *
     * @param bigint $codigoSeccion
     */
    public function setCodigoSeccion($codigoSeccion)
    {
        $this->codigo_seccion = $codigoSeccion;
    }

    /**
     * Get codigo_seccion
     *
     * @return bigint 
     */
    public function getCodigoSeccion()
    {
        return $this->codigo_seccion;
    }

    /**
     * Set codigo_reparticion
     *
     * @param bigint $codigoReparticion
     */
    public function setCodigoReparticion($codigoReparticion)
    {
        $this->codigo_reparticion = $codigoReparticion;
    }

    /**
     * Get codigo_reparticion
     *
     * @return bigint 
     */
    public function getCodigoReparticion()
    {
        return $this->codigo_reparticion;
    }

    /**
     * Set codigo_emision
     *
     * @param bigint $codigoEmision
     */
    public function setCodigoEmision($codigoEmision)
    {
        $this->codigo_emision = $codigoEmision;
    }

    /**
     * Get codigo_emision
     *
     * @return bigint 
     */
    public function getCodigoEmision()
    {
        return $this->codigo_emision;
    }

    /**
     * Set codigo_cuota_movimiento
     *
     * @param bigint $codigoCuotaMovimiento
     */
    public function setCodigoCuotaMovimiento($codigoCuotaMovimiento)
    {
        $this->codigo_cuota_movimiento = $codigoCuotaMovimiento;
    }

    /**
     * Get codigo_cuota_movimiento
     *
     * @return bigint 
     */
    public function getCodigoCuotaMovimiento()
    {
        return $this->codigo_cuota_movimiento;
    }

    /**
     * Set tipo_detalle
     *
     * @param string $tipoDetalle
     */
    public function setTipoDetalle($tipoDetalle)
    {
        $this->tipo_detalle = $tipoDetalle;
    }

    /**
     * Get tipo_detalle
     *
     * @return string 
     */
    public function getTipoDetalle()
    {
        return $this->tipo_detalle;
    }

    /**
     * Set cuota
     *
     * @param Gremio\SociosBundle\Entity\CuotaEmision $cuota
     */
    public function setCuota(\Gremio\SociosBundle\Entity\CuotaEmision $cuota)
    {
        $this->cuota = $cuota;
    }

    /**
     * Get cuota
     *
     * @return Gremio\SociosBundle\Entity\CuotaEmision 
     */
    public function getCuota()
    {
        return $this->cuota;
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
     * Set cierre
     *
     * @param Gremio\AbmBundle\Entity\Cierre $cierre
     */
    public function setCierre(\Gremio\AbmBundle\Entity\Cierre $cierre)
    {
        $this->cierre = $cierre;
    }

    /**
     * Get cierre
     *
     * @return Gremio\AbmBundle\Entity\Cierre 
     */
    public function getCierre()
    {
        return $this->cierre;
    }

    /**
     * Set reparticion
     *
     * @param Gremio\AbmBundle\Entity\Reparticion $reparticion
     */
    public function setReparticion(\Gremio\AbmBundle\Entity\Reparticion $reparticion)
    {
        $this->reparticion = $reparticion;
    }

    /**
     * Get reparticion
     *
     * @return Gremio\AbmBundle\Entity\Reparticion 
     */
    public function getReparticion()
    {
        return $this->reparticion;
    }
}