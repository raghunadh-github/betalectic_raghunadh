<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BlogController;        

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
    return view('auth/login');
});
Auth::routes();


Route::get('/home', [HomeController::class, 'index'])->name('home');

// check for logged in user
Route::middleware(['auth'])->group(function () {
    
  Route::get('blogs', [BlogController::class, 'index'])->name('blogs');

  Route::get('new-blog', [BlogController::class, 'create'])->name('blog.new');
  Route::post('store-blog', [BlogController::class, 'store'])->name('blog.store');
  Route::get('blog-show/{id}', [BlogController::class, 'show'])->name('blog.show');
  Route::get('blog-edit/{id}', [BlogController::class, 'edit'])->name('blog.edit');
  Route::post('blog-update', [BlogController::class, 'update'])->name('blog.update');
  Route::get('delete/{id}', [BlogController::class, 'destroy'])->name('blog.delete');  
});
