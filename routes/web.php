<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CotacoesController;

Route::get('/', [CotacoesController::class, 'index']);
Route::post('/', [CotacoesController::class, 'index']);