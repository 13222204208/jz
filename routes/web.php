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

    //跑马灯
    Route::get('running-horse-lamp', function () {
        return view('content.running-horse-lamp');
    })->middleware('adminLogin');

    Route::post('create/running/horse','Content\RunningHorseLampController@createRunHorse');//创建跑马灯
    Route::get('query/running/horse','Content\RunningHorseLampController@queryRunHorse');//查看跑马灯列表

    //赞助
    Route::get('support', function () {
        return view('content.support');
    })->middleware('adminLogin');
    Route::post('create/support','Content\SupportController@createSupport');//新建赞助
    Route::get('query/support','Content\SupportController@querySupport');//查看赞助
    Route::post('update/support','Content\SupportController@updateSupport');//更新赞助
    Route::post('del/support','Content\SupportController@delSupport');//更新赞助
});
