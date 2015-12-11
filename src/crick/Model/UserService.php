<?php
namespace crick\Model;

use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Description of FormRegister.
 *
 * @author maxime
 */
class UserService implements UserInterface
{
	private $username;
	private $password;
	private $apikey;
	private $roles;

    public function __construct($username, $password, $apikey, $roles)
    {
    	$this->username = $username;
    	$this->password = $password;
    	$this->apikey = $apikey;
    	$this->roles = $roles; 
    }

    public function getRoles()
    {

    	return $this->roles;
    }

    public function getPassword()
    {
    	return $this->password;
    }

    public function getApiKey()
    {
    	return $this->getApiKey();
    }

    public function isEqualTo(UserInterface $user)
    {
        if (!$user instanceof User) {
            return false;
        }

        if ($this->password !== $user->getPassword()) {
            return false;
        }

        if ($this->apikey !== $user->getApiKey()) {
            return false;
        }

        if ($this->username !== $user->getUsername()) {
            return false;
        }

        return true;
    }

    public function eraseCredentials() {
        
    }

    public function getSalt() {
        
    }

    public function getUsername() {
        return $this->username; 
    }

}
