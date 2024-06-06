<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['only' => ['store', 'update', 'destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Post::with('user')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'user_id' => 'required',
                'title' => 'required|string|min:3|max:255',
                'content' => 'required|string|min:3',
            ], [
                'title.required' => 'O campo título é obrigatório',
                'title.min' => 'O título deve ter pelo menos :min caracteres',
                'title.max' => 'O título deve ter no máximo :max caracteres',
                'content.required' => 'O campo conteúdo é obrigatório',
                'content.min' => 'O conteúdo deve ter pelo menos :min caracteres',
            ]);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }

        $request['user_id'] = auth()->user()->id; // Adiciona o ID do usuário autenticado

        $post = Post::create($request->all());

        if (!$post) {
            return response()->json(['error' => 'Erro ao criar post'], 500);
        }

        return $post;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        try {
            $request->validate([
                'title' => 'required|string|min:3|max:255',
                'content' => 'required|string|min:3',
            ], [
                'title.required' => 'O campo título é obrigatório',
                'title.min' => 'O título deve ter pelo menos :min caracteres',
                'title.max' => 'O título deve ter no máximo :max caracteres',
                'content.required' => 'O campo conteúdo é obrigatório',
                'content.min' => 'O conteúdo deve ter pelo menos :min caracteres',
            ]);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }

        if (!$post) {
            return response()->json(['error' => 'Post não encontrado'], 404);
        }

        $request['user_id'] = auth()->user()->id; // Adiciona o ID do usuário autenticado

        if (auth()->user()->id != $post->user_id) {
            return response()->json(['error' => 'Não é possível deletar posts de outros usuários'], 401);
        }

        $post->update($request->all());
        return $post;
    }

    public function show(Post $post)
    {
        if (!$post) {
            return response()->json(['error' => 'Post não encontrado'], 404);
        }

        return $post;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        if (!$post) {
            return response()->json(['error' => 'Post não encontrado'], 404);
        }

        if (auth()->user()->id != $post->user_id) {
            return response()->json(['error' => 'Não é possível deletar posts de outros usuários'], 401);
        }

        $post->delete();

        return $post;
    }
}
