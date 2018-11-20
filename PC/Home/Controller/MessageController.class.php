<?php
namespace Home\Controller;
use Think\Controller;
class MessageController extends Controller {
    public function index(){
    	$data['uid'] = session('user_id');
    	if(!$data['uid']){
    		$this -> error('请登录',U('Index/login'),1);
    		die;
    	}
    	if(session("header_img")){
    		$this -> assign("header_img",session("header_img"));
    	}
    	/*消息*/
    	$messagecount=M('msg')->where("u_id=".$data['uid']." and is_read=0")->count();
    	$this->assign('messagecount',$messagecount);
        /*底部信息*/
        $aboutmodel=M('about')->find();
        $this->assign('aboutmodel',$aboutmodel);
        $uid=session('user_id');
        $this->assign('user_id',$uid);
        $systemCount=M('msg')->where("u_id=".$uid." and ms_type=1 and is_read=0")->count();
        $activeCount=M('msg')->where("u_id=".$uid." and ms_type=2 and is_read=0")->count();
		$p1=getpage($systemCount,5);
		$p2=getpage($activeCount,5);
		$this -> assign('page1',$p1->show());
		$this -> assign('page2',$p2->show());
        $syslist=M('msg')->where("u_id=".$uid." and ms_type=1")->limit($p1->firstRow, $p1->listRows)->select();
        $actlist=M('msg')->where("u_id=".$uid." and ms_type=2")->limit($p2->firstRow, $p2->listRows)->select();
        $this -> assign('syslist',$syslist);
        $this -> assign('actlist',$actlist);
        $this -> assign('systemCount',$systemCount);
        $this -> assign('activeCount',$activeCount);
        layout(false);
        $this -> display();
    }
    
       /*消息详情页*/
    public function message_detail(){
	    if(session('header_img')){
            $this -> assign('header_img',session('header_img'));
        }
        if(session("user_id"))
        {
        	$this -> assign('user_id',session('user_id'));
        }
        /*底部信息*/
        $aboutmodel=M('about')->find();
        $this->assign('aboutmodel',$aboutmodel);
		/*消息*/
    	$messagecount=M('msg')->where("u_id=".$data['uid']." and is_read=0")->count();
    	$this->assign('messagecount',$messagecount);
        $data['id'] = I('id');
        $sys_info = M('msg') -> where($data)-> find();
		$sys_info['addTime']=date('Y-m-d h:m:s',$sys_info['addTime']);
        $data1['is_read']=1;
        M('msg')->where($data)->save($data1);
        $this -> assign('model',$sys_info);
		layout(false);
        $this -> display();
    }
    
    /*获得小图*/
    public function get_small($ac_list){
    
    	foreach($ac_list as $key=>$val){
    		$active_img = json_decode($ac_list[$key]['ac_img'],true);
    		$ac_list[$key]['ac_img'] = $active_img['sm_img'];
    		$ac_list[$key]['ac_content'] = stripslashes($ac_list[$key]['ac_content']);
    	}
    	return $ac_list;
    }
    
    /*获得大图*/
    public function get_big($ac_list){
    
    	foreach($ac_list as $key=>$val){
    		$active_img = json_decode($ac_list[$key]['ac_img'],true);
    		$ac_list[$key]['ac_img'] = $active_img['bg_img'];
    	}
    	return $ac_list;
    }
    

}