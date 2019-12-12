<?php

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
    return view('welcome');
});

Auth::routes();

Route::get('/token', 'HomeController@token')->name('home');//vtp获取token
Route::get('/callback', 'HomeController@callback')->name('home');//vtp 获取 token callback

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/getcategory', 'HomeController@getcategory')->name('home');//获取分类
Route::get('/getlist', 'HomeController@getlist')->name('home');//获取发布信息
Route::prefix('admin')->namespace('Admin')->group(function () {
    //后台首页
    $this->get('login', 'LoginController@showLoginForm')->name('admin.login');
    $this->post('login', 'LoginController@login');
    $this->get('logout', 'LoginController@logout')->name('admin.logout');
    Route::middleware('auth.admin:admin')->name('admin.')->group(function () {
        Route::get('/', 'HomeController@index');
        $this->get('member/index', 'MemberController@index');
        $this->get('blog/index', 'BlogController@index');//文章列表
        $this->get('blog/category', 'BlogController@categoryShow');//分类列表
        $this->get('blog/categoryAddshow', 'BlogController@categoryAddshow');//分类添加列表
        $this->post('blog/categoryAdd', 'BlogController@categoryAdd');//分类添加列表
        $this->get('blog/editstatus', 'BlogController@editstatus');//分类接口api修改分类是否启用
        $this->get('blog/editcategoryshow', 'BlogController@Editcategoryshow');//分类修改界面
        $this->get('blog/EditcategoryOne', 'BlogController@EditcategoryOne');//分类获取一条分类信息
        $this->post('blog/categoryEdit', 'BlogController@categoryEdit');//修改分类
        $this->get('blog/delcate', 'BlogController@delcate');//删除分类
        $this->get('blog/addArticle', 'BlogController@addArticle');//发布信息
        $this->post('blog/articlePush', 'BlogController@articlePush');//发布信息内容
        $this->post('blog/uploadimage', 'BlogController@uploadimage');//发布图片
        $this->get('blog/aritclelist', 'BlogController@aritclelist');//发布信息展示
        $this->get('blog/DelArticle', 'BlogController@DelArticle');//删除发布信息
        $this->get('blog/editArticle', 'BlogController@editArticle');//编辑发布信息
        $this->get('blog/getlistone', 'BlogController@getlistone');//获取一条发布信息
        $this->post('blog/articleEditPush', 'BlogController@articleEditPush');//修改信息
});
    $this->get('blog/categoryinfo', 'BlogController@categoryInfo');//分类显示接口api列表
    $this->get('blog/categorychildList', 'BlogController@categorychildList');//分类显示接口api列表

});
