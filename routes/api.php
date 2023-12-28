<?php

use App\Http\Controllers\adminController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\SalasController;
use App\Http\Controllers\SeriesController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
// USERS
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);


// USER WITH AUTH
Route::group([
    'middleware' => ['auth:sanctum']
], function () {
Route::get('/profile', [UserController::class, 'profile']);
Route::post('/logout', [UserController::class, 'logout']);
Route::put('/update', [UserController::class, 'updateProfile']);
});

// SERIES PUBLIC
Route::get('/series', [SeriesController::class, 'getAllSeries']);
Route::get('/serie/{id}', [SeriesController::class, 'getSerieById']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// MESSAGES
Route::group([
    "middleware" => [
        "auth:sanctum"
    ]
], function () {
    Route::post('/createMessage', [MessageController::class, 'createMessage']);
    Route::delete('/deleteMessage/{id}', [MessageController::class, 'deleteMessageById']);
    Route::get('/message', [MessageController::class, 'getMessage']);
    Route::get('/messages', [MessageController::class, 'getAllMessages']);
    Route::put('/updateMessage/{id}', [MessageController::class, 'updateMessageById']);
});




//ADMIN
Route::group([
    'middleware' => ['auth:sanctum', 'admin']
], function () {
    Route::post('/serie', [adminController::class, 'createSerie']);
    Route::delete('/serie/{id}', [adminController::class, 'deleteSerie']);
    Route::get('/salas', [adminController::class, 'getAllSalas']);
    Route::get('/users', [adminController::class, 'getAllUsers']);
});

//SALAS
Route::group([
    'middleware' => ['auth:sanctum']
], function () {
    Route::get('/sala/{id}', [SalasController::class, 'getSalaById']);
    Route::post('/sala', [SalasController::class, 'createSala']);
    Route::delete('/sala/{serie_id}', [SalasController::class, 'leaveSala']);
    
});