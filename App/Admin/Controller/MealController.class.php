<?php
namespace Admin\Controller;

class MealController extends AdminBaseController {

    public function index(){
        $this -> assign('username',session('username'));
        $this -> display();
    }
	
    /*套餐类型列表*/
	public function meal_type_list()
	{
		if($_SERVER['REQUEST_METHOD']=="POST")
		{
			$meal_name=$_POST['meal_name'];
			$list=M('mealtype')->where("title like '%".$meal_name."%'")->select();
			$count=M('mealtype')->where("title like '%".$meal_name."%'")->count();
		}
		else{
			$count=M('mealtype')->count();
			$list=M('mealtype')->select();
		}
		$this->assign('count',$count);
		$this->assign('list',$list);
		$this->display();
	}
	
	/*套餐类型添加*/
	public function meal_type_add()
	{
		if($_SERVER['REQUEST_METHOD']=="GET")
		{
			$this->display();
		}
		else{
			$parent=$_POST['type_parent'];
			$child=$_POST['type_child'];
			if($parent<=0&&$child<=0)
			{
				$this->error('数量选择有误',U('Meal/meal_type_add'),1);
				die();
			}
			if($parent==0)
			{
				$title=$child."儿童";
			}
			else if($child==0)
			{
				$title=$parent."成人";
			}
			else
			{
			  $title=$parent."成人".$child."儿童";
			}
			$model=M('mealtype')->where("title ='".$title."'")->select();
			if($model)
			{
				$this->error('此类套餐已存在',U('Meal/meal_type_add'),1);
			}
			$data['title']=$title;
			$count=M('mealtype')->add($data);
			if($count>0)
			{
				$this->success('套餐添加成功',U('Meal/meal_type_list'),1);
			}
			else{
				$this->error('套餐添加失败',U('Meal/meal_type_list'),1);
			}
		}
	}

	/*套餐类型删除*/
    public function meal_type_delete()
	{
		$id=$_GET['id'];
		$data['id']=$id;
		$count=M('mealtype')->where($data)->delete();
		if($count>0)
		{
			$this->success('删除成功',U('Meal/meal_type_list'),1);
		}
		else{
			$this->success('删除失败',U('Meal/meal_type_list'),1);
		}
	}
	
	/*套餐类型修改*/
	public function meal_type_update()
	{
		if($_SERVER['REQUEST_METHOD']=="GET")
		{
			$id=$_GET['id'];
			$data['id']=$id;
			$model=M('mealtype')->where($data)->select();
			$this->assign('model',$model);
			$this->display();
		}
		else{
			$id=$_POST['id'];
			$parent=$_POST['type_parent'];
			$child=$_POST['type_child'];
			if($parent<=0&&$child<=0)
			{
				$this->error('数量选择有误',U('Meal/meal_type_add'),1);
				die();
			}
			$title=$parent."成人".$child."儿童";
			$model=M('mealtype')->where("title ='".$title."'")->select();
			if($model)
			{
				$this->error('此类套餐已存在',U('Meal/meal_type_add'),1);
			}
			$filter['id']=$id;
			$data['title']=$title;
			$count=M('mealtype')->where($filter)->save($data);
			if($count>0)
			{
				$this->success('修改成功',U('Meal/meal_type_list'),1);
			}
			else{
				$this->error('修改失败',U('Meal/meal_type_list'),1);
			}
		}
	}
	
	/*活动套餐列表*/
    public function meal_list(){
		if($_SERVER['REQUEST_METHOD']=="POST")
		{
			$title_name=$_POST['title'];
			$count=M()->query("select count(*) as count from ze_active_meal as m left join ze_active as a on a.ac_id=m.ac_id where a.ac_title like '%".$title_name."%'");
			$count=$count[0]['count'];	
			$list=M()->query("select * from ze_active_meal as m left join ze_active as a on a.ac_id=m.ac_id where a.ac_title like '%".$title_name."%'");
		}
		else{
			$count=M()->query("select count(*) as count from ze_active_meal as m left join ze_active as a on a.ac_id=m.ac_id");
			$count=$count[0]['count'];
			$list=M()->query("select * from ze_active_meal as m left join ze_active as a on a.ac_id=m.ac_id");
		}
		foreach($list as $key=>$val)
		{
			$count=M('order')->where('me_id='.$list[$key]['id']." and status=1")->count();
			$list[$key]['join_num']=$count;
		}
        $this -> assign('list',$list);
		$this -> assign('count',$count);
        $this -> display();
    }
	
    /*活动套餐添加*/
    public function meal_add(){
		if($_SERVER['REQUEST_METHOD']=="GET")
		{	
           $this -> display();
		}
		else{
			$data['ac_id'] = I('ac_id');
            $data['me_info'] = I('me_info');
            $data['me_title'] = I('me_title');
            $res1=M('active_meal')->where($data)->count();
            if($res1)
            {
            	$this -> error('该活动套餐已存在');die;
            }
            $res = M('active_meal') -> add($data);
            if($res){
                $this -> success('活动套餐添加成功', U('Meal/meal_list'),1);
                die;
            }else{
                $this -> success('活动套餐添加失败', U('Meal/meal_add'),1);
                die;
            }
		}
    }
    
    /*活动套餐修改*/
	public function meal_update()
	{
		if($_SERVER['REQUEST_METHOD']=="GET")
		{
			$id=$_GET['id'];
			$data['id']=$id;
			$model=M('active_meal')->where($data)->find();
			$this->assign('model',$model);
			$this->display();
		}
		else{
			$filter['id']=$_POST['id'];
			$data['ac_id'] = I('ac_id');
			//$data['join_num'] = I('join_num');
			$data['me_info'] = I('me_info');
			$data['me_title'] = I('me_title');
			$res = M('active_meal') ->where($filter)->save($data);
			if($res){
				$this -> success('活动套餐修改成功', U('Meal/meal_list'),1);
				die;
			}else{
				$this -> success('活动套餐修改失败', U('Meal/meal_add'),1);
				die;
			}
		}
	}
	
	/*活动套餐删除*/
	public function meal_del()
	{
		$id=$_GET['id'];
		$data['id']=$id;
		$count=M('active_meal')->where($data)->delete();
		if($count>0)
		{
			$this->success('删除成功',U('Meal/meal_list'),1);
		}
		else{
			$this->error('删除失败',U('Meal/meal_list'),1);
		}
	}
 
	/*活动套餐时间列表*/
	public function mealtime_list()
	{
		$id=$_GET['id'];
		$list=M('active_meal_time')->where('me_id='.$id)->select();
		$count=M('active_meal_time')->where('me_id='.$id)->count();
		$this->assign('list',$list);
		$this->assign('count',$count);
		$this->assign('me_id',$id);
		$this->display();
	}
	
	/*活动套餐时间设置*/
	public function mealtime_add()
	{
		if($_SERVER['REQUEST_METHOD']=="GET")
		{
			$me_id=$_GET['me_id'];
			$this->assign('me_id',$me_id);
			$this->display();
		}
		else {
			$data['me_id']=$_POST['me_id'];
			$data['start_time'] = I('start_time');
			$data['start_hour'] = I('start_hour');
			$data['end_time'] = I('end_time');
			$data['end_hour'] = I('end_hour');
			$data['join_num'] = I('join_num');
			$res=M('active_meal_time')->where($data)->count();
			if($res)
			{
				$this->success('已存在该项套餐，请重新添加，或在套餐列表中修改',U('/Admin/Meal/mealtime_list/id/'.I('me_id')),1);
				die;
			}
			$res2=M('active_meal_time')->add($data);
			if($res2){
			   $this->success('添加成功',U('/Admin/Meal/mealtime_list/id/'.I('me_id')),1);
			   die;
			}
			else
			{
				$this->success('添加失败',U('/Admin/Meal/mealtime_list/id/'.I('me_id')),1);
				die;
			}
		}
	}
	
	/*活动套餐时间修改*/
	public function mealtime_update()
	{
	
	}
	
	/*活动套餐时间删除*/
	public function mealtime_delete()
	{
		$id=$_GET['id'];
		$meid=M('active_meal_time')->where('id='.$id)->field('me_id')->find();
		$data['id']=$id;
		$count=M('active_meal_time')->where($data)->delete();
		if($count>0)
		{
			$this->success('删除成功',U('/Admin/Meal/mealtime_list/id/'.$meid['me_id']),1);
		}
		else{
			$this->success('删除失败',U('/Admin/Meal/mealtime_list/id/'.$meid['me_id']),1);
		}
	}
	
	/*活动套餐价格列表*/
	public function mealprice_list()
	{
		$id=$_GET['id'];
		$data['time_id']=$id;
		$list=M()->query('select m.id,a.start_time,a.end_time,m.price,t.title from ze_active_meal_price as m left join ze_mealtype as t on m.type_id=t.id left join ze_active_meal_time as a on a.id=m.time_id where m.time_id='.$id);
		$count=M('active_meal_price')->where($data)->count();
		$this->assign('list',$list);
		$this->assign('count',$count);
		$this->assign('time_id',$id);
		$this->display();
	}
	
	/*活动套餐价格设置*/
	public function mealprice_add()
	{
		if($_SERVER['REQUEST_METHOD']=="GET")
		{
			$time_id=$_GET['id'];
			$list=M('mealtype')->select();
			$this->assign('list',$list);
			$this->assign('time_id',$time_id);
			$this -> display();
		}
		else{
			$data['time_id']=I('time_id');
			$data['type_id']=I('type_id');
			$check=M('active_meal_price')->where($data)->count();
			if($check)
			{
				$this->success('已存在该项套餐，请重新添加，或在套餐列表中修改',U('/Admin/Meal/mealprice_list/id/'.I('time_id')),1);
				die;
			}
			else {
				$data['price']=I('price');
				$res=M('active_meal_price')->add($data);
				if($res)
				{
					$this->success('添加成功',U('/Admin/Meal/mealprice_list/id/'.I('time_id')),1);
					die;
				}
				else
				{
					$this->success('添加失败',U('/Admin/Meal/mealprice_list/id/'.I('time_id')),1);
					die;
				}
			}
		}
	}
	
	/*活动套餐价格修改*/
	public function mealprice_update()
	{
		if($_SERVER['REQUEST_METHOD']=="GET")
		{
			$id=$_GET['id'];
			$model=M('active')->where('id='.$id)->find();
			$this->assign('model',$model);
			$this->assign('id',$id);
			$this->display();
		}
		else
		{
			$filter['id']=$_POST['id'];
			$timeid=M('active_meal_price')->where($filter)->field('time_id')->find();
			$data['type_id']=I('type_id');
			$data['price']=I('price');
			$check=M('active_meal_price')->where($data)->count();
			if($check)
			{
				$this->success('已存在该项套餐，请重新添加，或在套餐列表中修改',U('/Admin/Meal/mealprice_list/id/'.$timeid['time_id']),1);
				die;
			}
			else {
				$res=M('active_meal_price')->where($filter)->save($data);
				if($res)
				{
					$this->success('修改成功',U('/Admin/Meal/mealprice_list/id/'.$timeid['time_id']),1);
					die;
				}
				else
				{
					$this->success('修改失败',U('/Admin/Meal/mealprice_list/id/'.$timeid['time_id']),1);
					die;
				}
			}
		}
	}

	/*活动套餐价格删除*/
	public function mealprice_delete()
	{
		$id=$_GET['id'];
		$timeid=M('active_meal_price')->where('id='.$id)->field('time_id')->find();
		$data['id']=$id;
		$count=M('active_meal_price')->where($data)->delete();
		if($count>0)
		{
			$this->success('删除成功',U('/Admin/Meal/mealprice_list/id/'.$timeid['time_id']),1);
		}
		else{
			$this->success('删除失败',U('/Admin/Meal/mealprice_list/id/'.$timeid['time_id']),1);
		}
	}

	/*徽章列表*/
	public function badge_list()
	{
		$id=(int)$_GET['id'];
		$filter1['id']=$id;
		$model=M('active_meal')->where($filter1)->find();
		$ac_id=$model['ac_id'];
		$filter2['ac_id']=$ac_id;
		$kidactivelist=M('active_kids')->where($filter2)->select();
		foreach ($kidactivelist as $key=>$val)
		{
			$oid=$kidactivelist[$key]['oid'];
			$state=M('order')->where('oid='.$oid)->field('status')->find();
			//0 待支付 1未出行 4 订单取消
			if($state['status']==1 || $state['status']==0 ||$state['status']==4)//只对已完成的订单发放徽章
			{
				unset($kidactivelist[$key]);
			}
			else {
				$kidmodel[] = M()->table('ze_active_kids as a')->join('ze_kids as k on a.kid=k.id')->join('ze_order as o on o.oid=a.oid')->where('a.kid='.$kidactivelist[$key]['kid']." and me_id=".$id)->field('a.id,a.is_evalute,o.order_sn,k.name,k.sex,k.addr,k.header_img')->find();
			}
		}
		foreach ($kidmodel as $key=>$val)
		{
			if($kidmodel[$key]['sex']==1)
			{
				$kidmodel[$key]['sex']='男';
			}
			else if($kidmodel[$key]['sex']==2){
				$kidmodel[$key]['sex']='女';
			}
		}
		//var_dump($kidmodel);exit;
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
			$id=$_GET['id'];		
			$this->assign('id',$id);
			$this->display();
		}
		else
		{
			/*增加每个孩子的徽章个数*/
			$filter1['id']=$_POST['id'];
			$active_kidsmodel=M('active_kids')->where($filter1)->field('kid')->find();
			$filter2['id']=$active_kidsmodel['kid'];
			$kidmodel=M('kids')->where($filter2)->field('badge_number')->find();
			$badge_number=$kidmodel['badge_number'];
			$badge_number=$badge_number+1;
			$data1['badge_number']=$badge_number;
			$res1=M('kids')->where($filter2)->save($data1);			
			if($res1){
				/*为每个孩子编写活动评论*/
				$data['group_name']=$_POST['group_name'];
				$data['group_slogan']=$_POST['group_slogan'];
				$data['group_role']=$_POST['group_role'];
				$data['active_evalute']=$_POST['active_evalute'];
				$data['is_evalute']=1;
				$res=M('active_kids')->where($filter1)->save($data);
				if($res)
				{
					$this->success('徽章发放成功',U("/Admin/Meal/badge_list"),1);
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
}
