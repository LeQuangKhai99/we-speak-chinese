<?php

namespace App\DTOs;

class RegisterDTO extends BaseDTO
{
    /**
     * RegisterDTO constructor.
     */
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $password
    ) {}

    /**
     * Create RegisterDTO from array.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            email: $data['email'],
            password: $data['password']
        );
    }
}
