<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\RegisterController;
use Laravel\Passport\Bridge\AccessToken;
use Laravel\Passport\Http\Controllers\AccessTokenController;

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
Route::post('register', [RegisterController::class, 'register']);

Route::post('login', [AccessTokenController::class, 'issueToken'])->middleware(['tokenlogin','throttle']);
Route::get('users', [RegisterController::class, 'index'])->middleware(['tokenlogin','throttle']);
Route::delete('delete-user/{id}', [RegisterController::class, 'destroy'])->middleware(['tokenlogin','throttle']);
Route::delete('delete-users', [RegisterController::class, 'destroyAllusers'])->middleware(['tokenlogin','throttle']);

Route::get('edit-user/{id}', [RegisterController::class, 'edit'])->middleware(['tokenlogin','throttle']);
Route::put('update-user/{id}', [RegisterController::class, 'update'])->middleware(['tokenlogin','throttle']);
Route::get('logout', [RegisterController::class, 'logout'])->middleware(['tokenlogin','throttle']);
Route::get('getuser', [RegisterController::class, 'getuser'])->middleware(['tokenlogin','throttle']);
Route::get('getuserpic', [RegisterController::class, 'getuserpic'])->middleware(['tokenlogin','throttle']);
Route::get('getuserrole', [RegisterController::class, 'getuserrole'])->middleware(['tokenlogin','throttle']);



Route::middleware('tokenlogin','auth:api')->get('/user',  function (Request $request) {
    return $request->user()->name;
});