<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    /** @var User */
    protected $model;

    /**
     * UserRepository constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    /**
     * @param array<string, string> $inputs
     * @return mixed
     */
    public function create(array $inputs)
    {
        return $this->model->create($inputs);
    }

    /**
     * @param User $user
     * @param array<string, string> $inputs
     * @return User
     */
    public function update(User $user, array $inputs)
    {
        $user->fill($inputs);

        $user->save();

        return $user;
    }
}
