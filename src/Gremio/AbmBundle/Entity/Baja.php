<?php

namespace Gremio\AbmBundle\Entity;



use Doctrine\ORM\Mapping as ORM;


/**
 * Gremio\AbmBundle\Entity\Baja
 *
 * @ORM\Table(name="baja")
 * @ORM\Entity(repositoryClass="Gremio\AbmBundle\Entity\BajaRepository")
 */
class Baja
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
     * @var string $usuario_baja
     *
     * @ORM\Column(name="usuario_baja", type="string", length=50)
     */
    private $usuario_baja;

    /**
     * @var string $usuario_cancela_baja
     *
     * @ORM\Column(name="usuario_cancela_baja", type="string", length=50, nullable="true")
     */
    private $usuario_cancela_baja;

    /**
     * @var datetime $fecha_baja
     *
     * @ORM\Column(name="fecha_baja", type="datetime")
     */
    private $fecha_baja;

    /**
     * @var datetime $fecha_cancela_baja
     *
     * @ORM\Column(name="fecha_cancela_baja", type="datetime", nullable="true")
     */
    private $fecha_cancela_baja;

    
    /**
     * @ORM\ManyToOne(targetEntity="Socio", inversedBy="bajas")
     * @ORM\JoinColumn(name="socio_id", referencedColumnName="id") 
     */
    
    private $socio;
    
    

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
     * Set usuario_baja
     *
     * @param string $usuarioBaja
     */
    public function setUsuarioBaja($usuarioBaja)
    {
        $this->usuario_baja = $usuarioBaja;
    }

    /**
     * Get usuario_baja
     *
     * @return string 
     */
    public function getUsuarioBaja()
    {
        return $this->usuario_baja;
    }

    /**
     * Set usuario_alta
     *
     * @param string $usuarioAlta
     */
    public function setUsuarioCancelaBaja($usuarioCancelaBaja)
    {
        $this->usuario_cancela_baja = $usuarioCancelaBaja;
    }

    /**
     * Get usuario_alta
     *
     * @return string 
     */
    public function getUsuarioCancelaBaja()
    {
        return $this->usuario_cancela_baja;
    }

    /**
     * Set fecha_baja
     *
     * @param datetime $fechaBaja
     */
    public function setFechaBaja($fechaBaja)
    {
        $this->fecha_baja = $fechaBaja;
    }

    /**
     * Get fecha_baja
     *
     * @return datetime 
     */
    public function getFechaBaja()
    {
        return $this->fecha_baja;
    }

    /**
     * Set fecha_cancela_baja
     *
     * @param datetime $fechaCancelaBaja
     */
    public function setFechaCancelaBaja($fechaCancelaBaja)
    {
        $this->fecha_cancela_baja = $fechaCancelaBaja;
    }

    /**
     * Get fecha_cancela_baja
     *
     * @return datetime 
     */
    public function getFechaCancelaBaja()
    {
        return $this->fecha_cancela_baja;
    }

    /**
     * Set socio
     *
     * @param Gremio\AbmBundle\Entity\Socio $socio
     */
    public function setSocio(Socio $socio)
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
}