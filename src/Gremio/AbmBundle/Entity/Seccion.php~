<?php

namespace Gremio\AbmBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Gremio\AbmBundle\Entity\Seccion
 *
 * @ORM\Table(name="seccion")
 * @ORM\Entity(repositoryClass="Gremio\AbmBundle\Entity\SeccionRepository")
 */
class Seccion
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
     * @var string $Descripcion
     *
     * @ORM\Column(name="Descripcion", type="string", length=50)
     */
    private $Descripcion;

    /**
     * @var string $Domicilio
     *
     * @ORM\Column(name="Domicilio", type="string", length=100)
     */
    private $Domicilio;

    /**
     * @var string $Telefono
     *
     * @ORM\Column(name="Telefono", type="string", length=12)
     */
    private $Telefono;


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
     * Set Descripcion
     *
     * @param string $descripcion
     */
    public function setDescripcion($descripcion)
    {
        $this->Descripcion = $descripcion;
    }

    /**
     * Get Descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->Descripcion;
    }

    /**
     * Set Domicilio
     *
     * @param string $domicilio
     */
    public function setDomicilio($domicilio)
    {
        $this->Domicilio = $domicilio;
    }

    /**
     * Get Domicilio
     *
     * @return string 
     */
    public function getDomicilio()
    {
        return $this->Domicilio;
    }

    /**
     * Set Telefono
     *
     * @param string $telefono
     */
    public function setTelefono($telefono)
    {
        $this->Telefono = $telefono;
    }

    /**
     * Get Telefono
     *
     * @return string 
     */
    public function getTelefono()
    {
        return $this->Telefono;
    }
    
    public function __toString()
    {
        return $this->getDescripcion();
    }
    
    /**
     * @ORM\ManyToOne(targetEntity="Localidad")
     * @Orm\JoinColumn(name="localidad_id", referencedColumnName="id") 
     */
    
    protected $localidad;

    /**
     * Set localidad
     *
     * @param Gremio\AbmBundle\Entity\Localidad $localidad
     */
    public function setLocalidad(\Gremio\AbmBundle\Entity\Localidad $localidad)
    {
        $this->localidad = $localidad;
    }

    /**
     * Get localidad
     *
     * @return Gremio\AbmBundle\Entity\Localidad 
     */
    public function getLocalidad()
    {
        return $this->localidad;
    }
}