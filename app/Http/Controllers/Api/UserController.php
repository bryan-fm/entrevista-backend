<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    protected $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 10);

        return response()->json($this->service->paginateUsers($perPage), Response::HTTP_OK);
    }

    public function allUsers(Request $request) {
        return response()->json($this->service->getAllUsers(), Response::HTTP_OK);
    }

    public function store(StoreUserRequest $request)
    {
        $user = $this->service->createUser($request->validated());
        return response()->json($user, Response::HTTP_CREATED);
    }

    public function find(Int $userId)
    {
        $user = $this->service->findUserById($userId);
        return response()->json($user, Response::HTTP_OK);
    }

    public function update(UpdateUserRequest $request, Int $userId)
    {
        $updated = $this->service->updateUser($userId, $request->validated());
        return response()->json($updated, Response::HTTP_OK);
    }

    public function destroy(User $user)
    {
        $this->service->deleteUser($user);
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}