<?php
namespace Admin\Controller;
use Think\Controller;

class AdminBaseController extends Controller {

    public function _initialize(){
        if(!session('user_id')){
        	session('refer',$_SERVER['REDIRECT_URL']);
            $this -> success('请登录', U('Admin/Login/index'),1);
            die;
        }
    }
}
