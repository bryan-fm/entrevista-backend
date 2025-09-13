<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Services\TaskService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends Controller
{
    protected $service;

    public function __construct(TaskService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 10);

        return response()->json($this->service->paginateTasks($perPage), Response::HTTP_OK);
    }

    public function allTasks(Request $request) {
        return response()->json($this->service->getAllTasks(), Response::HTTP_OK);
    }

    public function store(StoreTaskRequest $request)
    {
        $task = $this->service->createTask($request->validated());
        return response()->json($task, Response::HTTP_CREATED);
    }

    public function find(Int $taskId)
    {
        $task = $this->service->findTaskByIdWithRelations($taskId);
        return response()->json($task, Response::HTTP_OK);
    }

    public function delete(Int $taskId)
    {
        $deleted = $this->service->deleteTask($taskId);
        return response()->json($deleted, Response::HTTP_OK);
    }

    public function update(UpdateTaskRequest $request, Int $taskId)
    {
        $updated = $this->service->updateTask($taskId, $request->validated());
        return response()->json($updated, Response::HTTP_OK);
    }
}