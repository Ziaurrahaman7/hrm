<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [\App\Http\Controllers\AdminController::class, 'users'])->name('users');
    Route::get('/users/create', [\App\Http\Controllers\AdminController::class, 'createUser'])->name('users.create');
    Route::post('/users', [\App\Http\Controllers\AdminController::class, 'storeUser'])->name('users.store');
    Route::get('/users/{user}/edit', [\App\Http\Controllers\AdminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{user}', [\App\Http\Controllers\AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}', [\App\Http\Controllers\AdminController::class, 'destroyUser'])->name('users.destroy');
});

Route::middleware('auth')->group(function () {
    Route::resource('employees', \App\Http\Controllers\EmployeeController::class);
    Route::get('departments', [\App\Http\Controllers\DepartmentController::class, 'index'])->name('departments.index');
    Route::post('departments', [\App\Http\Controllers\DepartmentController::class, 'store'])->name('departments.store');
    Route::put('departments/{department}', [\App\Http\Controllers\DepartmentController::class, 'update'])->name('departments.update');
    Route::delete('departments/{department}', [\App\Http\Controllers\DepartmentController::class, 'destroy'])->name('departments.destroy');
    Route::get('skills', [\App\Http\Controllers\SkillController::class, 'index'])->name('skills.index');
    Route::post('skills', [\App\Http\Controllers\SkillController::class, 'store'])->name('skills.store');
    Route::put('skills/{skill}', [\App\Http\Controllers\SkillController::class, 'update'])->name('skills.update');
    Route::delete('skills/{skill}', [\App\Http\Controllers\SkillController::class, 'destroy'])->name('skills.destroy');
    Route::get('employees/filter/{department}', [\App\Http\Controllers\EmployeeController::class, 'filterByDepartment']);
    Route::post('check-email', [\App\Http\Controllers\EmployeeController::class, 'checkEmail']);
});

require __DIR__.'/auth.php';
