<?php

namespace Modules\MicroBusiness\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\MicroBusiness\Http\Requests\StoreMedicoRequest;
use Modules\MicroBusiness\Http\Requests\UpdateMedicoRequest;
use Modules\MicroBusiness\Http\Services\MedicoService;

class MedicoController extends Controller
{
    public function __construct(private readonly MedicoService $medicoService)
    {
    }

    public function index()
    {
        return response()->json($this->medicoService->getAll(), 200);
    }

    public function show($id)
    {
        return response()->json($this->medicoService->getById((int) $id), 200);
    }

    public function store(StoreMedicoRequest $request)
    {
        return response()->json($this->medicoService->create($request->validated()), 201);
    }

    public function update(UpdateMedicoRequest $request, $id)
    {
        return response()->json($this->medicoService->update((int) $id, $request->validated()), 200);
    }

    public function destroy($id)
    {
        $this->medicoService->delete((int) $id);
        return response()->json(null, 204);
    }
}