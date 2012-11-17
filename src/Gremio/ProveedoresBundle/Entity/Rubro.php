<?php

namespace Gremio\ProveedoresBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Gremio\ProveedoresBundle\Entity\Rubro
 *
 * @ORM\Table(name="rubro")
 * @ORM\Entity(repositoryClass="Gremio\ProveedoresBundle\Entity\RubroRepository")
 */
class Rubro {

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $descripcion
     *
     * @ORM\Column(name="descripcion", type="string", length=150)
     */
    private $descripcion;

    /**
     * @ORM\Column(name="fecha_baja", type="datetime", nullable="true")
     *  
     */
    protected $fecha_baja;

    /**
     * @ORM\Column(name="usuario_baja", type="string", nullable="true")
     *  
     */
    protected $usuario_baja;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     */
    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion() {
        return $this->descripcion;
    }

    
    
    public function __toString() {
        return $this->descripcion;
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
}