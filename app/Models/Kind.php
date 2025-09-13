<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kind extends Model
{
    use HasFactory;

    protected $table = 'kinds';

    protected $fillable = [
      'description'
    ];

    public static function rules(): array
    {
        return [
            'description' => ['required', 'string', 'max:255'],
        ];
    }
}
