<?php

namespace App\DTOs;

class LoginDTO extends BaseDTO
{
    /**
     * LoginDTO constructor.
     */
    public function __construct(
        public readonly string $email,
        public readonly string $password
    ) {}

    /**
     * Create LoginDTO from array.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            email: $data['email'],
            password: $data['password']
        );
    }
}
