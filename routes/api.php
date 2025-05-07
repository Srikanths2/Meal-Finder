<?php

// use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;

// use App\Http\Middleware\CheckRole;

use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;

use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminUsersController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserAddressesController;
use App\Http\Controllers\OrderController;



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
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::get('/products/{products}/product', [ProductController::class, 'showByProduct']);
// Route::get('/categories/{category}/{name}', [ProductController::class, 'showByCategoryAndName']);
// Admin-only
Route::post('/products', [ProductController::class, 'store']);
Route::put('/products/{id}', [ProductController::class, 'update']);
Route::put('/products/{id}/toggle-status', [ProductController::class, 'toggleStatus']);
Route::delete('/products/{id}', [ProductController::class, 'destroy']);

// Route::post('/categories', [ProductController::class, 'store'])->middleware('admin');
// Route::put('/categories/{category}/{name}', [ProductController::class, 'update'])->middleware('admin');
// Route::delete('/categories/{category}/{name}', [ProductController::class, 'destroy'])->middleware('admin');

// Route::middleware(['admin'])->group(function () {
Route::get('/users', [AdminUsersController::class, 'index']);
Route::get('/users/{id}', [AdminUsersController::class, 'show']);
Route::post('/users', [AdminUsersController::class, 'create']);
Route::put('/users/{id}', [AdminUsersController::class, 'update']);
Route::delete('/users/{id}', [AdminUsersController::class, 'destroy']);
// Route::patch('/users/{id}/role', [AdminUsersController::class, 'changeRole']);
// });

Route::post('/add-category', [CategoryController::class, 'storeCategory']);
Route::get('/all-categories', [CategoryController::class, 'getAllCategories']);
Route::get('/category/{id}', [CategoryController::class, 'getCategoryById']);
Route::put('/update-category/{id}', [CategoryController::class, 'updateCategory']);
Route::delete('/delete-category/{id}', [CategoryController::class, 'deleteCategory']);

// wishlist routes
// Route::middleware('auth')->group(function () {
Route::get('/wishlist/{id}', [WishlistController::class, 'index']);
Route::post('/wishlist', [WishlistController::class, 'store']);
Route::delete('/wishlist/{id}', [WishlistController::class, 'destroy']);
Route::delete('/wishlist/clear/{userId}', [WishlistController::class, 'clearWishlist']);
// });

// cart routes 
Route::get('/cart/{id}', [CartController::class, 'index']);
Route::post('/cart', [CartController::class, 'store']);
Route::delete('/cart/{id}', [CartController::class, 'destroy']);
Route::put('/cart/{id}', [CartController::class, 'updateQuantity']);

// user_addresses routes
Route::get('/user_addresses/{user_id}', [UserAddressesController::class, 'index']);
Route::get('/user_addresses/specific/{id}', [UserAddressesController::class, 'show']);
Route::post('/user_addresses', [UserAddressesController::class, 'store']);
Route::put('/user_addresses/{id}', [UserAddressesController::class, 'update']);
Route::delete('/user_addresses/{id}', [UserAddressesController::class, 'destroy']);

// order routes
Route::post('/orders', [OrderController::class, 'store']);
Route::put('/orders/{id}/status', [OrderController::class, 'updateStatus']);
Route::get('/orders', [OrderController::class, 'index']);
Route::get('/orders/{id}', [OrderController::class, 'show']);

