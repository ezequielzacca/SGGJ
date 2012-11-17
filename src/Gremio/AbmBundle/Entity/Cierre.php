<?php

namespace Gremio\AbmBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Gremio\AbmBundle\Entity\Cierre
 *
 * @ORM\Table(name="cierre")
 * @ORM\Entity(repositoryClass="Gremio\AbmBundle\Entity\CierreRepository")
 */
class Cierre
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
     * @var string $descripcion
     *
     * @ORM\Column(name="descripcion", type="string", length=7)
     */
    private $descripcion;

    /**
     * @var string $usuario_alta
     *
     * @ORM\Column(name="usuario_alta", type="string", length=255)
     */
    private $usuario_alta;

    /**
     * @var datetime $fecha_alta
     *
     * @ORM\Column(name="fecha_alta", type="datetime")
     */
    private $fecha_alta;


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
     * Set descripcion
     *
     * @param string $descripcion
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
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
     * Set usuario_alta
     *
     * @param string $usuarioAlta
     */
    public function setUsuarioAlta($usuarioAlta)
    {
        $this->usuario_alta = $usuarioAlta;
    }

    /**
     * Get usuario_alta
     *
     * @return string 
     */
    public function getUsuarioAlta()
    {
        return $this->usuario_alta;
    }

    /**
     * Set fecha_alta
     *
     * @param datetime $fechaAlta
     */
    public function setFechaAlta($fechaAlta)
    {
        $this->fecha_alta = $fechaAlta;
    }

    /**
     * Get fecha_alta
     *
     * @return datetime 
     */
    public function getFechaAlta()
    {
        return $this->fecha_alta;
    }
}