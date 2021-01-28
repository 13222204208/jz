<?php

use App\Models\User;
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
    if (session('id')==1) {
        $per = array('用户管理','后台帐号管理','产品管理','内容管理','工程管理','表单管理','用户列表','用户协议','实名认证','报修售后列表','用户美图','后台帐号','角色管理','权限管理','产品库','套餐管理','轮播图','案例和资讯',
        '案例标签','合同列表','工程订单','客户订单','智能设计','户型列表','类型列表');

        return view('index',['per'=>$per]);
    }else if (session('id')) {
       $user= User::find(session('id'));
       $permission= $user->getAllPermissions();
       $data= json_decode($permission);
       $per = array();
   
       foreach($data as $d){
           $per[] = $d->{'name'};
       }
        //dd($per);exit;
       return view('index',['per'=>$per]);
   }
})->middleware('adminLogin');

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
    })->name('lunbo')->middleware('adminRoute');

    Route::post('/upload/rotation/img','Content\RotationChartController@uploadRotationImg');//上传轮播图片
    Route::post('create/chart','Content\RotationChartController@createChart');//创建轮播图片
    Route::get('query/rotation/list','Content\RotationChartController@queryRotationList');//轮播列表
    Route::post('del/rotation/chart','Content\RotationChartController@delRotationChart');//删除一个轮播图
    Route::post('update/rotation/chart','Content\RotationChartController@updateRotationChart');//更新一个轮播图

    Route::get('case-tag', function () {//案例的标签
        return view('content.case-tag');
    })->name('casetag')->middleware('adminRoute');
    Route::resource('casetag', 'Content\CaseTagController');//案例标签

    Route::get('create-case-info', function () {//创建案例和资讯
        return view('content.create-case-info');
    });

    Route::post('upload/imgs','UploadController@uploadImgs');//上传图片
    Route::post('caseinfo/img','UploadController@caseInfoImg');//上传详情图片

    Route::get('case-info-list', function () {//案例和资讯列表
        return view('content.case-info-list');
    })->name('caseinfo')->middleware('adminRoute');

    Route::resource('caseinfo', 'Content\CaseInfoController');//案例和资讯    

    Route::get('contract-list', function () {//合同列表
        return view('content.contract-list');
    })->name('contract')->middleware('adminRoute');
    Route::get('create-contract', function () {//合同列表
        return view('content.create-contract');
    });

    Route::get('goods-package','Content\ContractPackageController@getGoodsPackage');
    Route::post('create-contract-package','Content\ContractPackageController@createContractPackage');
    Route::post('file','UploadFileController@file');//上传合同附件
    
    Route::get('search_contract','Content\SearchContractController@searchContract');
    Route::resource('contract', 'Content\ContractController');//合同
    Route::post('updateContract/{id}','Content\SearchContractController@updateContract');

});

Route::prefix('admin')->group(function () {//经纪人管理

    Route::get('account', function () {
        return view('admin.account');//帐号管理
    })->name('adminaccount')->middleware('adminRoute');

    Route::post('add/account','Admin\AdminController@addAccount');//添加后台帐号
    Route::post('have/branch','Admin\AdminController@haveBranch');//选择部门

    Route::post('del/account','Admin\AdminController@delAccount');//删除一个帐号
    Route::post('update/account','Admin\AdminController@updateAccount');//更新帐号

    Route::get('query/account','Admin\AdminController@queryAccount');//获取所有后台帐号
    Route::post('add/role','Admin\AdminController@addRole');//添加角色
    Route::get('query/role','Admin\AdminController@queryRole');//查看所有角色

    Route::get('query/permission','Admin\AdminController@queryPermission');//查看所有权限
    Route::get('gain/admin/permission/{id}','Admin\AdminController@gainPermission');//查看子权限
    Route::post('del/permission','Admin\AdminController@delPermission');//删除一个权限
    Route::post('update/pname','Admin\AdminController@updatePname');//更新权限的名称


    Route::post('del/role','Admin\AdminController@delRole');//删除一个角色
    Route::get('gain/role','Admin\AdminController@gainRole');//获取所有角色

    //Route::post('all/role','Admin\AdminController@addRoleScope');//获取所有角色

    Route::post('have/role','Admin\AdminController@haveRole');//获取当前用户的角色名称
    Route::post('update/role','Admin\AdminController@updateRole');//更新用户的角色


    Route::post('update/permission','Admin\AdminController@updatePermission');//更新角色的权限
    Route::post('add/power','Admin\AdminController@addPower');//添加权限
    Route::get('all/permission','Admin\AdminController@allPermission');//获取所有权限名称
    Route::post('have/permission','Admin\AdminController@havePermission');//获取当前角色的权限名称

    
    Route::get('power', function () {
        return view('admin.power');//权限管理
    })->name('permission')->middleware('adminRoute');



    Route::get('role', function () {
        return view('admin.role');//角色管理
    })->name('role')->middleware('adminRoute');
});



Route::prefix('goods')->group(function () {

    Route::get('list', function () {
        return view('goods.goods');//产品列表
    })->name('glist')->middleware('adminRoute');

    Route::get('create', function () {
        return view('goods.create-goods');//产品
    });

    Route::resource('goods', 'Goods\GoodsController');//产品

    Route::post('upload/imgs','UploadController@uploadImgs');//上传图片
    Route::post('content/img','UploadController@contentImg');//上传商品详情图片

    Route::get('grouplist', function () {
        return view('goods.goods-group');//套餐列表
    })->name('goodspackage')->middleware('adminRoute');

    Route::get('addgroup', function () {
        return view('goods.addgroup');//添加套餐
    });

    Route::resource('group', 'Goods\GroupController');//套餐
    Route::patch('updateGroup/{id}', 'Goods\GroupController@updateGroup');//套餐
});

Route::prefix('build')->group(function () {

    Route::get('list', function () {
        return view('build.order-list');//工程订单列表
    })->name('order')->middleware('adminRoute');
  
    Route::resource('build', 'Build\BuildOrderController');//工程订单

    Route::get('owner-order-list', function () {
        return view('build.owner-order-list');//工程订单列表
    })->name('ownerorder')->middleware('adminRoute');
  
    Route::resource('ownerOrder', 'Build\OwnerOrderController');//客户下的工程订单
    Route::post('updateOrder/{id}', 'Build\OwnerOrderController@updateOrder');//修改客户下的工程订单
    Route::get('merchant', 'Build\OwnerOrderController@merchant');//获取商家列表
    Route::patch('relevance/{id}', 'Build\OwnerOrderController@relevance');//关联商家

    Route::get('goods/{id}','Build\OrderGoodsController@goods');

    Route::get('design-list', function () {
        return view('build.design-list');//智能设计列表
    })->name('design')->middleware('adminRoute');
    
    Route::resource('design', 'Build\DesignController');//智能设计
    
    
});

Route::prefix('user')->group(function () {

    Route::get('list', function () {
        return view('user.list');//用户列表
    })->name('userlist')->middleware('adminRoute');
    
    Route::resource('userinfo', 'User\UserInfoController');
    Route::post('updateInfo/{id}','User\UserInfoController@updateInfo');//更新用户信息
    Route::get('search','User\SearchUserController@search');

    Route::get('true-name', function () {
        return view('user.true-name');//实名认证
    })->name('truename')->middleware('adminRoute');
    
    Route::resource('truename', 'User\TruenameController');
    
    Route::get('protocol', function () {
        return view('user.protocol');//用户协议
    })->name('protocol')->middleware('adminRoute');
    Route::post('create/protocol','User\ProtocolController@createProtocol');//创建用户协议
    Route::post('edit/protocol','User\ProtocolController@editProtocol');//修改用户协议
    Route::get('gain/protocol','User\ProtocolController@gainProtocol');//查看合同期限
    

    Route::get('after-sale-list', function () {
        return view('user.after-sale-list');//报修售后列表
    })->name('aftersale')->middleware('adminRoute');
    
    Route::resource('after', 'User\AfterSaleController');//报修和售后

    Route::get('dynamic-list', function () {
        return view('user.dynamic-list');//用户美图
    })->name('userdynamic')->middleware('adminRoute');
    
    Route::resource('dynamic', 'User\DynamicController');//用户美图
    
    
});

Route::prefix('form')->group(function () {

    Route::get('house-type', function () {
        return view('form.house-type');//户型
    })->name('housetype')->middleware('adminRoute');
    
    Route::resource('housetype', 'Form\HouseTypeController');//户型

    Route::get('goods-type', function () {
        return view('form.goods-type');//类型
    })->name('goodstype')->middleware('adminRoute');
    
    Route::resource('goodstype', 'Form\GoodsTypeController');//表单类型
    
    
});

