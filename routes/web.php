<?php

use App\Http\Controllers\BackupController;
use App\Models\Backup;
use App\Models\User;
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

Route::get('/', function () {
    // $user = User::count();
    // dd($user);
    $backup = Backup::first();
    return view('welcome', compact('backup'));
});
Route::get('/backup-database', [BackupController::class, 'backup'])->name('backup');
