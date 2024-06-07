<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['prefix'=>'user','as'=>'user.'],function (){
    Route::post('login',[\App\Http\Controllers\api\auth\user\indexController::class,'login'])->name('login');
    Route::post('register',[\App\Http\Controllers\api\auth\user\indexController::class,'register'])->name('register');

    Route::group(['middleware' => 'auth:api'],function (){
        Route::get('profile',[\App\Http\Controllers\api\auth\user\indexController::class,'profile'])->name('profile');
        Route::get('logout',[\App\Http\Controllers\api\auth\user\indexController::class,'logout'])->name('logout');
    });
});

Route::group(['prefix'=>'client','as'=>'client.'],function (){
    Route::post('login',[\App\Http\Controllers\api\auth\client\indexController::class,'login'])->name('login');
    Route::post('register',[\App\Http\Controllers\api\auth\client\indexController::class,'register'])->name('register');

    Route::group(['middleware' => 'auth:api_client'],function (){
        Route::get('profile',[\App\Http\Controllers\api\auth\client\indexController::class,'profile'])->name('profile');
        Route::get('logout',[\App\Http\Controllers\api\auth\client\indexController::class,'logout'])->name('logout');
    });
});

