<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // GET /users
    public function index(Request $request)
    {
        $users = User::withCount('listings')->get();

        if ($request->wantsJson()) {
            return response()->json($users);
        }

        return view('users.index', compact('users'));
    }

    // GET /users/create
    public function create()
    {
        return view('users.create');
    }

    // POST /users
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'           => 'required|string|max:255',
            'email'          => 'required|email|unique:users,email',
            'password'       => 'required|string|min:6',
            'contact_number' => 'nullable|string|max:50',
        ]);

        $user = User::create($data);

        if ($request->wantsJson()) {
            return response()->json($user, 201);
        }

        return redirect()
            ->route('users.show', $user->id)
            ->with('success', 'Пользователь создан.');
    }

    // GET /users/{id}
    public function show(Request $request, $id)
    {
        $user = User::with(['listings.serviceType'])->findOrFail($id);

        if ($request->wantsJson()) {
            return response()->json($user);
        }

        return view('users.show', compact('user'));
    }

    // GET /users/{id}/edit
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    // PUT /users/{id}
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $data = $request->validate([
            'name'           => 'required|string|max:255',
            'email'          => "required|email|unique:users,email,{$id}",
            'password'       => 'nullable|string|min:6',
            'contact_number' => 'nullable|string|max:50',
        ]);

        if (empty($data['password'])) {
            unset($data['password']);
        }

        $user->update($data);

        if ($request->wantsJson()) {
            return response()->json($user);
        }

        return redirect()
            ->route('users.show', $user->id)
            ->with('success', 'Пользователь обновлён.');
    }

    // DELETE /users/{id}
    public function destroy(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        if ($request->wantsJson()) {
            return response()->json(['message' => 'deleted']);
        }

        return redirect()
            ->route('users.index')
            ->with('success', 'Пользователь удалён.');
    }
}
