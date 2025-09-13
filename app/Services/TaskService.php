<?php
namespace App\Services;

use App\Exceptions\Task\TaskCreationException;
use App\Exceptions\Task\TaskNotFoundException;
use App\Exceptions\Task\TaskUpdateException;
use App\Repositories\TaskRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TaskService
{
    protected $repository;

    public function __construct(TaskRepository $repository)
    {
        $this->repository = $repository;
    }

    public function createTask(array $data)
    {
        try {
            return $this->repository->create($data);
        } catch (\Exception $e) {
            throw new TaskCreationException();
        }
    }

    public function updateTask($taskId, array $data)
    {
        $task = $this->repository->findById($taskId);
        if (!$task) {
            throw new TaskNotFoundException();
        }
        try {
            return $this->repository->update($task, $data);
        } catch (\Exception $e) {
            throw new TaskUpdateException();
        }
    }

    public function getAllTasks()
    {
        return $this->repository->all();
    }

    public function deleteTask($taskId)
    {
        try {
            return $this->repository->delete($taskId);
        } catch (ModelNotFoundException $e) {
            throw new TaskNotFoundException();
        } catch (\Exception $e) {
            throw new TaskUpdateException();
        }
    }

    public function paginateTasks(int $perPage = 10)
    {
        return $this->repository->paginate($perPage);
    }

    public function findTaskById($id)
    {
        try {
            return $this->repository->findById($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            throw new TaskNotFoundException();
        }
    }

        public function findTaskByIdWithRelations($id)
    {
        try {
            return $this->repository->findByIdWithRelations($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            throw new TaskNotFoundException();
        }
    }
}