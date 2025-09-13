<?php
namespace App\Services;

use App\Exceptions\User\UserCreationException;
use App\Exceptions\User\UserDeleteException;
use App\Exceptions\User\UserNotFoundException;
use App\Exceptions\User\UserUpdateException;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;

class UserService
{
    protected $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function createUser(array $data)
    {
        try {
            $data['password'] = Hash::make($data['password']);
            return $this->repository->create($data);
        } catch (\Exception $e) {
            throw new UserCreationException();
        }
    }

    public function updateUser($userId, array $data)
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        $user = $this->repository->findById($userId);
        if (!$user) {
            throw new UserNotFoundException();
        }
        try {
            return $this->repository->update($user, $data);
        } catch (\Exception $e) {
            throw new UserUpdateException();
        }
    }

    public function getAllUsers()
    {
        return $this->repository->all();
    }

    public function paginateUsers(int $perPage = 10)
    {
        return $this->repository->paginate($perPage);
    }

    public function findUserById($id)
    {
        try {
            return $this->repository->findById($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            throw new UserNotFoundException();
        }
    }
}