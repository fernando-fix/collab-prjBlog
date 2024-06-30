<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Comment;
use App\Models\Post;
use App\Models\PostTag;
use App\Models\Tag;
use Illuminate\Support\Str;
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
    public function store(PostRequest $request)
    {
        if ($request['user_id'] != auth()->user()->id) {
            return response()->json(['error' => 'Não é possível criar posts para outros usuários'], 401);
        }

        $post = Post::create($request->all());

        if (!$post) {
            return response()->json(['error' => 'Erro ao criar post'], 500);
        }

        if (isset($request['tags'])) {
            $new_tags = [];
            foreach ($request['tags'] as $tagName) {
                $tagName = Str::upper(trim($tagName));
                $tagSlug = Str::slug($tagName);
                $tag = Tag::firstOrCreate([
                    'name' => $tagName,
                    'slug' => $tagSlug,
                ]);

                $postTag = PostTag::firstOrCreate([
                    'post_id' => $post->id,
                    'tag_id' => $tag->id,
                ]);
            }
        }

        return $post->load('user', 'tags', 'comments');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, Post $post)
    {
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
