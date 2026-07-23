<?php

namespace Modules\MicroAuth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->route('id');

        return [
            'name'     => ['sometimes', 'required', 'string', 'max:255'],
            'email'    => ['sometimes', 'required', 'email', "unique:microauth.users,email,{$userId}"],
            'password' => ['sometimes', 'required', 'string', 'min:6'],
            'role_id'  => ['sometimes', 'required', 'integer', 'exists:microauth.roles,id'],
        ];
    }
}
