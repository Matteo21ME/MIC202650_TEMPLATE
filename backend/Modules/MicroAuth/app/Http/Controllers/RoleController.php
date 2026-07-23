<?php

namespace Modules\MicroAuth\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Modules\MicroAuth\Models\Role;

class RoleController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Role::orderBy('nombre')->get(), 200);
    }
}
