<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Article extends Model
{
    /**
     * @title 获取list长度
     * @param $where
     * @return int
     */
    public static function getArticleCount($where){
        if($where){
            return DB::table('article')->where(function ($query) use($where){
                $query->where('title','like','%'.$where.'%')->orwhere('author','like','%'.$where.'%')->orwhere('context','like','%'.$where.'%')->orwhere('updatetime','like','%'.$where.'%');
            })->orderBy('updatetime','desc')->count();
        }else{
            return DB::table('article')->orderBy('updatetime','desc')->count();
        }

    }

    /**
     * @title  获取文章list
     * @param $where
     * @return mixed
     */
    public static function getArticle($where,$limitnum,$limit){
        if($where){
            $aritcle= DB::table('article')->leftJoin('category', 'article.cid', '=', 'category.cid')->where(function ($query) use($where){
                $query->where('article.title','like','%'.$where.'%')->orwhere('article.author','like','%'.$where.'%')->orwhere('article.context','like','%'.$where.'%')->orwhere('article.updatetime','like','%'.$where.'%');
            });
        }else{
            $aritcle= DB::table('article')->leftJoin('category', 'article.cid', '=', 'category.cid');
        }
//        DB::connection()->enableQueryLog();
         return $aritcle->orderBy('article.updatetime','desc')->offset($limitnum)->limit($limit)->select('article.*','category.title as ctitle')->get()->map(function ($item){
            return array(
                'id'=>$item->id,
                'title'=>$item->title,
                'author'=>$item->author,
                'context'=>$item->context,
                'cid'=>$item->cid,
                'ctitle'=>$item->ctitle,
                'sort'=>$item->sort,
                'status'=>$item->is_enable,
                'starttime'=>$item->starttime,
                'endtime'=>$item->endtime,
                'updatetime'=>$item->updatetime
            );
        })->toArray();
//        dd(DB::getQueryLog());
    }
    public static function articleEditPush($data){
        $id=$data['id'];unset($data['id']);
//        DB::connection()->enableQueryLog();
        return DB::table('article')->where(['id'=>$id])->update($data);
//        dd(DB::getQueryLog());
    }
    /**
     * @title 删除
     * @param $id
     * @return int
     */
    public static function DelArticle($id){
        return DB::table('article')->where('id','=',$id)->delete();
    }

    /**
     * @title 添加
     * @param $data
     * @return bool
     */
    public static function addArticle($data){
        return DB::table('article')->insert($data);
    }
    /**
     *根据id获取一条信息
     */
    public static function getlistone($id){
        return DB::table('article')->where(array('id'=>$id))->first();
    }
    public static function getlistbycid($cid){
        if($cid){
            return DB::table('article')->where(array('cid'=>$cid,'is_enable'=>1))->where('endtime','>',date('Y-m-d H:i:s'))->get()->toArray();
        }else{
            return DB::table('article')->where(array('is_enable'=>1))->where('endtime','>',date('Y-m-d H:i:s'))->get()->toArray();
        }
    }

}
