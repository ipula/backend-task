<?php

use GrahamCampbell\GitHub\Facades\GitHub;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::get('/user', function (Request $request) {
//    return GitHub::me()->organizations();
//});

Route::get("/users", [\App\Http\Controllers\GithubUserController::class, 'getAllUsers']); // Done
Route::get("/user", [\App\Http\Controllers\GithubUserController::class, 'getAUser']); // Done
Route::get("/user/{id}", [\App\Http\Controllers\GithubUserController::class, 'getUserDetails']); // Done
Route::get("/repos/{user_id}", [\App\Http\Controllers\GithubUserController::class, 'getRepos']); // Done

