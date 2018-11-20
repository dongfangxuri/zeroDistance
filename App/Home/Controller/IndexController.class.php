<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {

	/*首页*/
    public function index(){
        if(session('header_img')){
            $this -> assign('header_img',session('header_img'));
        }
        /*城市列表*/
        $citylist=M('area')->where('parentid!=0 and state=1')->select();
        
        /*首页轮播图列表*/
        $lun_list = M('active_lun')-> order('sort_id') -> limit(5) -> select();
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
        /*会首先加载当前城市下的活动。如果当前城市未开通，则加载其他城市下的数据*/
        if($_GET['cityid'])
        {
        	$cityid=(int)$_GET['cityid'];
        	$aclist=M('active_city')->where('city_id='.$cityid)->select();
        	/*亲子游学活动*/
        	foreach ($aclist as $key=>$val)
        	{
        		$id=(int)$aclist[$key]['ac_id'];
        		$count=M('active')->where('category_id=1 and status=0 and ac_id='.$id)->count();
        		if($count){
        			$qinzilist[]=M('active')->where('category_id=1 and status=0 and is_top=1 and ac_id='.$id)->find();
        		}
        	}
        	/*如果当前城市未开通，则加载其他城市下的数据*/
        	if(count($qinzilist)==0)
        	{
        		$qinzilist=M('active')->where('category_id=1 and status=0')->order('is_top desc,sort_id asc')->limit(2)->select();
        	}
        	else {
        	    $qinzilist=array_slice($qinzilist,0,2);
        	}
        	$qinzilist=getActiveinfo($qinzilist);
        	/*推荐门票*/
        	foreach ($aclist as $key=>$val)
        	{
        		$id=(int)$aclist[$key]['ac_id'];
        		$count=M('active')->where('category_id=4 and status=0 and type=3 and ac_id='.$id)->count();
        		if($count)
        		{
        			$ticketlist_recommend[]=M('active')->where('category_id=4 and status=0 and and is_top=1 type=3 and ac_id='.$id)->select();
        		}
        	}
        	/*当前城市下不存在推荐门票*/
        	if(count($ticketlist_recommend)==0)
        	{
        		$ticketlist_recommend=M('active')->where('category_id=4 and status=0 and type=3')->order('is_top desc,sort_id asc')->limit(10)->select();
        	}
        	else{
        		
        	    $ticketlist_recommend=array_slice($ticketlist_recommend,0,10);   
        	}
        	$ticketlist_recommend=getActiveinfo($ticketlist_recommend,true);  

        	/*推荐亲子酒店*/
        	foreach ($aclist as $key=>$val)
        	{
        		$id=(int)$aclist[$key]['ac_id'];
        		$count=M('active')->where('category_id=5 and status=0 and type=3 and ac_id='.$id)->count();
        		if($count){
        		   $jiudianlist_recommend[]=M('active')->where('category_id=5 and status=0 and type=3 and is_top=1 and ac_id='.$id)->find();
        		}
        	}
        	/*不存在推荐亲子酒店*/
        	if(count($jiudianlist_recommend)==0)
        	{       	
        		$jiudianlist_recommend=M('active')->where('category_id=5 and status=0 and type=3')->order('is_top desc,sort_id asc')->limit(10)->select();
        	}
        	else {
	        	$jiudianlist_recommend=array_slice($jiudianlist_recommend,0,10);
        	}
        	
	        $jiudianlist_recommend=getActiveinfo($jiudianlist_recommend,true);
        	/*当前城市*/
        	$citymodel=M('area')->where('areaid='.$cityid)->limit(1)->select();
        	$this->assign('cityname',$citymodel[0]['name']);
        }
        else{   
	        /*亲子游学活动*/
	        $qinzilist=M('active')->where('category_id=1 and status=0')->order('is_top desc,sort_id asc')->limit(2)->select();
        	$qinzilist=getActiveinfo ($qinzilist);
	        /*推荐门票*/
	        $ticketlist_recommend=M('active')->where('category_id=4 and status=0 and type=3')->order('is_top desc,sort_id asc')->limit(10)->select();
	        $ticketlist_recommend=getActiveinfo($ticketlist_recommend,true);
	        /*推荐酒店*/
	        $jiudianlist_recommend=M('active')->where('category_id=5 and status=0 and type=3')->order('is_top desc,sort_id asc')->limit(10)->select();
	        $jiudianlist_recommend=getActiveinfo($jiudianlist_recommend,true);
	        $this->assign('cityname','南通');
        }  
        $this -> assign('lun',$lun_list);
        $this->assign('menu1',$menu1);
        $this->assign('menu2',$menu2);
        $this->assign('citylist',$citylist);
        $this->assign('qinzilist',$qinzilist);
        $this->assign('jiudianlist_recommend',$jiudianlist_recommend);     
        $this->assign('ticketlist_recommend',$ticketlist_recommend);
        $this->assign('articlelist',$articlelist);
        $this -> display();
    }
    
    /*活动详情*/
    public function detail(){
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
    	}
    	else {
    		$this->assign('is',0);
    	}
    	$id=$_GET['ac_id'];
    	$activemodel=M('active')->where('ac_id='.$id)->find();
		/*活动图片*/
		$active_img = json_decode($activemodel['ac_img'],true);
 		$activemodel['ac_img'] = $active_img['bg_img'];
    	/*截断标题*/
     	if(strlen($activemodel['ac_title'])>30)
    	{
    		$activemodel['ac_title']=mb_substr($activemodel['ac_title'],0, 30,'UTF-8')."......";
    	}
    	if(strlen($activemodel['ac_intro'])>40)
    	{
    		$activemodel['ac_intro']=mb_substr($activemodel['ac_intro'],0, 40,'UTF-8')."......";
    	}
		/*互动自由编辑行*/
    	$contentlist=M('active_content')->where('ac_id='.$id)->select();
		$contentcount=M('active_content')->where('ac_id='.$id)->count();
    	$this->assign('contentlist',$contentlist);
		$this->assign('contentcount',$contentcount);
    	/*最低价格*/
		$leastprice=getleastprice($id);
		$this->assign('leastprice',$leastprice);
    	/*活动开始截止时间*/
		$active_meal_model=M('active_meal')->where("ac_id=".$id)->field('id')->find();
		$timemodel=M('active_meal_time')->where('me_id='.$active_meal_model['id'])->find();
    	$temp1=strtotime($timemodel['start_time']);
    	$activemodel['start_time']=date('Y年m月d日',$temp1);
    	$temp2=strtotime($timemodel['end_time']);
    	$activemodel['end_time']=date('Y年m月d日',$temp2);
    	/*报名人数*/
    	$entry_count=M('order')->where("ac_id=".$id." and status=1")->count();
    	$activemodel['count']=$entry_count;
    	$this->assign('activemodel',$activemodel);//html_entity_decode(
		$this->assign('activcontent',html_entity_decode($activemodel['ac_content']));
		/*已经购买的会员*/
    	$entryuserlist=M('order')->where("ac_id=".$id." and status=1")->select();
    	foreach ($entryuserlist as $key=>$val)
    	{
    		$user=M('user')->where('uid='.$entryuserlist[$key]['uid'])->find();
    		$entryuserlist[$key]['header_img']=$user['header_img'];
    	}
    	$this->assign('userlist',$entryuserlist);
    	/*统计该活动的套餐个数*/
    	$mealcount=M('active_meal')->where("ac_id=".$id)->count();
    	if($mealcount <= 1)
    	{
    		$mealmodel=M('active_meal')->where("ac_id=".$id)->find();
    		$this->assign('mealmodel',$mealmodel);
    	}
    	$this->assign('count',$mealcount);
    	/*活动套餐*/    	   
    	$taocanlist=M('active_meal')->where("ac_id=".$id)->select();
    	foreach ($taocanlist as $key=>$val)
    	{
    		if(strlen($taocanlist[$key]['me_title'])>18)
    		{
    			$taocanlist[$key]['me_title']=mb_substr($taocanlist[$key]['me_title'],0, 18,'UTF-8')."......";
    		}
    		if(strlen($taocanlist[$key]['me_info'])>15)
    		{
    			$taocanlist[$key]['me_info']=mb_substr($taocanlist[$key]['me_info'],0, 15,'UTF-8')."......";
    		}
    		$templist1=M('active_meal_time')->where('me_id='.$taocanlist[0]['id'])->field('id')->find();
    		$templist2=M('active_meal_price')->where('time_id='.$templist1['id'])->field('price')->find();
    		$templeastprice=$templist2['price'];  		
    		$meallist1=M('active_meal_time')->where('me_id='.$taocanlist[$key]['id'])->field('id')->select();
    		foreach ($meallist1 as $key1=>$val1)
    		{
    			//查询某个套餐下的最低价格
    			$meallist2=M('active_meal_price')->where('time_id='.$meallist1[$key1]['id'])->field('price')->select();
    			sort($meallist2);
    			if($meallist2[0]['price']<$templeastprice)
    			{
    				$templeastprice=$meallist2[0]['price'];
    			}
    		}
    		$taocanlist[$key]['leastprice']=$templeastprice;
    	}
    	$this->assign('taocanlist',$taocanlist);
    	/*活动评价*/
    	$commentlist=M('comment')->where('ac_id='.$id)->select();
    	$star=0;
    	$commentcount=M('comment')->where('ac_id='.$id)->count();
    	foreach ($commentlist as $key=>$val)
    	{
    		$star+=$commentlist[$key]['star'];
    		$usemodel=M('user')->where('uid='.$commentlist[$key]['uid'])->find();
    		$commentlist[$key]['header_img']=$usemodel['header_img'];
    		$commentlist[$key]['nick_name']=$usemodel['nick_name'];
    		$commentlist[$key]['addTime']=date('Y-m-d',$commentlist[$key]['addTime']);
    	}
    	$average_star=(int)($star/$commentcount);
    	$this->assign('average_star',$average_star);//总体评价
    	$this->assign('commentcount',$commentcount);
    	$this->assign('commentlist',$commentlist);
    	/*活动留言*/
    	$leamsglist=M('leavemsg')->where('ac_id='.$id)->select();
    	$leamsgcount=M('leavemsg')->where('ac_id='.$id)->count();
    	foreach ($leamsglist as $key=>$val)
    	{
    		$usemodel=M('user')->where('uid='.$leamsglist[$key]['uid'])->find();
    		$leamsglist[$key]['header_img']=$usemodel['header_img'];
    		$leamsglist[$key]['nick_name']=$usemodel['nick_name'];
    		$leamsglist[$key]['addTime']=date('m-d H:m',$leamsglist[$key]['addTime']);
    		$leamsglist[$key]['responsetime']=date('m-d H:m',$leamsglist[$key]['responsetime']);
    	}
    	$this->assign('leamsglist',$leamsglist);
    	$this->assign('leamsgcount',$leamsgcount);
        $this -> display();
    }

	/*qq活动分享*/
	public function zoneshare()
	{
		if(!session('user_id'))
    	{
    		echo "<script type='text/javascript'>alert('请先登录！');</script>";
    		$this -> redirect('Index/login');
    		//$this->success('')
    	}
		$time=date('Y-m-d',time());
		$count=M()->query("select sum(star) as count from ze_share_log where sharetime='".$time."' and uid=".session('user_id'));
		if($count[0]['count']>=280)
		{
			$this->success('分享失败',U('Min/Index'),1);
		}
		else{
			$data1['uid']=session('user_id');
			$data1['sharetime']=date('Y-m-d',time());
			$data1['star']=30;
			M('share_log')->add($data1);
			$model=M('user')->where('uid='.session('user_id'))->find();
			$inte=$model['star'];
			$data['star']=$inte+30;
			$res=M('user')->where('uid='.session('user_id'))->save($data);
			if($res)
			{
				$this->success('分享成功',U('Min/Index'),1);
			}
			else{
				$this->success('分享失败',U('Min/Index'),1);
			}
		}
	}
	
	/*qq好友分享*/
	public function qqfriend()
	{
		if(!session('user_id'))
    	{
    		echo "<script type='text/javascript'>alert('请先登录！');</script>";
    		$this -> redirect('Index/login');
    		//$this->success('')
    	}
		$time=date('Y-m-d',time());
		$count=M()->query("select sum(star) as count from ze_share_log where sharetime='".$time."' and uid=".session('user_id'));
		if($count[0]['count']>=300)
		{
			$this->success('分享失败',U('Min/Index'),1);
		}
		else{
			$data1['uid']=session('user_id');
			$data1['sharetime']=date('Y-m-d',time());
			$data1['star']=10;
			M('share_log')->add($data1);
			$model=M('user')->where('uid='.session('user_id'))->find();
			$inte=$model['star'];
			$data['star']=$inte+10;
			$res=M('user')->where('uid='.session('user_id'))->save($data);
			if($res)
			{
				$this->success('分享成功',U('Min/Index'),1);
			}
			else{
				$this->success('分享失败',U('Min/Index'),1);
			}
		}
	}
	
    /*修改密码*/
    public function changePwd(){
    	if(!session('user_id'))
    	{
    		echo "<script type='text/javascript'>alert('请先登录！');</script>";
    		$this -> redirect('Index/login');
    		//$this->success('')
    	}
    	if($_SERVER['REQUEST_METHOD']=="GET")
    	{
            $this -> display();
    	}
    	else
    	{
    		$data['uid']=session('user_id');
    		$info = M('user') -> where($data) -> find();
    		$password1=$_POST['password1'];
    		$password2=$_POST['password2'];
    		if($password2!=$password1)
    		{
    			echo "<script type='text/javascript'>alert('两次输入的密码不一致！');location.href='/Home/Min/index';</script>";die;
    		}
    		$pwd = md5(I('password1'));
    		if($info['pwd'] == $pwd)
    		{
    			echo "<script type='text/javascript'>alert('新设置的密码与原密码一致！');location.href='/Home/Min/index';</script>";die;
    		}
    		else{
    			$data1['pwd'] = $pwd;
    			$res = M('user') -> where($data) -> save($data1);
    			if($res>0)
    			{
    				echo "<script type='text/javascript'>alert('密码修改成功！');location.href='/Home/Min/index';</script>";die;
    			}
    			else {
    				echo "<script type='text/javascript'>alert('密码修改失败！');location.href='/Home/Min/index';</script>";die;
    			}
    		}
    	}
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
    			$this->error('验证码错误!');
    			session('code',null);
    			die;
    		}
            $data['phone'] = I('phone');
            $info = M('user') -> where($data) -> find();
            if(!$info)
            {
            	$this->error('该用户不存在!');
				session('code',null);
				die;
            }
            else 
            {
            	$password1=$_POST['password1'];
            	$password2=$_POST['password2'];
            	if($password2!=$password1)
            	{
            		$this->error('两次输入的密码不一致!');
					session('code',null);
            		die;
            	}
            	$pwd = md5(I('password1'));
            	if($info['pwd'] == $pwd)
            	{
            		$this->error('新设置的密码与原密码一致!');
					session('code',null);
					die;
            	}
            	else{
            		$data1['pwd'] = $pwd;
            		$res = M('user') -> where($data) -> save($data1);
            		if($res>0)
            		{
            			$this->success('密码设置成功!',U('Min/Index'),1);
						session('code',null);
						die;
            		}
            		else {
            			$this->success('密码设置失败!',U('Min/Index'),1);
						session('code',null);
						die;
            		}
            	}
            }
           
        }
    }

	/*登录*/
    public function login(){

        if(session('header_img')){
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
					if(session('refer')){
						$url=session('refer');
						session('refer',null);//防止冲突
						header('Location:'.$url);
					}
					else{
						$this->redirect('/Home/Min/index');
					}
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
        $this -> display();
    }

    /*注册*/
    public function register(){
    	if($_SERVER['REQUEST_METHOD']=="GET")
    	{
    		$this -> display();
    	}
    	else
    	{
        	$code=$_POST['passcode'];
        	if($code!=session('code'))
        	{
        		$this->error('验证码错误');
        		session('user_id',null);
        		die;
        	}
            $data['phone'] = I('phone');
            $res = M('user') -> where($data) -> find();
            if($res)
            {
            	$this->error('该用户已存在');
				session('user_id',null);
				die;
            }
            else
            {
                $data['pwd'] = md5(I('pwd'));
                $res = M('user') -> add($data);
                if($res){
					session('user_id', $res);
                    $this -> redirect('/Home/Min/prefect');
                    die();
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
		$model=M('order')->where($filter1)->find();
		/*查询该活动详悉信息*/
		//$filter2=session('ac_id');
		$filter2['ac_id']=$model['ac_id'];
		$activemodel=M('active')->where($filter2)->find();
		$start_time = date("Y/m/d",strtotime($activemodel['start_time']));
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
    
    /*活动分类*/
    public function category(){
    	/*首页轮播图列表*/
    	$lun_list = M('lun')-> order('sort_id') -> limit(5) -> select();
    	foreach ($lun_list as $key=>$val)
    	{
    		$tmp=json_decode($lun_list[$key]['pic_path'],true);
    		$lun_list[$key]['pic_path']=$tmp['bg_img'];
    	}
    	$this->assign('lun',$lun_list);
    	$category_id=(int)$_GET['id'];
    	$data['id']=$category_id;
    	$category=M('menu')->where($data)->field('menu_name')->find();
    	if($category_id==5){
    	   $this->assign('title','亲子酒店');
    	}
    	else {
    	   $this->assign('title',$category['menu_name']);
    	}
    	$m = M('active');
    	$where = 'category_id='.$category_id;
    	$count = $m->where($where)->count();
    	$p = getpage($count,6);
    	$list = $m->field(true)->where($where)->order('is_top desc,status asc,sort_id asc')->limit($p->firstRow, $p->listRows)->select();
    	$ac_list=getActiveinfo($list);
    	$this->assign('page',$p->show());
    	$this -> assign('list',$ac_list);
        $this -> display();
    }
 
    /*检索活动*/
    public function search(){
    	if(I('keyword')){
	        $keyword = I('keyword');
	        $where="ac_title like'%".$keyword."%' or ac_content like'%".$keyword."%' or ac_intro like'%".$keyword."%'";
	        $count=M('active')->where($where)->count();
	        //$ac_list = M() -> query("select * from ze_active where  order by is_top desc,status asc,store_id asc");
			if($count==0){
				$this -> assign("empty","暂无搜索结果");
			}
			$p = getpage($count,6);
			$ac_list=M('active')->where($where)->limit($p->firstRow, $p->listRows)->select();
	        $ac_list=getActiveinfo($ac_list);
	        $this -> assign('list',$ac_list);
	        $this->assign('page',$p->show());
    	}
    	else if($_GET['date'])
    	{
    		$temp=explode('-', $_GET['date']);
    		if($temp[1]<10)
    		{
    			$temp[1]="0".$temp[1];
    		}
    		if($temp[2]<10)
    		{
    			$temp[2]="0".$temp[2];
    		}
    		$string=implode('-', $temp)." 00:00:00";
    		$active_list=M()->query("select * from ze_active as a LEFT JOIN ze_active_meal as m on a.ac_id=m.ac_id LEFT JOIN ze_active_meal_time as t on t.me_id =m.id 
                                    where t.start_time='".$string."'
                                    ORDER BY is_top desc,status asc,sort_id asc");
    		$temparray=getActiveinfo($active_list);
    		$this -> assign('list',$temparray);
    		//$this->assign('page',$p->show());
    	}
    	else {
    		$count=M('active')->count();
    		$p = getpage($count,6);
    		$active_list=M('active')->limit($p->firstRow, $p->listRows)->order('is_top desc,status asc,sort_id asc')->select();
    		$ac_list=getActiveinfo($active_list);
    		$this -> assign('list',$ac_list);
    		$this->assign('page',$p->show());
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
        $this -> display('category');
    }

}
?>