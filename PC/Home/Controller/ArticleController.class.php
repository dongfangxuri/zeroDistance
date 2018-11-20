<?php
namespace Home\Controller;
use Think\Controller;
class ArticleController extends Controller {
	
    public function index(){
    	/*底部信息*/
    	$aboutmodel=M('about')->find();
    	$this->assign('aboutmodel',$aboutmodel);
        $id=$_GET['id'];
    	$data['id']=$id;
    	$model=M('article')->where($data)->find();
    	$this->assign('model',$model);
    	//var_dump($model);exit();
    	$this->display();
    }
    
    public function article_list(){
    	$id=$_GET['id'];
    	$data['id']=$id;
    	$model=M('article')->where($data)->select();
    	$this->assign('model',$model);
    	$this->display();
    }
}
