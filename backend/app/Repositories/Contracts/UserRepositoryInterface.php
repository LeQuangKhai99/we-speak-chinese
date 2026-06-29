<?php

namespace App\Repositories\Contracts;

use App\Models\User;

interface UserRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Find a user by their email address.
     *
     * @param  string  $email
     * @return User|null
     */
    public function findByEmail(string $email): ?User;
}
