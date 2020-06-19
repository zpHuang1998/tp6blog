<?php
namespace app\admin\controller;

use app\admin\BaseController;
use think\facade\Db;

class Admin extends BaseController
{
	//管理员的列表
    public function index()
    {
    	$adminRes = Db::table('admin')->select();
        return view('list', ['adminRes'=>$adminRes]);
    }


    public function add()
    {
    	if($this->request->isPost()){
    		$data = $this->_adminData();
    		$add = Db::table('admin')->insert($data);
    		if($add){
    			return json(['code'=>200, 'msg'=>'添加管理员成功']);
    		}else{
    			return json(['code'=>301, 'msg'=>'添加管理员失败']);
    		}
    	}
        return view();
    }

    public function edit()
    {
    	$id = input('id', 0, 'intval');
    	$adminInfo = Db::table('admin')->find($id);
        if($this->request->isPost()){
    		$data = $this->_adminData();
    		$data['id'] = $id;
    		$save = Db::table('admin')->where('id', $id)->update($data);
    		if($save !== false){
    			return json(['code'=>200, 'msg'=>'编辑管理员成功']);
    		}else{
    			return json(['code'=>301, 'msg'=>'编辑管理员失败']);
    		}
    	}

        return view('edit',['adminInfo'=>$adminInfo]);
    }

    public function check($username)
    {
        $checkInfo = Db::table('admin')->where("username='$username'")->find();
        if ($checkInfo)
        {
            return json(['code'=>301,'msg'=>'用户名已存在，请换一个']);
        }
        else
        {
            return json(['code'=>200,'msg'=>'用户名可用']);

        }
    }


    private function _adminData(){
    	$data = array();
    	$data['username'] = input('username', '', 'trim');
    	$data['password'] = input('password', '', 'md5');
    	return $data;
    }


    public function del($id)
    {
    	$del = Db::table('admin')->delete($id);
    	if($del){
    			return json(['code'=>200, 'msg'=>'删除管理员成功']);
    		}else{
    			return json(['code'=>301, 'msg'=>'删除管理员失败']);
    		}
    }

}