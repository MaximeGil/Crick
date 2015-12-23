<?php

namespace crick\Security\Provider;

use PommProject\ModelManager\Session;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use crick\Service\UserService;

class UserProvider implements UserProviderInterface {

    private $session;

    public function __construct(Session $session) {
        $this->session = $session;
    }

    public function getUsernameForApiKey($apiKey) {
        $users = $this->session
                ->getModel('db\Db\PublicSchema\UsersModel')
                ->findWhere('api = $*', array($apiKey));

        if ($users->isEmpty()) {
            throw new UsernameNotFoundException(sprintf('Cannot find user for API key = "%s"', $apiKey));
        }

        return $users->get(0)->getEmail();
    }

    public function loadUserByUsername($username) {
        $users = $this->session
                ->getModel('db\Db\PublicSchema\UsersModel')
                ->findWhere('email = $*', [$username]);

        if ($users->isEmpty()) {
            throw new UsernameNotFoundException(sprintf('Username "%s" does not exist.', $username));
        }

        $user = $users->get(0);

        return new UserService(
                $user['email'], $user['password'], $user['api'], $user['role'] ? [$user['role']] : []
        );
    }

    public function refreshUser(UserInterface $user) {
        if (!$user instanceof UserService) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
        }
        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass($class) {
        return $class === 'Symfony\Component\Security\Core\User\User';
    }

}
