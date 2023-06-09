<?php

use App\Http\Controllers\IssueController;
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
    return view('welcome');
});

Route::resource('issue', IssueController::class)->whereNumber('issue');
Route::get('issue/search', [IssueController::class, 'search'])->name('issue.search');
Route::get('issue/download_csv', [IssueController::class, 'downloadCsv'])->name('issue.download_csv');
