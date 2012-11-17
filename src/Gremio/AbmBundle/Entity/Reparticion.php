<?php

namespace Gremio\AbmBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Gremio\AbmBundle\Entity\Reparticion
 *
 * @ORM\Table(name="reparticion")
 * @ORM\Entity(repositoryClass="Gremio\AbmBundle\Entity\ReparticionRepository")
 */
class Reparticion
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
     * 
     *
     * @ORM\Column(name="redondeo", type="decimal", scale="2")
     */
    private $redondeo;


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
    
    
    public function __toString()
    {
        return $this->getDescripcion();
    }

    

    /**
     * Set redondeo
     *
     * @param decimal $redondeo
     */
    public function setRedondeo($redondeo)
    {
        $this->redondeo = $redondeo;
    }

    /**
     * Get redondeo
     *
     * @return decimal 
     */
    public function getRedondeo()
    {
        return $this->redondeo;
    }
}