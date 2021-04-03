<?php

use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\LoginController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "admin" middleware group. Now create something great!
|
*/

Route::group( ['namespace' => 'Dashboard' , 'middleware'=> 'auth:admin' ] , function(){

    Route::get('/', [DashboardController::class , 'index'] )-> name('admin.dashboard');





} ) ;





Route::group( ['namespace' => 'Dashboard' , 'middleware'=> 'guest:admin' ] , function(){

    Route::get('/login', [LoginController::class , 'login'] )-> name('admin.login');
    Route::post('login', [LoginController::class ,'postLogin'] )->name('admin.post.login');


} ) ;
