<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GigsController;
use App\Http\Controllers\PaketController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StoreController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::prefix('/gigs')->group(function () {
//     Route::get('/', [GigsController::class, 'index']);
//     Route::get('/images/{filename}', [GigsController::class, 'showImage']);
//     Route::post('/', [GigsController::class, 'store']);
//     Route::post('/{id}', [GigsController::class, 'update']);
//     Route::get('/delete/{id}', [GigsController::class, 'destroy']);
// });


// Route::prefix('/category')->group(function () {
//     Route::get('/', [CategoryController::class, 'index']);
//     Route::post('/', [CategoryController::class, 'store']);
//     Route::post('/{id}', [CategoryController::class, 'update']);
//     Route::delete('/{id}', [CategoryController::class, 'destroy']);
// });

// Route::prefix('/paket')->group(function () {
//     Route::get('/', [PaketController::class, 'index']);
//     Route::post('/', [PaketController::class, 'store']);
//     Route::post('/{id}', [PaketController::class, 'update']);
//     Route::delete('/{id}', [PaketController::class, 'destroy']);
// });


Route::post('/login',[AuthController::class,'login']);
Route::get('/logout',[AuthController::class,'logout'])->middleware(['auth:sanctum']);
Route::get('/me',[AuthController::class,'me'])->middleware(['auth:sanctum']);
Route::post('/register',[AuthController::class,'register']);


Route::prefix('category')->group(function () {
    Route::get('/',[CategoryController::class,'index']);
    Route::get('/{filename}',[CategoryController::class, 'showImage']);
    Route::post('/',[CategoryController::class,'store'])->middleware(['auth:sanctum']);
    Route::post('/{id}',[CategoryController::class,'update'])->middleware(['auth:sanctum']);
    Route::get('/delete/{id}',[CategoryController::class, 'destroy'])->middleware(['auth:sanctum']);
});

Route::prefix('paket')->group(function () {
    Route::get('/',[PaketController::class,'index']);
    Route::post('/',[PaketController::class,'store'])->middleware(['auth:sanctum']);
    Route::post('/{id}',[PaketController::class, 'update'])->middleware(['auth:sanctum']);
    Route::get('/delete/{id}',[PaketController::class, 'destroy'])->middleware(['auth:sanctum']);
});

Route::prefix('store')->group(function () {
    Route::get('/',[StoreController::class,'index']);
    Route::get('/mystore',[StoreController::class,'showByOwner'])->middleware(['auth:sanctum']);
    Route::get('/{fileName}',[StoreController::class,'showByIcons']);
    Route::post('/',[ StoreController::class,'store'])->middleware(['auth:sanctum']);
    Route::post('/{id}',[StoreController::class,'update'])->middleware(['auth:sanctum']);
    Route::get('/delete/{id}',[StoreController::class,'destroy'])->middleware(['auth:sanctum']);
});

Route::prefix('gigs')->group(function () {
    Route::get('/',[GigsController::class,'index']);
    Route::post('/',[GigsController::class,'store'])->middleware(['auth:sanctum']);
    Route::get('/{id}',[GigsController::class,'showDetails']);
    Route::post('/{id}',[GigsController::class,'update'])->middleware(['auth:sanctum']);
    Route::get('/delete/{id}',[GigsController::class,'destroy'])->middleware(['auth:sanctum']);
});





// // Route::prefix('admin')->group(function () {

// });
