<?php

// use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;

// use App\Http\Middleware\CheckRole;

use App\Http\Controllers\FoodCategoryController;
use App\Http\Controllers\CategoryController;

use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminUsersController;
use App\Http\Controllers\WishlistController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::get('/profile/{id}', [UserController::class, 'showProfile']);
Route::put('/updateProfile/{id}', [UserController::class, 'updateProfile']);
Route::put('/changePassword/{id}', [UserController::class, 'changePassword']);
Route::post('/logout', [UserController::class, 'logout']);

// Publicly accessible (index & show)
Route::get('/categories', [FoodCategoryController::class, 'index']);
Route::get('/categories/{id}', [FoodCategoryController::class, 'show']);
Route::get('/categories/{categorys}/category', [FoodCategoryController::class, 'showByCategory']);
Route::get('/categories/{category}/{name}', [FoodCategoryController::class, 'showByCategoryAndName']);
// Admin-only
Route::post('/categories', [FoodCategoryController::class, 'store']);
Route::put('/categories/{id}', [FoodCategoryController::class, 'update']);
Route::put('/categories/{id}/toggle-status', [FoodCategoryController::class, 'toggleStatus']);
Route::delete('/categories/{id}', [FoodCategoryController::class, 'destroy']);

// Route::post('/categories', [FoodCategoryController::class, 'store'])->middleware('admin');
// Route::put('/categories/{category}/{name}', [FoodCategoryController::class, 'update'])->middleware('admin');
// Route::delete('/categories/{category}/{name}', [FoodCategoryController::class, 'destroy'])->middleware('admin');


// Route::middleware(['admin'])->group(function () {
    Route::get('/users', [AdminUsersController::class, 'index']);
    Route::get('/users/{id}', [AdminUsersController::class, 'show']);
    Route::post('/users', [AdminUsersController::class, 'create']);
    Route::put('/users/{id}', [AdminUsersController::class, 'update']);
    Route::delete('/users/{id}', [AdminUsersController::class, 'destroy']);
    // Route::patch('/users/{id}/role', [AdminUsersController::class, 'changeRole']);
// });

Route::post('/add-category',[CategoryController::class,'storeCategory']);
Route::get('/all-categories',[CategoryController::class,'getAllCategories']);
Route::get('/category/{id}',[CategoryController::class,'getCategoryById']);
Route::put('/update-category/{id}',[CategoryController::class,'updateCategory']);
Route::delete('/delete-category/{id}',[CategoryController::class,'deleteCategory']);

// wishlist routes
// Route::middleware('auth')->group(function () {
    Route::get('/wishlist', [WishlistController::class, 'index']);
    Route::post('/wishlist', [WishlistController::class, 'store']);
    Route::delete('/wishlist/{id}', [WishlistController::class, 'destroy']);
// });
