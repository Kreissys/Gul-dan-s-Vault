<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserManagementController extends Controller
{
    public function index()
    {
        // Verificar si el usuario está desactivado
        if (Auth::check() && !Auth::user()->is_active) {
            return view('blocked');
        }

        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect()->back()->with('error', 'No tienes permisos para acceder a esta sección.');
        }

        $users = User::all();
        return view('user-management.index', compact('users'));
    }

    public function edit(User $user)
    {
        // Verificar si el usuario está desactivado
        if (Auth::check() && !Auth::user()->is_active) {
            return view('blocked');
        }

        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect()->back()->with('error', 'No tienes permisos para realizar esta acción.');
        }

        return view('user-management.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        // Verificar si el usuario está desactivado
        if (Auth::check() && !Auth::user()->is_active) {
            return view('blocked');
        }

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
        // Verificar si el usuario está desactivado
        if (Auth::check() && !Auth::user()->is_active) {
            return view('blocked');
        }

        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect()->back()->with('error', 'No tienes permisos para realizar esta acción.');
        }

        if ($user->id === Auth::id()) {
            return redirect()->back()->with('error', 'No puedes desactivar tu propio usuario.');
        }

        // Desactivar el usuario
        $user->is_active = false;
        $user->save();
        
        return redirect()->back()->with('success', 'Usuario desactivado exitosamente.');
    }

    public function activate(User $user)
    {
        // Verificar si el usuario está desactivado
        if (Auth::check() && !Auth::user()->is_active) {
            return view('blocked');
        }

        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect()->back()->with('error', 'No tienes permisos para realizar esta acción.');
        }

        if ($user->id === Auth::id()) {
            return redirect()->back()->with('error', 'No puedes activar tu propio usuario.');
        }

        // Activar el usuario
        $user->is_active = true;
        $user->save();
        
        return redirect()->back()->with('success', 'Usuario activado exitosamente.');
    }
}
