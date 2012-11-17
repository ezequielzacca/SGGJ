<?php

namespace Gremio\AbmBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Gremio\AbmBundle\Entity\Localidad
 *
 * @ORM\Table(name="localidad")
 * @ORM\Entity(repositoryClass="Gremio\AbmBundle\Entity\LocalidadRepository")
 */
class Localidad
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
     * @var string $Nombre
     *
     * @ORM\Column(name="Nombre", type="string", length=100)
     */
    private $Nombre;

    /**
     * @var integer $Codigo_Postal
     *
     * @ORM\Column(name="Codigo_Postal", type="integer")
     */
    private $Codigo_Postal;
	
	/**
     * @ORM\OneToMany(targetEntity="Socio", mappedBy="localidad")
     */
    protected $socios;


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
     * Set Nombre
     *
     * @param string $nombre
     */
    public function setNombre($nombre)
    {
        $this->Nombre = $nombre;
    }

    /**
     * Get Nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->Nombre;
    }

    /**
     * Set Codigo_Postal
     *
     * @param integer $codigoPostal
     */
    public function setCodigoPostal($codigoPostal)
    {
        $this->Codigo_Postal = $codigoPostal;
    }

    /**
     * Get Codigo_Postal
     *
     * @return integer 
     */
    public function getCodigoPostal()
    {
        return $this->Codigo_Postal;
    }
    public function __construct()
    {
        $this->socios = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add socios
     *
     * @param Gremio\AbmBundle\Entity\Socio $socios
     */
    public function addSocio(\Gremio\AbmBundle\Entity\Socio $socios)
    {
        $this->socios[] = $socios;
    }

    /**
     * Get socios
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getSocios()
    {
        return $this->socios;
    }
	
	public function __toString()
	{
		return $this->getNombre();
	}
}