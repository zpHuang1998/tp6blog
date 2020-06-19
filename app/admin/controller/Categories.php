<?php
namespace app\admin\controller;

use app\admin\BaseController;
use think\facade\Db;

class Categories extends BaseController
{
	//分类的列表
    public function index()
    {
    	$cateRes = Db::table('categories')->select();
        return view('list', ['cateRes'=>$cateRes]);
    }


    public function add()
    {
    	if($this->request->isPost()){
    		$data = $this->_categoriesData();
    		$add = Db::table('categories')->insert($data);
    		if($add){
    			return json(['code'=>200, 'msg'=>'添加分类成功']);
    		}else{
    			return json(['code'=>301, 'msg'=>'添加分类失败']);
    		}
    	}
        return view();
    }

    public function edit()
    {
    	$id = input('id', 0, 'intval');
    	$cateInfo = Db::table('categories')->find($id);
        if($this->request->isPost()){
    		$data = $this->_categoriesData();
    		$data['id'] = $id;
    		$save = Db::table('categories')->where('id', $id)->update($data);
    		if($save !== false){
    			return json(['code'=>200, 'msg'=>'编辑分类成功']);
    		}else{
    			return json(['code'=>301, 'msg'=>'编辑分类失败']);
    		}
    	}

        return view('edit',['cateInfo'=>$cateInfo]);
    }

    private function _categoriesData(){
    	$data = array();
    	$data['cate_name'] = input('cate_name', '', 'trim');
    	$data['keywords'] = input('keywords', '', 'trim');
    	$data['description'] = input('description', '', 'trim');
    	$data['sort'] = input('sort', 10, 'intval');
    	return $data;
    }


    public function del($id)
    {
    	$del = Db::table('categories')->delete($id);
    	if($del){
    			return json(['code'=>200, 'msg'=>'删除分类成功']);
    		}else{
    			return json(['code'=>301, 'msg'=>'删除分类失败']);
    		}
    }

}