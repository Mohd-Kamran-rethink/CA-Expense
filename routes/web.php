<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CreditsController;
use App\Http\Controllers\DepartmentsController;
use App\Http\Controllers\ExpenseController;
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

Route::get('/dashboard', function () {
    return view('Admin.Dashboard.index');
});
// AUTH ROUTES
Route::get('/',[AuthController::class,'loginView'])->name('loginView');
Route::post('/login',[AuthController::class,'login'])->name('login');
Route::get('/logout',[AuthController::class,'logout'])->name('logout');

// expnse type
Route::middleware('ValidateManager')->prefix('expense-type')->group(function () {
    Route::get('',[ExpenseController::class,'list'])->name('list');
    Route::post('/delete',[ExpenseController::class,'delete'])->name('delete');
    Route::get('/edit',[ExpenseController::class,'editForm'])->name('editForm');
    Route::post('/edit',[ExpenseController::class,'edit'])->name('edit');
    Route::get('/add',[ExpenseController::class,'addForm'])->name('addForm');
    Route::post('/add',[ExpenseController::class,'add'])->name('add');
});
Route::middleware('CommonUsers')->prefix('expenses')->group(function () {
    Route::get('',[ExpenseController::class,'listMyExpenses'])->name('listMyExpenses');
    Route::get('add',[ExpenseController::class,'addExpenseForm'])->name('addExpenseForm');
    Route::post('add',[ExpenseController::class,'addExpense'])->name('addExpense');
    Route::post('/delete',[ExpenseController::class,'deleteExpense'])->name('deleteExpense');
    Route::get('/render-expense-type',[ExpenseController::class,'renderExpensesType'])->name('renderExpensesType');
    Route::get('/download/attatchement/{id}',[ExpenseController::class,'downloadAttatchment'])->name('downloadAttatchment');
});
// departments
Route::middleware('ValidateSuperManager')->prefix('departments')->group(function () {
    Route::get('',[DepartmentsController::class,'list'])->name('list');
    Route::get('/add',[DepartmentsController::class,'addForm'])->name('addForm');
    Route::post('/add',[DepartmentsController::class,'add'])->name('add');
    Route::post('/delete',[DepartmentsController::class,'delete'])->name('delete');
});  
// credits
Route::middleware('CommonUsers')->prefix('credits')->group(function () {
    Route::get('',[CreditsController::class,'list'])->name('list');
});
