<?php

use App\Http\Controllers\Api\PatientController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ServantController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Resources\DoctorResource;
use App\Http\Resources\PatientResource;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\verifyUser;

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


Route::get('/index', [PatientController::class, 'index'])->name('list');
Route::post('/list', [PatientController::class, 'list'])->name('api.list');
Route::post('/store', [PatientController::class, 'store'])->name('api.store');
Route::post('/update/{id}', [PatientController::class, 'update'])->name('api.update');
Route::post('/edit', [PatientController::class, 'edit'])->name('api.edit');
Route::post('/delete', [PatientController::class, 'delete'])->name('api.delete');


Route::get('/user/{id}', function (string $id) {
    return new PatientResource(Patient::findOrFail($id));
});



Route::get('/doctors', function () {
    return DoctorResource::collection(Doctor::all());
});

Route::get('/patients', function () {
    return PatientResource::collection(Patient::all());
});


Route::controller(AuthController::class)->group(function () {
    Route::prefix('/doctor')->name('doctor.')->group(function () {
        Route::post('register', 'register');
        Route::post('login', 'login');
        Route::post('logout', 'logout');
        Route::middleware(['auth:api'])->group(function () {
            Route::get('userinfo', 'getUserDetail');
            Route::post('changepassword', 'change_password');
        });
    });
});

// Route::middleware(['auth:sanctum'])->group(function () {
//     Route::post('/changepassword', [AuthController::class, 'change_password']);
// });


Route::controller(ServantController::class)->group(function () {
    Route::prefix('/servant')->name('servant.')->group(function () {
        Route::post('register', 'register');
        Route::post('login', 'login');
        Route::post('logout', 'logout');
        Route::middleware(['auth:servants'])->group(function () {
            Route::get('userinfo', 'getUserDetail');
            Route::post('changepassword', 'change_password');
        });
    });
});