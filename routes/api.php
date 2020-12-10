<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('user')->group(function (){

    Route::post('login','Api\User\UserinfoController@login');//登录

    Route::group(['middleware' => 'auth.jwt'], function () {
        Route::post('logout', 'Api\UserinfoController@logout');//退出登录

    });
});
