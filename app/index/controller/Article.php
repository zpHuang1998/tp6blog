<?php
namespace app\index\controller;

use app\index\BaseController;
use think\facade\Db;

class Article extends BaseController
{
    public function index()
    {
    	$artId = input('art_id', 0, 'intval');
    	//阅读数
    	Db::table('articles')->where('id', $artId)->inc('click')->update();
    	$artInfo = Db::table('articles')->find($artId);
    	//当前分类
    	$curCate = Db::table('categories')->find($artInfo['cate_id']);
        $cateRes = $this->getCategories();
    	$hotArts = $this->getHotArts();
        return view('article', ['curCate'=>$curCate, 'selectedCateId'=>$artInfo['cate_id'], 'artInfo'=>$artInfo, 'cateRes'=>$cateRes, 'hotArts'=>$hotArts]);
    }

}
