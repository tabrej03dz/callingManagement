<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NumberController;
use App\Http\Controllers\UserNumberController;
use App\Http\Controllers\CallRecordController;
use App\Http\Controllers\UserController;

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
    return view('welcome');
});

Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('number')->name('number.')->group(function(){
        Route::get('/', [NumberController::class, 'index'])->name('index');
        Route::get('notAssigned', [NumberController::class, 'notAssigned'])->name('notAssigned');
        Route::get('upload', [NumberController::class, 'numberUploadForm'])->name('upload');
        Route::post('upload', [NumberController::class, 'numberUpload'])->name('upload');
        Route::post('assignToUser', [UserNumberController::class, 'assign'])->name('assignToUser');
        Route::get('assigned', [NumberController::class, 'assignedNumbers'])->name('assigned');
    });

    Route::prefix('callRecord')->name('callRecord.')->group(function(){
        Route::get('show/{number}', [CallRecordController::class, 'show'])->name('show');
        Route::get('create/{number}', [CallRecordController::class, 'create'])->name('create');
        Route::post('store/{number}', [CallRecordController::class, 'store'])->name('store');
    });

    Route::prefix('user')->name('user.')->group(function(){
       Route::get('/', [UserController::class, 'index'])->name('index');
    });
});

require __DIR__.'/auth.php';
