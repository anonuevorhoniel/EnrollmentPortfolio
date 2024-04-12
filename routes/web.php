<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EnrollController;
use App\Models\Enroll;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('login');
})->name('login');

Route::match(['post', 'get'] ,'/loginCheck', [EnrollController::class, 'login'])->name('login.check'); //login

Route::get('/dashboard', [EnrollController::class, 'dashboard'])->name('student.dashboard')->middleware('auth');

Route::get('/signup', function()
{
    return view('signup');
});

Route::post('/signup-post', [EnrollController::class, 'createUsers'])->name('signup');

Route::any('/logout', [EnrollController::class, 'logout'])->name('logout');
Route::any('/createContent', [EnrollController::class, 'createEnrollment'])->name('create.content');
Route::get('/subjects', [EnrollController::class, 'subjects'])->name('subjects')->middleware('auth');
Route::get('/loginAdmin', function()
{
    return view('loginAdmin');
});
Route::get('/dashboardAdmin',[EnrollController::class, 'adminDashboard'])->name('admin.dashboard')->middleware('auth');
Route::get('/viewenrollees', [EnrollController::class, 'viewUsers']);
Route::any('/logincheck', [EnrollController::class, 'loginAdmin']);
//add
Route::post('/addedsub', [EnrollController::class, 'addSubjects'])->name('addSubjects');
Route::put('/updatedata/{id}', [EnrollController::class, 'editSub']);
Route::delete('/delete/{id}', [EnrollController::class, 'delete']);
Route::post('/savesubject', [EnrollController::class, 'saveSubs']);
Route::post('/courseyear', [EnrollController::class, 'courseyear']);
Route::get('/courses', [EnrollController::class, 'courses']);
Route::post('/addcourse', [EnrollController::class, 'addCourses']);
Route::post('/acceptstudent', [EnrollController::class, 'acceptstudent']);