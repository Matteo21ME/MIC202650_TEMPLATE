<?php

namespace Modules\MicroBusiness\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\MicroBusiness\Http\Requests\StorePacienteRequest;
use Modules\MicroBusiness\Http\Requests\UpdatePacienteRequest;
use Modules\MicroBusiness\Http\Services\PacienteService;

class PacienteController extends Controller
{
    public function __construct(private readonly PacienteService $pacienteService)
    {
    }

    public function index()
    {
        return response()->json($this->pacienteService->getAll(), 200);
    }

    public function show($id)
    {
        return response()->json($this->pacienteService->getById((int) $id), 200);
    }

    public function store(StorePacienteRequest $request)
    {
        return response()->json($this->pacienteService->create($request->validated()), 201);
    }

    public function update(UpdatePacienteRequest $request, $id)
    {
        return response()->json($this->pacienteService->update((int) $id, $request->validated()), 200);
    }

    public function destroy($id)
    {
        $this->pacienteService->delete((int) $id);
        return response()->json(null, 204);
    }
}