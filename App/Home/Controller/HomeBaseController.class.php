<?php
namespace Home\Controller;
use Think\Controller;

class HomeBaseController extends Controller {

    public function _initialize(){
        if(!session('user_id')){
        	session('refer',$_SERVER['REDIRECT_URL']);
            $this -> success('请登录', U('Home/Index/login'),1);
            die;
        }
    }
}
