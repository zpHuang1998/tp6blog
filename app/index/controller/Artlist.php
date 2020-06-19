<?php
namespace app\index\controller;

use app\index\BaseController;
use think\facade\Db;

class Artlist extends BaseController
{
    public function index()
    {
    	$cateId = input('cate_id', 0, 'intval');
    	$artRes = Db::table('articles')->alias('a')->join('categories c', "a.cate_id = c.id")->field('a.id, a.title, a.description, a.add_time, a.click, a.thumb,a.cate_id, c.cate_name')->where('cate_id', $cateId)->paginate(['list_rows'=>5,'query' => request()->param()]);
    	$cateInfo = Db::table('categories')->find($cateId);
    	$cateRes = $this->getCategories();
    	$hotArts = $this->getHotArts();
        return view('index', ['selectedCateId'=>$cateId, 'artRes'=>$artRes, 'cateInfo'=>$cateInfo, 'cateRes'=>$cateRes, 'hotArts'=>$hotArts]);
    }


}
