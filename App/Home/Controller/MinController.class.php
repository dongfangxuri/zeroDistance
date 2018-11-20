<?php
namespace Home\Controller;
class MinController extends HomeBaseController {

    public function index(){
    	if(session("header_img")){
    		$this -> assign("header_img",session("header_img"));
    	}
    	$uid=session('user_id');
		$data['uid'] = session('user_id');
        $usermodel=M('user')->where('uid='.$uid)->find();
        $this->assign('model',$usermodel);
		//0 待付款 1 未出行订单 2 待评价 3 已完成
		$filter_unpay['status']=0;
		$filter_unpay['uid']=$uid;
		$filter_unpay_num=M('order')->where($filter_unpay)->count();
		$filter_unshopping['status']=1;
		$filter_unshopping['uid']=$uid;
		$filter_unshopping_num=M('order')->where($filter_unshopping)->count();
		$filter_uncomment['status']=2;
		$filter_uncomment['uid']=$uid;
		$filter_uncomment_num=M('order')->where($filter_uncomment)->count();
		$filter_ok['status']=3;
		$filter_ok['uid']=$uid;
		$filter_ok_num=M('order')->where($filter_ok)->count();
        if(I('nick_name')){
            $data['nick_name'] = I('nick_name');
            $data['uid'] = session('user_id');
            $res = M('user') -> save($data);
            if($res){
                session('nick_name', $data['nick_name']);
            }
        }
        if(session('user_id')){
            $data['uid'] = session('user_id');
            $num = M('user') -> where($data) -> getField('badge_num');
            $list = M('badge') -> limit($num) -> select();
            $this -> assign('list',$list);
        }else{
            $list = M('badge') -> limit(4) -> select();
            $this -> assign('list',$list);
        }
		$this->assign('user_id',session('user_id'));
        $this -> assign('filter_unpay_num',$filter_unpay_num);
		$this -> assign('filter_unshopping_num',$filter_unshopping_num);
		$this -> assign('filter_uncomment_num',$filter_uncomment_num);
		$this -> assign('filter_ok_num',$filter_ok_num);
        $this -> assign('num',$num);
        $this -> display();
    }

    /*完善信息*/
    public function prefect(){
    	if(I('nick_name')){
    
    		$path = upload('header','head_img',false);
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
    
    /*修改个人信息*/
    public function changeinfo()
    {
    	if($_FILES['header_img']['name']){
    		$path = upload('header','header_img',true);
    		$data['header_img'] = $path['bg_img'];
    	}
    	$filter['uid']=$_POST['uid'];
    	$data['nick_name']=$_POST['nick_name'];
    	$data['sex']=$_POST['sex'];
    	$data['address']=$_POST['address'];
    	$res=M('user')->where($filter)->save($data);
    	if($res)
    	{
    		$this->success('修改成功！');
    	}
    	else
    	{
    		$this->error('修改失败！');
    	}
    }

    /*活动分享*/
    public function share()
    {
    	$uid=session('user_id');
    	$data['uid'] = session('user_id');
    	$usermodel=M('user')->where('uid='.$uid)->find();
    	$this->assign('model',$usermodel);
    	$this->display();
    }

    /*退出*/
    public function userexit(){
		header("content-type:text/html;charset:utf-8");
        session(null);
		echo '<script type="text/javascript"> alert("退出成功");location.href="/";</script>';die;
    }

       /*收藏*/
    public function collection_list(){
        $data['uid'] = session('user_id');
        $list = M('collection') -> where($data) -> field('ac_id') -> select();
        $collectioncount = M('collection') -> where($data) -> field('ac_id') -> count();
        $str = '';
        foreach($list as $key=>$val){
            $str .= $val['ac_id'].',';
        }
        $str = substr($str,0,strlen($str)-1);
        $where['ac_id'] = array('in',$str);
        $m = M('active');
        $count = $m->where($where)->count();
        $p = getpage($count,5);
        $list = $m->field(true)->where($where)->order('addTime desc')->limit($p->firstRow, $p->listRows)->select();
        foreach ($list as $key=>$val)
        {
        	/*统计报名人数*/
        	$entry_count=M('order')->where('ac_id='.$list[$key]['ac_id']." and status=1")->count();
        	$list[$key]['count']=$entry_count;
        	/*判断当前活动是否已经截止*/
        	$$list[$key]['is_close']=$entry_count==$list[$key]['ac_id'] ? 1:0;
        	$list[$key]['single_price']=getleastprice($list[$key]['ac_id']);
        	$cate=M('active_category')->where('id='.$list[$key]['category_id'])->field('category_name')->find();
        	$list[$key]['category_id']=$cate['category_name'];
        }
        $list=get_big($list);
        $this->assign('count',$collectioncount);
        $this -> assign('page',$p->show());
        $this -> assign('collectioncount',$collectioncount);
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
    
    /*留言*/
    public function leamsg()
    {
    	$data['uid']=(int)session('user_id');
    	$data['ac_id']=$_POST['id'];
    	if(!$_POST['leavemsg'])
    	{
    		$this->error('请先输入用户留言');
    		die;
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
    
	/*收藏删除  */
    public function collection_del(){
    	$data['ac_id']=$_GET['ac_id'];
        $data['uid'] = session('user_id');
        $res = M("collection") -> where($data) -> delete();
        if($res){
           $this->success('取消收藏成功',U('Min/collection_list'),1);
           die;
        }else{
           $this->success('取消收藏失败',U('Min/collection_list'),1);
           die;
        }
    }
 
    /*出行人列表*/
    public function contact_list(){
        $data['uid'] = session('user_id');
        $count=M('contact') -> where($data) ->count();
        $p = getpage($count,5);
        $list = M('contact')->field(true)->where($data)->limit($p->firstRow, $p->listRows)->select();
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
                $list[$key]['ID_type'] = '临时身份证';
            }
            elseif($val['ID_type'] == 3){
            	$list[$key]['ID_type'] = '军官证';
            }
            elseif($val['ID_type'] == 4){
                $list[$key]['ID_type'] = '士兵证';
            }
            elseif($val['ID_type'] == 5){
            	$list[$key]['ID_type'] = '回乡证';
            }
            elseif($val['ID_type'] == 6){
            	$list[$key]['ID_type'] = '台胞证';
            }
            elseif($val['ID_type'] == 7){
            	$list[$key]['ID_type'] = '港澳通行证';
            }
            if($list[$key]['is_child'] == 0){
            	$list[$key]['is_child'] = '成人';
            }
            else {
            	$list[$key]['is_child'] = '儿童';
            }
        }
        $this -> assign('list',$list);
        $this->assign('page',$p->show());
        $this -> display();
    }

    /*出行人修改*/
    public function contact_update(){
    	if($_SERVER['REQUEST_METHOD']=="GET")
    	{
    	   
    	   $id=$_GET['id'];
    	   $model=M('contact')->where('id='.$id)->find();
    	   $this->assign('model',$model);
    	   session('refer',$_SERVER['HTTP_REFERER']);
    	   $this->display();
    	}
    	else{
            $map['id'] = I('id');
            $data['name'] = I('name');
            $data['sex'] = I('sex');
            $data['born'] = I('born');
            $data['ID_type'] = I('ID_type');
            $data['ID_card'] = I('ID_num');
            if(time()-strtotime(I('born'))>=18*365*24*60*60)
            {
            	$data['is_child']=0;
            }
            else {
            	$data['is_child']=1;
            }
			//长度验证  
			if(I('ID_type')==1){
				if(!preg_match('/^\d{17}(\d|x)$/i',I('ID_num')) and!preg_match('/^\d{15}$/i',I('ID_num')))  
				{  
				   $this->error('身份证格式错误');die;
				} 
			}
            $res = M('contact') -> where($map) -> save($data);
            if($res){
            	if($data['is_child']==1)//添加出行人的同时添加孩子信息
            	{
            		$data2['id']=$map['id'];
            		$data3['uid']=session('user_id');
            		$data3['name']=I('name');
            		$data3['sex']=I('sex');
            		$res2=M('kids')->where($data2)->count();
            		if($res2>0) //更新儿童信息
            		{
            			 $res3=M('kids')->where($data2)->save($data3);
            			 if($res3){
		            		$url=session('refer');
		            		if(!$url)
		            		{
		            			$this -> success('修改成功',U('Min/contact_list'),1);
		            			die;
		            		}
		            		session('refer',null);
		            		header('Location:'.$url);
            			 }
            			 else {
		            		$url=session('refer');
		            		if(!$url)
		            		{
		            			$this -> success('修改失败',U('Min/contact_list'),1);
		            			die;
		            		}
		            		session('refer',null);
		            		header('Location:'.$url);
            			 }
            		}
            		else {  //添加一个儿童信息
            			$data3['id']=$map['id'];
            			$res4=M('kids')->add($data3);
            			if($res4>0)
            			{
		            		$url=session('refer');
		            		if(!$url)
		            		{
		            			$this -> success('修改成功',U('Min/contact_list'),1);
		            			die;
		            		}
		            		session('refer',null);
		            		header('Location:'.$url);
            			}
            			else {
		            		$url=session('refer');
		            		if(!$url)
		            		{
		            			$this -> success('修改失败',U('Min/contact_list'),1);
		            			die;
		            		}
		            		session('refer',null);
		            		header('Location:'.$url);
            			}
            		}

            	}
            	else {
            		//删除儿童信息
            		$res5=M('kids')->where($map)->delete();
	            	if($res5)
	            	{
	            		$url=session('refer');
	            		if(!$url)
	            		{
	            			$this -> success('修改成功',U('Min/contact_list'),1);
	            			die;
	            		}
	            		session('refer',null);
	            		header('Location:'.$url);
	            	}
	            	else {
	            		$url=session('refer');
	            		if(!$url)
	            		{
	            			$this -> success('修改失败',U('Min/contact_list'),1);
	            			die;
	            		}
	            		session('refer',null);
	            		header('Location:'.$url);
	            	}

            	}
            }else {
            		$url=session('refer');
            		if(!$url)
            		{
            			$this -> success('修改失败',U('Min/contact_list'),1);
            			die;
            		}
            		session('refer',null);
            		header('Location:'.$url);
            }
        }
    }

    /*删除出行人*/
    public function contact_del(){
        if(I('id')){
            $data['id'] = I('id');
            $data['uid'] = session('user_id');
            $res = M('contact') -> where($data) -> delete();
            if($res){
                $this -> success('删除成功',U('Min/contact_list'),1);
                die;
            }else{
                $this -> success('删除失败',U('Min/contact_list'),1);
                die;
            }
        }
    }

    /*添加出行人*/
    public function contact_add(){
        if(I('name')){
            $data['uid'] = session('user_id');
            $data['name'] = I('name');
            $data['sex'] = I('sex');
            $data['born'] = I('born');
            if(time()-strtotime(I('born'))>=18*365*24*60*60)
            {
            	$data['is_child']=0;
            }
            else {
            	$data['is_child']=1;
            }
            $data['ID_type'] = I('ID_type');
            $data['ID_card'] = I('ID_num');
			 //长度验证  
			if(I('ID_type')==1){
				if(!preg_match('/^\d{17}(\d|x)$/i',I('ID_num')) and!preg_match('/^\d{15}$/i',I('ID_num')))  
				{  
				   $this->error('身份证格式错误');die;
				} 
			}
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
	            		$url=session('refer');
	            		if(!$url)
	            		{
	            			$this -> success('添加成功',U('Min/contact_list'),1);
	            			die;
	            		}
	            		session('refer',null);
	            		header('Location:'.$url);
	            	}
	            	else {
		            		$url=session('refer');
		                    if(!$url)
		                    {
		                    	$this -> success('添加失败',U('Min/contact_list'),1);
		                    	die;
		                    }
			            	session('refer',null);
			            	header('Location:'.$url);
	            	}
            	}
            	else {
            			$url=session('refer');
	                    if(!$url)
	                    {
	                    	$this -> success('添加成功',U('Min/contact_list'),1);
	                    	die;
	                    }
		            	session('refer',null);
		            	header('Location:'.$url);
            	}
            }else {
                $url=session('refer');
	            if(!$url)
	             {
	                 $this -> success('添加失败',U('Min/contact_list'),1);
	                 die;
	              }
		         session('refer',null);
		         header('Location:'.$url);
            }
        }
        session('refer',$_SERVER['HTTP_REFERER']);
        $this -> display();
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

    /*活动报名*/
    public function join()
    {
    	$filter['id']=$_GET['id'];
    	$active_meal=M('active_meal')->where($filter)->field('ac_id')->find();
    	$data['ac_id']=$active_meal['ac_id'];
    	$data['uid']=session('user_id');
    	$data['me_id']=$_GET['id'];//参加的活动套餐
    	$data['order_sn']=date('YmdHis').rand(10000000,99999999);
    	$data['status']=0;
    	$res=M('order')->add($data);
    	if($res)
    	{
    		session('order_id',$res);
    		$this->redirect("/Home/Rili/rili/id/".$_GET['id']);
    	}
    	else
    	{
    		$this -> error('报名失败');
    		die;
    	}
    }

    /*选择套餐活动时间*/
    public function choosedate()
    {
    		if($_GET['orderid']) //此段代码主要用来判断操作是否是从未支付订单列表跳转过来的
    		{
    			$order=M('order')->where('oid='.$_GET['orderid'])->find();
    			session('order_id',$_GET['orderid']);
    			$this->redirect('/Home/Rili/rili/id/'.$order['me_id']);
    		}
    		$order_id=session('order_id');
    		$model = M()->table('ze_active as a')->join('ze_order as b on b.ac_id=a.ac_id')->where('b.oid='.$order_id)->find();
    		//更新生成订单的套餐活动时间
    		$me_id=$model['me_id'];
    		$date=$_GET['date'];
    		$temparray=explode('-', $date);
    		if((int)$temparray[1]<10)
    		{
    			$temparray[1]="0".$temparray[1];
    		}
    		if((int)$temparray[2]<10)
    		{
    			$temparray[2]="0".$temparray[2];
    		}
    		$date=implode('-', $temparray)." 00:00:00";
    		$time_id=M('active_meal_time')->where('me_id='.$me_id." and start_time='".$date."'")->field('id')->find();
    		$time['time_id']=$time_id['id'];
    		$this->assign('time_id',$time_id['id']);
    		$active_timemodel=M('active_meal_time')->where('id='.$time_id['id'])->find();
    		$timeres=M('order')->where('oid='.$order_id)->save($time);
    		if($timeres<0)
    		{
    			$this->error('套餐活动时间选择失败');
    		}
    		else
    		{
    			$this->redirect('/Home/Min/choosemeal');
    		}
    }
    
    /*选择套餐*/
    public function choosemeal()
    {
    	if($_SERVER['REQUEST_METHOD']=="GET")
    	{
    		if($_GET['orderid']) //此段代码主要用来判断操作是否是从未支付订单列表跳转过来的
    		{
    			session('order_id',$_GET['orderid']);
    		}
    		$order_id=session('order_id');
    		$model = M()->table('ze_active as a')->join('ze_order as b on b.ac_id=a.ac_id')->where('b.oid='.$order_id)->find();
	    	/*页面其他内容展示*/
    		$active_meal_timemodel=M('active_meal_time')->where('id='.$model['time_id'])->find();
	    	$temptime=$active_meal_timemodel['start_time'];
    		$date=date('Y-m-d',strtotime($temptime));
    		$this->assign('date',$date);
    		if(strlen($model['ac_title'])>35)
    		{
    			$model['ac_title']=mb_substr($model['ac_title'], 0,35,'utf-8')."...";
    		}
    		/*该活动时间对应下的价格套餐*/
    		$meallist=M()->query('select a.price,a.id,m.title from ze_active_meal_price as a left join ze_mealtype as m on a.type_id=m.id where a.time_id='.$model['time_id']);
    		foreach ($meallist as $key=>$val)
    		{
    			$temparr=$meallist[$key]['title'];
    			if(!strpos($temparr,'成人')||!strpos($temparr,'儿童'))
    			{
    				$meallist[$key]['type']=1;
    			}
    			else {
    				$meallist[$key]['type']=0;
    			}
    		}
			$this->assign('meallist',$meallist);
    		/*统计报名人数*/
    		if($model['is_half_active']==0){  //非半天活动
    			/*已报名人数*/
    			$filter1['me_id']=$model['me_id'];
    			$filter1['time_id']=$model['time_id'];
    			$filter1['status']=1;//未出行人数
    			$hasjoin=M('order')->where($filter1)->count();
    			$state=$hasjoin/($active_meal_timemodel['join_num']);
    			if($state<0.5)
    			{
    				$state="充足";
    			}
    			else
    				$state="紧张";
    			$this->assign('state',$state);
    			$model['during']=date('m/d',strtotime($active_meal_timemodel['start_time']))."-".date('m/d',strtotime($active_meal_timemodel['end_time']));
    		}
	    	else   //半天活动
	    		{
	    			/*统计上午报名人数*/
	    			$filter1['me_id']=$model['me_id'];
	    			$filter1['time_id']=$active_meal_timemodel['time_id'];
	    			$filter1['status']=1;
	    			$filter1['half_time']=$model['morning_half_time'];
	    			$morninghasjoin=M('order')->where($filter1)->count();
	    			$state1=$hasjoin/($active_meal_timemodel['join_num']);
	    			if($state1<0.5)
	    			{
	    				$state1="充足";
	    			}
	    			else if($state1==1)
	    			{
	    				$state1="截止";
	    			}
	    			else{
	    				$state1="紧张";
	    			}
	    			$morning_arr['morning_half_time']=$model['morning_half_time'];
	    			$morning_arr['state']=$state1;
	    			$this->assign('morning_arr',$morning_arr);
	    			/*统计上午报名人数*/
	    			$filter2['ac_id']=$model['ac_id'];
	    			$filter2['status']=1;
	    			$filter2['half_time']=$model['after_half_time'];
	    			$afterhasjoin=M('order')->where($filter2)->count();
	    			$state2=$afterhasjoin/$model['after_partake_num'];
	    			if($state2<0.5)
	    			{
	    				$state2="充足";
	    			}
	    			else if($state2==1)
	    			{
	    				$state2="截止";
	    			}
	    			else{
	    				$state2="紧张";
	    			}
	    			$after_arr['after_half_time']=$model['after_half_time'];
	    			$after_arr['state']=$state2;
	    			$this->assign('after_arr',$after_arr);
	    		}
	    		$this->assign('model',$model);
	    		$this->display();
    	}
    	else {
    		$filter['oid']=session('order_id');
            $ordermodel=M('order')->where('oid='.session('order_id'))->find();
    		$meallist=M('active_meal_price')->where('time_id='.$ordermodel['time_id'])->select();
    		$person=0;
    		$child=0;
    		foreach ($meallist as $key=>$val)
    		{
    			if($_POST["meal".$meallist[$key]['id']]!=0)
    			{
    				$temp=M('active_meal_price')->where('id='.$meallist[$key]['id'])->field('type_id')->find();
    				$id=$temp['type_id'];
    				$meal_name=M('mealtype')->where('id='.$id)->field('title')->find();
					//var_dump($meal_name);
                    if(!strpos($meal_name['title'],"成人"))
    				{
    				    $child+=(int)mb_substr($meal_name['title'], 0,1,'utf-8')*$_POST["meal".$meallist[$key]['id']];
    				}
    				else if(!strpos($meal_name['title'],"儿童"))
    				{
    					$person+=((int)mb_substr($meal_name['title'], 0,1,'utf-8'))*$_POST["meal".$meallist[$key]['id']];
    				}
    				else{
    				    $person+=((int)mb_substr($meal_name['title'], 0,1,'utf-8'))*$_POST["meal".$meallist[$key]['id']];
    				    $child+=(int)mb_substr($meal_name['title'], 3,1,'utf-8')*$_POST["meal".$meallist[$key]['id']];
    				}    			
				}
    		}
    		session('person',$person);
    		session('child',$child);
    		$total_price=$_POST['totalprice'];
    		$data['order_amount']=$total_price;
    		$data['half_time']=$_POST['half_time'];
    		$data['child_amount']=$child;
    		$data['people_amount']=$person;
    		$res=M('order')->where($filter)->save($data);
			$this->redirect('Min/choosecontact');
    		//if($res)
    		//{
    		//	$this->redirect('Min/choosecontact');
    		//}
    		//else {
    		//	$this->error('套餐选择失败');die;
    		//}
    	}
    	 
    }
    
    /*选择出行人*/
    public function choosecontact()
    {
    	if($_GET['orderid'])       //此段代码主要用来判断操作是否是从未支付订单列表跳转过来的
    	{
    		session('order_id',$_GET['orderid']);
    	}
    	if(!session('person')||!session('child'))
    	{
    		$this->redirect('/Home/Min/choosemeal');
    	}
    	$person=session('person');
    	$child=session('child');
    	$this->assign('person',$person);
    	$this->assign('child',$child);
    	$list=M('contact')->where('uid='.session('user_id'))->select();
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
    			$list[$key]['ID_type'] = '临时身份证';
    		}
    		elseif($val['ID_type'] == 3){
    			$list[$key]['ID_type'] = '军官证';
    		}
    		elseif($val['ID_type'] == 4){
    			$list[$key]['ID_type'] = '士兵证';
    		}
    		elseif($val['ID_type'] == 5){
    			$list[$key]['ID_type'] = '回乡证';
    		}
    		elseif($val['ID_type'] == 6){
    			$list[$key]['ID_type'] = '台胞证';
    		}
    		elseif($val['ID_type'] == 7){
    			$list[$key]['ID_type'] = '港澳通行证';
    		}
    		if($list[$key]['is_child'] == 0){
    			$list[$key]['is_child'] = '成人';
    		}
    		else {
    			$list[$key]['is_child'] = '儿童';
    		}
    	}
    	$this -> assign('list',$list);
    	$this->display();
    }
    
    /*完善订单*/
    public function confirmorder()
    {
    	if($_GET['orderid'])
    	{
    		session('order_id',$_GET['orderid']);
    	}
    	$contact="";
    	if($_POST['contact_string'])
    	{
    		$contact=$_POST['contact_string'];
    	}
    	else{
	    	$order=M('order')->where('oid='.session('order_id'))->find();
	    	if($order['contact_string']=='')
	    	{
	    		$this->redirect('/Home/Min/choosecontact');
	    	}
	    	else {
	    		$contact=$order['contact_string'];
	    	}
    	}
    	$filter['oid']=session('order_id');
    	$data['contact_string']=$contact;
    	M('order')->where($filter)->save($data);
    	$ordermodel=M('order')->where('oid='.session('order_id'))->find();
    	$actvie_meal_time_model=M('active_meal_time')->where('id='.$ordermodel['time_id'])->find();
    	$title=M('active_meal')->where('id='.$ordermodel['me_id'])->field('me_title')->find();
    	//添加儿童活动经历
    	$array=explode(',', $contact);
    	$childString="";
    	$personString="";
    	foreach ($array as $key=>$val)
    	{
    		$temp=M('contact')->where('id='.$array[$key])->find();
    		if($temp['is_child']==1)
    		{
    			$childString.=$temp['name'].",";
    			$kids['oid']=session('order_id');
    			$kids['kid']=$temp['id'];
    			$ac_id=M('order')->where('oid='.session('order_id'))->field('ac_id')->find();
    			$kids['ac_id']=$ac_id['ac_id'];
    			$kids['addTime']=strtotime($actvie_meal_time_model['start_time']);
    			M('active_kids')->add($kids);
    		}
    		else
    		{
    			$personString.=$temp['name'].",";
    		}
    	}
    	$childString=mb_substr($childString, 0,strlen($childString)-1);
    	$personString=mb_substr($personString, 0,strlen($personString)-1);
    	$this->assign('personstring',$personString);
    	$this->assign('childstring',$childString);
    	$usermodel=M('user')->where('uid='.session('user_id'))->find();
    	$during=date('Y/m/d',strtotime($actvie_meal_time_model['start_time']))."-".date('m/d',strtotime($actvie_meal_time_model['end_time']));
    	$star=(int)$ordermodel['order_amount']*300;
    	$starstring="该订单最多可使用".$star."积分";
    	$this->assign('during',$during);
    	$this->assign('title',$title['me_title']);
    	$this->assign('usermodel',$usermodel);
    	$this->assign('ordermodel',$ordermodel);
    	$this->assign('starmax',$starstring);
    	$this->assign('maxstar',$star);
    	$this->display();
    }
    
    /*继续支付*/
    public function continue_pay()
    {
    	$id=$_GET['orderid'];
    	$model=M('order')->where('oid='.$id)->find();
    	var_dump($model['star_amount']);
    	if((int)$model['time_id']==0)
    	{
    		//选择套餐时间
    		//var_dump(1);exit;
    		$this->redirect('/Home/Min/choosedate/orderid/'.$id);
    	}
    	else if((int)$model['me_id']==0)
    	{
    		//选择套餐数量以及时间
    		//var_dump(2);exit;
    		$this->redirect('/Home/Min/choosemeal/orderid/'.$id);
    	}
    	else if(!$model['contact_string'])
    	{
    		//选择出行人  
    		//var_dump(3);exit;
    		$this->redirect('/Home/Min/choosecontact/orderid/'.$id);
    	}
    	
    	else if($model['star_amount']==null)
    	{
    		//完善订单
    		//var_dump(13);exit;
    		$this->redirect('/Home/Min/confirmorder/orderid/'.$id);
    	}
    	else
    	{
    		//var_dump(123);exit;
    		$this->redirect('/Home/Min/pay/orderid/'.$id);
    	}
    }
    
    /*支付*/
    public function pay(){
    	if($_GET['orderid'])
    	{
    		session('order_id',$_GET['orderid']);
    	}
    	//$count=M('order_info')->where('id='.session('order_id'))->count();
    	//if($count==0)
    	//{
    	//	$this->redirect('/Home/Min/confirmorder');
    	//}
		$filter['oid']=session('order_id');
		$data1['star_amount']=(int)$_POST['star'];
		M('order')->where($filter)->save($data1);
		$data2['content']=$_POST['content'];
		$data2['id']=session('order_id');//需要和当前订单关联起来
		$data2['name']=$_POST['name'];
		$data2['phone']=$_POST['phone'];
		$data2['uid']=session('user_id');
		$exist=M('order_info')->where($data2)->count();
		if($exist==0){
		   $res2=M('order_info')->add($data2);
		   if($res2)
		   {
			   	$ordermodel=M('order')->where($filter)->find();
			   	/*标题截断*/
			   	if(strlen($ordermodel['ac_title'])>15)
			   	{
			   		$ordermodel['ac_title']=mb_substr($ordermodel['ac_title'], 0,strlen($ordermodel['ac_title'])-15,'utf-8')."...";
			   	}
			   	$active_meal_time=M('active_meal_time')->where('id='.$ordermodel['time_id'])->find();
			   	$this -> assign("ordermodel",$ordermodel);
			   	$starttime=date('Y/m/d',strtotime($active_meal_time['start_time']));
			   	$endtime=date('Y/m/d',strtotime($active_meal_time['end_time']));
			   	$during=$starttime."-".$endtime;
			   	$this -> assign("during",$during);
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
			    else{
			   		$this -> assign("is_weixin",0);
			   	}
			   	$this->display();
		   }
		   else {
		   	$this->error('订单填写失败');die;
		   }
		}
		else {
			$ordermodel=M('order')->where($filter)->find();
			/*标题截断*/
			if(strlen($ordermodel['ac_title'])>15)
			{
				$ordermodel['ac_title']=mb_substr($ordermodel['ac_title'], 0,strlen($ordermodel['ac_title'])-15,'utf-8')."...";
			}
			$active_meal=M('active_meal')->where('id='.$ordermodel['me_id'])->find();
			$this -> assign("title",$active_meal['me_title']);
			$active_meal_time=M('active_meal_time')->where('id='.$ordermodel['time_id'])->find();
			$this -> assign("ordermodel",$ordermodel);
			$starttime=date('Y/m/d',strtotime($active_meal_time['start_time']));
			$endtime=date('Y/m/d',strtotime($active_meal_time['end_time']));
			$during=$starttime."-".$endtime;
			$this -> assign("during",$during);
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
			else{
				$this -> assign("is_weixin",0);
			}
			$this->display();
		}
		
    }
    
    /*支付成功*/
    public function pay_success()
    {
    	$this->display();
    }

    /*支付失败*/
    public function pay_fail()
    {
    	$this->display();
    }
    
	  /*qq空间分享*/
    public function zoneshare()
    {
    	$time=date('Y-m-d',time());
    	$count=M()->query("select sum(star) as count from ze_share_log where sharetime='".$time."' and uid=".session('user_id'));
    	if($count[0]['count']>=280)
    	{
    		//$this->success('分享失败',U('Min/Index'),1);
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
    	}
    }
    
		  /*微信好友空间分享*/
    public function wxzoneshare()
    {
    	$time=date('Y-m-d',time());
    	$count=M()->query("select sum(star) as count from ze_share_log where sharetime='".$time."' and uid=".session('user_id'));
    	if($count[0]['count']>=280)
    	{
    		//$this->success('分享失败',U('Min/Index'),1);
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
    	}
    }
	
    /*qq好友分享*/
    public function qqfriend()
    {
    	$time=date('Y-m-d',time());
    	$count=M()->query("select sum(star) as count from ze_share_log where sharetime='".$time."' and uid=".session('user_id'));
    	if($count[0]['count']>=300)
    	{
    		//$this->success('分享失败',U('Min/Index'),1);
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
    	}
    }
	
	    /*qq好友分享*/
    public function wxfriend()
    {
    	$time=date('Y-m-d',time());
    	$count=M()->query("select sum(star) as count from ze_share_log where sharetime='".$time."' and uid=".session('user_id'));
    	if($count[0]['count']>=300)
    	{
    		//$this->success('分享失败',U('Min/Index'),1);
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
    	}
    }
	
    /*获取积分*/
    public function integral(){
		require_once '/Public/Weixin/jssdk/jssdk.php';
		//$jssdk=new \JSSDK('wxb5a44bff56e1e26f', '59903ab18acde73980b5ae19c8e995fe');
    	$jssdk=new \JSSDK('wxd6f020aa26b90d5b', '52936485b8945e29a012b19d42127c13');
    	$signPackage = $jssdk->GetSignPackage();
		$this->assign('signPackage',$signPackage);
    	$model=M('user')->where('uid='.session('user_id'))->find();
    	$this->assign('model',$model);
        $this -> display();
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
			}break;
			case 2: //微信支付
			{
				//echo '<script type="text/javascript">alert("微信支付");location.href="/Home/Index";</script>';
				$this->redirect("/Home/Wxpay/new_pay/oid/".$oid);
				die;
			}
			case 3: //银联支付
			{
				//echo '<script type="text/javascript">alert("微信支付");location.href="/Home/Index";</script>';
				$this->redirect('/Home/Wxpay/new_pay');
				die;
			}
			break;
		}
	}
    
	/*完成订单*/
    public function pay_finish(){
    	$data['uid'] = session('user_id');
    	$uid=session('user_id');
    	$m = M()->table('ze_order as b')->join('LEFT JOIN ze_active as a on b.ac_id=a.ac_id');
    	$where = 'b.status=3 and b.uid='.$uid;
    	$count = $m->where($where)->count();
    	$p = getpage($count,5);
    	$list =M()->table('ze_order as b')->join('left join ze_active as a on b.ac_id=a.ac_id')->where('b.status=3 and b.uid='.$uid)->limit($p->firstRow, $p->listRows)->select();
    	 
        foreach($list as $key=>$val){
        	
        	/*标题截断*/
        	if(strlen($list[$key]['ac_title'])>15)
        	{
        		$list[$key]['ac_title']=mb_substr($list[$key]['ac_title'],0,15,'utf-8')."...";
        	}
        	/*活动时间*/
        	$temp=date('Y-m-d',strtotime($list[$key]['start_time']))." ".$list[$key]['start_hour'].":00";
        	$list[$key]['start_time']=$temp;
        	/*活动图片*/
			$active_img = json_decode($list[$key]['ac_img'],true);
            $list[$key]['pic'] = $active_img['sm_img'];
            $active_meal_time=M('active_meal_time')->where('id='.$list[$key]['time_id'])->find();
            $list[$key]['start_time']=date('Y-m-d',strtotime($active_meal_time['start_time']))." ".$active_meal_time['start_hour'].":00";
            $list[$key]['meal_string'].=$list[$key]['people_amount']."成人".$list[$key]['child_amount']."儿童";
            /*下单时间*/
            $list[$key]['add_time']=date('Y-m-d H:m:s',strtotime($list[$key]['add_time']));
        }
        $this->assign('page', $p->show()); // 赋值分页输出
        $this -> assign('list',$list);
        $this -> assign('count',$count);
        $this -> display();
    }
    
    /*关于我们*/
    public function AboutUs(){
        $this -> display('AboutUs');
    }

	/*订单详情*/
	public function order_detail()
	{
		$type=$_GET['type'];
		$data['uid'] = session('user_id');
		$order=M('order');
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
	
	/*待付款*/
    public function no_payment(){
        $data['uid'] = session('user_id');
        $uid=session('user_id');
        $m = M()->table('ze_order as b')->join('LEFT JOIN ze_active as a on b.ac_id=a.ac_id');
        $where = 'b.status=0 and b.uid='.$uid;
        $count = $m->where($where)->count();
        $p = getpage($count,5);
        $list =M()->table('ze_order as b')->join('left join ze_active as a on b.ac_id=a.ac_id')->where('b.status=0 and b.uid='.$uid)->limit($p->firstRow, $p->listRows)->select();       
        foreach($list as $key=>$val){
			$active_img = json_decode($list[$key]['ac_img'],true);
            $list[$key]['pic'] = $active_img['sm_img'];
            $active_meal_time=M('active_meal_time')->where('id='.$list[$key]['time_id'])->find();
            $list[$key]['start_time']=date('Y-m-d',strtotime($active_meal_time['start_time']))." ".$active_meal_time['start_hour'].":00";
            $list[$key]['meal_string'].=$list[$key]['people_amount']."成人".$list[$key]['child_amount']."儿童";
        }
        $this->assign('page', $p->show()); // 赋值分页输出
        $this -> assign('list',$list);
        $this -> assign('count',$count);
        $this -> display();
    }

    /*待评价*/
    public function no_assessment(){
        $data['uid'] = session('user_id');
        $uid=session('user_id');
        $m = M()->table('ze_order as b')->join('LEFT JOIN ze_active as a on b.ac_id=a.ac_id');
        $where = 'b.status=2 and b.uid='.$uid;
        $count = $m->where($where)->count();
        $p = getpage($count,5);
        $list =M()->table('ze_order as b')->join('left join ze_active as a on b.ac_id=a.ac_id')->where('b.status=2 and b.uid='.$uid)->limit($p->firstRow, $p->listRows)->select();        
       foreach($list as $key=>$val){
			$active_img = json_decode($list[$key]['ac_img'],true);
            $list[$key]['pic'] = $active_img['sm_img'];
            $active_meal_time=M('active_meal_time')->where('id='.$list[$key]['time_id'])->find();
            $list[$key]['start_time']=date('Y-m-d',strtotime($active_meal_time['start_time']))." ".$active_meal_time['start_hour'].":00";
            $list[$key]['meal_string'].=$list[$key]['people_amount']."成人".$list[$key]['child_amount']."儿童";
        }
        $this->assign('page', $p->show()); // 赋值分页输出
        $this -> assign('list',$list);
        $this -> assign('count',$count);
        $this -> display();
    }

    /*订单评价*/
    public function evalute()
    {
    	if($_SERVER['REQUEST_METHOD']=="GET")
    	{
	    	$oid=$_GET['orderid'];
	    	$model=M('order')->where('oid='.$oid)->find();
	    	$ordermodel=M('active')->where('ac_id='.$model['ac_id'])->find();
	    	$category=M('active_category')->where('id='.$ordermodel['category_id'])->find();
	    	$ordermodel['category']=$category['category_name'];
	    	if(strlen($ordermodel['ac_title'])>10)
	    	{
	    		$ordermodel['ac_title']=mb_substr($ordermodel['ac_title'], 0,10,'utf-8');
	    	}
	    	$temp=json_decode($ordermodel['ac_img'],true);
	    	$ordermodel['ac_img']=$temp['bg_img'];
	    	/*最低价格*/
	    	$leastprice=M('meal')->where('ac_id='.$ordermodel['ac_id'])->field('price')->select();
	    	sort($leastprice);
	    	$weekprice=M('meal')->where('ac_id='.$ordermodel['ac_id'])->field('week_price')->select();
	    	sort($weekprice);
	    	$ordermodel['single_price']=min($leastprice[0]['price'],$weekprice[0]['week_price']);
	    	$entry_count=M('order')->where("ac_id=".$ordermodel['ac_id']." and status=1")->count();
	    	$ordermodel['count']=$entry_count;
	    	$this->assign('model',$ordermodel);
	    	$this->assign('oid',$oid);
	    	$this->display();
    	}
    	else
    	{
    		$data['uid']=session('user_id');
    		$data['ac_id']=$_POST['ac_id'];
    		$data['order_id']=$_POST['order_id'];
    		$data['content']=$_POST['comment'];
    		$data['star']=$_POST['star'];
    		$data['addTime']=time();
    		$res=M('comment')->add($data);
    		if($res)
    		{
    			$filter['oid']=$_POST['order_id'];
    			$data1['status']=3;
    			$res=M('order')->where($filter)->save($data1);
    			if($res){
    			   $this->success('评价成功',U('Min/index'),1);
    			}
    			else {
    			    $this->error('评价失败');die;
    			}
    		}
    		else
    		{
    			$this->error('评价失败');die;
    		}
    	}
    }

}