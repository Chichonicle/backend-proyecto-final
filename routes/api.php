<?php

use App\Http\Controllers\MemberController;
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
// PUBLIC
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);


// USER WITH AUTH
Route::middleware("auth:sanctum")->get('/profile', [UserController::class, 'profile']);
Route::middleware("auth:sanctum")->post('/logout', [UserController::class, 'logout']);
Route::middleware("auth:sanctum")->put('/update', [UserController::class, 'updateProfile']);

// SERIES PUBLIC
Route::get('/series', [SeriesController::class, 'getAllSeries']);
Route::get('/serie/{id}', [SeriesController::class, 'getSerieById']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// MESSAGES




//MEMBERS
Route::group([
    "middleware" => [
        "auth:sanctum"
    ]
], function () {
Route::post('/member', [MemberController::class, 'addUserSalas']);
Route::post('/member/add', [MemberController::class, 'addMember']);
});