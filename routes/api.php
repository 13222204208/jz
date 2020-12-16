<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('user')->group(function (){

    Route::post('login','Api\User\UserinfoController@login');//登录
    Route::post('upload_img','Api\User\UserinfoController@uploadImg');//图片上传
    Route::post('edit','Api\User\UserinfoController@edit');//用户编辑资料

    Route::post('dynamic','Api\User\UserDynamicController@dynamic');//用户美图发布

    Route::group(['middleware' => 'auth.jwt'], function () {
        Route::post('logout', 'Api\UserinfoController@logout');//退出登录

    });
});

Route::prefix('homepage')->group(function (){

    Route::get('banner','Api\Homepage\BannerController@banner');//获取banner轮播图

    Route::get('menu','Api\Homepage\MenuController@menu');//获取首页套餐显示

});

Route::prefix('goods')->group(function (){

    Route::get('list','Api\Goods\GoodsListController@list');//获取产品列表 

    Route::get('menu','Api\Homepage\MenuController@menu');//获取首页套餐显示

});

Route::prefix('gp')->group(function (){//套餐

    Route::get('list','Api\GoodsPackage\GoodsPackageController@list');//获取套餐产品 

});


Route::prefix('aftersale')->group(function (){//报修和售后

    Route::post('create','Api\AfterSale\AfterSaleController@create');//提交报修和售后

});

Route::prefix('caseinfo')->group(function (){//案例和资讯

    Route::get('list','Api\CaseInfo\CaseInfoController@list');//查询案例和资讯

});
