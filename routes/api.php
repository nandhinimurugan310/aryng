<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ChatController;

Route::post('/chat', [ChatController::class, 'handle']);
