<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Kind;

class Task extends Model
{
    use HasFactory;

    protected $table = 'tasks';

    /**
     * Campos que podem ser preenchidos em mass assignment.
     */
    protected $fillable = [
        'title',
        'description',
        'user_id',
        'kind_id',
    ];

    /**
     * Relação com User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relação com Kind (categoria/tipo da tarefa).
     */
    public function kind()
    {
        return $this->belongsTo(Kind::class);
    }

    /**
     * Regras de validação (opcional, se você usar FormRequest ou serviço).
     */
    public static function rules(): array
    {
        return [
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'user_id'     => ['required', 'exists:users,id'],
            'kind_id'     => ['required', 'exists:kinds,id'],
        ];
    }
}