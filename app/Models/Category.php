<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Category extends Model
{
    /**
     * 获取分类列表
     */
    public static function GetCategoryList(){
        $categoryInfo=DB::table('category')->where('status','=','1')->get()->map(function($item){
            return array(
                'cid'=>$item->cid,
                'title'=>$item->title,
                'sort'=>$item->sort,
                'status'=>$item->status,
                'pid'=>$item->pid,
                'updatetime'=>$item->updatetime
            );
        })->toArray();
        return Category::getTree($categoryInfo);
    }

    /**
     * @title 获取child 二级分类
     * @return array
     */
    public static function GetcategoryChildTree(){
        $categoryInfo=DB::table('category')->get()->map(function($item){
            return array(
                'cid'=>$item->cid,
                'title'=>$item->title,
                'sort'=>$item->sort,
                'status'=>$item->status,
                'pid'=>$item->pid,
                'updatetime'=>$item->updatetime
            );
        })->toArray();
        return Category::generateTree($categoryInfo);
    }
    /**
     * @title 添加分类
     * @param $data
     * @return bool
     */
    public static function CategoryAdd($data){
       return DB::table('category')->insert($data);
    }

    /**
     * @title 获取二维数组的无限极分类
     * @param $arr
     * @param int $pid
     * @param int $level
     * @return array
     */
    public static function getTree($arr,$pid=0,$level=0){
        static $list = [];
        foreach ($arr as $key => $value) {
            if ($value["pid"] == $pid) {
                $value["level"] = $level;
                $list[] = $value;
                unset($arr[$key]); //删除已经排好的数据为了减少遍历的次数，当然递归本身就很费神就是了
                Category::getTree($arr,$value["cid"],$level+1);
            }
        }
        return $list;
    }

    /**
     * @title 获取child tree 无限极分类
     * @param $data
     * @return array
     */
    public static function generateTree($data)
    {
        $items = array();
        foreach ($data as $v) {
            $array=array(
                'id'=>$v['cid'],
                'name'=>$v['title'],
                'pid'=>$v['pid'],
                'status'=>$v['status']
            );
            $items[$v['cid']] = $array;
        }
        $tree = array();
        foreach ($items as $k => $item) {
            if (isset($items[$item['pid']])) {
                $items[$item['pid']]['children'][] = &$items[$k];
            } else {
                $tree[] = &$items[$k];
            }
        }
        return $tree;
    }

    /**
     * @title 修改 sttaus
     * @param $data
     * @return int
     */
    public static function EditCategory($data){
        $id=$data['id'];unset($data['id']);
        return DB::table('category')->where(['cid'=>$id])->update($data);
    }

    /**
     * @title 获取一条信息
     * @param $id
     * @return Model|\Illuminate\Database\Query\Builder|object|null
     */
    public static function getcategoryone($id){
        //DB::connection()->enableQueryLog();
        return DB::table('category')->where(['cid'=>$id])->first();
        //dd(DB::getQueryLog());

    }

    public static function DelCategory($id){
        return DB::table('category')->where(array('cid'=>$id))->delete();
    }
}
