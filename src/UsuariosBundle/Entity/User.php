<?php

namespace UsuariosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
/**
 * @ORM\Entity
 * @UniqueEntity(fields="username", message="Nombre de usuario ya existe")
 */
/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="UsuariosBundle\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="username", type="string", length=255, unique=true)
     */
    private $username;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var string
     * @ORM\Column(name="password", type="string", length=64)
     */
    private $password;
    /**
    * @Assert\NotBlank()
    * @Assert\Length(max=4096)
    */
     private $plainPassword;
    /**
    *
    * @ORM\Column(type="json_array")
    */
    private  $roles  =  array ();
    
    /**
     * @ORM\ManyToOne(targetEntity="EmpresasBundle\Entity\Empresa", inversedBy="user")
     * @ORM\JoinColumn(name="empresa", referencedColumnName="id")
     */
    private $empresa;

     /**
     * @var bool
     *
     * @ORM\Column(name="Baja", type="boolean", nullable=true)
     */
    private $baja; 
    
    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return User
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    public function getPlainPassword()
    {
       return $this->plainPassword;
    }
    public function setPlainPassword($password)
    {
       $this->plainPassword = $password;
    }
    /**
     * Set empresa
     *
     * @param \EmpresasBundle\Entity\Empresa $empresa
     *
     * @return User
     */
    public function setEmpresa(\EmpresasBundle\Entity\Empresa $empresa)
    {
        $this->empresa = $empresa;
        return $this;
    }
    /**
     * Get empresa
     *
     * @return int
     */
    public function getEmpresa()
    {
        return $this->empresa;
    }
    
    public function getSalt()
    {
        // The bcrypt and argon2i algorithms don't require a separate salt.
        // You *may* need a real salt if you choose a different encoder.
        return null;
    }
    public function eraseCredentials() {
    }
    
    public function getRoles()
    {
      return $this->roles;
     }
    public function setRoles($roles)
    {
        $this->roles = $roles;
    }
    
    
    
    
     /**
     * Set baja
     *
     * @param boolean $baja
     *
     * @return User
     */
    public function setBaja($baja)
    {
        $this->baja = $baja;
        return $this;
    }
    /**
     * Get baja
     *
     * @return bool
     */
    public function getBaja()
    {
        return $this->baja;
    }    
}

