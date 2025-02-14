<?php
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;

//! auth
Route::post('/register', [AuthController::class, 'register']); //* ini untuk register
Route::post ('/login', [AuthController::class, 'login']); //*ini untuk login
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum'); //* ini untuk logout
Route::middleware('auth:sanctum')->get('/user', [UserController::class, 'getUser']); //*ini untuk mengembil data user yg sedang login
Route::post('/register', [AuthController::class, 'register']);

// routes/api.php

Route::prefix('categories')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [CategoryController::class, 'index']);  // Ambil semua kategori
    Route::post('/', [CategoryController::class, 'store']); // Tambah kategori baru
    Route::get('/{id}', [CategoryController::class, 'show']); // Detail kategori
    Route::put('/{id}', [CategoryController::class, 'update']); // Update kategori
    Route::delete('/{id}', [CategoryController::class, 'destroy']); // Hapus kategori
});

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('products', ProductController::class);
});


Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('order', OrderController::class);
});