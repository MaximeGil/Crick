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

    public function loadUserByUsername($username) {

        $user = $this->conn
                ->getModel('db\Db\PublicSchema\UsersModel')
                ->findWhere('name = $*', array(strtolower($username)));

        if ($user->isEmpty()) {
            throw new UsernameNotFoundException(sprintf('Username "%s" does not exist.', $username));
        }
        return new User($user->get('name'), $user->get('pass'), array($user->get('role')), true, true, true, true);
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
