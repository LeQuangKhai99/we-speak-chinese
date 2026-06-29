<?php

namespace App\DTOs;

abstract class BaseDTO
{
    /**
     * Create a DTO instance from an array of data.
     *
     * @param  array  $data
     * @return static
     */
    abstract public static function fromArray(array $data): self;
}
