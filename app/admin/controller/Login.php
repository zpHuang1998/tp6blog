<?php
namespace app\admin\controller;

use app\BaseController;
use app\admin\model\Admin;

class Login extends BaseController
{
    public function index()
    {
    
        return view('login');
    }

    public function login(){
    	$adminModel = new Admin();
    	$data = $adminModel->login();
    	return json($data);
    }

}