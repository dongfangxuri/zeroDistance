<?php
namespace Admin\Controller;

class ActiveController extends AdminController {

    /*开通城市*/
    public function city_add()
    {
    	if($_SERVER['REQUEST_METHOD']=="GET")
		{	
			$sql="parentid=0 and state=0";
			$list=M('area')->where($sql)->select();
			$this->assign('list',$list);
			$this->display();
		}
		else{
			$areaid=(int)$_POST['areaid'];
			$data['state']=(int)$_POST['state'];
			$count=M('area')->where('areaid='.$areaid)->save($data);
			if($count>0)
			{
				$this -> success('城市添加成功', U('Active/city_list'),1);
                die;
			}
			else{
				$this -> success('城市添加失败', U('Active/city_list'),1);
                die;
			}
		}
    }
    
    /*开通城市列表*/
    public function city_list()
    {
    	$sql="state=1";
    	if(isset($_POST['name']))
    	{
    		$active_name=$_POST['name'];
    		$sql.=" and name like '%$active_name%'";
    		$list = M('area')->where($sql) -> order('vieworder')->select();
    		$count = M('area')->where($sql) -> count();
    	}
    	else{
    		$count=M('area')->where($sql)->count();
    		$list=M('area')->where($sql)->order('vieworder')->select();
    	}
    	foreach($list as $key=>$val)
    	{
    		if($list[$key]['state']==1)
    		{
    			$list[$key]['state']="已开通";
    		}
    		else
    		{
    			$list[$key]['state']="未开通";
    		}
    	}
    	$this->assign('list',$list);
    	$this->assign('count',$count);
    	$this->display();
    }
    
	/*查询城市*/
    public function getcitylist()
    {
    	$id=$_GET['parentid'];
    	$list=M('area')->where('parentid='.$id)->select();
    	//exit(json_encode($list));
    	echo json_encode($list);
    }
	
    /*关闭城市*/
    public function city_del(){
    	if(isset($_GET['areaid']))
    	{
    		$filter['areaid'] = $_GET['areaid'];
    		$data['state']=0;
    		$res = M('area') -> where($filter)-> save($data);
    		if($res){
    			$this -> success('关闭成功', U('Active/city_list'),1);
    			die;
    		}else{
    			$this -> success('关闭失败', U('Active/city_list'),1);
    			die;
    		}
    	}
    	else{
    		$this -> success('删除失败,请选择具体的城市!', U('Active/city_list'),1);
    	}
    }
    
    /*徽章列表*/
	public function badge_list()
	{
		if(!isset($_GET['ac_id']))
		{
			$this->error('请选择要发放勋章的活动');
		}
		$ac_id=(int)$_GET['ac_id'];
		$filter['ac_id']=$ac_id;
		$kidavtivelist=M('active_kids')->where($filter)->select();
		foreach ($kidavtivelist as $key=>$val)
		{
			$oid=$kidavtivelist[$key]['oid'];
			$state=M('order')->where('oid='.$oid)->field('status')->find();
			//0 待支付 1未出行 4 订单取消
			if($state['status']==1 || $state['status']==0 &&$state['status']==4)//只对已完成的订单发放徽章
			{
				unset($kidavtivelist[$key]);
			}
			else {
				//$kidmodel[]=M('kids')->where('id='.$kidavtivelist[$key]['kid'])->find();
                 $kidmodel[] = M()->table('ze_active_kids as a')->join('ze_kids as k on a.kid=k.id')->join('ze_order as o on o.oid=a.oid')->where('a.id='.$kidavtivelist[$key]['kid'])->find();
								//$kidmodel['oid']=$oid;
			}
		}
		foreach ($kidmodel as $key=>$val)
		{
			if($kidmodel[$key]['sex']==1)
			{
				$kidmodel[$key]['sex']='男';
			}
			else 
				$kidmodel[$key]['sex']='女';
		}
		$this->assign('ac_id',$ac_id);
		$this -> assign('count',count($kidmodel));
		$this -> assign('list',$kidmodel);
		$this->display();
	}

	/*发放徽章*/
	public function badge_send()
	{
		if($_SERVER['REQUEST_METHOD']=="GET")
		{
			$oid=$_GET['oid'];
			$kids=$_GET['kid'];
			$ac_id=$_GET['ac_id'];
			$this->assign('oid',$oid);
			$this->assign('kid',$kids);
			$this->assign('ac_id',$ac_id);
			$this->display();
		}
		else
		{
			/*增加每个孩子的徽章个数*/
			$filter1['id']=$_POST['kid'];
			$kidmodel=M('kids')->where($filter1)->field('badge_number')->find();
			$badge_number=$kidmodel['badge_number'];
			$badge_number=$badge_number+1;
			$data1['badge_number']=$badge_number;
			$res1=M('kids')->where($filter1)->save($data1);
			if($res1){
				/*为每个孩子编写活动评论*/
				$filter['kid']=$_POST['kid'];
				$filter['oid']=$_POST['oid'];
				$filter['kid']=$_POST['kid'];
				$filter['ac_id']=$_POST['ac_id'];
				$data['group_name']=$_POST['group_name'];
				$data['group_slogan']=$_POST['group_slogan'];
				$data['group_role']=$_POST['group_role'];
				$data['active_evalute']=$_POST['active_evalute'];
				$data['is_evalute']=1;
				$res=M('active_kids')->where($filter)->save($data);
				if($res)
				{
					$this->success('徽章发放成功',U("/Admin/Active/badge_list/ac_id/".$_POST['ac_id']),1);
				}
				else {
					$this->error('发放失败');die;
				}
			}
			else {
				$this->error('发放失败');die;
			}
		}
	}
	
    public function active_picture_add(){

        if(I('id')){
            cookie('ac_id',I('id'));
        }
        if(I('img_title')){
            $data['ac_id'] = cookie('ac_id');
            $num = M('activelun') -> where($data) -> count();
            if($num > 3){
                $this -> success('每个项目最多允许上传三张图片', U('Index/active_picture'),1);
                die;
            }
            $data['img_title'] = I('img_title');
            $path = active_upload('Lunbo','pic_path',false);
            $data['pic_path'] = $path['bg_img'];
            $res = M('activelun') -> add($data);
            if($res){
                $this -> success('图片上传成功', U('Index/active_picture'),1);
                die;
            }else{
                $this -> success('图片上传失败', U('Index/active_picture_add'),1);
                die;
            }
        }
        $this -> display();
    }
  
    /*活动列表*/
    public function active_list(){
		if(isset($_POST['active_name']))
		{
			$active_name=$_POST['active_name'];
			$filter="ac_title like '%$active_name%'";
			$list = M('active')->where($filter) -> order('sort_id')->select();
			$count = M('active')->where($filter) -> count();
		}
		else{
          $list = M('active') -> order('sort_id')->select();
		  $count = M('active') -> count();
		}
        foreach($list as $key=>$val){
        	/*报名人数*/
        	$entry_count=M('order')->where("ac_id=".$list[$key]['ac_id']." and status=1")->count();
        	$list[$key]['count']=$entry_count;
        	/*开通城市*/
        	$city_string="";
        	$namemodel=M('active_city')->where('ac_id='.(int)$list[$key]['ac_id'])->select();
        	foreach ($namemodel as $key1=>$val1)
        	{
        		$name=M('area')->where('areaid='.$namemodel[$key1]['city_id'])->field('name')->find();
        		$city_string.=$name['name'].",";
        	}
        	$len=strlen($city_string);
        	$city_string=mb_substr($city_string, 0,$len-1);//,'utf-8'
        	$list[$key]['city_string']=$city_string;
			$catemodel=M('active_category')->where('id='.$list[$key]['category_id'])->field('category_name')->find();
			$list[$key]['category'] =$catemodel['category_name'] ;
			$status=$list[$key]['status'];
			$type="";
			switch($status)
			{
				case 0:
			     	{
						$type="报名中";
					    $badge=0;
					}break; 
				case 5:
					{
						$type="尚无开启报名";
						$badge=0;
					}break;
				case 1:
				   {
					  $type="报名截止";
					  $badge=0;
				   }break; 
				case 2:
				{
					$type="活动进行中";
				    $badge=0;
				}
				break; 
				case 3:
				{
					$type="活动结束";
					//统计该活动未发放徽章的孩子个数
					$filter3['ac_id']=$list[$key]['ac_id'];
					$filter3['is_evalute']=0;
					$count=M('active_kids')->where($filter3)->count();
					if($count)//还有孩子未发放徽章
					{
						$badge=1;
					}
					else  //所有孩子都已发放徽章  （转点所在）
					{
						$data['status']=4;
						M('active')->where('ac_id='.$list[$key]['ac_id'])->save($data);
						$badge=0;
					}
				}break; 
				case 4:
				{
					$type="已发放徽章";
					$badge=0;
				}break; 
			}
			$list[$key]['status1']=$type;
			$list[$key]['badge']=$badge;
        }
        //var_dump($list);
        $this -> assign('list',$list);
		$this -> assign('count',$count);
        $this -> display();
    }

    /*开启报名*/
    public function open_enter()
    {
    	$filter['ac_id']=(int)$_GET['ac_id'];
    	$data['status']=0;
    	$res=M('active')->where($filter)->save($data);
    	if($res)
    	{
    		$this->success('活动开启成功',U('Active/active_list'),1);die();
    	}
    	else
    	{
    		$this->success('活动开启失败',U('Active/active_list'),1);die();
    	}
    }
    
    /*停止报名*/
    public function stop_enter()
    {
    	$ac_id=$_GET['ac_id'];
    	$data['status']=1;
    	$res=M('active')->where('ac_id='.$ac_id)->save($data);
    	if($res)
    	{
    		$this->success('活动关闭成功',U('Active/active_list'),1);die();
    	}
    	else
    	{
    		$this->success('活动关闭失败',U('Active/active_list'),1);die();
    	}
    }
    
    /*开启活动*/
    public function start_active()
    {
    	$filter['ac_id']=(int)$_GET['ac_id'];
    	$data['status']=2;
    	$res=M('active')->where($filter)->save($data);
    	if($res)
    	{
    		$this->success('活动开启成功',U('Active/active_list'),1);die();
    	}
    	else
    	{
    		$this->success('活动开启失败',U('Active/active_list'),1);die();
    	}
    }
    
    /*结束活动*/
    public function stop_active()
    {
    	$ac_id=$_GET['ac_id'];
    	$data['status']=3;
    	$res=M('active')->where('ac_id='.$ac_id)->save($data);
    	if($res)
    	{
    		$this->success('活动关闭成功',U('Active/active_list'),1);die();
    	}
    	else
    	{
    		$this->success('活动关闭失败',U('Active/active_list'),1);die();
    	}
    }
    
    /*活动修改*/
    public function active_update(){
		if($_SERVER['REQUEST_METHOD']=="GET")
		{
			$sql="parentid!=0 and state=1";
			$citylist = M('area')->where($sql) -> order('vieworder')->select();
			$this->assign('citylist',$citylist);
			$list=M('active_category')->select();
			$this->assign('list',$list);
			$ac_id=isset($_GET['ac_id'])?$_GET['ac_id']:0;
			$model=M('active')->where('ac_id='.$ac_id)->find();
			$model['ac_content']= $model['ac_content'];  
			$this->assign('model',$model);
			$this->assign('is_top',$model['is_top']);
			$this->assign('is_half_active',$model['is_half_active']);
			$this -> display();
		}
		else{
			$filter['ac_id']=(int)$_POST['ac_id'];
			if(!I('ac_title'))
			{
				$this->error('请输入活动标题');
				die();
			}
			if(!I('city_id'))
			{
				$this->error('请选择活动城市');
				die();
			}
			$data['ac_title'] = I('ac_title');
			$data['city_id_string'] = implode(',',$_POST['city_id']);
			$data['category_id'] = I('category');
			$data['lable'] = I('lable');
			$data['fit_age'] = I('fit_age');
			$data['ac_intro'] = I('ac_intro');
			$data['type'] = I('type');
			$data['is_half_active']=intval(I('is_half_active'));
			$data['after_partake_num']=I('after_partake_num');
			$data['after_half_time']=I('after_half_time');
			$data['morning_partake_num']=I('morning_partake_num');
			$data['morning_half_time']=I('morning_half_time');
			$data['is_top']=intval(I('is_top'));
			$data['sort_id']=intval(I('sort_id'));
			$data['recommend_reason']=I('recommend_reason');
			$data['ac_content'] = stripslashes(I('ac_content'));
            $model=M('active')->where($filter)->save($data);
			if($model>0)
			{
				M('active_city')->where('ac_id='.$_POST['ac_id'])->delete();
				/*添加城市*/
				$temparr= $_POST['city_id'];
				foreach ($temparr as $key=>$val)
				{
					$data1['ac_id']=(int)$_POST['ac_id'];
					$data1['city_id']=$temparr[$key];
					//$isexist=M('active_city')->where($data1)->count();
					//if($isexist==0){
					   $res=M('active_city')->add($data1);
					//}
				}
				$this -> success('修改成功', U('Active/active_list'),1);
			}
			else{
				$this -> error('修改失败', U('Active/active_list'),1);
			}
		}
    }

    /*活动添加*/
    public function active_add(){
		
		if($_SERVER['REQUEST_METHOD']=="GET")
		{
			$sql="parentid!=0 and state=1";
			$citylist = M('area')->where($sql) -> order('vieworder')->select();
			$this->assign('citylist',$citylist);
			$list=M('active_category')->select();
			$this->assign('list',$list);
			$this -> display();
		}
		else{
			$data['ac_title'] = I('ac_title');
			if(!isset($_POST['ac_title']))
			{
				$this->error('请填写活动标题');die;
			}
			if(!isset($_POST['city_id']))
			{
				$this->error('请选择活动城市');die;
			}
			//$data['partake_num'] = intval(I('partake_num'));
			$data['lable'] = I('lable');
			$data['fit_age'] = I('fit_age');
			$data['city_id_string'] = implode(',',$_POST['city_id']);
			$data['category_id'] = I('category');
			$data['view_addr'] = I('view_addr');
			$data['ac_intro'] = I('ac_intro');
			$data['type'] = I('type');
			$data['is_half_active']=I('is_half_active');
			$data['after_partake_num']=I('after_partake_num');
			$data['after_half_time']=I('after_half_time');
			$data['morning_partake_num']=I('morning_partake_num');
			$data['morning_half_time']=I('morning_half_time');
			$data['is_top']=I('is_top');
			$data['sort_id']=I('sort_id');
			$data['recommend_reason']=I('recommend_reason');
			$data['ac_content'] = stripslashes(I('ac_content'));
			$path = active_upload('Active','ac_img',true);
			$data['ac_img'] = json_encode($path);
			$res = M('active') -> add($data);
			if($res){
				/*添加活动的自由编辑行*/
				$add_content=$_POST['add_content'];
				if($add_content==1){
					$num=$_POST['num'];
					for($i=1;$i<=$num;$i++)
					{
						$content="content".$i;
						$temp=$_POST[$content];
						$contentdata['ac_id']=$res;
						$contentdata['content']=$temp;
						M('active_content')->add($contentdata);
					}
				}
				/*添加城市*/
				$temparr= $_POST['city_id'];
				foreach ($temparr as $key=>$val)
				{
					$data1['ac_id']=$res;
					$data1['city_id']=$temparr[$key];
					M('active_city')->add($data1);
				}
				$this -> success('添加成功', U('Active/active_list'),1);
				die;
			}else{
				$this -> success('添加失败', U('Active/active_add'),1);
				die;
			}
		}
    }

    /*活动删除*/
    public function active_del(){
        if(isset($_GET['ac_id']))
		{
            $data['ac_id'] = $_GET['ac_id'];
            $res = M('active') -> where($data) -> delete();
            if($res){
                $this -> success('删除成功', U('Active/active_list'),1);
                die;
            }else{
                $this -> success('删除失败', U('Active/active_list'),1);
                die;
            }
        }
		else{
			$this -> error('删除失败,请选择具体的活动!');
		}
    }

    public function picture_add(){
        if(I('img_title')){
            $data['img_title'] = I('img_title');
            $path = $this -> upload('Lunbo','pic_path',true);
            $data['pic_path'] = json_encode($path,true);
            $res = M('lun') -> add($data);
            if($res){
                $this -> success('图片上传成功', U('Index/picture_list'),1);
                die;
            }else{
                $this -> success('图片上传失败', U('Index/picture_add'),1);
                die;
            }
        }
        $this -> display();
    }

    public function picture_list(){
        $pic_list = M('lun') -> select();
        foreach($pic_list as $key=>$val){
            $img_path = json_decode($pic_list[$key]['pic_path'],true);
            $pic_list[$key]['pic_path'] = $img_path['sm_img'];
        }
        $this -> assign('list',$pic_list);

        $this -> display();
    }

}
