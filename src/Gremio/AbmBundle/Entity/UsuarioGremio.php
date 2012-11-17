<?php

namespace Gremio\AbmBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;



/**
 * Gremio\AbmBundle\Entity\UsuarioGremio
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="usuariogremio")
 * @ORM\Entity(repositoryClass="Gremio\AbmBundle\Entity\UsuarioGremioRepository")
 */
class UsuarioGremio implements UserInterface, \Serializable
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
     * @var bigint $num_documento
     *
     * @ORM\Column(name="num_documento", type="string")
     */
    protected $num_documento;

   
  
    /**
     * @var string $apellido
     * @ORM\Column(name="apellido", type="string")
     */
    protected $apellido;

    /**
     * @var string $aombres
     *
     * @ORM\Column(name="nombres", type="string")
     */
    protected $nombres;

    /**
     * @var string $Domicilio
     *
     * @ORM\Column(name="domicilio", type="string")
     */
    protected $domicilio;

    
    /**
     * @var string $email
     *
     * @ORM\Column(name="email", type="string", length=30, nullable="true")
     */
    protected $email;

    /**
     * @var datetime $fecha_nacimiento
     *
     * @ORM\Column(name="fecha_nacimiento", type="datetime", nullable="true")
     */
    protected $fecha_nacimiento;
	
    
    /**
     * 
     *
     * @ORM\Column(name="sexo", type="string")
     */
    protected $sexo;
    
   
    
    
    
    
    
    
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
        if($this->getFechaBaja())
            return array('ROLE_BAJA');
        else
            return array('ROLE_GREMIO');
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
        $this->setPassword($encoder->encodePassword('gremio', $this->getSalt()));
        
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set num_documento
     *
     * @param string $numDocumento
     */
    public function setNumDocumento($numDocumento)
    {
        $this->num_documento = $numDocumento;
    }

    /**
     * Get num_documento
     *
     * @return string 
     */
    public function getNumDocumento()
    {
        return $this->num_documento;
    }

    /**
     * Set apellido
     *
     * @param string $apellido
     */
    public function setApellido($apellido)
    {
        $this->apellido = $apellido;
    }

    /**
     * Get apellido
     *
     * @return string 
     */
    public function getApellido()
    {
        return $this->apellido;
    }

    /**
     * Set nombres
     *
     * @param string $nombres
     */
    public function setNombres($nombres)
    {
        $this->nombres = $nombres;
    }

    /**
     * Get nombres
     *
     * @return string 
     */
    public function getNombres()
    {
        return $this->nombres;
    }

    /**
     * Set domicilio
     *
     * @param string $domicilio
     */
    public function setDomicilio($domicilio)
    {
        $this->domicilio = $domicilio;
    }

    /**
     * Get domicilio
     *
     * @return string 
     */
    public function getDomicilio()
    {
        return $this->domicilio;
    }

    /**
     * Set email
     *
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set fecha_nacimiento
     *
     * @param datetime $fechaNacimiento
     */
    public function setFechaNacimiento($fechaNacimiento)
    {
        $this->fecha_nacimiento = $fechaNacimiento;
    }

    /**
     * Get fecha_nacimiento
     *
     * @return datetime 
     */
    public function getFechaNacimiento()
    {
        return $this->fecha_nacimiento;
    }

    /**
     * Set sexo
     *
     * @param string $sexo
     */
    public function setSexo($sexo)
    {
        $this->sexo = $sexo;
    }

    /**
     * Get sexo
     *
     * @return string 
     */
    public function getSexo()
    {
        return $this->sexo;
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