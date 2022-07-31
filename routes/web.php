<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('landing.index', [
        "title" => "Landing",
        "css" => "landing"
    ]);
});

// Login
Route::get('/{url}', [AuthController::class, "loginGet"])->where(["url" => "auth|auth/login"])->name("auth");
Route::post('/auth/login', [AuthController::class, "loginPost"]);

// Register
Route::get('/auth/register', [AuthController::class, "registrationGet"]);
Route::post('/auth/register', [AuthController::class, "registrationPost"]);

// Logout
Route::post('/auth/logout', [AuthController::class, "logoutPost"]);


// main
Route::middleware(['auth'])->group(function () {
    // Home
    Route::controller(HomeController::class)->group(function () {
        Route::get("/home", "index");
    });

    // profile
    Route::controller(ProfileController::class)->group(function () {
        Route::get("/profile/my_profile", "my_profile");
    });
});
