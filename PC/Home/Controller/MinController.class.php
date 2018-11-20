<?php
namespace Home\Controller;
use Think\Controller;
class MinController extends Controller {

    public function index(){
		$data['uid'] = session('user_id');
        if(!$data['uid']){
            $this -> success('请登录',U('Index/login'),1);
            die;
        }
        $uid=session('user_id');
        $this->assign('user_id',session('user_id'));
        /*个人信息*/
        $model=M('user')->where('uid='.(int)session('user_id'))->find();
        $this->assign('model',$model);
        $this->assign('header_img',$model['header_img']);
        /*底部信息*/
        $aboutmodel=M('about')->find();
        $this->assign('aboutmodel',$aboutmodel);
        /*消息*/
        $messagecount=M('msg')->where("u_id=".$uid." and is_read=0")->count();
        $this->assign('messagecount',$messagecount);
		
		/*0 待付款 */
        $m1 = M()->table('ze_order as b')->join('LEFT JOIN ze_active as a on b.ac_id=a.ac_id');
        $where1 = 'b.status=0 and b.uid='.$uid;
        $count1 = $m1->where($where1)->count();
        $p1 = getpage($count1,5);
        $list1 =M()->table('ze_order as b')->join('left join ze_active as a on b.ac_id=a.ac_id')->where('b.status=0 and b.uid='.$uid)->limit($p1->firstRow, $p1->listRows)->select();
        $filter_unpay_list=getActiveInfo1 ($list1);
		$this->assign('page1',$p1->show());
		//var_dump($p1);exit;
		/*1未出行*/
		$m2 = M()->table('ze_order as b')->join('LEFT JOIN ze_active as a on b.ac_id=a.ac_id');
		$where2 = 'b.status=1 and b.uid='.$uid;
		$count2 = $m1->where($where2)->count();
		$p2 = getpage($count2,5);
		$list2 =M()->table('ze_order as b')->join('left join ze_active as a on b.ac_id=a.ac_id')->where('b.status=1 and b.uid='.$uid)->limit($p2->firstRow, $p2->listRows)->select();
		$filter_unshopping_list=getActiveInfo1 ($list2);
		foreach ($filter_unshopping_list as $key=>$val)
		{
			$time = strtotime($filter_unshopping_list[$key]['end_time'])-time();
			if($time < 0)
			{
				$filter_unshopping_list[$key]['is_over'] =1;
			}
			else{
				$temp=$this -> time2string($time);
				$filter_unshopping_list[$key]['is_over'] =0;
				$filter_unshopping_list[$key]['distance'] =$temp;
			}
		}
		$this->assign('page2',$p2->show());
		/*2待评论*/
		$m3 = M()->table('ze_order as b')->join('LEFT JOIN ze_active as a on b.ac_id=a.ac_id');
		$where3 = 'b.status=2 and b.uid='.$uid;
		$count3 = $m1->where($where3)->count();
		$p3 = getpage($count3,5);
		$list3 =M()->table('ze_order as b')->join('left join ze_active as a on b.ac_id=a.ac_id')->where('b.status=2 and b.uid='.$uid)->limit($p3->firstRow, $p3->listRows)->select();
		$filter_uncomment_list=getActiveInfo1 ($list3);	
		$this->assign('page3',$p3->show());
		/*3已完成*/
		$m4 = M()->table('ze_order as b')->join('LEFT JOIN ze_active as a on b.ac_id=a.ac_id');
		$where4 = 'b.status=3 and b.uid='.$uid;
		$count4 = $m1->where($where4)->count();
		$p4 = getpage($count4,5);
		$list4 =M()->table('ze_order as b')->join('left join ze_active as a on b.ac_id=a.ac_id')->where('b.status=3 and b.uid='.$uid)->limit($p4->firstRow, $p4->listRows)->select();
		$filter_ok_list=getActiveInfo1 ($list4);
		$this->assign('page4',$p4->show());
		/*我的收藏*/
		$collectcount = M()->table('ze_active as a')->join('ze_collection as c on c.ac_id=a.ac_id')->where('c.uid='.$uid)->count();
		$p5 = getpage($collectcount,5);
		$collectlist = M()->table('ze_active as a')->join('ze_collection as c on c.ac_id=a.ac_id')->where('c.uid='.$uid)->limit($p5->firstRow, $p5->listRows)->select();
		$this->assign('page5',$p5->show());
        foreach ($collectlist as $key=>$val)
        {
        	$active_img = json_decode($collectlist[$key]['ac_img'],true);
        	$collectlist[$key]['pic'] = $active_img['sm_img'];
        	/*时间*/
        	$startdate1=date('Y/m/d h:m',strtotime($collectlist[$key]['start_time']));
        	$collectlist[$key]['start_time1']=$startdate1;
        	$startdate2=date('m/d -h:m',strtotime($collectlist[$key]['start_time']));
        	$collectlist[$key]['start_time2']=$startdate2;
        	$enddate=date('m/d -h:m',strtotime($collectlist[$key]['end_time']));
        	$collectlist[$key]['end_time']=$enddate;
        	/*标题*/
        	if(strlen($collectlist[$key]['ac_title'])>20)
        	{
        		$collectlist[$key]['ac_title']=mb_substr($collectlist[$key]['ac_title'], 0,20,'utf-8');
        	}
        }
        $this -> assign('collectlist',$collectlist);
        /*出行人列表*/
        $contactcount=M('contact')->where('uid='.$uid)->count();
        $p6 = getpage($contactcount,5);
		$contactlist=M('contact')->where('uid='.$uid)->limit($p6->firstRow, $p6->listRows)->select();
		foreach ($contactlist as $key=>$val)
		{
			$contactlist[$key]['born']=date('Y/m/d',strtotime($contactlist[$key]['born']));
		}
		$cactontcount=M('contact')->where('uid='.$uid)->count();
		$this->assign('page6',$p6->show());
		$this->assign('contactlist',$contactlist);
		/*孩子成长*/
		$count7=M('kids')->where('uid='.session('user_id'))->count();
		$p7=getpage($count7,3);
		$childlsit=M('kids')->where('uid='.session('user_id'))->limit($p7->firstRow, $p7->listRows)->select();
		foreach ($childlsit as $key=>$val)
		{
			$count=$childlsit[$key]['badge_number'];
			$badge_name="";
			if($count==0)
			{
				$badge_name="暂无级别";
				$id=0;
			}
			else if($count>=1 && $count<=7)
			{
				$badge_name="一级童军";
				$id=1;
			}
			else if($count>=8 && $count<=15)
			{
				$badge_name="二级童军";
				$id=2;
			}
			else if($count>=16 && $count<=22)
			{
				$badge_name="三级童军";
				$id=3;
			}
			else if($count>=23 && $count<=29)
			{
				$badge_name="狮级童军";
				$id=4;
			}
			else{
				$badge_name="雄狮童军";
				$id=5;
			}
			$rank=M('badge')->where('id='.$id)->find();
			$temp=json_decode($rank['pic'],true);
			$rank['pic']=$temp['sm_img'];
			$childlsit[$key]['rank']=$badge_name;
			$childlsit[$key]['rank_pic']=$temp['sm_img'];
			$activelist = M()->table('ze_active_kids as k')->join('LEFT JOIN ze_active as a on k.ac_id=a.ac_id')->where('kid='.$childlsit[$key]['id']." and is_evalute=1")->select();
			$childlsit[$key]['active']=$activelist;
		}
		$this->assign('childlsit',$childlsit);
		$this->assign('page7',$p7);
		$kidslist=M('kids')->where('uid='.$uid)->select();
		$kidscount=M('kids')->where('uid='.$uid)->count();
		$this->assign('user_id',session('user_id'));
        $this -> assign('filter_unpay_list',$filter_unpay_list);
		$this -> assign('filter_unshopping_list',$filter_unshopping_list);
		$this -> assign('filter_uncomment_list',$filter_uncomment_list);
		$this -> assign('filter_ok_list',$filter_ok_list);
        layout(false);
        $this -> display();
    }


	/*添加订单*/
	public function join()
	{
		$data['uid'] = session('user_id');
        if(!$data['uid']){
            $this -> success('请登录',U('Index/login'),1);
            die;
        }
        $uid=session('user_id');
        $this->assign('user_id',session('user_id'));
        /*个人信息*/
        $model=M('user')->where('uid='.(int)session('user_id'))->find();
        $this->assign('model',$model);
        $this->assign('header_img',$model['header_img']);
		$data['order_sn']=date('YmdHis').rand(10000000,99999999);
		$data['status']=0;
		$data['order_amount']=$_POST['total_price'];
		/*活动套餐meal_string添加*/
		$meallist=M('meal')->where('ac_id='.$_POST['ac_id'])->select();
		$meal_string="";
		$person=0;
		$child=0;
		foreach ($meallist as $key=>$val)
		{
			if($_POST["meal".$meallist[$key]['id']]!=0)
			{
				$temp=M('meal')->where('id='.$meallist[$key]['id'])->field('type_id')->find();
				$id=$temp['type_id'];
				$meal_string.=$id.",";
				$meal_name=M('mealtype')->where('id='.$id)->field('title')->find();
				$person+=((int)mb_substr($meal_name['title'], 0,1,'utf-8'))*$_POST["meal".$meallist[$key]['id']];
				$child+=(int)mb_substr($meal_name['title'], 3,1,'utf-8')*$_POST["meal".$meallist[$key]['id']];
			}
		}
		session('person',$person);
		session('child',$child);
		$meal_string=mb_substr($meal_string, 0,strlen($meal_string)-1,'utf-8');
		$data['meal_string']=$meal_string;
		$res=M('order')->add($data);
		if($res)
		{
			session('order_id',$res);
			session('total_price',$_POST['total_price']);
			$this->assign('total_price',$_POST['total_price']);
			$order_id=session('order_id');
			$this->success('套餐选择成功，请选择出行人');
		}
		else
		{
			$this -> error('选择套餐失败');
			die;
		}
	}

	/*完善订单*/
	public function confirmorder()
	{
		$data['uid'] = session('user_id');
		if(!$data['uid']){
			$this -> success('请登录',U('Index/login'),1);
			die;
		}
		$filter['oid']=session('order_id');
		$data['contact_string']=$_POST['contact_string'];
		$res=M('order')->where($filter)->save($data);
		$array=explode(',', $_POST['contact_string']);
		foreach ($array as $key=>$val)
		{
			$temp=M('contact')->where('id='.$array[$key])->find();
			if($temp['is_child']==1)
			{
				//$childString.=$temp['name'].",";
				//添加儿童活动经历
				$kids['oid']=session('order_id');
				$kids['kid']=$temp['id'];
				$ac_id=M('order')->where('oid='.session('order_id'))->field('ac_id')->find();
				$kids['ac_id']=$ac_id['ac_id'];
				$active=M('ac_tive')->where('ac_id='.$ac_id['ac_id'])->field('start_time')->find();
				$kids['addTime']=strtotime($active['start_time']);
				M('active_kids')->add($kids);
			}
			else
			{
				//$personString.=$temp['name'].",";
			}
		}
		$activeorder=M('order')->where('oid='.session('order_id'))->find();
		session('total_price',$activeorder['order_amount']);
		$this->assign('total_price',$activeorder['order_amount']);
		$usermodel=M('user')->where('uid='.session('user_id'))->find();
		$data12['uid']=session('user_id');
		$data12['id']=session('order_id');
		$data12['name']=$usermodel['nick_name'];
		$data12['phone']=$usermodel['phone'];
		M('order_info')->add($data12);		
		$this->success('出行人选择成功,请到支付账单列表下支付订单！');

	}

	/*订单支付*/
	public function pay()
	{
		$data['uid'] = session('user_id');
		if(!$data['uid']){
			$this -> success('请登录',U('Index/login'),1);
			die;
		}
		$uid=session('user_id');
		$this->assign('user_id',session('user_id'));
		/*个人信息*/
		$model=M('user')->where('uid='.(int)session('user_id'))->find();
		$this->assign('model',$model);
		$this->assign('header_img',$model['header_img']);
		/*底部信息*/
		$aboutmodel=M('about')->find();
		$this->assign('aboutmodel',$aboutmodel);
		$filter['oid']=session('order_id');
		$ordermodel=M('order')->where($filter)->find();
		/*标题截断*/
		if(strlen($ordermodel['ac_title'])>15)
		{
			$ordermodel['ac_title']=mb_substr($ordermodel['ac_title'], 0,strlen($ordermodel['ac_title'])-15,'utf-8')."...";
		}
		$active=M('active')->where('ac_id='.$ordermodel['ac_id'])->find();
		$this -> assign("ordermodel",$ordermodel);
		$starttime=date('Y/m/d',strtotime($active['start_time']));
		$endtime=date('Y/m/d',strtotime($active['end_time']));
		$active['during']=$starttime."-".$endtime;
		$this -> assign("active",$active);
		$price=$ordermodel['order_amount'];
		$star=$ordermodel['star_amount'];
		$need_price=$price-$star/300;
		$this -> assign("need_price",$need_price);
		session('need_price',$need_price);
		session('order_sn',$ordermodel['order_sn']);
		if(strpos($_SERVER['HTTP_USER_AGENT'],'MicroMessenger') !== false)
		{
			$this -> assign("is_weixin",1);
		}
		else {
			$this -> assign("is_weixin",0);
		}
		$this->display();
	}

	/*支付成功*/
	public function pcpay_succ()
	{
		$this->display();
	}
	
	/*支付失败*/
	public function pcpay_fail()
	{
		$this->display();
	}
	
	/*微信支付*/
	public function paypost()
	{
		$pay_type=(int)$_POST['paytype'];
		$oid=$_POST['order_id'];
		switch($pay_type)
		{
			case 1: //支付宝支付
				{
					$this->redirect("/Home/Wappay/doalipay/oid/".$oid);
				}   break;
			case 2: //微信支付
				{
					//echo '<script type="text/javascript">alert("微信支付");location.href="/Home/Index";</script>';
					$this->redirect("/Home/Wxpay/native_pays/oid/".$oid);
					die;
				}break;
			case 3: //银联支付
				{
					//echo '<script type="text/javascript">alert("微信支付");location.href="/Home/Index";</script>';
					$this->redirect('/Home/Wxpay/new_pay');
					die;
				}
				break;
		}
	}
	
	/*获取积分*/
	public function integral()
	{
		$data['uid'] = session('user_id');
        if(!$data['uid']){
            $this -> success('请登录',U('Index/login'),1);
            die;
        }
        /*底部信息*/
        $aboutmodel=M('about')->find();
        $this->assign('aboutmodel',$aboutmodel);
		$model=M('user')->where('uid='.session('user_id'))->find();
		$this->assign('model',$model);
		$this->display();
	}
	
    /*完善信息*/
    public function set()
    {
    	if($_SERVER['REQUEST_METHOD']=="GET")
    	{
    		$data['uid']=session('user_id');
    		$model=M('user')->where($data)->find();
    		$this->assign('model',$model);
    		$this->assign('user_id',session('user_id'));
    		/*底部信息*/
    		$aboutmodel=M('about')->find();
    		$this->assign('aboutmodel',$aboutmodel);
    		/*消息*/
    		$messagecount=M('msg')->where("u_id=".(int)session('user_id')." and is_read=0")->count();
    		$this->assign('messagecount',$messagecount);
    		layout(false);
    		$this->display();
    	}
    	else
    	{
    		$filter['uid']=session('user_id');
    		$data['nick_name']=I('nickname');
    		$data['sex']=I('sex');
    		$data['address']=I('areaname');
    		$path = $this -> upload('header','head_img',false);
    		$data['header_img']=$path['bg_img'];
    		$res=M('user')->where($filter)->save($data);
    		if($res){
    			session('header_img',$data['header_img']);
    			$this -> success('修改成功',U('Min/index'),1);
    			die();
    		}else {
    			$this->success('修改失败', U('Min/index'), 1);
    			die();
    		}
    	}
    }
    
    /*微信登录*/
    public function WeChat()
    {
    	/*底部信息*/
    	$aboutmodel=M('about')->find();
    	$this->assign('aboutmodel',$aboutmodel);
        $this->display();	
    }

    /*修改密码*/
    public function changePwd(){
    	if(!session('user_id'))
    	{
    		$this->success('请先登录！',U('Min/login'),1);die();
    	}
    	if($_SERVER['REQUEST_METHOD']=="GET")
    	{
    		/*消息*/
    		$messagecount=M('msg')->where("u_id=".session('user_id')." and is_read=0")->count();
    		$this->assign('messagecount',$messagecount);
    		/*底部信息*/
    		$aboutmodel=M('about')->find();
    		$this->assign('aboutmodel',$aboutmodel);
    		layout(false);
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
    			$this->error('两次输入的密码不一致！');die();
    		}
    		$pwd = md5(I('password1'));
    		if($info['pwd'] == $pwd)
    		{
    			$this->error('新设置的密码与原密码一致！');die();
    		}
    		else{
    			$data1['pwd'] = $pwd;
    			$res = M('user') -> where($data) -> save($data1);
    			if($res>0)
    			{
    				$this->success('密码修改成功！',U('Min/index'),1);die();
    			}
    			else {
    				$this->error('密码修改失败！',U('Min/index'),1);die();
    			}
    		}
    	}
    }
    
    /*忘记密码*/
    public function forgetPwd()
    {
    	if($_SERVER['REQUEST_METHOD']=="GET")
    	{
    		/*底部信息*/
    		$aboutmodel=M('about')->find();
    		$this->assign('aboutmodel',$aboutmodel);
    		$this->display();
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
    		$password1=$_POST['password1'];
    		$password2=$_POST['password2'];
    		if($password1!=$password2)
    		{
    			$this->error('两次输入的密码不一致');die;
    		}
    		$data['phone'] = I('phone');
    		$res = M('user') -> where($data) -> find();
    		if($res)
    		{
    			$this->error('该用户已存在');die;
    		}
    		else
    		{
    			$data['pwd'] = md5(I('password1'));
    			$res = M('user') -> add($data);
    			if($res){
    				session('user_id', $res);
    				$this->success('注册成功',U('Index/prefect'),1);die;
    			}else{
    				$this->error('注册失败');die;
    			}
    		}
    	}
    }
    
    /*退出*/
    public function userexit(){
		header("content-type:text/html;charset:utf-8");
        session(null);
		$this->success('退出成功',U('Index/index'),1);
		die;
    }

    /*添加收藏*/
    public function collect_add()
    {
    	if(!session('user_id'))
    	{
    		$this->success('请先登录！',U('Index/login'),1);die();
    	}
    	$filter['uid']=session('user_id');
    	$filter['ac_id']=$_GET['ac_id'];
        $res=M('collection')->add($filter);
        if($res){
        	$this->success('收藏成功',U('Min/index'),1);die;
        }else{
        	$this->error('收藏失败');die;
        }
    }
    
    /*收藏列表*/
    public function collection_list(){
        $data['uid'] = session('user_id');
        if(!$data['uid']){
            $this -> success('请登录',U('Index/login'),1);
            die;
        }
        $data['uid'] = session('user_id');
        $list = M('collection') -> where($data) -> field('ac_id') -> select();
        $str = '';
        foreach($list as $key=>$val){
            $str .= $val['ac_id'].',';
        }
        $str = substr($str,0,strlen($str)-1);
        $where['ac_id'] = array('in',$str);
        $list = M('active') -> where($where) -> select();
        $count = M('active') -> where($where) -> count();
        foreach ($list as $key=>$val)
        {
        	/*统计报名人数*/
        	$entry_count=M('order')->where('ac_id='.$list[$key]['ac_id']." and status=1")->count();
        	$list[$key]['count']=$entry_count;
        	/*判断当前活动是否已经截止*/
        	$$list[$key]['is_close']=$entry_count==$list[$key]['ac_id'] ? 1:0;
        	$leastprice=M('meal')->where('ac_id='.$list[$key]['ac_id'])->field('price')->select();
        	sort($leastprice);
        	$list[$key]['single_price']=$leastprice[0]['price'];
        	$cate=M('active_category')->where('id='.$list[$key]['category_id'])->field('category_name')->find();
        	$list[$key]['category_id']=$cate['category_name'];
        }
        $list=$this->get_big($list);
        $this -> assign('count',$count);
        $this -> assign('list',$list);
        $this -> display();
    }
    
    /*取消收藏*/
    public function uncollect()
    {
       $data['ac_id'] = I('ac_id');
       $data['uid'] = session('user_id');
       $res = M("collection") -> where($data) -> delete();
       if($res){
       	    $this->success('取消收藏成功！',U('Min/index'),1);die;
       }else{
            $this->success('取消收失败！',U('Min/index'),1);die;
       }
    }
	
	/*订单取消*/
	public function order_cancel()
	{
		$oid=isset($_GET['id'])?(int)$_GET['id']:0;
		$filter['oid']=$oid;
		$data['status']=4;//订单取消
		$ordermodel=M('order')->where($filter)->save($data);
		echo "<script type='text/javascript'> alert('订单取消成功');location.href='/Home/Min/no_payment';</script>";
	}
    
    /*出行人列表*/
    public function constact_list(){
        $data['uid'] = session('user_id');
        if(!$data['uid']){
            $this -> error('请登录',U('Index/login'),1);
            die;
        }
        $list = M('contact') -> where($data) -> select();
        foreach($list as $key=>$val){
            if($val['sex'] == 1){
                $list[$key]['sex'] = '男';
            }else if($val['sex'] == 2){
                $list[$key]['sex'] = '女';
            }else {
            	$list[$key]['sex'] = '保密';
            }
            if($val['ID_type'] == 1){
                $list[$key]['ID_type'] = '身份证';
            }
            elseif($val['ID_type'] == 2){
                $list[$key]['ID_type'] = '军官证';
            }
            else {
            	$list[$key]['ID_type'] = '其他';
            }
            if($list[$key]['is_child'] == 1){
            	$list[$key]['is_child'] = '成人';
            }
            else {
            	$list[$key]['is_child'] = '儿童';
            }
        }
        $this -> assign('list',$list);
        $this -> display();
    }

    /*出行人修改*/
    public function contact_update(){
        if(I('name')){
        	$filter['id']=$_POST['id'];
            $data['uid'] = session('user_id');
            $data['name'] = I('name');
            $data['sex'] = I('sex');
            $data['born'] = I('born');
            $data['ID_type'] = I('ID_type');
            $data['ID_card'] = I('ID_card');
            $res = M('contact') -> where($filter) -> save($data);
            if($res){
                $this -> success('修改成功');
                die();
            }else {
                $this->success('修改失败');
                die();
            }
        }
    }

    /*出行人删除*/
    public function contact_del(){

        if(I('id')){
            $data['id'] = I('id');
            $res = M('contact') -> where($data) -> delete();
            if($res){
                $this -> success('删除成功',U('Min/Index'),1);
                die;
            }else{
                $this -> success('删除失败',U('Min/Index'),1);
                die;
            }
        }
    }

    /*添加出行人下订单页*/
    public function contact_add(){
       if(I('name')){
            $data['uid'] = session('user_id');
            $data['name'] = I('name');
            $data['sex'] = I('sex');
            $data['born'] = 
            $temp1=explode('-',I('born'));
            $temp2=explode('-',date('Y-m-d',time()));
            if($temp2[0]-$temp1[0]>=18)
            {
            	$data['is_child']=0;
            }
            else {
            	$data['is_child']=1;
            }
            $data['ID_type'] = I('ID_type');
            $data['ID_card'] = I('ID_num');
            $res = M('contact') -> add($data);
            if($res){
            	if($data['is_child']==1)//添加出行人的同时添加孩子信息
            	{
	            	$data2['id']=$res;
	            	$data2['uid']=session('user_id');
	            	$data2['name']=I('name');
	            	$data2['sex']=I('sex');
	            	$res2=M('kids')->add($data2);
	            	if($res2){
	                    $this -> success('添加成功');
	            	}
	            	else {
	            		$this->error('添加失败');die;
	            	}
            	}
            	else {
            		$this -> success('添加成功');
            	}
            }else {
                $this -> success('添加失败');
                die;
            }
        }
    }
	
    /*添加出行人PC端个人中心页的*/
    public function contact_add1(){
    	if(I('name')){
    		$data['uid'] = session('user_id');
    		$data['name'] = I('name');
    		$data['sex'] = I('sex');
    		$data['born'] =I('born');
    		if(time()-strtotime(I('born'))>=18*365*24*60*60)
    			{
    			   $data['is_child']=0;
    			}
    		else{
    			   $data['is_child']=1;
    			}
    		$data['ID_type'] = I('ID_type');
    		$data['ID_card'] = I('ID_num');
    		$res = M('contact') -> add($data);
    		if($res){
    			if($data['is_child']==1)//添加出行人的同时添加孩子信息
    			{
    				$data2['id']=$res;
    				$data2['uid']=session('user_id');
    				$data2['name']=I('name');
    				$data2['sex']=I('sex');
    				$res2=M('kids')->add($data2);
    				if($res2){
    					$this -> success('添加成功');
    				}
    				else {
    					$this->error('添加失败');die;
    				}
    			}
    			else {
    				$this -> success('添加成功');
    			}
    		}else {
    			$this -> success('添加失败');
    			die;
    		}
    	}
    }
    
	/*选择出行人*/
    public function select_contacts(){
        if($_SERVER['REQUEST_METHOD']=="GET"){
			$data['uid'] = session('user_id');
			$list = M('contact') -> where($data) -> select();
			foreach($list as $key=>$val){
				if($val['sex'] == 1){
					$list[$key]['sex'] = '男';
				}else{
					$list[$key]['sex'] = '女';
				}
				if($val['ID_type'] == 1){
					$list[$key]['ID_type'] = '身份证';
				}elseif($val['ID_type'] == 2){
					$list[$key]['ID_type'] = '军官证';
				}
			}
			$this -> assign('list',$list);
			layout(false);
			$this -> display();
		}
		else{
			$al_price=session('al_price');
			echo "<script type='text/javascript'>alert('选择成功');location.href='/Home/Index/order?al_price=".$al_price."';</script>";
		}
    }
   
    /*关于我们*/
    public function AboutUs(){
    	/*底部信息*/
    	$aboutmodel=M('about')->find();
    	$this->assign('aboutmodel',$aboutmodel);
        $ab = M('about') -> order('addTime desc') -> find();
        $this -> assign('about',$ab);
        if(session('user_id'))
        {
           $this->assign('user_id',session('user_id'));
           $this->assign('header_img',session('header_img'));
           $model=M('user')->where('uid='.session('user_id'))->find();
           $this->assign('model',$model);
        }
        $this -> display('AboutUs');
    }

	/*订单详情*/
	public function order_detail()
	{
		$type=$_GET['type'];
		$data['uid'] = session('user_id');
        if(!$data['uid']){
            $this -> error('请登录',U('Index/login'),1);
            die;
        }
		$order=M('order');
		//$list = $order->table('active')->where('stats.id = profile.typeid')->order('stats.id desc' )->select();
		//$list = M('order') ->where('status='.$type)->select();
		//var_dump($list);exit;
		$sql="select * from ze_order left join ze_active on ze_order.ac_id =ze_active.ac_id where ze_order.status=0";
		$res=mysql_query($sql);
		$list=mysql_fetch_assoc($res);
        foreach($list as $key=>$val){
            $list[$key]['start_time'] = date("Y/m/d-H",$val['start_time']);
            $list[$key]['end_time'] = date("d-H:i",$val['end_time']);
            $list[$key]['addTime'] = date("Y/m/d",$val['addTime']);
        }
        $this -> assign('list',$list);
        $this -> display();
	}
	
    /*取消订单*/
    public function cancle_order()
    {
       $orderid=(int)$_GET['orderid'];
       $data['oid']=$orderid;
       $data1['status']=4;
       $count=M('order')->where($data)->save($data1);
       if($count>0)
       {
            $this->success('订单取消成功',U('Min/index'),1);
            die();
       }
       else {
	       	$this->success('订单取消失败',U('Min/index'),1);
	       	die();
       }
    }
    
    /*活动评价*/
    public function evaluate()
    {
    	if(!session('user_id'))
    	{
    		$this->success('请先登录',U('Index/login'),1);
    		die;
    	}
    	$uid=(int)session('user_id');
    	if($_SERVER['REQUEST_METHOD']=="GET")
    	{
    		$orderid=(int)$_GET['orderid'];
    		/*底部信息*/
    		$aboutmodel=M('about')->find();
    		$this->assign('aboutmodel',$aboutmodel);
    		/*消息*/
    		$messagecount=M('msg')->where("u_id=".$uid." and is_read=0")->count();
    		$this->assign('messagecount',$messagecount);
    		$this->assign('orderid',$orderid);
    	    layout(false);
    	    $this->display();
    	}
    	else
    	{
    		if(!$_POST['comment'])
    		{
    			$this->error('请输入活动评价');exit;
    		}
    		$activemodel=M('order')->where('oid='.(int)$_POST['orderid'])->field('ac_id')->find();
    		$data['order_id']=(int)$_POST['orderid'];
    		$data['ac_id']=$activemodel['ac_id'];
    		$data['uid']=$uid;
    		$data['star']=(int)$_POST['star'];
    		$data['content']=$_POST['comment'];
    		$res=M('comment')->add($data);
    		if($res){
    			$filter['oid']=(int)$_POST['orderid'];
    			$data2['status']=3;
    			$re=M('order')->where($filter)->save($data2);
    			if($re)
    			{
    				$this -> success('评价成功',U('Min/Index'),1);
    				die;
    			}
    		}else{
    			$this -> success('评价失败',U('Min/Index'),1);
    			die;
    		}
    	}
    }

    /*修改活动评价*/
    public function chevaluate()
    {
    	if(!session('user_id'))
    	{
    		$this->success('请先登录',U('Index/login'),1);
    		die;
    	}
    	$uid=(int)session('user_id');
    	if($_SERVER['REQUEST_METHOD']=="GET")
    	{
    		$data3['order_id']=(int)$_GET['orderid'];
    		$data3['uid']=$uid;
    		$count=M('comment')->where($data3)->count();
    		if($count==0)
    		{
    			$this->error('请先在待评价订单列表中进行评价');die;
    		}
    		$orderid=(int)$_GET['orderid'];
    		/*底部信息*/
    		$aboutmodel=M('about')->find();
    		$this->assign('aboutmodel',$aboutmodel);
    		/*消息*/
    		$messagecount=M('msg')->where("u_id=".$uid." and is_read=0")->count();
    		$this->assign('messagecount',$messagecount);
    		$this->assign('orderid',$orderid);
    		layout(false);
    		$this->display('evaluate');
    	}
    	else
    	{
    		if(!$_POST['comment'])
    		{
    			$this->error('请输入活动评价');exit;
    		}
    		$data3['order_id']=(int)$_GET['orderid'];
    		$data3['uid']=$uid;
    		$data['star']=(int)$_POST['star'];
    		$data['content']=$_POST['comment'];
    		$res=M('comment')->where($data3)->save($data);
    		if($res){
    			$this -> success('修改评价成功',U('Min/Index'),1);
    			die;
    		}else{
    			$this -> success('修改评价失败',U('Min/Index'),1);
    			die;
    		}
    	}
    }

    public function time2string($second){
    	$arry=array();
        $day = floor($second/(3600*24));
        $second = $second%(3600*24);//除去整天之后剩余的时间
        $hour = floor($second/3600);
        $second = $second%3600;//除去整小时之后剩余的时间
        $minute = floor($second/60);
        $second = $second%60;//除去整分钟之后剩余的时间
        //返回字符串
        $arry['day']=$day;
        $arry['hour']=$hour;
        $arry['minute']=$minute;
        return $arry;
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
}