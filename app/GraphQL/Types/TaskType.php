<?php

namespace App\GraphQL\Types;

use App\Models\Task;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;

class TaskType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Task',
        'description' => 'A task',
        'model' => Task::class,
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'ID of the task',
            ],
            'title' => [
                'type' => Type::nonNull(Type::string()),
            ],
            'description' => [
                'type' => Type::string(),
            ],
            'user' => [
                'type' => GraphQL::type('User'),
                'resolve' => function(Task $task) {
                    return $task->user;
                }
            ],
            'kind' => [
                'type' => GraphQL::type('Kind'),
                'resolve' => function(Task $task) {
                    return $task->kind;
                }
            ],
        ];
    }
}
