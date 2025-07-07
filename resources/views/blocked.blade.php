@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
    <div class="bg-red-600/20 border border-red-600 rounded-lg p-8 text-center">
        <div class="text-red-400 text-4xl mb-4">❌</div>
        <h2 class="text-2xl font-bold text-red-400 mb-4">Cuenta Desactivada</h2>
        <p class="text-red-300 mb-6">Tu cuenta ha sido desactivada temporalmente.</p>
        <p class="text-red-300 mb-6">Para más información, contacta con el soporte.</p>
        <div class="mt-6">
            <a href="/login" 
               class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                Volver al inicio
            </a>
        </div>
    </div>
</div>
@endsection
