<?php
// /routes/web.php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::resource('events', App\Http\Controllers\EventController::class);
    Route::put('events/{id}/resize', [App\Http\Controllers\EventController::class, 'resizeEvent'])->name('resize-event');
    Route::get('refetch-events', [App\Http\Controllers\EventController::class, 'refetchEvents'])->name('refetch-events');
});
