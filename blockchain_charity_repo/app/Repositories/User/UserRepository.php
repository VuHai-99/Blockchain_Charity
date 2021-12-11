<?php

namespace App\Repositories\User;

use App\Repositories\BaseRepository;
use App\User;

class UserRepository extends BaseRepository
{
    public function __construct(User $user)
    {
        parent::__construct($user);
    }

    public function updateUser($userAddress, $data)
    {
        return $this->model->where('user_address', $userAddress)->update($data);
    }
}