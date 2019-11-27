<?php


namespace App\Http\Controllers\Admin;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    /**
     * 文章列表
     */
    public function index(){
        return view('admin.pages.article.list');
    }

    /**
     * @title 发布信息
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\think\response\View
     */
    public function addArticle(){
        return view('admin.pages.article.addarticle');
    }

    /**
     * @title 添加发布信息
     * @param Request $request
     */
    public function articlePush(Request $request){
//        dd($request->all());
        $data=$request->all();
        unset($data['_token']);
        unset($data['file']);
        unset($data['level']);
        $ret=Article::addArticle($data);
        if($ret){
            echo json_encode(array('code'=>0,'msg'=>'ok'));
        }else{
            echo json_encode(array('code'=>-1,'msg'=>'error'));
        }

    }

    /**
     * @title 修改发布信息页面
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\think\response\View
     */
    public function editArticle(Request $request){

        return view('admin.pages.article.editarticle',array('id'=>$request->get('id')));
    }

    public function articleEditPush(Request $request){
        if($request->has('id')){
            $data=$request->all();
            unset($data['_token']);
            unset($data['file']);
            $ret=Article::articleEditPush($data);
            if($ret){
                echo json_encode(array('code'=>0,'msg'=>'ok'));
            }else{
                echo json_encode(array('code'=>-1,'msg'=>'error'));
            }
        }else{
            echo json_encode(array('code'=>-1,'msg'=>'参数不合法'));
        }
    }

    /**
     * @title 获取一条信息
     * @param Request $request
     */
    public function getlistone(Request $request){
        if($request->has('id')){
            $list=Article::getlistone($request->get('id'));
            if($list){
                echo json_encode(array('code'=>0,'msg'=>'ok','data'=>$list));
            }else{
                echo json_encode(array('code'=>-1,'msg'=>'error'));
            }
        }else{
            echo json_encode(array('code'=>-1,'msg'=>'参数不合法'));
        }
    }

    /**
     * @图片上传
     * @param Request $request
     */
    public function uploadimage(Request $request){
        if ($request->isMethod('POST')) {

            $fileCharater = $request->file('file');

            if ($fileCharater->isValid()) {

                //获取文件的扩展名
                $ext = $fileCharater->getClientOriginalExtension();

                //获取文件的绝对路径
                $path = $fileCharater->getRealPath();

                //定义文件名
                $filename = date('Y-m-d-h-i-s').'.'.$ext;

                //存储文件。disk里面的public。
                Storage::disk('public')->put($filename, file_get_contents($path));
            }
        }
        echo json_encode(array(
            'errno'=>0,
            'errno'=>0,
            'data'=>array(asset('storage/'.$filename))
        ));
    }
    /**
     * @title 发布信息列表
     */
    public function aritclelist(Request $request){
        $page=$request->has('page') ?$request->get('page'):1;
        $limit=$request->has('limit') ?$request->get('limit'):1;
        $search=$request->has('search') ?$request->get('search'):null;
        $limitnum=($page-1)*$limit;
        $count=Article::getArticleCount($search);
        $aritcle=Article::getArticle($search,$limitnum,$limit);
        echo json_encode(array('code'=>0,'msg'=>'ok','count'=>$count,'data'=>$aritcle));

    }
    /**
     * 删除发布信息
     */
    public function DelArticle(Request $request){
        if($request->has('id')){
            $ret=Article::DelArticle($request->get('id'));
            if($ret){
                echo json_encode(array('code'=>0,'msg'=>'ok'));
            }else{
                echo json_encode(array('code'=>-1,'msg'=>'error'));
            }
        }else{
            echo json_encode(array('code'=>-1,'msg'=>'参数不合法'));
        }
    }
    /**
     * 分类列表
     */
    public function categoryShow(){

        return view('admin.pages.article.category');
    }
    /**
     * 分类添加
     */
    public function categoryAddshow(){
//        $categoryInfo=Category::GetCategoryList();
//        $cateoptions='<option value="0" data-level="0">顶级分类</option>';
//        foreach ($categoryInfo as $key =>$val){
//
//            $cateoptions.='<option value="'.$val['cid'].'" data-level="'.$val['level'].'">'.$val['title'].'</option>';
//        }
        return view('admin.pages.article.category-add');
    }

    /**
     * @title 添加分类
     * @param Request $request
     * @return false|string
     */
    public function  categoryAdd(Request $request){
        $postdata=array(
            'pid'=>$request->get('pid'),
            'title'=>$request->get('title'),
            'sort'=>$request->get('order'),
            'status'=>$request->get('switch'),
            'updatetime'=>date('Y-m-d H:i:s')
        );
        $ret=Category::CategoryAdd($postdata);
        if($ret){
            echo json_encode(array('code'=>0,'msg'=>'添加成功'));
        }else{
            return json_encode(array('code'=>-1,'msg'=>'添加失败'));
        }
    }

    /**
     * @title 获取二维数组 分类详情无限极分类
     */
    public function categoryInfo(){
        $categoryInfo=Category::GetCategoryList();
        $cateoptions='<option value="0" data-level="0">顶级分类</option>';
        foreach ($categoryInfo as $key =>$val){
            $spance=($val['level']>0)?"├　":"".str_repeat("  ",$val['level']);
            $cateoptions.='<option value="'.$val['cid'].'" data-level="'.$val['level'].'">'.$spance.$val['title'].'</option>';
        }
        echo $cateoptions;
    }

    /**
     * @title 获取分类child
     */
    public function categorychildList(){
        $categoryList=Category::GetcategoryChildTree();
//        dd($categoryList);
        echo json_encode(array('code'=>0,'msg'=>'','data'=>$categoryList));
    }

    public function editstatus(Request $request){
        if($request->get('id') && strlen($request->get('status'))>0){
            $ret=Category::EditCategory(array('id'=>$request->get('id'),'status'=>$request->get('status')));
            if($ret){
                echo json_encode(array('code'=>0,'msg'=>'ok'));exit;
            }else{
                echo json_encode(array('code'=>-1,'msg'=>'fail'));exit;
            }
        }else{
            echo json_encode(array('code'=>-1,'msg'=>'参数不合法'));exit;
        }
    }

    /**
     * @title 修改分类展示
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\think\response\View
     */
    public function Editcategoryshow(Request $request){
//        if($request->has('cid')){
//            $categoryInfo=Category::getcategoryone($request->get('cid'));
//        }
        return view('admin.pages.article.categoryedit-show',array('cid'=>$request->get('cid')));
    }

    /**
     * @title 获取一条分类信息
     * @param Request $request
     * @return false|string
     */
    public function EditcategoryOne(Request $request){
        if($request->has('cid')){
            $categoryInfo=Category::getcategoryone($request->get('cid'));
        }
        return json_encode(array('code'=>0,'data'=>$categoryInfo));
    }

    /**
     * @title 修改分类
     * @param Request $request
     */
    public function categoryEdit(Request $request){
        if($request->has('id')){
            $data=$request->all();
            unset($data['_token']);
            $ret=Category::EditCategory($data);
            if($ret){
                echo json_encode(array('code'=>0,'msg'=>'ok'));
            }else{
                echo json_encode(array('code'=>-1,'msg'=>'error'));
            }
        }else{
            echo json_encode(array('code'=>-1,'msg'=>'参数不合法'));
        }
    }
    public function delcate(Request $request){
        if($request->has('cid')){
            $ret=Category::DelCategory($request->get('cid'));
            if($ret){
                echo json_encode(array('code'=>0,'msg'=>'ok'));
            }else{
                echo json_encode(array('code'=>-1,'msg'=>'error'));
            }
        }else{
            echo json_encode(array('code'=>-1,'msg'=>'参数不合法'));
        }
    }
}
