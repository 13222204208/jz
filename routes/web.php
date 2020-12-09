<?php

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
    return view('index');
});

Route::get('login', function () {//登陆
    return view('login.login');
});

Route::get('user/upassword', function () {
    return view('user.upassword');
});
Route::post('user/set/mypass','Login\LoginController@setMypass');//修改登陆密码
//后台退出
Route::get('logout', function (Illuminate\Http\Request $request) {
    $request->session()->flush();
    return redirect('login');
});

Route::get('admin/code/{tmp}','Login\LoginController@adminLogin');//后台登录验证码
Route::post('login/login','Login\LoginController@login');//后台登录验证

Route::prefix('content')->group(function () {

    //轮播图
    Route::get('rotation-chart', function () {
        return view('content.rotation-chart');
    });

    Route::post('/upload/rotation/img','Content\RotationChartController@uploadRotationImg');//上传轮播图片
    Route::post('create/chart','Content\RotationChartController@createChart');//创建轮播图片
    Route::get('query/rotation/list','Content\RotationChartController@queryRotationList');//轮播列表
    Route::post('del/rotation/chart','Content\RotationChartController@delRotationChart');//删除一个轮播图
    Route::post('update/rotation/chart','Content\RotationChartController@updateRotationChart');//更新一个轮播图
});



Route::prefix('goods')->group(function () {

    Route::get('list', function () {
        return view('goods.goods');//产品列表
    });

    Route::get('create', function () {
        return view('goods.create-goods');//产品
    });

    Route::resource('goods', 'Goods\GoodsController');//产品

    Route::post('upload/imgs','UploadController@uploadImgs');//上传图片
    Route::post('content/img','UploadController@contentImg');//上传商品详情图片

    Route::get('group', function () {
        return view('goods.goods-group');//产品组合
    });

    Route::get('addgroup', function () {
        return view('goods.addgroup');//产品组合
    });
});

