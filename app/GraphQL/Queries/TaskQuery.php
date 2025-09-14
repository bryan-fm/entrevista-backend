<?php

namespace App\GraphQL\Queries;

use App\GraphQL\Auth\Authenticate;
use App\Models\Task;
use App\Services\TaskService;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;

class TaskQuery extends Query
{    protected $attributes = [
        'name' => 'taskQuery',
        'description' => 'Get a single task'
    ];

    protected TaskService $service;

    public function __construct(TaskService $service)
    {
        $this->service = $service;
    }

    public function type(): Type
    {
        return GraphQL::type('Task');
    }

    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::nonNull(Type::int()),
            ]
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $info)
    {
        $user = auth('api')->user(); // força o guard 'api'

        if (!$user) {
            throw new \Exception('Unauthorized');
        }

        // Extrai os campos solicitados
        $fields = collect($info->getFieldSelection(1));

        $query = Task::query();

        // Se o cliente pediu "user", faz eager loading
        if ($fields->has('user')) {
            $query->with('user');
        }

        // Se pediu "kind", faz eager loading também
        if ($fields->has('kind')) {
            $query->with('kind');
        }

        return $query->findOrFail($args['id']);
    }
}
