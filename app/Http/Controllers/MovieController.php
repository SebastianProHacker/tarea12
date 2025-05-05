<?php

// app/Http/Controllers/MovieController.php
namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MovieController extends Controller
{
    // Obtener todas las películas/series
    public function index()
    {
        return Movie::all();
        // Opcional: Paginación
        // return Movie::paginate(10);
    }

    // Crear nueva película/serie
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'classification' => 'required|string|max:255',
            'release_date' => 'required|date',
            'review' => 'required|string',
            'type' => 'required|in:movie,series',
            'season' => 'required_if:type,series|nullable|integer'
        ]);

        if ($validated['type'] === 'movie') {
            $validated['season'] = null;
        }

        $movie = Movie::create($validated);
        return response()->json($movie, Response::HTTP_CREATED);
    }

    // Mostrar una película/serie específica
    public function show(Movie $movie)
    {
        return response()->json($movie);
    }

    // Actualizar película/serie
    public function update(Request $request, Movie $movie)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'classification' => 'sometimes|string|max:255',
            'release_date' => 'sometimes|date',
            'review' => 'sometimes|string',
            'type' => 'sometimes|in:movie,series',
            'season' => 'nullable|integer|required_if:type,series'
        ]);

        if (isset($validated['type']) && $validated['type'] === 'movie') {
            $validated['season'] = null;
        }

        $movie->update($validated);
        return response()->json($movie);
    }

    // Eliminar película/serie
    public function destroy(Movie $movie)
    {
        $movie->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}