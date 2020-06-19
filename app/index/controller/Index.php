<?php
namespace app\index\controller;

use app\index\BaseController;
use think\facade\Db;

class Index extends BaseController
{
    public function index()
    {
    	$artRes = Db::table('articles')->alias('a')->join('categories c', "a.cate_id = c.id")->field('a.id, a.title, a.description, a.add_time, a.click, a.thumb, a.cate_id, c.cate_name')->paginate(5, false ,['type'=> 'Mypaginate']);
    	$cateRes = $this->getCategories();
    	$hotArts = $this->getHotArts();
        return view('index', ['artRes'=>$artRes, 'cateRes'=>$cateRes, 'hotArts'=>$hotArts]);
    }

    
}
