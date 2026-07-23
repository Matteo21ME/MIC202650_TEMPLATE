<?php

namespace Modules\MicroAuth\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Modules\MicroAuth\Http\Requests\StoreUserRequest;
use Modules\MicroAuth\Http\Requests\UpdateUserRequest;
use Modules\MicroAuth\Models\User;

class UserController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(User::with('role')->orderBy('id')->get(), 200);
    }

    public function show(int $id): JsonResponse
    {
        return response()->json(User::with('role')->findOrFail($id), 200);
    }

    public function store(StoreUserRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);

        return response()->json($user->load('role'), 201);
    }

    public function update(UpdateUserRequest $request, int $id): JsonResponse
    {
        $user = User::findOrFail($id);
        $data = $request->validated();

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);

        return response()->json($user->fresh()->load('role'), 200);
    }

    public function destroy(int $id): JsonResponse
    {
        User::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}
