<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Kind\StoreKindRequest;
use App\Http\Requests\Kind\UpdateKindRequest;
use App\Services\KindService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class KindController extends Controller
{
    protected $service;

    public function __construct(KindService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 10);

        return response()->json($this->service->paginateKinds($perPage), Response::HTTP_OK);
    }

    public function allKinds(Request $request) {
        return response()->json($this->service->getAllKinds(), Response::HTTP_OK);
    }

    public function store(StoreKindRequest $request)
    {
        $kind = $this->service->createKind($request->validated());
        return response()->json($kind, Response::HTTP_CREATED);
    }

    public function find(Int $kindId)
    {
        $kind = $this->service->findKindById($kindId);
        return response()->json($kind, Response::HTTP_OK);
    }

    public function delete(Int $kindId)
    {
        $deleted = $this->service->deleteKind($kindId);
        return response()->json($deleted, Response::HTTP_OK);
    }

    public function update(UpdateKindRequest $request, Int $kindId)
    {
        $updated = $this->service->updateKind($kindId, $request->validated());
        return response()->json($updated, Response::HTTP_OK);
    }
}