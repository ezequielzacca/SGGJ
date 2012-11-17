<?php

namespace Gremio\ProveedoresBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;


/**
 * Gremio\ProveedoresBundle\Entity\Cajero
 *
 * @ORM\Table(name="cajero")
 * @ORM\Entity(repositoryClass="Gremio\ProveedoresBundle\Entity\CajeroRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Cajero implements UserInterface, \Serializable
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
     * @var string $apellido
     *
     * @ORM\Column(name="apellido", type="string", length=50)
     */
    private $apellido;

    /**
     * @var string $nombres
     *
     * @ORM\Column(name="nombres", type="string", length=50)
     */
    private $nombres;

    /**
     * @var string $numero_documento
     *
     * @ORM\Column(name="numero_documento", type="string", length=8, nullable=true)
     */
    private $numero_documento;

    /**
     * @var string $email
     *
     * @ORM\Column(name="email", type="string", length=50)
     */
    private $email;

    /**
     * @var datetime $created_at
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $created_at;
    
    /**
     * @ORM\ManyToOne(targetEntity="Proveedor")
     * @ORM\JoinColumn(name="proveedor_id", referencedColumnName="id") 
     */
    
    protected $proveedor;

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
    public function getId()
    {
        return $this->id;
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
     * Set numero_documento
     *
     * @param string $numeroDocumento
     */
    public function setNumeroDocumento($numeroDocumento)
    {
        $this->numero_documento = $numeroDocumento;
    }

    /**
     * Get numero_documento
     *
     * @return string 
     */
    public function getNumeroDocumento()
    {
        return $this->numero_documento;
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
     * Set created_at
     *
     * @param datetime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;
    }

    /**
     * Get created_at
     *
     * @return datetime 
     */
    public function getCreatedAt()
    {
        return $this->created_at;
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
    

    
    /* ###############################################################
     * Fin Propiedades Relacionadas con el rol de Usuario de la Aplicacion
     * ###############################################################
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
            return array('ROLE_PROVEEDOR');
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
    
    
    /**
     * @ORM\prePersist 
     */    
    public function setUserPass()
    {
        $this->setUsername(strtolower(substr($this->getNombres(),0,1)) . strtolower($this->getApellido()));
        $encoder = new MessageDigestPasswordEncoder('sha512', true, 10);
        $this->setSalt(md5(time()));
        $this->setPassword($encoder->encodePassword('proveedor', $this->getSalt()));
        
    }
    
    
    public function __construct()
    {
        $this->setCreatedAt(new \DateTime());
    }
    
    
    public function getCompleteName()
    {
        return 'Cajero de: '.$this->getProveedor()->getRazonSocial().' '. $this->getApellido() .' ' .$this->getNombres();
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