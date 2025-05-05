<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// routes/api.php
use App\Http\Controllers\MovieController;
use App\Http\Controllers\CharacterController;

Route::apiResource('movies', MovieController::class);
Route::apiResource('characters', CharacterController::class);
