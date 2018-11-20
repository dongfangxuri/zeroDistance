<?php
namespace Home\Controller;
use Think\Controller;
class ArticleController extends Controller {

    public function index(){
       $id=$_GET['id'];
    	$data['id']=$id;
    	$model=M('article')->where()->select();
    	$$this->display();
    }
}
