<?php

namespace Gremio\SociosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Gremio\SociosBundle\Entity\TipoEmision
 *
 * @ORM\Table(name="tipoemision")
 * @ORM\Entity(repositoryClass="Gremio\SociosBundle\Entity\TipoEmisionRepository")
 */
class TipoEmision
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
     * @ORM\Column(name="descripcion", type="string", length=50)
     */
    private $descripcion;


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
    
    public function __toString()
    {
        return $this->getDescripcion();
    }
}