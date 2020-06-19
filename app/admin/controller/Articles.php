<?php
namespace app\admin\controller;

use app\admin\BaseController;
use think\facade\Db;

class Articles extends BaseController
{
	//文章的列表
    public function index()
    {
    	$artRes = Db::table('articles')->alias('a')->join('categories c', "a.cate_id = c.id")->field('a.id, a.title, c.cate_name')->paginate(5);
        return view('list', ['artRes'=>$artRes]);
    }


    public function add()
    {
    	if($this->request->isPost()){
    		$data = $this->_articlesData();
            $data['add_time'] = time();
            $data['thumb'] = $this->upload();
    		$add = Db::table('articles')->insert($data);
    		if($add){
    			return json(['code'=>200, 'msg'=>'添加文章成功']);
    		}else{
    			return json(['code'=>301, 'msg'=>'添加文章失败']);
    		}
    	}

        $cateRes = Db::table('categories')->select();
        return view('add', ['cateRes'=>$cateRes]);
    }

    public function edit()
    {
    	$id = input('id', 0, 'intval');
    	$artInfo = Db::table('articles')->find($id);
        if($this->request->isPost()){
    		$data = $this->_articlesData();
    		$data['id'] = $id;            
            if($_FILES['thumb']['tmp_name']){
                $data['thumb'] = $this->upload();
            }
    		$save = Db::table('articles')->where('id', $id)->update($data);
    		if($save !== false){
    			return json(['code'=>200, 'msg'=>'编辑文章成功']);
    		}else{
    			return json(['code'=>301, 'msg'=>'编辑文章失败']);
    		}
    	}

        $cateRes = Db::table('categories')->select();
        return view('edit', ['cateRes'=>$cateRes,'artInfo'=>$artInfo]);
    }

    private function _articlesData(){
    	$data = array();
    	$data['cate_id'] = input('cate_id', 0, 'intval');
        $data['title'] = input('title', '', 'trim');
    	$data['keywords'] = input('keywords', '', 'trim');
    	$data['description'] = input('description', '', 'trim');
        $data['content'] = input('content');
    	return $data;
    }


    public function del($id)
    {
    	$del = Db::table('articles')->delete($id);
    	if($del){
    			return json(['code'=>200, 'msg'=>'删除文章成功']);
    		}else{
    			return json(['code'=>301, 'msg'=>'删除文章失败']);
    		}
    }

    //图片上传
    public function upload(){
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('thumb');
        // 上传到本地服务器
        $savename = \think\facade\Filesystem::disk('public')->putFile( 'uploads', $file);
        return $savename;
    }

}