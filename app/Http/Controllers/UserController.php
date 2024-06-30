<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index', 'store', 'show']]);
    }

    public function index()
    {
        return User::all();
    }

    public function store(UserRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        if (!$user) {
            return response()->json(['error' => 'Erro ao criar usuário'], 500);
        }

        return $user;
    }

    public function update(UserRequest $request, User $user)
    {
        if (!$user) {
            return response()->json(['error' => 'Usuário não encontrado'], 404);
        }

        if (auth()->user()->id != $user->id) {
            return response()->json(['error' => 'Não é possível alterar outros usuários'], 401);
        }

        $user->update($request->all());
        return $user;
    }

    public function show(User $user)
    {
        if (!$user) {
            return response()->json(['error' => 'Usuário não encontrado'], 404);
        }
        return $user;
    }

    public function destroy(User $user)
    {
        if (!$user) {
            return response()->json(['error' => 'Usuário não encontrado'], 404);
        }

        if (auth()->user()->id != $user->id) {
            return response()->json(['error' => 'Não é possível excluir outros usuários'], 401);
        }

        $user->delete();
        return $user;
    }
}
