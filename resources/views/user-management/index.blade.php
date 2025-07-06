@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="mb-8 slide-in">
        <h1 class="text-3xl font-bold text-slate-100 mb-2 brand-font">Gestión de Usuarios</h1>
    </div>

    @if(session('success'))
        <div class="card-glass p-4 mb-4">
            <div class="flex items-center">
                <span class="w-2 h-2 bg-green-400 rounded-full mr-3"></span>
                <p class="text-slate-400">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="card-glass p-4 mb-4">
            <div class="flex items-center">
                <span class="w-2 h-2 bg-red-400 rounded-full mr-3"></span>
                <p class="text-slate-400">{{ session('error') }}</p>
            </div>
        </div>
    @endif

    <div class="card-glass p-6 slide-in">
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Nombre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Rol</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-700/10">
                    @foreach($users as $user)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-slate-100">{{ $user->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-slate-100">{{ $user->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-slate-100">{{ $user->role ?? 'user' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <form action="{{ route('user-management.update', $user) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PUT')
                                    <a href="{{ route('user-management.edit', $user) }}" class="text-indigo-400 hover:text-indigo-300 mr-4 transition-colors">Editar</a>
                                </form>
                                <form action="{{ route('user-management.destroy', $user) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:text-red-300 transition-colors">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
