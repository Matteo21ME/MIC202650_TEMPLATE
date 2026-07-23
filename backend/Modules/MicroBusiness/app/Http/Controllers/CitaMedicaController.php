<?php

namespace Modules\MicroBusiness\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\MicroBusiness\Http\Requests\StoreCitaMedicaRequest;
use Modules\MicroBusiness\Http\Requests\UpdateCitaMedicaRequest;
use Modules\MicroBusiness\Http\Services\CitaMedicaService;

class CitaMedicaController extends Controller
{
    public function __construct(private readonly CitaMedicaService $citaMedicaService)
    {
    }

    public function index()
    {
        return response()->json($this->citaMedicaService->getAll(), 200);
    }

    public function show($id)
    {
        return response()->json($this->citaMedicaService->getById((int) $id), 200);
    }

    public function store(StoreCitaMedicaRequest $request)
    {
        return response()->json($this->citaMedicaService->create($request->validated()), 201);
    }

    public function update(UpdateCitaMedicaRequest $request, $id)
    {
        return response()->json($this->citaMedicaService->update((int) $id, $request->validated()), 200);
    }

    public function destroy($id)
    {
        $this->citaMedicaService->delete((int) $id);
        return response()->json(null, 204);
    }
}