<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class PostController extends Controller
{
    private $perpage = 6;

    public function __construct()
    {
        $this->middleware('auth:api', ['only' => ['store', 'update', 'destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Post::with('user', 'tags', 'comments');

        // Se houver busca
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%');
                $query->orWhereHas('user', function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                });
            });
        }

        // Se houver tag
        if (isset($request->tag)) {
            if (!Tag::where('name',  $request->tag)->first())
                return response()->json(['error' => 'Tag inexistente'], 404);
            $query->whereHas('tags', function ($query) use ($request) {
                $query->where('name', $request->tag);
            });
        }

        $posts =  $query->orderBy('created_at', 'desc')->paginate($this->perpage);
        return response()->json($posts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'title' => 'required|string|min:3|max:255',
            'content' => 'required|string|min:3',
            'tags' => 'required|array|min:1|max:3',
        ], [
            'title.required' => 'O campo título é obrigatório',
            'title.min' => 'O título deve ter pelo menos :min caracteres',
            'title.max' => 'O título deve ter no máximo :max caracteres',
            'content.required' => 'O campo conteúdo é obrigatório',
            'content.min' => 'O conteúdo deve ter pelo menos :min caracteres',
            'tags.required' => 'O campo TAG é obrigatório',
            'tags.min' => 'É necessário enviar ao menos :min TAG',
            'tags.max' => 'É possível enviar no máximo :max TAGs',
        ]);

        if ($request['user_id'] != auth()->user()->id) {
            return response()->json(['error' => 'Não é possível criar posts para outros usuários'], 401);
        }

        $post = Post::create($request->all());

        if (!$post) {
            return response()->json(['error' => 'Erro ao criar post'], 500);
        }

        if (isset($request['tags'])) {
            // maiuscula
            $new_tags = [];
            foreach ($request['tags'] as $tag) {
                $request['tags'] = strtoupper($tag);
                $tag  = Tag::firstOrCreate(['name' => $tag]);
                array_push($new_tags, $tag->id);
            }
            $post->tags()->attach($new_tags);
        }

        return $post->load('user', 'tags', 'comments');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
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

        if (!$post) {
            return response()->json(['error' => 'Post não encontrado'], 404);
        }

        $request['user_id'] = auth()->user()->id; // Adiciona o ID do usuário autenticado

        if (auth()->user()->id != $post->user_id) {
            return response()->json(['error' => 'Não é possível deletar posts de outros usuários'], 401);
        }

        $post->update($request->all());
        return $post->load('user', 'tags', 'comments');
    }

    public function show(Post $post)
    {
        if (!$post) {
            return response()->json(['error' => 'Post não encontrado'], 404);
        }

        $comments = Comment::with('user')->where('post_id', $post->id)->orderBy('created_at', 'desc')->paginate($this->perpage);
        return response()->json([
            'post' => $post->load('user', 'tags'),
            'comments' => $comments
        ]);
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

        $deletePost = $post->delete();

        if (!$deletePost) {
            return response()->json(['error' => 'Erro ao deletar post'], 500);
        }

        return $post->load('user', 'tags', 'comments');
    }
}
