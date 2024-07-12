<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditUserRequest extends FormRequest
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

        $user = $this->route('user');

        return [
            'name' => 'string|min:3|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'string|min:6',
            'password_confirmation' => 'required_with:password|same:password|min:6',
        ];
    }

    public function messages(): array
    {
        return [
            'email.email' => 'O campo email deve ser um email',
            'email.unique' => 'O email informado já existe',
            'password.min' => 'A senha deve ter pelo menos :min caracteres',
            'password_confirmation.required_with' => 'O campo confirmar senha é obrigatório',
            'password_confirmation.same' => 'As senhas informadas não conferem',
            'password_confirmation.min' => 'A confirmação da senha deve ter pelo menos :min caracteres',
        ];
    }
}
