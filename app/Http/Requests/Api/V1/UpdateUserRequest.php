<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        $user = $this->route('user');
        $userId = $user ? $user->id : null;

        return [
            'name' => 'sometimes|string|min:2|max:100',
            'email' => 'sometimes|email|max:255|unique:users,email,' . $userId,
            'password' => 'sometimes|string|min:8',
            'is_admin' => 'sometimes|boolean',
        ];
    }
}
