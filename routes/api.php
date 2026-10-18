<?php

use App\Http\Controllers\LivroController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/pokemon/{nome}', function (string $nome) {
    $resposta = Http::get("https://pokeapi.co/api/v2/pokemon/" . strtolower($nome));

    if ($resposta->failed()) {
        return response()->json(['erro' => 'Pokémon não encontrado'], 404);
    }

    return [
        'nome'   => $resposta['name'],
        'altura' => $resposta['height'],
        'peso'   => $resposta['weight'],
        'tipos'  => collect($resposta['types'])->pluck('type.name'),
    ];
});

Route::apiResource('livros', LivroController::class);