<?php

// app/Http/Controllers/CharacterController.php
namespace App\Http\Controllers;

use App\Models\Character;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CharacterController extends Controller
{
    // Listar todos los personajes con sus películas/series
    public function index()
    {
        return Character::with('movies')->get();
        // Opcional: Paginación
        // return Character::with('movies')->paginate(10);
    }

    // Crear nuevo personaje
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'required|url',
            'description' => 'required|string',
            'movies' => 'array',
            'movies.*' => 'exists:movies,id'
        ]);

        $character = Character::create($validated);
        $character->movies()->attach($request->movies);

        return response()->json($character->load('movies'), Response::HTTP_CREATED);
    }

    // Mostrar un personaje específico
    public function show(Character $character)
    {
        return response()->json($character->load('movies'));
    }

    // Actualizar personaje
    public function update(Request $request, Character $character)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'image' => 'sometimes|url',
            'description' => 'sometimes|string',
            'movies' => 'sometimes|array',
            'movies.*' => 'exists:movies,id'
        ]);

        $character->update($validated);

        if ($request->has('movies')) {
            $character->movies()->sync($request->movies);
        }

        return response()->json($character->load('movies'));
    }

    // Eliminar personaje
    public function destroy(Character $character)
    {
        $character->movies()->detach();
        $character->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}