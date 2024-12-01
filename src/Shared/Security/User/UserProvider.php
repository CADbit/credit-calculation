<?php

namespace App\Shared\Security\User;

use LogicException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserProvider implements UserProviderInterface
{
    public function refreshUser(UserInterface $user): UserInterface
    {
        if (! $user instanceof User) {
            throw new UnsupportedUserException('Nieobsługiwany typ użytkownika.');
        }

        return $user;
    }

    public function supportsClass(string $class): bool
    {
        return $class === User::class;
    }

    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        if ($identifier === 'admin') {
            return new User($identifier, ['ROLE_ADMIN']);
        }

        if ($identifier === 'user') {
            return new User($identifier, ['ROLE_USER']);
        }

        throw new LogicException('Użytkownik nie istnieje.');
    }
}
