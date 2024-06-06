<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

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

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|min:3|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6',
            ], [
                'name.required' => 'O campo nome é obrigatório',
                'email.required' => 'O campo email é obrigatório',
                'email.email' => 'O campo email deve ser um email',
                'email.unique' => 'O email informado ja existe',
                'password.required' => 'O campo senha é obrigatório',
                'password.min' => 'A senha deve ter pelo menos :min caracteres',
            ]);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }

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

    public function update(Request $request, User $user)
    {
        if (!$user) {
            return response()->json(['error' => 'Usuário não encontrado'], 404);
        }

        if (auth()->user()->id != $user->id) {
            return response()->json(['error' => 'Não é possível alterar outros usuários'], 401);
        }

        try {
            $request->validate([
                'name' => 'required|string|min:3|max:255',
                'email' => 'required|string|email|max:255',
                'password' => 'required|string|min:6',
            ], [
                'name.required' => 'O campo nome é obrigatório',
                'email.required' => 'O campo email é obrigatório',
                'email.email' => 'O campo email deve ser um email',
                'password.required' => 'O campo senha é obrigatório',
                'password.min' => 'A senha deve ter pelo menos :min caracteres',
            ]);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
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
