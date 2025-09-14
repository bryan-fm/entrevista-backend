<?php

declare(strict_types=1);

use Rebing\GraphQL\Support\PaginationType;
use Rebing\GraphQL\Support\SimplePaginationType;

return [

    'route' => [
        'prefix' => 'graphql',
        'controller' => \Rebing\GraphQL\GraphQLController::class . '@query',
        'middleware' => [], // Middleware global opcional
        'group_attributes' => [],
    ],

    'default_schema' => 'default',

    'batching' => [
        'enable' => true,
    ],

    'schemas' => [
        'default' => [
            'query' => [
                // Queries protegidas
                'task' => App\GraphQL\Queries\TaskQuery::class,
            ],

            'mutation' => [
                'createToken' => App\GraphQL\Mutations\CreateTokenMutation::class,
            ],

            'types' => [
                'Task' => App\GraphQL\Types\TaskType::class,
                'User' => App\GraphQL\Types\UserType::class,
                'Kind' => App\GraphQL\Types\KindType::class,
            ],

            // middleware global do schema (não obrigatório, queries/mutations individuais definem middleware)
            'middleware' => [], 
        ],
    ],

    'error_formatter' => [\Rebing\GraphQL\GraphQL::class, 'formatError'],
    'errors_handler' => [\Rebing\GraphQL\GraphQL::class, 'handleErrors'],

    'security' => [
        'query_max_complexity' => null,
        'query_max_depth' => null,
        'disable_introspection' => false,
    ],

    'pagination_type' => PaginationType::class,
    'simple_pagination_type' => SimplePaginationType::class,
    'defaultFieldResolver' => null,
    'headers' => [],
    'json_encoding_options' => 0,

    'execution_middleware' => [
        Rebing\GraphQL\Support\ExecutionMiddleware\ValidateOperationParamsMiddleware::class,
        Rebing\GraphQL\Support\ExecutionMiddleware\AutomaticPersistedQueriesMiddleware::class,
        Rebing\GraphQL\Support\ExecutionMiddleware\AddAuthUserContextValueMiddleware::class,
    ],


    'resolver_middleware_append' => null,
];
