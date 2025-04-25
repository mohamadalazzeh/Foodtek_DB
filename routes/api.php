<?php
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ItemController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\FavouriteController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\CategoryController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('register',[UserController::class,'register']);
Route::post('login',[UserController::class,'login']);
Route::post('send\otp',[UserController::class,'sendResetLinkEmail']);
Route::post('resetpass',[UserController::class,'resetPassword']);

// Orders
Route::post('/create_orders', [OrderController::class, 'createOrder']);
Route::get('/orders/user/{userId}', [OrderController::class, 'getOrdersByUser']);

// Items
Route::get('/get_items', [ItemController::class, 'getAllItems']);
    Route::post('/create', [ItemController::class, 'createItem']);
    Route::put('/items/{id}', [ItemController::class, 'updateItem']);
    Route::delete('/delete/{id}', [ItemController::class, 'deleteItem']);

// Favourites
Route::post('/favourites', [FavouriteController::class, 'addToFavourites']);
Route::get('/favourites/{userId}', [FavouriteController::class, 'getUserFavourites']);
Route::delete('/favourites', [FavouriteController::class, 'deleteFavourite']);

// Notifications
Route::post('/notifications', [NotificationController::class, 'addNotification']);


// Offers
Route::post('/offers', [OfferController::class, 'createOffer']);
Route::get('/offers', [OfferController::class, 'getAllOffers']);
Route::put('/offers/{id}', [OfferController::class, 'updateOffer']);
Route::delete('/offers/{id}', [OfferController::class, 'deleteOffer']);

// Reviews
Route::post('/reviews', [ReviewController::class, 'createReview']);
Route::put('/reviews/{id}', [ReviewController::class, 'updateReview']);
Route::delete('/reviews/{id}', [ReviewController::class, 'deleteReview']);
Route::get('/reviews/item/{itemId}', [ReviewController::class, 'getReviewsByItem']);

// Categories
Route::get('/categories', [CategoryController::class, 'getAllCategories']);