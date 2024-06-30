<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
            'title' => 'required|string|min:3|max:255',
            'content' => 'required|string|min:3',
            'tags' => 'required|array|min:1|max:3',
        ];

        if (!$this->route('post')) {
            $rules['tags'] = 'required|array|min:1|max:3';
        }
    }

    public function messages(): array
    {
        return [
            'title.required' => 'O campo título é obrigatório',
            'title.min' => 'O título deve ter pelo menos :min caracteres',
            'title.max' => 'O título deve ter no máximo :max caracteres',
            'content.required' => 'O campo conteúdo é obrigatório',
            'content.min' => 'O conteúdo deve ter pelo menos :min caracteres',
            'tags.required' => 'O campo TAG é obrigatório',
            'tags.min' => 'É necessário enviar ao menos :min TAG',
            'tags.max' => 'É possível enviar no máximo :max TAGs',
        ];
    }
}
