<?php

namespace Gremio\AbmBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Gremio\AbmBundle\Entity\Baja;
use Gremio\AbmBundle\Entity\TipoSocio;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;



/**
 * Gremio\AbmBundle\Entity\Socio
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="socio")
 * @ORM\Entity(repositoryClass="Gremio\AbmBundle\Entity\SocioRepository")
 */
class Socio implements UserInterface, \Serializable
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var bigint $Legajo
     *
     * @ORM\Column(name="Legajo", type="bigint",unique="true")
     */
    protected $Legajo;

   

    /**
     * @var bigint $Num_Documento
     *
     * @ORM\Column(name="Num_Documento", type="string")
     */
    protected $Num_Documento;

    /**
     * @var bigint $Cuit
     *
     * @ORM\Column(name="Cuit", type="string", nullable="true")
     */
    protected $Cuit;

    /**
     * @var string $Apellido
     * @ORM\Column(name="Apellido", type="string")
     */
    protected $Apellido;

    /**
     * @var string $Nombres
     *
     * @ORM\Column(name="Nombres", type="string")
     */
    protected $Nombres;

    /**
     * @var string $Domicilio
     *
     * @ORM\Column(name="Domicilio_Laboral", type="string")
     */
    protected $Domicilio_Laboral;

    /**
     * @var string $Telefono
     *
     * @ORM\Column(name="Telefono_Laboral", type="string", nullable="true")
     */
    protected $Telefono_Laboral;


    /**
     * @var integer $Numero_Mesa
     *
     * @ORM\Column(name="Numero_Mesa", type="integer", nullable="true")
     */
    protected $Numero_Mesa;

    /**
     * @var datetime $Ingreso_Justicia
     *
     * @ORM\Column(name="Ingreso_Justicia", type="datetime", nullable="true")
     */
    protected $Ingreso_Justicia;

    /**
     * @var bigint $Cbu
     *
     * @ORM\Column(name="Cbu", type="string", nullable="true")
     */
    protected $Cbu;

    /**
     * @var string $Domicilio_Particular
     *
     * @ORM\Column(name="Domicilio_Particular", type="string", nullable="true")
     */
    protected $Domicilio_Particular;

    /**
     * @var string $Telefono_Particular
     *
     * @ORM\Column(name="Telefono_Particular", type="string")
     */
    protected $Telefono_Particular;

    /**
     * @var string $Email
     *
     * @ORM\Column(name="Email", type="string", length=30, nullable="false", unique="true")
     */
    protected $Email;

    /**
     * @var datetime $Fecha_Nacimiento
     *
     * @ORM\Column(name="Fecha_Nacimiento", type="datetime", nullable="true")
     */
    protected $Fecha_Nacimiento;
	
    /**
     * 
     *
     * @ORM\Column(name="margen", type="integer")
     */
    protected $margen;
    
    
    /**
     * @ORM\ManyToOne(targetEntity="TipoSocio")
     * @ORM\JoinColumn(name="tipo_socio_id", referencedColumnName="id") 
     */
    
    
    
    protected $tipo_socio;
    
    /**
     * @ORM\ManyToOne(targetEntity="Seccion")
     * @ORM\JoinColumn(name="seccion_id", referencedColumnName="id")
     */
    
    protected $seccion;
    
    /**
     * @ORM\ManyToOne(targetEntity="Reparticion")
     * @ORM\JoinColumn(name="reparticion_id", referencedColumnName="id") 
     */
    protected $reparticion;
    
    /**
     * @ORM\ManyToOne(targetEntity="Localidad", inversedBy="socios")
     * @ORM\JoinColumn(name="localidad_id", referencedColumnName="id")
     */
    
    
    protected $localidad;
    
	
    /**
     * 
     *
     * @ORM\Column(name="sexo", type="string")
     */
    protected $sexo;
    
    /**
     * @ORM\OneToMany(targetEntity="Gremio\SociosBundle\Entity\Emision", mappedBy="socio")
     * 
     */
    protected $emisiones;
   
    
    /**
     * @ORM\OneToMany(targetEntity="Baja", mappedBy="socio")
     * 
     */
    protected $bajas;
    
    
    
    
    
    
    /* #####################################################
     * Propiedades Relacionadas con la Auditoria del Sistema
     * #####################################################
     */
    
    /**
     * @ORM\Column(type="string", length="50", nullable="true")
     * 
     */
    
    protected $user_last_modif;
    
    public function setUserLastModif($user_last_modif)
    {
        $this->user_last_modif = $user_last_modif;
    }
    
    public function getUserLastModif()
    {
        return $this->user_last_modif;
    }
    
    /**
     * @ORM\Column(type="datetime", nullable="true")
     * 
     */
    
    protected $last_modif_date;
    
    public function setLastModifDate($last_modif_date)
    {
        $this->last_modif_date=$last_modif_date;
    }
    
    public function getLastModifDate()
    {
        return $this->last_modif_date;
    }
    /* ###############################################################
     * Propiedades Relacionadas con el rol de Usuario de la Aplicacion
     * ###############################################################
     */
    
    /**
     * @ORM\Column(type="string", length="255", unique=true)
     *
     * @var string username
     */
    protected $username;
    
    /**
     * @ORM\Column(type="string", length="255")
     *
     * @var string password
     */
    protected $password;
    
    /**
     * @ORM\Column(type="string", length="255")
     *
     * @var string salt
     */
    protected $salt;
    
    /**
     * @ORM\Column(type="datetime", name="created_at")
     * 
     * @var DateTime $createdAt
     */
    protected $createdAt;
    
        
    /**
     * @ORM\OneToMany(targetEntity="Baja", mappedBy="socio")
     * 
     */
    
    
    
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set Legajo
     *
     * @param bigint $legajo
     */
    public function setLegajo($legajo)
    {
        $this->Legajo = $legajo;
    }

    /**
     * Get Legajo
     *
     * @return bigint 
     */
    public function getLegajo()
    {
        return $this->Legajo;
    }

    

    /**
     * Set Num_Documento
     *
     * @param bigint $numDocumento
     */
    public function setNumDocumento($numDocumento)
    {
        $this->Num_Documento = $numDocumento;
    }

    /**
     * Get Num_Documento
     *
     * @return bigint 
     */
    public function getNumDocumento()
    {
        return $this->Num_Documento;
    }

    /**
     * Set Cuit
     *
     * @param bigint $cuit
     */
    public function setCuit($cuit)
    {
        $this->Cuit = $cuit;
    }

    /**
     * Get Cuit
     *
     * @return bigint 
     */
    public function getCuit()
    {
        return $this->Cuit;
    }

    /**
     * Set Apellido
     *
     * @param string $apellido
     */
    public function setApellido($apellido)
    {
        $this->Apellido = $apellido;
    }

    /**
     * Get Apellido
     *
     * @return string 
     */
    public function getApellido()
    {
        return $this->Apellido;
    }

    /**
     * Set Nombres
     *
     * @param string $nombres
     */
    public function setNombres($nombres)
    {
        $this->Nombres = $nombres;
    }

    /**
     * Get Nombres
     *
     * @return string 
     */
    public function getNombres()
    {
        return $this->Nombres;
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

    /**
     * Set Sexo
     *
     * @param string $sexo
     */


    /**
     * Set Numero_Mesa
     *
     * @param integer $numeroMesa
     */
    public function setNumeroMesa($numeroMesa)
    {
        $this->Numero_Mesa = $numeroMesa;
    }

    /**
     * Get Numero_Mesa
     *
     * @return integer 
     */
    public function getNumeroMesa()
    {
        return $this->Numero_Mesa;
    }

    /**
     * Set Ingreso_Justicia
     *
     * @param datetime $ingresoJusticia
     */
    public function setIngresoJusticia($ingresoJusticia)
    {
        $this->Ingreso_Justicia = $ingresoJusticia;
    }

    /**
     * Get Ingreso_Justicia
     *
     * @return datetime 
     */
    public function getIngresoJusticia()
    {
        return $this->Ingreso_Justicia;
    }

    /**
     * Set Cbu
     *
     * @param bigint $cbu
     */
    public function setCbu($cbu)
    {
        $this->Cbu = $cbu;
    }

    /**
     * Get Cbu
     *
     * @return bigint 
     */
    public function getCbu()
    {
        return $this->Cbu;
    }

    /**
     * Set Domicilio_Particular
     *
     * @param string $domicilioParticular
     */
    public function setDomicilioParticular($domicilioParticular)
    {
        $this->Domicilio_Particular = $domicilioParticular;
    }

    /**
     * Get Domicilio_Particular
     *
     * @return string 
     */
    public function getDomicilioParticular()
    {
        return $this->Domicilio_Particular;
    }

    /**
     * Set Telefono_Particular
     *
     * @param string $telefonoParticular
     */
    public function setTelefonoParticular($telefonoParticular)
    {
        $this->Telefono_Particular = $telefonoParticular;
    }

    /**
     * Get Telefono_Particular
     *
     * @return string 
     */
    public function getTelefonoParticular()
    {
        return $this->Telefono_Particular;
    }

    /**
     * Set Email
     *
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->Email = $email;
    }

    /**
     * Get Email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->Email;
    }

    /**
     * Set Fecha_Nacimiento
     *
     * @param datetime $fechaNacimiento
     */
    public function setFechaNacimiento($fechaNacimiento)
    {
        $this->Fecha_Nacimiento = $fechaNacimiento;
    }

    /**
     * Get Fecha_Nacimiento
     *
     * @return datetime 
     */
    public function getFechaNacimiento()
    {
        return $this->Fecha_Nacimiento;
    }

    /**
     * Set Domicilio_Laboral
     *
     * @param string $domicilioLaboral
     */
    public function setDomicilioLaboral($domicilioLaboral)
    {
        $this->Domicilio_Laboral = $domicilioLaboral;
    }

    /**
     * Get Domicilio_Laboral
     *
     * @return string 
     */
    public function getDomicilioLaboral()
    {
        return $this->Domicilio_Laboral;
    }

    /**
     * Set Telefono_Laboral
     *
     * @param string $telefonoLaboral
     */
    public function setTelefonoLaboral($telefonoLaboral)
    {
        $this->Telefono_Laboral = $telefonoLaboral;
    }

    /**
     * Get Telefono_Laboral
     *
     * @return string 
     */
    public function getTelefonoLaboral()
    {
        return $this->Telefono_Laboral;
    }

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
	

    /**
     * Set sexo
     *
     * @param Gremio\AbmBundle\Entity\Sexo $sexo
     */
    public function setSexo($sexo)
    {
        $this->sexo = $sexo;
    }

    /**
     * Get sexo
     *
     * @return Gremio\AbmBundle\Entity\Sexo 
     */
    public function getSexo()
    {
        return $this->sexo;
    }

    
    /***********************************/
    
      
    
    
    
    
    
    /**
     * Gets the username.
     *
     * @return string The username.
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Sets the username.
     *
     * @param string $value The username.
     */
    public function setUsername($value)
    {
        $this->username = $value;
    }
    
    /**
     * Gets the complete username.
     *
     * @return string The username.
     */
    public function getCompleteName()
    {
        return $this->getApellido() .' ' .$this->getNombres();
    }

    /**
     * Gets the user password.
     *
     * @return string The password.
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Sets the user password.
     *
     * @param string $value The password.
     */
    public function setPassword($value)
    {
        $this->password = $value;
    }

    /**
     * Gets the user salt.
     *
     * @return string The salt.
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Sets the user salt.
     *
     * @param string $value The salt.
     */
    public function setSalt($value)
    {
        $this->salt = $value;
    }
    
    /**
     * Gets an object representing the date and time the user was created.
     * 
     * @return DateTime A DateTime object
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
    
   
    
    
    /**
     * Constructs a new instance of User
     */
    public function __construct()
    {
        
        
        $this->createdAt = new \DateTime();
    }
    
    
    
    /**
     * Gets the full name of the user.
     * 
     * @return string The full name
     */
    public function getFullName()
    {
        return sprintf('%s %s', $this->Apellido, $this->Nombres);
    }

    /**
     * Erases the user credentials.
     */
    public function eraseCredentials()
    {

    }

    /**
     * Gets an array of roles.
     * 
     * @return array An array of Role objects
     */
    public function getRoles()
    {
        if ($this->getFechaBaja())
            return array('ROLE_BAJA');
        else
            return array('ROLE_SOCIO');
    }

    /**
     * Compares this user to another to determine if they are the same.
     * 
     * @param UserInterface $user The user
     * @return boolean True if equal, false othwerwise.
     */
    public function equals(UserInterface $user)
    {
        return md5($this->getUsername()) == md5($user->getUsername());
    }

    

    /**
     * Set createdAt
     *
     * @param datetime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

   
    
    /** 
     * @ORM\prePersist 
     */
    public function setUserPass()
    {
        $this->setUsername(strtolower(substr($this->getNombres(),0,1)) . strtolower($this->getApellido()));
        $encoder = new MessageDigestPasswordEncoder('sha512', true, 10);
        $this->setSalt(md5(time()));
        $this->setPassword($encoder->encodePassword('socio', $this->getSalt()));
        
    }
    
    public function serialize()
{
return serialize(array(
$this->id,
$this->password,
$this->username
));
}

public function unserialize($serialized)
{
list(
$this->id,
$this->password,
$this->username
) = unserialize($serialized);
}


    

    /**
     * Set tipo_socio
     *
     * @param Gremio\AbmBundle\Entity\TipoSocio $tipoSocio
     */
    public function setTipoSocio(\Gremio\AbmBundle\Entity\TipoSocio $tipoSocio)
    {
        $this->tipo_socio = $tipoSocio;
    }

    /**
     * Get tipo_socio
     *
     * @return Gremio\AbmBundle\Entity\TipoSocio 
     */
    public function getTipoSocio()
    {
        return $this->tipo_socio;
    }

    /**
     * Set seccion
     *
     * @param Gremio\AbmBundle\Entity\Seccion $seccion
     */
    public function setSeccion(\Gremio\AbmBundle\Entity\Seccion $seccion)
    {
        $this->seccion = $seccion;
    }

    /**
     * Get seccion
     *
     * @return Gremio\AbmBundle\Entity\Seccion 
     */
    public function getSeccion()
    {
        return $this->seccion;
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

    /**
     * Set margen
     *
     * @param integer $margen
     */
    public function setMargen($margen)
    {
        $this->margen = $margen;
    }

    /**
     * Get margen
     *
     * @return integer 
     */
    public function getMargen()
    {
        return $this->margen;
    }

    /**
     * Add emisiones
     *
     * @param Gremio\SociosBundle\Entity\Emision $emisiones
     */
    public function addEmision(\Gremio\SociosBundle\Entity\Emision $emisiones)
    {
        $this->emisiones[] = $emisiones;
    }

    /**
     * Get emisiones
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getEmisiones()
    {
        return $this->emisiones;
    }

    /**
     * Get fecha_baja
     *
     * @return datetime 
     */
    public function getFechaBaja()
    {
        foreach ($this->getBajas() as $baja)
        {
            if ($baja->getFechaCancelaBaja()==null)
                return $baja->getFechaBaja();
        }
    }

    

    

    /**
     * Add bajas_socio
     *
     * @param Gremio\AbmBundle\Entity\Baja $bajasSocio
     */
    public function addBaja(\Gremio\AbmBundle\Entity\Baja $baja)
    {
        $this->bajas[] = $baja;
    }

    /**
     * Get bajas_socio
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getBajas()
    {
        return $this->bajas;
    }
    
    public function __toString()
    {
        return $this->getApellido().' '.$this->getNombres();
    }

    
}