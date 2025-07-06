<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class ProfilePhotoController extends Controller
{
    public function update(Request $request)
    {
        // Validar que solo el usuario pueda actualizar su propia foto
        if (!Auth::check()) {
            return redirect()->back()->with('error', 'No estás autenticado.');
        }

        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Máximo 2MB
        ]);

        $user = Auth::user();

        // Eliminar la foto anterior si existe
        if ($user->profile_photo) {
            Storage::delete('public/profile-photos/' . $user->profile_photo);
        }

        // Guardar la nueva foto
        try {
            $photoPath = $request->file('photo')->store('profile-photos', 'public');
            $user->profile_photo = basename($photoPath);
            $user->save();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al guardar la foto: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Foto de perfil actualizada exitosamente.');
    }

    public function destroy()
    {
        // Validar que solo el usuario pueda eliminar su propia foto
        if (!Auth::check()) {
            return redirect()->back()->with('error', 'No estás autenticado.');
        }

        $user = Auth::user();

        // Eliminar la foto si existe
        if ($user->profile_photo) {
            Storage::delete('public/profile-photos/' . $user->profile_photo);
            $user->profile_photo = null;
            $user->save();
        }

        return redirect()->back()->with('success', 'Foto de perfil eliminada.');
    }
}
