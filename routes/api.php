<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Role\RoleController;
use App\Http\Controllers\Api\User\UserController;
use App\Http\Controllers\Api\Category\CategoryController;
use App\Http\Controllers\Api\Event\EventController;
use App\Http\Controllers\Api\Booking\BookingController;
use App\Http\Controllers\Api\Payment\PaymentController;
use App\Http\Controllers\Api\Image\ImageController;
use App\Http\Controllers\Api\Review\ReviewController;
use App\Http\Controllers\Api\Notification\NotificationController;
use App\Http\Controllers\Api\Ticket\TicketController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::apiResource('categories', CategoryController::class)->only(['index', 'show']);
Route::apiResource('events', EventController::class)->only(['index', 'show']);

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::apiResource('roles', RoleController::class);
    Route::apiResource('users', UserController::class)->except(['store']);

    Route::apiResource('events', EventController::class)->except(['index', 'show']);

    Route::apiResource('bookings', BookingController::class);
    Route::apiResource('tickets', TicketController::class);
    Route::apiResource('payments', PaymentController::class);
    Route::apiResource('images', ImageController::class);
    Route::apiResource('reviews', ReviewController::class);
    Route::apiResource('notifications', NotificationController::class);
});