<?php

declare(strict_types=1);

namespace App\Web\Model;

use Marko\Authentication\AuthenticatableInterface;

class User implements AuthenticatableInterface
{
    public function __construct(
        private int $id,
        private string $email,
        private string $password,
        private string $name,
        private string $role,
        private string $location,
        private string $joined,
        private string $bio,
        private ?string $rememberToken = null,
    ) {}

    public function getAuthIdentifier(): int
    {
        return $this->id;
    }

    public function getAuthIdentifierName(): string
    {
        return 'id';
    }

    public function getAuthPassword(): string
    {
        return $this->password;
    }

    public function getRememberToken(): ?string
    {
        return $this->rememberToken;
    }

    public function setRememberToken(?string $token): void
    {
        $this->rememberToken = $token;
    }

    public function getRememberTokenName(): string
    {
        return 'remember_token';
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'location' => $this->location,
            'joined' => $this->joined,
            'bio' => $this->bio,
        ];
    }
}
