<?php

namespace Modules\MicroAuth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'unique:microauth.users,email'],
            'password' => ['required', 'string', 'min:6'],
            'role_id'  => ['required', 'integer', 'exists:microauth.roles,id'],
        ];
    }
}
