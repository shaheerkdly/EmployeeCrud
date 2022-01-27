<?php

use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;

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

Route::put('{employee}', [EmployeeController::class, 'update'])->name('update');
Route::get('/', [EmployeeController::class, 'index'])->name('index');
Route::get('create', [EmployeeController::class, 'create'])->name('create');
Route::post('/', [EmployeeController::class, 'store'])->name('store');
Route::get('{employee}/edit', [EmployeeController::class, 'edit'])->name('edit');
Route::delete('{employee}', [EmployeeController::class, 'destroy'])->name('destroy');
