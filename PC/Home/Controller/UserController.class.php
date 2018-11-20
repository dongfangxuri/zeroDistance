<?php
namespace Home\Controller;
use Think\Controller;
class UserController extends Controller {
    public function index(){
     	/*底部信息*/
    	$aboutmodel=M('about')->find();
    	$this->assign('aboutmodel',$aboutmodel);
    	$this->display();
    }
}