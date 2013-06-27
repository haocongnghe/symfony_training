<?php
// src/Study/BlogBundle/Entity/User.php
namespace Study\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;

/**
 * @ORM\Entity(repositoryClass="Study\BlogBundle\Entity\UserRepository")
 * @ORM\Table(name="user")
 * @ORM\HasLifecycleCallbacks()
 */

class User implements UserInterface, \Serializable
{
   /**
    * @ORM\Column(type="integer")
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="AUTO")
    */
   private $id;
   
   /**
    * @ORM\Column(type="string", length=25, unique=true)
    */
   private $username;
   
   /**
    * @ORM\Column(type="string", length=32)
    */
   private $salt;
   
   /**
    * @ORM\Column(type="string", length=255)
    */
   private $password;
   
   /**
    * @ORM\Column(type="string", length=60, unique=true)
    */
   private $email;
   
   /**
    * @ORM\Column(name="is_active", type="boolean")
    */
   private $isActive;
   
   /**
    *@ORM\Column(type="string") 
    */
   private $role;


   public function __construct() {
	   $this->isActive = true;
	   $this->salt = md5(uniqid(null, true));
   }
   
   /**
    * @inheritDoc
    */
   public function getUsername() {
	   return $this->username;
   }
   
   /**
    * @inheritDoc
    */
   public function getSalt() {
	   return $this->salt;
   }
   
   /**
    * @inheritDoc
    */
   public function getPassword() {
	   return $this->password;
   }
   
   /**
    * @inheritDoc
    */
   public function getRoles() {
	   return array($this->getRole());
   }
   
   /**
    * @inheritDoc
    */
   public function eraseCredentials() {
	   
   }
   
   /**
    * @see \Serializable::serialize()
    */
   public function serialize() {
	   return serialize(array(
			$this->id,
	   ));
   }
   
   /**
    * @see \Serializable:unserialize()
    */
   public function unserialize($serialized) {
	   list (
	   $this->id,
	) = unserialize($serialized);
   }
   
   /**
    * @param UserInterface $user
    */
   public function isEqualTo(UserInterface $user)
   {
	   return $this->id === $user->getId();
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
     * Set username
     *
     * @param string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;
    
        return $this;
    }

    /**
     * Set salt
     *
     * @param string $salt
     * @return User
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
    
        return $this;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
		$encoder = new MessageDigestPasswordEncoder();
        $password = $encoder->encodePassword($password, $this->getSalt());
        $this->password = $password;
    
        return $this;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
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
     * Set isActive
     *
     * @param boolean $isActive
     * @return User
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
    
        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean 
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set role
     *
     * @param string $role
     * @return User
     */
    public function setRole($role)
    {
        $this->role = $role;
    
        return $this;
    }

    /**
     * Get role
     *
     * @return string 
     */
    public function getRole()
    {
        return $this->role;
    }
}