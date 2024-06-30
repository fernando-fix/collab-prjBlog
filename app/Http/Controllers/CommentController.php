<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;

class CommentController extends Controller
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
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CommentRequest $request)
    {
        $createComment = Comment::create($request->all());
        if (!$createComment) {
            return response()->json(['error' => 'Erro ao criar comentário'], 500);
        }

        return $createComment;
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CommentRequest $request, Comment $comment)
    {
        if (!$comment) {
            return response()->json(['error' => 'Comentário não encontrado'], 404);
        }

        if (auth()->user()->id != $comment->user_id) {
            return response()->json(['error' => 'Não é possível editar comentários de outros usuários'], 401);
        }

        $updateComment = $comment->update($request->all());
        if (!$updateComment) {
            return response()->json(['error' => 'Erro ao editar comentário'], 500);
        }

        return $comment->load('user');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        if (!$comment) {
            return response()->json(['error' => 'Comentário não encontrado'], 404);
        }

        if (auth()->user()->id != $comment->user_id) {
            return response()->json(['error' => 'Não é possível deletar comentários de outros usuários'], 401);
        }

        $deleteComment = $comment->delete();

        if (!$deleteComment) {
            return response()->json(['error' => 'Erro ao deletar comentário'], 500);
        }

        return $comment->load('user');
    }
}
