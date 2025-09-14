<?php

namespace App\GraphQL\Queries;

use App\Services\TaskService;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;

class TaskQuery extends Query
{
    protected $attributes = [
        'name' => 'task',
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

    public function resolve($root, $args)
    {
        return $this->service->findTaskById($args['id']);
    }
}
