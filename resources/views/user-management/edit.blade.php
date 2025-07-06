@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="mb-8 slide-in">
        <h1 class="text-3xl font-bold text-slate-100 mb-2 brand-font">Editar Usuario</h1>
    </div>

    <div class="card-glass p-6 slide-in">
        <form action="{{ route('user-management.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <!-- Nombre -->
                <div>
                    <label for="name" class="block text-sm font-medium text-slate-400 mb-2">Nombre</label>
                    <input type="text" name="name" id="name" 
                           value="{{ old('name', $user->name) }}"
                           class="w-full px-4 py-2 rounded-lg bg-slate-800/50 text-slate-100 border border-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-transparent transition-colors"
                           required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-slate-400 mb-2">Email</label>
                    <input type="email" name="email" id="email" 
                           value="{{ old('email', $user->email) }}"
                           class="w-full px-4 py-2 rounded-lg bg-slate-800/50 text-slate-100 border border-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-transparent transition-colors"
                           required>
                    @error('email')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Rol -->
                <div>
                    <label for="role" class="block text-sm font-medium text-slate-400 mb-2">Rol</label>
                    <select name="role" id="role" 
                            class="w-full px-4 py-2 rounded-lg bg-slate-800/50 text-slate-100 border border-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-transparent transition-colors"
                            required>
                        <option value="user" {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>Usuario Normal</option>
                        <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Administrador</option>
                    </select>
                    @error('role')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Botones -->
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('user-management.index') }}" 
                       class="px-4 py-2 text-slate-400 hover:text-slate-100 transition-colors">Cancelar</a>
                    <button type="submit" 
                            class="px-6 py-2 bg-indigo-400 hover:bg-indigo-300 text-white rounded-lg transition-colors">
                        Actualizar Usuario
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
