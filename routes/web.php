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

//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('/users', \App\Http\Controllers\UserController::class)
        ->except(["index"]);
    Route::get('/users', \App\Http\Livewire\UserIndex::class)
        ->name('users.index');

    Route::resource('/documents', \App\Http\Controllers\DocumentController::class)
        ->except(["index"]);
    Route::get('/documents', \App\Http\Livewire\DocumentIndex::class)
        ->name('documents.index');
    Route::get('/documents/{document}/download', [App\Http\Controllers\DocumentController::class, 'download'])
        ->name('documents.download');

    Route::resource('/departments', \App\Http\Controllers\DepartmentController::class);
    Route::resource('/metadataTypes', \App\Http\Controllers\MetadataTypeController::class);

    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

});

require __DIR__.'/auth.php';
