<?php

use App\Http\Controllers\Api\ClassController;
use App\Http\Controllers\Api\TimetableController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// TODO: implement auth
Route::controller(TimetableController::class)
    ->prefix('timetable')
    ->group(function () {
        Route::get('/', 'lessons')->name('api.timetable.lessons');
    });

Route::controller(ClassController::class)
    ->prefix('classes')
    ->group(function () {
        Route::get('/{classId}', 'show')->name('api.class.show');
    });


