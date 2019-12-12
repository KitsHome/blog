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
    /**
     * vtp 获取token
     */
    public function token(){
        //
        $callback='http://www.theaged.club/callback';
        $url="https://open-oauth.jd.com/oauth2/to_login?app_key=A2808BE115B62436B78E22E1C6BC8B29&response_type=code&redirect_uri=".$callback."&state=20180416&scope=snsapi_base";
        return redirect($url);
    }

    /**
     * vtp 获取callback token$re
     */
    public function callback(Request $request){
        if($request->has('code')){
            $url="https://open-oauth.jd.com/oauth2/access_token?app_key=A2808BE115B62436B78E22E1C6BC8B29&app_secret=f92c98c61a7e4312ab453c107f3a52d1&grant_type=authorization_code&code=".$request->get('code');
            return redirect($url);
        }else{
            dd($request->all());
        }
    }
}
