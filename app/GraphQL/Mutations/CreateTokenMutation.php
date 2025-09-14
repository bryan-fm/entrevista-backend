<?php

namespace App\GraphQL\Mutations;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Support\Facades\Auth;

class CreateTokenMutation extends Mutation
{
    protected $attributes = [
        'name' => 'login',
        'description' => 'Authenticate user and return JWT token',
    ];

    public function type(): Type
    {
        return Type::string(); // retorna apenas o token
    }

    public function args(): array
    {
        return [
            'email' => ['type' => Type::nonNull(Type::string())],
            'password' => ['type' => Type::nonNull(Type::string())],
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $info)
    {
        if (!$token = Auth::guard('api')->attempt([
            'email' => $args['email'],
            'password' => $args['password'],
        ])) {
            throw new \GraphQL\Error\Error('Invalid credentials');
        }

        return $token;
    }
}
