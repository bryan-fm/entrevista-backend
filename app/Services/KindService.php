<?php
namespace App\Services;

use App\Exceptions\Kind\KindCreationException;
use App\Exceptions\Kind\KindNotFoundException;
use App\Exceptions\Kind\KindUpdateException;
use App\Repositories\KindRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class KindService
{
    protected $repository;

    public function __construct(KindRepository $repository)
    {
        $this->repository = $repository;
    }

    public function createKind(array $data)
    {
        try {
            return $this->repository->create($data);
        } catch (\Exception $e) {
            throw new KindCreationException();
        }
    }

    public function updateKind($kindId, array $data)
    {
        $kind = $this->repository->findById($kindId);
        if (!$kind) {
            throw new KindNotFoundException();
        }
        try {
            return $this->repository->update($kind, $data);
        } catch (\Exception $e) {
            throw new KindUpdateException();
        }
    }

    public function getAllKinds()
    {
        return $this->repository->all();
    }

    public function deleteKind($kindId)
    {
        try {
            return $this->repository->delete($kindId);
        } catch (ModelNotFoundException $e) {
            throw new KindNotFoundException();
        } catch (\Exception $e) {
            throw new KindUpdateException();
        }
    }

    public function paginateKinds(int $perPage = 10)
    {
        return $this->repository->paginate($perPage);
    }

    public function findKindById($id)
    {
        try {
            return $this->repository->findById($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            throw new KindNotFoundException();
        }
    }
}