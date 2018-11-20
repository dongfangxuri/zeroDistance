<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {

    function _initialize(){
    	
    }

    /*首页*/
    public function index(){
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
        /*城市列表*/
        $citylist=M('area')->where('parentid!=0 and state=1')->select();
        /*首页轮播图列表*/
        $lun_list = M('lun')-> order('sort_id') -> limit(5) -> select();
        foreach ($lun_list as $key=>$val)
        {
        	 $tmp=json_decode($lun_list[$key]['pic_path'],true);
        	 $lun_list[$key]['pic_path']=$tmp['bg_img'];
        }
        /*首页菜单列表*/
        $menu1=M('menu')->limit(0,4)->order('sort_id')->select();
        foreach ($menu1 as $key=>$val)
        {
        	$tmp=json_decode($menu1[$key]['image_url'],true);
        	$menu1[$key]['image_url']=$tmp['bg_img'];
        }
        $menu2=M('menu')->limit(4,4)->order('sort_id')->select();
        foreach ($menu2 as $key=>$val)
        {
        	$tmp=json_decode($menu2[$key]['image_url'],true);
        	$menu2[$key]['image_url']=$tmp['bg_img'];
        }
        /*最新公告*/
        $articlelist=M('article')->limit(4)->order('addTime desc')->select();
        /*根据城市异步加载*/
        if($_GET['cityid'])
        {
        	$cityid=(int)$_GET['cityid'];
        	$aclist=M('active_city')->where('city_id='.$cityid)->select();
        	/*景点门票活动*/
        	foreach ($aclist as $key=>$val)
        	{
        		$id=(int)$aclist[$key]['ac_id'];
        		$ticketlist[]=M('active')->where('category_id=1 and status=0 and ac_id='.$id)->select();
        	}
        	$ticketlist=array_slice($ticketlist,0,6);
        	$ticketlist=getAvtiveInfo2($ticketlist);   
        	/*童子军活动*/
        	foreach ($aclist as $key=>$val)
        	{
        		$id=(int)$aclist[$key]['ac_id'];
        		$tongjunlist[]=M('active')->where('category_id=2  and status=0 and ac_id='.$id)->select();
        	}
        	$tongjunlist=array_slice($tongjunlist,0,6);
        	$tongjunlist=getAvtiveInfo2($tongjunlist);
        	/*冬夏令营活动*/
        	foreach ($aclist as $key=>$val)
        	{
        		$id=(int)$aclist[$key]['ac_id'];
        		$camplist[]=M('active')->where('category_id=3  and status=0 and ac_id='.$id)->select();
        	}
        	$camplist=array_slice($camplist,0,6);
        	$camplist=getAvtiveInfo2($camplist);
        	
        	/*亲子游学活动*/
        	foreach ($aclist as $key=>$val)
        	{
        		$id=(int)$aclist[$key]['ac_id'];
        		$qinzilist[]=M('active')->where('category_id=4  and status=0 and ac_id='.$id)->select();
        	}      	
        	$qinzilist=array_slice($qinzilist,0,6);
        	$qinzilist=getAvtiveInfo2 ( $qinzilist );
        	/*亲子酒店活动*/
        	foreach ($aclist as $key=>$val)
        	{
        		$id=(int)$aclist[$key]['ac_id'];
        		$jiudianlist[]=M('active')->where('category_id=5  and status=0 and ac_id='.$id)->select();
        	}
        	$jiudianlist=array_slice($jiudianlist,0,6);
        	$jiudianlist=getAvtiveInfo2($jiudianlist);
        	
        	/*当前城市*/
        	$citymodel=M('area')->where('areaid='.$cityid)->limit(1)->select();
        	$this->assign('cityname',$citymodel[0]['name']);
        }
        else{   
	        /*景点门票活动*/
	        $ticketlist=M('active')->where('category_id=1 and status=0')->limit(6)->select();
	        $ticketlist=getAvtiveInfo2($ticketlist);
	        /*童子军*/
	        $tongjunlist=M('active')->where('category_id=2 and status=0')->limit(6)->select();
	        $tongjunlist=getAvtiveInfo2($tongjunlist);
	        /*冬夏令营*/
	        $camplist=M('active')->where('category_id=3 and status=0')->limit(6)->select();
	        $camplist=getAvtiveInfo2($camplist);
	        /*亲子游学活动*/
	        $qinzilist=M('active')->where('category_id=4 and status=0')->limit(6)->select();
	        $qinzilist=getAvtiveInfo2 ( $qinzilist );
	        /*亲子酒店*/
	        $jiudianlist=M('active')->where('category_id=5 and status=0')->limit(6)->select();
	        $jiudianlist=getAvtiveInfo2($jiudianlist);
	        $this->assign('cityname','南通');
        }  
        $this -> assign('lun',$lun_list);
        $this->assign('menu1',$menu1);
        $this->assign('menu2',$menu2);
        $this->assign('citylist',$citylist);
        $this->assign('qinzilist',$qinzilist);
        $this->assign('jiudianlist',$jiudianlist);
        $this->assign('camplist',$camplist);
        $this->assign('ticketlist',$ticketlist);      
        $this->assign('tongjunlist',$tongjunlist);
        $this->assign('articlelist',$articlelist);
        $this -> display();
    }
    
    /*活动详情*/
    public function detail(){
        $data['ac_id'] = I('ac_id');
        if(!I('ac_id')){
            $data['ac_id'] = cookie('ac_id');
        }
        //判断是否添加过收藏
        if(session('user_id'))
        {
        	$filter['uid']=(int)session('user_id');
        	$filter['ac_id'] = I('ac_id');
        	$re = M('collection') -> where($filter) -> find();
        	if($re){
        		$this -> assign('is',1);
        	}else{
        		$this -> assign('is',0);
        	}
        }
        else {
        	$this -> assign('is',0);
        }
        cookie('ac_id',I('ac_id'));
		$map2['ac_id'] = I('ac_id');
		$map2['status'] = 1;
		//增加已付款条件限制
		$en_list = M("order") -> where($map2) -> select();
		$en_num = M("order") -> where($map2) -> count();
		$img_list = array();
		foreach($en_list as $key=>$val){
			$map3['uid'] = $val['uid'];
			$img_list[]['img'] = M('user') -> where($map3) -> getField("header_img");
		}
        $lun = M('activelun') -> where($data) -> field('pic_path') -> limit(3) -> select();
        $com_num = M('comment') -> where($data) -> count();
        $com_list = M('comment') -> where($data) -> select();
        foreach($com_list as $key=>$val){
            $user_info = M('user') -> where('uid='.$val['uid']) -> find();
            $com_list[$key]['nick_name'] = $user_info['nick_name'];
            $com_list[$key]['header_img'] = $user_info['header_img'];
        }

        $active = M('active') -> where($data) -> find();
        $active_img = json_decode($active['ac_img'],true);
        $active['ac_img'] = $active_img['bg_img'];
        $time = strtotime($active['addTime']);
        $active['addTime'] = date('m月d日',$time);
        $active['ac_content'] =html_entity_decode($active['ac_content']);
        $fine = M('active') -> where('type=3') -> field('ac_id,ac_title,single_price') -> limit(3) -> select();
        foreach($fine as $key=>$val){
            $active_img = json_decode($val['ac_img'],true);
            $fine[$key]['ac_img'] = $active_img['bg_img'];
        }
        $ac_list = M('active') -> order('addTime asc') -> field('ac_id,ac_title,ac_intro,partake_num,ac_img,single_price') -> limit(4) -> select();
        $ac_list = $this -> get_small($ac_list);
		$this -> assign('en_num',$en_num);
		$this -> assign('img_list',$img_list);
        $this -> assign('list',$ac_list);
        $this -> assign('lun',$lun);
        $this -> assign('com_num',$com_num);
        $this -> assign('com_list',$com_list);
        $this -> assign('fine',$fine);
        $this -> assign('active',$active);
        //layout(false);
        $this -> display();
        echo '<br/>';echo '<br/>';echo '<br/>';
    }

    /*找回密码*/
    public function forgetPwd(){

    	if($_SERVER['REQUEST_METHOD']=="GET")
    	{
    		$this -> display();
    	}
    	else 
    	{
    		$code=$_POST['passcode'];
    		if($code!=session('code'))
    		{
    			echo "<script type='text/javascript'>alert('验证码错误');</script>";die;
    		}
            $data['phone'] = I('phone');
            $info = M('user') -> where($data) -> find();
            if($info)
            {
            	echo "<script type='text/javascript'>alert('该用户不存在');</script>";die;
            }
            else 
            {
            	$password1=$_POST['password1'];
            	$password2=$_POST['password2'];
            	if($password2!=$password1)
            	{
            		echo "<script type='text/javascript'>alert('两次输入的密码不一致！');</script>";die;
            	}
            	$pwd = md5(I('password1'));
            	if($info['pwd'] == $pwd)
            	{
            		echo "<script type='text/javascript'>alert('新设置的密码与原密码一致！');</script>";die;
            	}
            	else{
            		$data1['pwd'] = $pwd;
            		$res = $info -> save($data1);
            		if($res>0)
            		{
            			echo "<script type='text/javascript'>alert('密码设置成功！');</script>";die;
            		}
            		else {
            			echo "<script type='text/javascript'>alert('密码设置失败！');</script>";die;
            		}
            	}
            }
           
        }
    }

	/*登录*/
    public function login(){
        if(session('user_id')){
            $this->redirect('Min/index');
        }
        if(I("username")){
            $data['phone'] = I('username');
            $data['statue'] = 1;
            $res = M('user') -> where($data) -> find();
            if($res){
                $pwd = md5(I('password'));
                if($pwd == $res['pwd']){
					session('user_id', $res['uid']);
                    session('star', $res['star']);
                    session('nick_name', $res['nick_name']);
                    session('header_img',$res['header_img']);
                    session('user_addr',$res['address']);
                    session('sex_v',$res['sex']);
                    if($res['sex'] == 1){
                        $res['sex'] = '男';
                    }elseif($res['sex'] == 2){
                        $res['sex'] = '女';
                    }else{
                        $res['sex'] = '保密';
                    }
                    session('sex',$res['sex']);
                    //$this -> redirect($_SESSION['refer']);
                    $this -> redirect('Min/Index');
					die();
                }else{
                    $this -> success('登录失败',U('Index/login'),1);
                    session('user_id',null);
                    session('nick_name',null);
                    session('header_img',null);
                    die();
                }
            }else{
                $this -> success('用户不存在或已被禁用',U('Index/login'),1);
                die();
            }
        }
        $isweixin=0;
        if(strpos($_SERVER['HTTP_USER_AGENT'],'MicroMessenger') == true)
        {
           $isweixin=1;
        }
        $this->assign('isweixin',$isweixin);
        /*底部信息*/
        $aboutmodel=M('about')->find();
        $this->assign('aboutmodel',$aboutmodel);
        $this -> display();
    }

    /*注册*/
    public function register(){

    	if($_SERVER['REQUEST_METHOD']=="GET")
    	{
    		/*底部信息*/
    		$aboutmodel=M('about')->find();
    		$this->assign('aboutmodel',$aboutmodel);
    		$this -> display();
    	}
    	else
    	{
        	$code=$_POST['passcode'];
        	if($code!=session('code'))
        	{
                $this->error('验证码错误');
                session('user_id',null);die;
        	}
        	$password1=$_POST['password1'];
        	$password2=$_POST['password2'];
        	if($password1!=$password2)
        	{
        		$this->error('两次输入的密码不一致');die;
        	}
            $data['phone'] = I('phone');
            $res = M('user') -> where($data) -> find();
            if(!$res)
            {
				$this->error('该用户已存在');
				session('user_id',null);
				die;
            }
            else
            {
                $data['pwd'] = md5(I('password1'));
                $res = M('user') -> add($data);
                if($res){
					session('user_id', $res);
					$this->success('注册成功',U('Min/set'),1);
					session('user_id',null);
					die;
                }else{
					$this->error('注册失败');
					session('user_id',null);
					die;
                }
            }
        }
       
    }

    /*增加收藏*/
    public function collection_add(){

        $data['uid'] = session('user_id');
        $data['ac_id'] = I('ac_id');
        $re = M('collection') -> where($data) -> find();

        if(!$re){
            $res = M('collection') -> add($data);
            if($res){
                $data['statue'] = 1;
                $this->ajaxReturn($data);
            }else{
                $data['statue'] = 0;
                $this->ajaxReturn($data);
            }
        }else{
            $data['statue'] = 2;
            $this->ajaxReturn($data);
        }
    }

    /*增加收藏*/
    public function meal_detail(){
        if(!session('user_id')){
            $this -> success('请登录',U('Index/login'),1);
            die;
        }
        if(I('ac_id')){
            $ac_id = I('ac_id');
            cookie('content_ac_id',$ac_id);
            $data['ac_id'] = $ac_id;
            $data['uid'] = session('user_id');
            $re = M('order') -> where($data) -> find();
            if(!$re){
                $res = M('order') -> add($data);
				session('order_id',$res);
            }else{
			    session('order_id',$re['oid']);
			}
            $list = M() -> query("select ze_meal.id,ze_meal.me_title,ze_meal.days,ze_active.addr,ze_meal.content,ze_meal.start_time from ze_meal left join ze_active on ze_meal.ac_id=ze_active.ac_id where ze_meal.ac_id=".$ac_id);
            //$meal_list = M('meal') -> where($data) -> join("left join ze_active on ze_meal.ac_id=ze_active.ac_id") -> select();
            foreach($list as $key=>$val){
                $num = (int)$val['days'];
                $list[$key]["ye"] = $num -1;
                $date = $val['start_time'];
                $list[$key]["end_time"] = date('Y/m/d',strtotime("$date +$num day"));
            }
            $meal_list = M('meal') -> select();
            session('meal_ac_id',$ac_id);
            $this -> assign('list',$list);
        }
        $this -> display();
    }

    /*获取积分*/
    public function integral(){
    	if(!session('user_id')){
    		$this -> success('请登录',U('Index/login'),1);
    		die;
    	}
    	$model=M('user')->where('uid='.session('user_id'))->find();
    	$this->assign('model',$model);
        $this -> display();
    }

    public function choseNumber(){
        if(!session('user_id')){
            $this -> success('请登录',U('Index/login'),1);
            die;
        }
		$filter1['oid']=(int)session('order_id');
		/* 更新旅游时间*/
		$travel_time=isset($_GET['time'])?$_GET['time']."":"00-00-00";
		$array=explode('-',$travel_time);
		$time=implode(':',$array);
		$data['travel_start_time']=$time;
		$ordermodel=M('order')->where($filter1)->save($data);
		$model=M('order')->where($filter1)->limit(1)->select();
		/*查询该活动详悉信息*/
		//$filter2=session('ac_id');
		$filter2['ac_id']=$model[0]['ac_id'];
		$activemodel=M('active')->where($filter2)->limit(1)->select();
		$start_time = date("Y/m/d",strtotime($activemodel[0]['start_time']));
        $end_time = date("m/d",$activemodel[0]['end_time']);
		$this->assign('start_time',$start_time);   
		$this->assign('end_time',$end_time);
		$this->assign('model',$activemodel[0]);
		/*查询该活动对应的套餐情况*/
		$mealmodel=M('mealtype')->select();
		$this->assign('mealmodel',$mealmodel);
		layout(false);
        $this -> display();
    }

    /*完善个人信息*/
    public function prefect(){

        if(I('nick_name')){

            $path = $this -> upload('header','head_img',false);
            $data['nick_name'] = I('nick_name');
            $data['sex'] = I('sex');
            $data['address'] = I('area');
            $data['header_img'] = $path['bg_img'];
            $data['uid'] = session('user_id');
            $res = M('user') -> save($data);
            if($res){
                $this -> success('修改成功', U('Index/index'),1);
                session('nick_name',$data['nick_name']);
                session('header_img',$data['header_img']);
                die;
            }else{
                $this -> success('修改失败', U('Index/prefect'),1);
                die;
            }
        }

        layout(false);
        $this -> display();
    }

    public function accommodation(){
    	$category_id=(int)$_GET['id'];
        $ac_list = M('active') -> where('category='.$category_id) -> order('addTime asc') -> field('ac_id,ac_title,ac_intro,partake_num,ac_img,single_price') -> limit(7) -> select();
        $ac_list = $this -> get_small($ac_list);
        $this -> assign('list',$ac_list);
        $this -> display();
    }

    public function service(){
        if(I('title')){
            $data['uid'] = session('user_id');
			if(!$data['uid']){
				$this -> success('您未登录，请登录', U('Index/login'),1);
				die;
			}
            $data['title'] = I('title');
            $data['content'] = I('content');
            $data['qq'] = I('qq');
            $res = M('suggest') -> add($data);
            if($res){
                $this -> success('反馈成功', U('Index/detail'),1);
                die;
            }else{
                $this -> success('反馈失败', U('Index/service'),1);
                die;
            }
        }
        layout(false);
        $this -> display();
    }
   
    /* 获取活动详细信息*/
    private function getActiveinfo($qinzilist,$small=false) {
    	foreach ($qinzilist as $key=>$val)
    	{
    		/*活动图片*/
    		$active_img = json_decode($qinzilist[$key]['ac_img'],true);
    		if($small){
    			$qinzilist[$key]['ac_img'] = $active_img['sm_img'];
    		}else {
    			$qinzilist[$key]['ac_img'] = $active_img['bg_img'];
    		}
    		/*最低价格*/
    		$leastprice=M('meal')->where('ac_id='.$qinzilist[$key]['ac_id'])->field('price')->select();
    		sort($leastprice);
    		$weekprice=M('meal')->where('ac_id='.$qinzilist[$key]['ac_id'])->field('week_price')->select();
    		sort($weekprice);
    		$qinzilist[$key]['single_price']=min($leastprice[0]['price'],$weekprice[0]['week_price']);
    		$entry_count=M('order')->where("ac_id=".$qinzilist[$key]['ac_id']." and status=1")->count();
    		$qinzilist[$key]['count']=$entry_count;
    		if(strlen($qinzilist[$key]['ac_title'])>35)
    		{
    			$qinzilist[$key]['ac_title']=mb_substr($qinzilist[$key]['ac_title'],0,35,'utf-8')."...";
    		}
    	}
    	return $qinzilist;
    }
    
    /*上传图片*/
    public function upload($path,$file_name,$is_small)
    {

        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize = 3145728;// 设置附件上传大小
        $upload->exts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->rootPath = $_SERVER['DOCUMENT_ROOT'] . '/Uploads/';// 设置附件上传根目录
        $upload->savePath = $path.'/'.time() . '/'; // 设置附件上传（子）目录
        $upload->autoSub = false;
        // 上传文件
        $info = $upload->upload();
        if (!$info) {// 上传错误提示错误信息
            $this->error($upload->getError());
        } else {// 上传成功 获取上传文件信息

            if($is_small){

                $image = new \Think\Image();
                $image->open($upload->rootPath . $info[$file_name]['savepath'] . $info[$file_name]['savename']);
                //将图片裁剪为400x400并保存为corp.jpg
                $image->thumb(150, 150)->save($upload->rootPath . $info[$file_name]['savepath'] . 'sm_' . $info[$file_name]['savename']);

                $arr['sm_img'] = 'Uploads/' . $info[$file_name]['savepath'] . 'sm_' . $info[$file_name]['savename'];

            }
            $arr['bg_img'] = 'Uploads/' . $info[$file_name]['savepath'] . $info[$file_name]['savename'];

            return $arr;
        }
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
?>