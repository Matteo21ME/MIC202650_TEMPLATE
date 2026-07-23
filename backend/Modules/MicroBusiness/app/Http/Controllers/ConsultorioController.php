<?php

namespace Modules\MicroBusiness\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\MicroBusiness\Http\Requests\StoreConsultorioRequest;
use Modules\MicroBusiness\Http\Requests\UpdateConsultorioRequest;
use Modules\MicroBusiness\Http\Services\ConsultorioService;

class ConsultorioController extends Controller
{
    public function __construct(private readonly ConsultorioService $consultorioService)
    {
    }

    public function index()
    {
        return response()->json($this->consultorioService->getAll(), 200);
    }

    public function show($id)
    {
        return response()->json($this->consultorioService->getById((int) $id), 200);
    }

    public function store(StoreConsultorioRequest $request)
    {
        return response()->json($this->consultorioService->create($request->validated()), 201);
    }

    public function update(UpdateConsultorioRequest $request, $id)
    {
        return response()->json($this->consultorioService->update((int) $id, $request->validated()), 200);
    }

    public function destroy($id)
    {
        $this->consultorioService->delete((int) $id);
        return response()->json(null, 204);
    }
}