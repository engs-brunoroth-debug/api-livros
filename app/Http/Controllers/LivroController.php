<?php

namespace App\Http\Controllers;

use App\Http\Resources\LivroResource;
use App\Models\Livro;
use Illuminate\Http\Request;

class LivroController extends Controller
{
    public function index()
    {
        return LivroResource::collection(Livro::all());
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'titulo' => 'required|string|max:255',
            'autor'  => 'required|string|max:255',
            'ano'    => 'nullable|integer',
        ]);

        return (new LivroResource(Livro::create($dados)))
            ->response()->setStatusCode(201);
    }

    public function show(Livro $livro)
    {
        return new LivroResource($livro);
    }

    public function update(Request $request, Livro $livro)
    {
        $dados = $request->validate([
            'titulo' => 'sometimes|string|max:255',
            'autor'  => 'sometimes|string|max:255',
            'ano'    => 'nullable|integer',
        ]);

        $livro->update($dados);
        return new LivroResource($livro);
    }

    public function destroy(Livro $livro)
    {
        $livro->delete();
        return response()->noContent();
    }
}