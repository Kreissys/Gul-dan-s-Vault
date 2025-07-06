<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserManagementController extends Controller
{
    public function index()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect()->back()->with('error', 'No tienes permisos para acceder a esta sección.');
        }

        $users = User::all();
        return view('user-management.index', compact('users'));
    }

    public function edit(User $user)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect()->back()->with('error', 'No tienes permisos para realizar esta acción.');
        }

        return view('user-management.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect()->back()->with('error', 'No tienes permisos para realizar esta acción.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:user,admin',
        ]);

        $user->update($request->all());
        
        return redirect()->route('user-management.index')->with('success', 'Usuario actualizado exitosamente.');
    }

    public function destroy(User $user)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect()->back()->with('error', 'No tienes permisos para realizar esta acción.');
        }

        if ($user->id === Auth::id()) {
            return redirect()->back()->with('error', 'No puedes eliminar tu propio usuario.');
        }

        $user->delete();
        return redirect()->back()->with('success', 'Usuario eliminado exitosamente.');
    }
}
