<?php

namespace Gremio\SociosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Gremio\SociosBundle\Entity\CuotaEmision
 *
 * @ORM\Table(name="cuotaemision")
 * @ORM\Entity(repositoryClass="Gremio\SociosBundle\Entity\CuotaEmisionRepository")
 */
class CuotaEmision
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
     * @var integer $numero_cuota
     *
     * @ORM\Column(name="numero_cuota", type="integer")
     */
    private $numero_cuota;

    /**
     * @var float $importe_cuota
     *
     * @ORM\Column(name="importe_cuota", type="decimal", scale="2")
     */
    private $importe_cuota;

    /**
     * @var datetime $fecha_vencimiento
     *
     * @ORM\Column(name="fecha_vencimiento", type="datetime")
     */
    private $fecha_vencimiento;

    /**
     * @var boolean $procesada
     *
     * @ORM\Column(name="procesada", type="boolean")
     */
    private $procesada;

    /**
     * @var datetime $fecha_proceso
     *
     * @ORM\Column(name="fecha_proceso", type="datetime",nullable="true")
     */
    private $fecha_proceso;
    
    /**
     * @ORM\ManyToOne(targetEntity="Emision", inversedBy="cuotas")
     * @ORM\JoinColumn(name="emision_id", referencedColumnName="id") 
     */
    
    private $emision;
    
    
    


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
     * @param integer $numeroCuota
     */
    public function setNumeroCuota($numeroCuota)
    {
        $this->numero_cuota = $numeroCuota;
    }

    /**
     * Get numero_cuota
     *
     * @return integer 
     */
    public function getNumeroCuota()
    {
        return $this->numero_cuota;
    }

    /**
     * Set importe_cuota
     *
     * @param float $importeCuota
     */
    public function setImporteCuota($importeCuota)
    {
        $this->importe_cuota = $importeCuota;
    }

    /**
     * Get importe_cuota
     *
     * @return float 
     */
    public function getImporteCuota()
    {
        return $this->importe_cuota;
    }

    /**
     * Set fecha_vencimiento
     *
     * @param datetime $fechaVencimiento
     */
    public function setFechaVencimiento($fechaVencimiento)
    {
        $this->fecha_vencimiento = $fechaVencimiento;
    }

    /**
     * Get fecha_vencimiento
     *
     * @return datetime 
     */
    public function getFechaVencimiento()
    {
        return $this->fecha_vencimiento;
    }

    /**
     * Set procesada
     *
     * @param boolean $procesada
     */
    public function setProcesada($procesada)
    {
        $this->procesada = $procesada;
    }

    /**
     * Get procesada
     *
     * @return boolean 
     */
    public function getProcesada()
    {
        return $this->procesada;
    }

    /**
     * Set fecha_proceso
     *
     * @param datetime $fechaProceso
     */
    public function setFechaProceso($fechaProceso)
    {
        $this->fecha_proceso = $fechaProceso;
    }

    /**
     * Get fecha_proceso
     *
     * @return datetime 
     */
    public function getFechaProceso()
    {
        return $this->fecha_proceso;
    }

    /**
     * Set emision
     *
     * @param Gremio\SociosBundle\Entity\Emision $emision
     */
    public function setEmision(\Gremio\SociosBundle\Entity\Emision $emision)
    {
        $this->emision = $emision;
    }

    /**
     * Get emision
     *
     * @return Gremio\SociosBundle\Entity\Emision 
     */
    public function getEmision()
    {
        return $this->emision;
    }

    
}