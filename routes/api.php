<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('user')->group(function (){

    Route::post('login','Api\User\UserinfoController@login');//登录
    Route::group(['middleware' => 'auth.jwt'], function () {

        Route::post('upload_img','Api\User\UserinfoController@uploadImg');//图片上传
        Route::post('edit','Api\User\UserinfoController@edit');//用户编辑资料
    
        Route::post('truename','Api\User\UserinfoController@truename');//工程师编辑资料用于提交身份证资料实名认证
    
        Route::post('dynamic','Api\User\UserDynamicController@dynamic');//用户美图发布
        Route::get('my_dynamic','Api\User\UserDynamicController@myDynamic');//用户我的美图
        Route::post('comment','Api\User\UserDynamicController@comment');//用户对美图评论
    
        Route::get('form_type','Api\User\DesignController@formType');//表单类型数据
        Route::post('design','Api\User\DesignController@design');//提交智能设计数据
    
        Route::post('collect','Api\User\CollectController@collect');//收藏产品
        Route::get('collect_list','Api\User\CollectController@collectList');//产品收藏列表
        Route::post('defined','Api\User\CollectController@defined');//保存方案
    
        Route::get('rate','Api\User\ConstructController@rate');//订单进度显示

        Route::post('prot','Api\User\ProtController@prot');//订单进度显示

    });
});

Route::prefix('homepage')->group(function (){

    Route::get('banner','Api\Homepage\BannerController@banner');//获取banner轮播图
    //Route::get('menu','Api\Homepage\MenuController@menu');//获取首页套餐显示
    Route::get('dynamic','Api\Homepage\DynamicController@dynamic');//获取首页客户美图
    Route::get('dynamic_detail','Api\Homepage\DynamicController@dynamicDetail');//获取美图详细信息
    Route::group(['middleware' => 'auth.jwt'], function () {
        Route::post('like','Api\Homepage\DynamicController@like');//点赞客户美图
    });

});

Route::prefix('goods')->group(function (){

    Route::get('list','Api\Goods\GoodsListController@list');//获取产品列表 
    Route::group(['middleware' => 'auth.jwt'], function () {
        
      
    });


});

Route::prefix('gp')->group(function (){//套餐

    Route::group(['middleware' => 'auth.jwt'], function () {
        Route::get('list','Api\GoodsPackage\GoodsPackageController@list');//获取套餐产品 
    });


});


Route::prefix('aftersale')->group(function (){//报修和售后

    Route::group(['middleware' => 'auth.jwt'], function () {
        Route::post('create','Api\AfterSale\AfterSaleController@create');//提交报修和售后
    });

});

Route::prefix('caseinfo')->group(function (){//案例和资讯
    
    Route::get('list','Api\CaseInfo\CaseInfoController@list');//查询案例和资讯 
    Route::group(['middleware' => 'auth.jwt'], function () {
      
    });

});

Route::prefix('order')->group(function (){//商家端工程订单

    Route::group(['middleware' => 'auth.jwt'], function () {
        Route::post('create','Api\Order\BuildOrderController@create');//商家端添加工程订单
        Route::get('list','Api\Order\BuildOrderController@list');//商家端工程订单列表 
    });

});

Route::prefix('engineer')->group(function (){//商家端工程订单

    Route::group(['middleware' => 'auth.jwt'], function () {
        Route::get('list','Api\Engineer\EngineerController@list');//安装端显示的订单列表

        Route::post('schedule','Api\Engineer\EngineerController@schedule');//添加工程订单施工进度
        Route::post('done','Api\Engineer\EngineerController@done');//竣工
    
        Route::get('show','Api\Engineer\EngineerController@show');//展示施工进度
    
        Route::get('after','Api\Engineer\EngineerController@after');//售后处理列表
    });

});

Route::fallback(function(){
    return response()->json([
        'code' =>0,
        'msg' => '页面没有找到，可能请求地址错误'], 404);
});
