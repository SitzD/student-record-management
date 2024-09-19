<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StudentController;

// Redirect the root URL to /dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/students/create', [StudentController::class, 'create'])->name('students.create');
Route::post('/students', [StudentController::class, 'store'])->name('students.store');

Route::get('/students', [StudentController::class, 'index'])->name('students.index');

Route::get('/students/{student}/edit', [StudentController::class, 'edit'])->name('students.edit');
Route::put('/students/{student}', [StudentController::class, 'update'])->name('students.update');

Route::delete('students/{student}', [StudentController::class, 'destroy'])->name('students.destroy');

Route::get('/admin/settings', [AdminController::class, 'edit'])->name('admin.settings');
Route::put('/admin/settings', [AdminController::class, 'update'])->name('admin.settings.update');


