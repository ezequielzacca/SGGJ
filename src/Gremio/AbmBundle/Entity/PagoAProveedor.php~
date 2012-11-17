<?php

namespace Gremio\AbmBundle\Entity;



use Doctrine\ORM\Mapping as ORM;



/**
 * Gremio\AbmBundle\Entity\PagoAProveedor
 * @ORM\Table(name="pagoaproveedor")
 * @ORM\Entity(repositoryClass="Gremio\AbmBundle\Entity\PagoAProveedorRepository")
 */
class PagoAProveedor
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
     * @var datetime $fecha_pago
     * @ORM\Column(name="fecha_pago", type="datetime",nullable="true")
     */
    private $fecha_pago;

    

    
    /**
     * @ORM\ManyToOne(targetEntity="Cierre")
     * @ORM\JoinColumn(name="cierre_id", referencedColumnName="id") 
     */
    
    private $cierre;
    
    /**
     * @ORM\ManyToOne(targetEntity="Gremio\ProveedoresBundle\Entity\Proveedor")
     * @ORM\JoinColumn(name="proveedor_id", referencedColumnName="id")
     */
    
    private $proveedor;
    
    
    /**
     * @ORM\Column(name="pagado", type="boolean")
     */
    private $pagado;
    
    
    /**
     * @ORM\Column(name="importe", type="decimal",nullable="true")
     * 
     */
    private $importe;
    
    

    

    


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
     * Set fecha_pago
     *
     * @param datetime $fechaPago
     */
    public function setFechaPago($fechaPago)
    {
        $this->fecha_pago = $fechaPago;
    }

    /**
     * Get fecha_pago
     *
     * @return datetime 
     */
    public function getFechaPago()
    {
        return $this->fecha_pago;
    }

    /**
     * Set pagado
     *
     * @param boolean $pagado
     */
    public function setPagado($pagado)
    {
        $this->pagado = $pagado;
    }

    /**
     * Get pagado
     *
     * @return boolean 
     */
    public function getPagado()
    {
        return $this->pagado;
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
}