<?php

use App\Http\Controllers\ProfileController;
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
    return view('welcome-pw');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('/users', \App\Http\Controllers\UserController::class)
        ->except(["index"]);
    Route::get('/users', \App\Livewire\Users\UserIndexLivewire::class)
        ->name('users.index');

    Route::resource('/documents', \App\Http\Controllers\DocumentController::class)
        ->except(["index"]);
    Route::get('/documents', \App\Livewire\Documents\DocumentIndexLivewire::class)
        ->name('documents.index');

    Route::resource('/departments', \App\Http\Controllers\DepartmentController::class);
    Route::resource('/metadataTypes', \App\Http\Controllers\MetadataTypeController::class);
});

require __DIR__.'/auth.php';
