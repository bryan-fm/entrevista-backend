<?php
namespace App\Repositories;

use App\Models\Kind;

class KindRepository
{
    public function all()
    {
        return Kind::all();
    }

    public function paginate(int $perPage = 10)
    {
        return Kind::paginate($perPage);
    }

    public function findById(int $id): ?Kind
    {
        return Kind::findOrFail($id);
    }

    public function create(array $data): Kind
    {
        return Kind::create($data);
    }

    public function update(Kind $kind, array $data): Kind
    {
        $kind->update($data);
        return $kind;
    }
    public function delete(int $id): Kind
    {
        $kind = Kind::findOrFail($id);
        $kind->delete();
        return $kind;
    }

}
