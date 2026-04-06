<?php

use App\Http\Controllers\Api\Booking\BookingController;
use App\Http\Controllers\Api\Category\CategoryController;
use App\Http\Controllers\Api\Event\EventController;
use App\Http\Controllers\Api\Image\ImageController;
use App\Http\Controllers\Api\Notification\NotificationController;
use App\Http\Controllers\Api\Payment\PaymentController;
use App\Http\Controllers\Api\Review\ReviewController;
use App\Http\Controllers\Api\Role\RoleController;
use App\Http\Controllers\Api\User\UserController;
use Illuminate\Support\Facades\Route;

Route::apiResource('roles', RoleController::class);

Route::apiResource('users', UserController::class);

Route::apiResource('categories', CategoryController::class);

Route::apiResource('events', EventController::class);

Route::apiResource('bookings', BookingController::class);

Route::apiResource('payments', PaymentController::class);

Route::apiResource('images', ImageController::class);

Route::apiResource('reviews', ReviewController::class);

Route::apiResource('notifications', NotificationController::class);