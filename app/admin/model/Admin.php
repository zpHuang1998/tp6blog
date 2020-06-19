<?php
namespace app\admin\model;

use think\Model;
use think\facade\Db;

class Admin extends Model
{
	public function login(){
        $username = input('username', '', 'trim');
        $password = input('password', '', 'trim');
        $adminInfo = Db::table('admin')->where('username', $username)->find();
        if($adminInfo){
            if(md5($password) != $adminInfo['password']){
                return ['code'=>301, 'msg'=>'密码错误'];
            }else{
                session('uid', $adminInfo['id']);
                session('username', $adminInfo['username']);
                return ['code'=>200, 'msg'=>'登录成功！'];
            }
        }else{
            return ['code'=>301, 'msg'=>'用户不存在！'];
        }
    }

}