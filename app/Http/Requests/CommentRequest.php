<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
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
            'user_id' => 'required',
            'post_id' => 'required',
            'content' => 'required|string|min:3',
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required' => 'O campo usuário é obrigatório',
            'post_id.required' => 'O campo postagem é obrigatório',
            'content.required' => 'O campo conteúdo é obrigatório',
            'content.min' => 'O conteúdo deve ter pelo menos :min caracteres',
        ];
    }
}
