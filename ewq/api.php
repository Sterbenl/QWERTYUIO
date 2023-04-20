<?php
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\GenreController;
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
Route::post('/signup',[UserController::class, 'signup']);
Route::post('/auth',[UserController::class, 'auth']);
route::get('/user/{id}',[UserController::class,'show']);



Route::apiResource('/books', BookController::class)->only('index','show');
Route::apiResource('/genres', GenreController::class)->except('store','update','destroy');

Route::group(['middleware'=>['auth:sanctum']],function(){
Route::apiResource('/books', BookController::class)->except('index','show');
Route::apiResource('/genres', GenreController::class)->only('store','update','destroy');
});
