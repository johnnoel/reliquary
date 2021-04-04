<?php

declare(strict_types=1);

namespace App\Security;

use App\Entity\User;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthAwareUserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserProvider implements OAuthAwareUserProviderInterface, UserProviderInterface
{
    public function loadUserByOAuthUserResponse(UserResponseInterface $response): User
    {
        $data = $response->getData();

        if (!array_key_exists('id_str', $data) || !array_key_exists('screen_name', $data)) {
            throw new UsernameNotFoundException('Required fields id_str and screen_name not found in response data');
        }

        $id = $data['id_str'];
        $username = $data['screen_name'];

        return new User($username, $id);
    }

    public function loadUserByUsername(string $username): UserInterface
    {
        throw new \RuntimeException('loadUserByUsername should never be called');
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        // don't do anything, pass straight through
        return $user;
    }

    public function supportsClass(string $class): bool
    {
        return $class === User::class;
    }
}
