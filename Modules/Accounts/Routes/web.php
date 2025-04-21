<?php

use Illuminate\Support\Facades\Route;
use Modules\Accounts\Http\Controllers\IncomeController;
use Modules\Accounts\Http\Controllers\AccountController;
use Modules\Accounts\Http\Controllers\ExpenseController;

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

Route::prefix('admin/accounts')->middleware(['auth.routes'])->group(function () {
    Route::controller(AccountController::class)->group(function () {
        Route::get('/list', 'index')->name('admin.accounts.index')->middleware('PermissionCheck:account_list');
        Route::get('/create', 'create')->name('admin.accounts.create')->middleware('PermissionCheck:account_create');
        Route::post('/store', 'store')->name('admin.accounts.store')->middleware('PermissionCheck:account_store');
        Route::get('/edit/{id}', 'edit')->name('admin.accounts.edit')->middleware('PermissionCheck:account_update');
        Route::post('/update/{id}', 'update')->name('admin.accounts.update')->middleware('PermissionCheck:account_update');
        Route::get('/destroy/{id}', 'destroy')->name('admin.accounts.destroy')->middleware('PermissionCheck:account_delete');

        Route::get('transaction/list', 'transactionList')->name('admin.accounts.transaction.index')->middleware('PermissionCheck:transaction_list');
    });

    Route::controller(IncomeController::class)->group(function () {
        Route::get('/income/list', 'index')->name('admin.accounts.income.index')->middleware('PermissionCheck:income_list');
    });

    Route::controller(ExpenseController::class)->group(function () {
        Route::get('/expense/list', 'index')->name('admin.accounts.expense.index')->middleware('PermissionCheck:expense_list');
    });

});
