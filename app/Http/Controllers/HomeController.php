<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('index');
    }

    /**
     * 获取分类
     */
    public function getcategory(){
        $categoryInfo=Category::GetCategoryList();
        echo json_encode(array('code'=>0,'msg'=>'ok','data'=>$categoryInfo));
    }

    public function getlist(Request $request){
        if($request->has('cid')){
            $list=Article::getlistbycid($request->get('cid'));
            echo json_encode(array('code'=>0,'msg'=>'ok','data'=>$list));
        }else{
            echo json_encode(array('code'=>-1,'msg'=>'参数无效','data'=>''));
        }
    }
}
