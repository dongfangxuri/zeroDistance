<?php
namespace Home\Controller;
use Think\Controller;
class ActiveController extends Controller {
	
    public function index(){
    	if(session('user_id')){
	    	$uid=session('user_id');
	    	$this->assign('user_id',session('user_id'));
	    	/*个人信息*/
	    	$model=M('user')->where('uid='.(int)session('user_id'))->find();
	    	$this->assign('model',$model);
	    	$this->assign('header_img',$model['header_img']);
	    	$data1['ac_id']=$_GET['ac_id'];
	    	$data1['uid']=$uid;
	    	$is=M('collection')->where($data1)->count();
	    	$this->assign('is',$is);
	    	/**/
    	}
    	/*底部信息*/
    	$aboutmodel=M('about')->find();
    	$this->assign('aboutmodel',$aboutmodel);
        $id=$_GET['ac_id'];
    	$data['ac_id']=$id;
    	$model=M('active')->where($data)->find();
    	if(strlen($model['ac_title'])>45)
    	{
    		$model['ac_title']=mb_substr($model['ac_title'],0, 45,'UTF-8')."......";
    	}
		/*互动自由编辑行*/
    	$contentlist=M('active_content')->where('ac_id='.$id)->select();
    	$this->assign('contentlist',$contentlist);
    	/*开通城市*/
    	$cityname="";
    	$citylist=M('active_city')->where('ac_id='.$id)->select();
    	foreach ($citylist as $key=>$val)
    	{
    		$tempname=M('area')->where('areaid='.$citylist[$key]['city_id']." and state=1")->field('name')->find();
    		$cityname.=$tempname['name'].",";
    	}
    	/*活动图片*/
    	$active_img = json_decode($model['ac_img'],true);
    	$model['ac_img'] = $active_img['bg_img'];
    	$cityname=mb_substr($cityname, 0,strlen($cityname)-1,'utf-8');
    	$model['cityname']=$cityname;
    	/*互动详情介绍*/
    	$content=htmlspecialchars_decode($model['ac_content']);
    	$this->assign('content',$content);
    	/*周末、工作日价格*/
    	$normalleastprice=M('meal')->where('ac_id='.$id)->field('price')->select();
    	sort($normalleastprice);
    	$weekleastprice=M('meal')->where('ac_id='.$id)->field('week_price')->select();
    	sort($weekleastprice);
    	$model['normalleastprice'] =$normalleastprice[0]['price'];
    	$model['weekleastprice'] = $weekleastprice[0]['week_price'];
    	/*活动天数*/
    	$time=(strtotime($model['end_time'])-strtotime($model['start_time']))/(3600*24);
    	$time=ceil($time);
    	$model['time']=$time;
    	/*活动月份*/
    	$starttime=date("m月d",strtotime($model['start_time']));
    	$endtime=date("m月d",strtotime($model['end_time']));
    	$model['during']=$starttime."-".$endtime."";
    	/*套餐*/
    	$meallist=M('meal')->where('ac_id='.$id)->select();
    	foreach ($meallist as $key=>$val)
    	{
    		$temp[$key]['price']=$meallist[$key]['price'];
    		$temp[$key]['id']=$meallist[$key]['id'];
    		$title=M('mealtype')->where('id='.$meallist[$key]['type_id'])->field('title')->find();
    		$temp[$key]['title']=$title['title'];    		
    	}
    	$this->assign('taocanlist',$temp);
    	
    	/*活动评价*/
    	$commentlist=M('comment')->where('ac_id='.$id)->limit(8)->select();
    	foreach ($commentlist as $key=>$val)
    	{
    		$usemodel=M('user')->where('uid='.$commentlist[$key]['uid'])->find(); 		
    		$commentlist[$key]['header_img']=$usemodel['header_img'];
    	}
    	$this->assign('commentlist',$commentlist);
    	/*出行人列表*/
    	$contact_list=M('contact')->where('uid='.session('user_id'))->select();
    	$this->assign('contact_list',$contact_list);
    	//查询与该活动类型相同的其他推荐活动
    	$filter4['category_id']=$model['category_id'];
    	$filter4['type']=3;
    	$recommendlist=M('active')->where($filter4)->limit(4)->select();
    	foreach ($recommendlist as $key=>$val)
    	{
    		$temp=json_decode($recommendlist[$key]['ac_img'],true);
    		$recommendlist[$key]['ac_img']=$temp['bg_img'];
    	}
    	foreach ($recommendlist as $key=>$val)
    	{
    		if(strlen($recommendlist[$key]['ac_title'])>25)
    		{
    			$recommendlist[$key]['ac_title']=mb_substr($recommendlist[$key]['ac_title'],0, 25,'UTF-8')."......";
    		}
    	}
    	$this->assign('recommendlist',$recommendlist);
    	$this->assign('model',$model);
    	$this->assign('ac_id',$id);
    	$this->assign('person',session('person'));
    	$this->assign('child',session('child'));
    	$this->assign('total_price',session('total_price'));
    	$this->display();
    }
    
    /*活动分类页*/
    public function active_catelist()
    {
 /*    	$data['uid'] = session('user_id');
    	if(!$data['uid']){
    		$this -> success('请登录',U('Index/login'),1);
    		die;
    	}
    	$uid=session('user_id');
    	$this->assign('user_id',session('user_id')); */
    	/*底部信息*/
    	$aboutmodel=M('about')->find();
    	$this->assign('aboutmodel',$aboutmodel);
    	/*查询该类型的活动*/
    	$id=$_GET['id'];
    	$title=M('active_category')->where('id='.$id)->field('category_name')->find();
    	$this->assign('title',$title['category_name']);
		$filter2['category_id']=$id;
		$count=M('active')->where($filter2)->count();
		$p=getpage($count,5);
		$qinzilist=M('active')->where($filter2)->limit($p->firstRow, $p->listRows)->select();
		$qinzilist=getAvtiveInfo($qinzilist);
		$this->assign('page',$p->show());
		$this->assign('qinzilist',$qinzilist);
		//查询与该活动类型相同的其他推荐活动
		$filter4['category_id']=$id;
		$filter4['type']=3;
		$recommendlist=M('active')->where($filter4)->limit(4)->select();
		foreach ($recommendlist as $key=>$val)
		{
			$temp=json_decode($recommendlist[$key]['ac_img'],true);
			$recommendlist[$key]['ac_img']=$temp['bg_img'];
		}
		foreach ($recommendlist as $key=>$val)
		{
			if(strlen($recommendlist[$key]['ac_title'])>25)
			{
				$recommendlist[$key]['ac_title']=mb_substr($recommendlist[$key]['ac_title'],0, 25,'UTF-8')."......";
			}
		}
		$this->assign('recommendlist',$recommendlist);
		$this->display();
    }
    
    /*发表留言*/
    public function leavemsg()
    {
    	if(!session('user_id'))
    	{
    		$this->success('请先登录',U('Index/login'),1);
    		die;
    	}
    	$data['uid']=(int)session('user_id');
    	$data['ac_id']=$_POST['ac_id'];
    	if(!$_POST['leavemsg'])
    	{
    		$this->error('请先输入用户留言');die;
    	}
    	$data['content']=$_POST['leavemsg'];
    	$data['addTime']=time();
    	$res=M('leavemsg')->add($data);
        if($res){
    		$this -> success('留言成功',U('Min/Index'),1);
    		die;
    	}else{
    		$this -> success('留言失败',U('Min/Index'),1);
    		die;
    	}
    	
    }
    
    /*检索活动*/
    public function search(){
    
    	if(I('keyword')){
    		$keyword = I('keyword');
    		$ac_list = M() -> query("select * from ze_active where ac_title like'%".$keyword."%' or ac_content like'%".$keyword."%' or ac_intro like'%".$keyword."%' order by addTime desc");
    		if(!$ac_list){
    			$this -> assign("empty","暂无搜索结果");
    		}
    		$ac_list=getAvtiveInfo($ac_list);
    		$this -> assign('list',$ac_list);
    	}
    	else if($_GET['date'])
    	{
    		$active_list=M('active')->select();
    		foreach ($active_list as $key=>$val)
    		{
    			$temptime=date('Y-m-d',strtotime($active_list[$key]['start_time']));
    			if($temptime==$_GET['date'])
    			{
    				$temparray[]=$active_list[$key];
    			}
    		}
    		$temparray=getAvtiveInfo($temparray);
    		$this -> assign('list',$temparray);
    	}
    	else {
    		$active_list=M('active')->select();
    		$ac_list=getAvtiveInfo($active_list);
    		//var_dump($ac_list);exit();
    		$this -> assign('list',$ac_list);
    	}
    	/*首页轮播图列表*/
    	$lun_list = M('lun')-> order('sort_id') -> limit(5) -> select();
    	foreach ($lun_list as $key=>$val)
    	{
    		$tmp=json_decode($lun_list[$key]['pic_path'],true);
    		$lun_list[$key]['pic_path']=$tmp['bg_img'];
    	}
    	$this->assign('lun',$lun_list);
    	$this->assign('title','活动搜索');
    	$this -> display('active_catelist');
    }
    
    /*亲子游学*/
	public function qinzi()
	{
		$filter['category_name']="亲子游学";
		$id=M('active_category')->where($filter)->field('id')->find();
		$this->assign('title',"亲子游学");
		/*查询该类型的活动*/
		$filter2['category_id']=$id['id'];
		$filter2['status']=0;
		$qinzilist=M('active')->where($filter2)->limit(6)->select();
		$qinzilist=getAvtiveInfo($qinzilist);
		$this->assign('qinzilist',$qinzilist);
		$this->display();
	}
	
	/*童子军*/
	public function tongjun()
	{
		$filter['category_name']="童子军";
		$id=M('active_category')->where($filter)->field('id')->find();
		$this->assign('title',"童子军");
		/*查询该类型的活动*/
		$filter2['category_id']=$id['id'];
		$filter2['status']=0;
		$qinzilist=M('active')->where($filter2)->limit(6)->select();
		$qinzilist=getAvtiveInfo($qinzilist);
		$this->assign('qinzilist',$qinzilist);
		$this->display();
	}
	
	/*冬夏令营*/
	public function camp()
	{
		$filter['category_name']="冬夏令营";
		$id=M('active_category')->where($filter)->field('id')->find();
		$this->assign('title',"冬夏令营");
		/*查询该类型的活动*/
		$filter2['category_id']=$id['id'];
		$filter2['status']=0;
		$qinzilist=M('active')->where($filter2)->limit(6)->select();
		$qinzilist=getAvtiveInfo($qinzilist);
		$this->assign('qinzilist',$qinzilist);
		$this->display();
	}
	
	/*亲子游学*/
	public function ticket()
	{
		$filter['category_name']="酒店门票";
		$id=M('active_category')->where($filter)->field('id')->find();
		$this->assign('title',"酒店门票");
		/*查询该类型的活动*/
		$filter2['category_id']=$id['id'];
		$filter2['status']=0;
		$qinzilist=M('active')->where($filter2)->limit(6)->select();
		$qinzilist=getAvtiveInfo($qinzilist);
		$this->assign('qinzilist',$qinzilist);
		$this->display();
	}

}
