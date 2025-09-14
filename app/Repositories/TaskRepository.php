<?php
namespace App\Repositories;

use App\Http\Resources\TaskResource;
use App\Models\Task;

class TaskRepository
{
    public function all()
    {
        return Task::all();
    }

    public function paginate(int $perPage = 10)
    {
        return Task::paginate($perPage);
    }

    public function findById(int $id): ?Task
    {
        return Task::findOrFail($id);
    }

    public function findByIdWithRelations(int $id): ?TaskResource
    {
        //eager loading
        $task = Task::with(['user', 'kind'])->findOrFail($id);

        return new TaskResource($task);
    }

        public function findByIdWithRelationsGraphql(int $id): ?Task
    {
        //eager loading
        $task = Task::with(['user', 'kind'])->findOrFail($id);

        return $task;
    }
    
    public function create(array $data): Task
    {
        return Task::create($data);
    }

    public function update(Task $task, array $data): Task
    {
        $task->update($data);
        return $task;
    }
    public function delete(int $id): Task
    {
        $task = Task::findOrFail($id);
        $task->delete();
        return $task;
    }

}
