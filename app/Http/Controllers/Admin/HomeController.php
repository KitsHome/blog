<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    //
    public function index()
    {
//        dd('后台首页，当前管理员：' . auth('admin')->user()->name);
        return view('admin.index');
    }
}
