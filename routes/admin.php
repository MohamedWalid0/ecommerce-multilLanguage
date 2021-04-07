<?php

use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\LoginController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\SettingsController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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
Route::group([
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function(){ 

        Route::group( ['namespace' => 'Dashboard' , 'middleware'=> 'auth:admin' , 'prefix' => 'admin' ] , function(){

            Route::get('/', [DashboardController::class , 'index'] )-> name('admin.dashboard');

            Route::get('logout', [LoginController::class , 'logout'] )-> name('admin.logout');




            Route::group( ['prefix' => 'settings'] , function (){
        
                Route::get('shipping-methods/{type}' , [SettingsController::class , 'editShippingMethods']) -> name('edit.shippings.methods') ;
                Route::put('shipping-methods/{id}' , [SettingsController::class , 'updateShippingMethods']) ->name('update.shippings.methods') ;
        
            } ) ;
        

            Route::group(['prefix' => 'profile'], function () {
                Route::get('edit', [ProfileController::class , 'editProfile'])->name('profile.edit');
                Route::put('update', [ProfileController::class , 'updateProfile'])->name('profile.update');
            });


        
        } ) ;
        
        Route::group( ['namespace' => 'Dashboard' , 'middleware'=> 'guest:admin' , 'prefix' => 'admin'  ] , function(){

            Route::get('/login', [LoginController::class , 'login'] )-> name('admin.login');
            Route::post('login', [LoginController::class ,'postLogin'] )->name('admin.post.login');
        
        } ) ;

    });
    







