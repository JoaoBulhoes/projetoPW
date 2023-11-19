<?php

namespace App\Http\Requests;

use App\Dto\UserDTO;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nome' => ['required', 'max:250', 'min:6'],
            'email' => ['nullable', 'email'],
            'password' => ['required', 'min:8', 'max:16']
        ];
    }

    public function toDTO(): UserDTO
    {
        return new UserDTO($this->nome, $this->email, $this->password);
    }
}
