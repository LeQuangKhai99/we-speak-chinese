<?php

namespace App\Actions;

use App\DTOs\RegisterDTO;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class RegisterUserAction
{
    /**
     * RegisterUserAction constructor.
     */
    public function __construct(
        protected UserRepositoryInterface $userRepository
    ) {}

    /**
     * Execute the registration action.
     *
     * @param  RegisterDTO  $dto
     * @return User
     */
    public function execute(RegisterDTO $dto): User
    {
        /** @var User */
        return $this->userRepository->create([
            'name' => $dto->name,
            'email' => $dto->email,
            'password' => Hash::make($dto->password),
        ]);
    }
}
