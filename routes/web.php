<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home');
});



Route::get('/about', function () {
    return view('layouts/about');
});

Route::get('/courses', function () {
    return view('layouts/courses');
});
Route::get('/contact', function () {
    return view('layouts/contact');
});

Route::get('/team', function () {
    return view('layouts/team');
});

Route::get('/testimonial', function () {
    return view('layouts/testimonial');
});

Route::get('/404', function () {
    return view('layouts/404');
});




Route::middleware(['auth', 'student'])->group(function () {
    Route::get('/student/dashboard', [StudentController::class, 'dashboard'])->name('student.dashboard');
    
});

Route::middleware(['auth', 'teacher'])->group(function () {
    Route::get('/teacher/dashboard', [TeacherController::class, 'dashboard'])->name('teacher.dashboard');
    Route::get('/teacher/students', [TeacherController::class, 'showStudents'])->name('teacher.students');
});

Route::middleware(['auth', 'teacher'])->get('/teacher/dashboard', [TeacherController::class, 'index'])->name('teacher.dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');

    Route::put('/profile/{id}', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/{id}', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('students', StudentController::class);
Route::resource('teachers', TeacherController::class);
require __DIR__ . '/auth.php';

Auth::routes();
