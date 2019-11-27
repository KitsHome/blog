<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MemberController extends Controller
{
    //
    public function index()
    {
//        echo 1111;die;
//        dd('后台首页，当前管理员：' . auth('admin')->user()->name);
        return view('admin.pages.member.list');
    }
}
