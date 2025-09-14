<?php

namespace App\GraphQL\Types;

use App\Models\Kind;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class KindType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Kind',
        'description' => 'A kind',
        'model' => Kind::class,
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'ID of the user',
            ],
            'description' => [
                'type' => Type::nonNull(Type::string()),
            ],
        ];
    }
}
