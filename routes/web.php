<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ClinicDateController;
use App\Http\Controllers\ClinicVisitController;
use App\Http\Controllers\EmergencyController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/aboutus', function () {
    return view('aboutus');
});

Route::middleware(['middleware'=>'PreventBackHistory'])->group(function () {
    Auth::routes();
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get("/contactus", [ContactController::class, 'index']);
Route::post("/contactus", [ContactController::class, 'store']);

Route::group(['prefix' => 'admin', 'middleware' => ['isAdmin', 'auth', 'PreventBackHistory']], function () {
    Route::get('dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::resource('patients', PatientController::class);
    Route::resource('clinic_dates', ClinicDateController::class);
    Route::resource('clinic_visits', ClinicVisitController::class);
    Route::resource('emergencies', EmergencyController::class);
});

Route::group(['prefix' => 'doctor', 'middleware' => ['isDoctor', 'auth', 'PreventBackHistory']], function () {
    Route::get('dashboard', [DoctorController::class, 'index'])->name('doctor.dashboard');
});
