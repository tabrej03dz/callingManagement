<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NumberController;
use App\Http\Controllers\UserNumberController;
use App\Http\Controllers\CallRecordController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DemoController;
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
        Route::post('unAssign', [UserNumberController::class, 'unAssignTheNumber'])->name('unAssign');
        Route::get('add', [NumberController::class, 'addForm'])->name('add');
        Route::post('save', [NumberController::class, 'saveNumber'])->name('save');

        Route::get('status/{number}/{status}', [NumberController::class, 'status'])->name('status');
        Route::get('statusWise/{status?}', [NumberController::class, 'statusWise'])->name('statusWise');
    });

    Route::prefix('callRecord')->name('callRecord.')->group(function(){
        Route::get('show/{number}', [CallRecordController::class, 'show'])->name('show');
        Route::get('create/{number}', [CallRecordController::class, 'create'])->name('create');
        Route::post('store/{number}', [CallRecordController::class, 'store'])->name('store');
        Route::get('markAsRecalled/{record}', [CallRecordController::class, 'markAsRecalled'])->name('markAsRecalled');
        Route::get('dayWise', [CallRecordController::class, 'dayWise'])->name('dayWise');
        Route::get('statusWise/{status?}', [CallRecordController::class, 'callRecordStatusWise'])->name('statusWise');
    });

    Route::prefix('user')->name('user.')->group(function(){
       Route::get('/', [UserController::class, 'index'])->name('index');
       Route::get('create', [UserController::class, 'create'])->name('create');
       Route::post('store', [UserController::class, 'store'])->name('store');
       Route::get('edit/{user}', [UserController::class, 'edit'])->name('edit');
       Route::post('update/{user}', [UserController::class, 'update'])->name('update');
       Route::get('delete/{user}', [UserController::class, 'delete'])->name('delete');
       Route::get('assignedNumbers/{user}', [UserController::class, 'userAssignedNumbers'])->name('assignedNumbers');
       Route::get('permissions/{user}', [UserController::class, 'userPermission'])->name('permissions');
       Route::get('permissionRemove/{permission}/{user}', [UserController::class, 'permissionRemove'])->name('permissionRemove');
       Route::get('unAssignNumber/{userNumber}', [UserNumberController::class, 'unAssign'])->name('unAssignNumber');
    });

    Route::prefix('role')->name('role.')->group(function(){
       Route::get('/', [RoleController::class, 'index'])->name('index');
       Route::get('create', [RoleController::class, 'create'])->name('create');
       Route::post('store', [RoleController::class, 'store'])->name('store');
       Route::get('delete/{role}', [RoleController::class, 'delete'])->name('delete');
       Route::get('permission/{role}', [RoleController::class, 'rolePermission'])->name('permission');
       Route::get('permissionRemove/{permission}/{role}', [RoleController::class, 'permissionRemove'])->name('permissionRemove');
    });

    Route::prefix('permission')->name('permission.')->group(function(){
       Route::get('/', [PermissionController::class, 'index'])->name('index');
       Route::post('giveToUserOrRole', [PermissionController::class, 'givePermissionToUserOrRole'])->name('giveToUserOrRole');
    });

    Route::prefix('status')->name('status.')->group(function (){
        Route::get('/', [StatusController::class, 'index'])->name('index');
        Route::get('create', [StatusController::class, 'create'])->name('create');
        Route::post('store', [StatusController::class, 'store'])->name('store');
        Route::get('delete/{status}', [StatusController::class, 'delete'])->name('delete');
    });

    Route::prefix('report')->name('report.')->group(function(){
       Route::get('user/{user}', [ReportController::class, 'userReport'])->name('user');
    });

    Route::prefix('demo')->name('demo.')->group(function (){
       Route::get('/', [DemoController::class, 'index'])->name('index');
       Route::get('create', [DemoController::class, 'create'])->name('create');
       Route::post('store', [DemoController::class, 'store'])->name('store');
       Route::get('edit/{demo}', [DemoController::class, 'edit'])->name('edit');
       Route::post('update/{demo}', [DemoController::class, 'update'])->name('update');
       Route::get('delete/{demo}', [DemoController::class, 'delete'])->name('delete');
       Route::get('imageDelete/{image}', [DemoController::class, 'imageDelete'])->name('imageDelete');

       Route::get('images/{demo}', [DemoController::class, 'demoImages'])->name('images');
       Route::get('addImage/{demo}', [DemoController::class, 'addImage'])->name('addImage');
       Route::post('storeImage/{demo}', [DemoController::class, 'storeImage'])->name('storeImage');
    });
});

require __DIR__.'/auth.php';
