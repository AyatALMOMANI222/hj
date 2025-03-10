<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DrivingLessonController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\RatingResponseController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehiclesController;
use App\Models\Rating;
use Illuminate\Support\Facades\Route;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Laravel\Sanctum\Sanctum;

Route::post('/register', action: [UserController::class, 'store']);
Route::post('/login', action: [AuthController::class, 'login']);
Route::get('/user/profile', [AuthController::class, 'userProfile'])->middleware('auth:sanctum');
Route::post('/users', action: [UserController::class, 'getUsers']);
Route::delete('/user/{id}',action:[UserController::class , 'destroy'])->middleware(['auth:sanctum','admin']);
// Route::delete('/floor/delete/{id}', [StandardBoothPackageController::class, 'deleteById'])->middleware(['auth:sanctum', 'admin']);

Route::post('/rating',action:[RatingController::class,'store'])->middleware('auth:sanctum');
Route::get('/rating/{id}', action:[RatingController::class,'getRatingByTrainerId']);
Route::delete('/rating/{ratingId}',action:[RatingController::class,'destroy'])->middleware('auth:sanctum');
Route::put('/rating/{ratingId}',action:[RatingController::class,'update'])->middleware('auth:sanctum');


Route::get('/rating/avg/{id}', action:[RatingController::class,'getAvgRatingByTrainerId']);





Route::get('/user/{type}',action:[UserController::class,'getUserByType'] );


// cources
Route::post('/course',[CourseController::class , 'store'])->middleware('auth:sanctum');
Route::get('/courses/{center_id}', [CourseController::class,'getAllCources'])->middleware('auth:sanctum');
Route::get('/all/course',[CourseController::class,'getAll']);
Route::delete('/course/{id}',action:[CourseController::class,'destroy'])->middleware('auth:sanctum');
Route::put('/course/{id}',action:[CourseController::class,'update'])->middleware('auth:sanctum');

//vehicles
Route::post('/vehicles',[VehiclesController::class, 'store'])->middleware('auth:sanctum');
Route::post('/veh/update/{id}',action:[VehiclesController::class,'update'])->middleware(['auth:sanctum']);
Route::get(uri: '/vehicles/{userId}',action:[VehiclesController::class,'getVehicleByOwner']);
Route::get(uri: '/vehicles/data/{Id}',action:[VehiclesController::class,'getVehiclesById']);
Route::delete('/vehicle/{id}',action:[VehiclesController::class,'destroy'])->middleware(['auth:sanctum']);


// DrivingLessons
Route::post('/driving/lessons',action:[DrivingLessonController::class,'store'])->middleware('auth:sanctum');
Route::delete('/delete/lesson/{id}',action:[DrivingLessonController::class , 'destroy'])->middleware('auth:sanctum');
Route::get('/lesson/{id}/{type}',action:[DrivingLessonController::class , 'getByType']);
// $allowedTypes = ['course', 'instructor', 'center'];
Route::put('/lesson/{id}',action:[DrivingLessonController::class , 'update'])->middleware('auth:sanctum');


Route::get('/lesson/count/m/{instructorId}',action:[DrivingLessonController::class , 'getCompletedLessonsByInstructor']);
Route::get('/lesson/instructor',action:[DrivingLessonController::class , 'getDrivingLessonByInstructorId'])->middleware('auth:sanctum');



// Booking 
Route::post('/booking',action:[BookingController::class,'store'])->middleware('auth:sanctum');
Route::delete('/booking/{id}',action:[BookingController::class,'deleteBooking'])->middleware('auth:sanctum');
Route::put('/booking/{id}',action:[BookingController::class,'update'])->middleware('auth:sanctum');


Route::get('/booking',action:[BookingController::class,'getBookings'])->middleware('auth:sanctum');
Route::get('/booking/paid',action:[BookingController::class,'getPaidBookings'])->middleware('auth:sanctum');

// RatingResponse
Route::post('/rating/response/{rating_id}',action:[RatingResponseController::class,'store'])->middleware('auth:sanctum');
Route::get('/rating/response/{rating_id}',action:[RatingResponseController::class,'getResponsesByRating']);
Route::get('/rating/res/user',action:[RatingResponseController::class,'getResponsesByUser'])->middleware('auth:sanctum');
Route::put('/update/res/{response_id}',action:[RatingResponseController::class,'updateResponse'])->middleware('auth:sanctum');
Route::delete('/delete/res/{response_id}',action:[RatingResponseController::class,'deleteResponse'])->middleware('auth:sanctum');
