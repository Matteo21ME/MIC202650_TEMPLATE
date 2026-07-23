<?php

namespace Modules\MicroBusiness\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\MicroBusiness\Http\Requests\StoreEspecialidadRequest;
use Modules\MicroBusiness\Http\Requests\UpdateEspecialidadRequest;
use Modules\MicroBusiness\Http\Services\EspecialidadService;

class EspecialidadController extends Controller
{
    public function __construct(private readonly EspecialidadService $especialidadService)
    {
    }

    public function index()
    {
        return response()->json($this->especialidadService->getAll(), 200);
    }

    public function show($id)
    {
        return response()->json($this->especialidadService->getById((int) $id), 200);
    }

    public function store(StoreEspecialidadRequest $request)
    {
        return response()->json($this->especialidadService->create($request->validated()), 201);
    }

    public function update(UpdateEspecialidadRequest $request, $id)
    {
        return response()->json($this->especialidadService->update((int) $id, $request->validated()), 200);
    }

    public function destroy($id)
    {
        $this->especialidadService->delete((int) $id);
        return response()->json(null, 204);
    }
}