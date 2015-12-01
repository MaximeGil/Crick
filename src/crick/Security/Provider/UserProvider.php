<?php

namespace crick\Security\Provider;

use PommProject\ModelManager\Session;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use PommProject\Foundation\Pomm;

class UserProvider implements UserProviderInterface {

    private $conn;

    public function __construct(Session $conn) {
        $this->conn = $conn;
    }

    public function getUsernameForApiKey($apiKey) {
        $user = $this->conn
                ->getModel('db\Db\PublicSchema\UsersModel')
                ->findWhere('pass = $*', array($apiKey));
        
        foreach($user as $target)
        {
            $user = $target['name'];
        }
        return $user;
    }

    public function loadUserByUsername($username) {
        $name = null;
        $pass = null;
        $role= null; 
        
        $user = $this->conn
                ->getModel('db\Db\PublicSchema\UsersModel')
                ->findWhere('name = $*', array($username));
        if ($user->isEmpty()) {
            throw new UsernameNotFoundException(sprintf('Username "%s" does not exist.', $username));
        }
        
        foreach($user as $target)
        {
            $name = $target['name'];
            $pass = $target['pass'];
            $role = $target['role'];
        }

        return new User($name, $pass, array($role), true, true, true, true);
    }

    public function refreshUser(UserInterface $user) {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
        }
        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass($class) {
        return $class === 'Symfony\Component\Security\Core\User\User';
    }

}
