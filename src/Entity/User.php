<?php

declare(strict_types=1);

namespace App\Entity;

use Symfony\Component\Security\Core\User\UserInterface;

class User implements UserInterface
{
    public function __construct(private string $username, private string $id)
    {
    }

    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return array<string>
     */
    public function getRoles(): array
    {
        return [ 'ROLE_USER' ];
    }

    public function getPassword(): string
    {
        return '';
    }

    public function getSalt(): string
    {
        return '';
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function eraseCredentials(): void
    {
    }
}
