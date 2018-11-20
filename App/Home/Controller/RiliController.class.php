<?php
namespace Home\Controller;
use Think\Controller;
class RiliController extends Controller {

	//日历首页
    public function index(){
		layout(false);
        $this -> display();
    }
    
    /*日历页面*/
    public function rili(){
    	
    	$me_id=$_GET['id'];
    	$this->assign('id',$me_id);
        $this -> display();
    }
 
	public function test()
    {
    	$res = M('active') -> field('start_time as Date,partake_num as Price,ac_id') -> select();
    	foreach($res as $key=>$val){
            $time=date('Y-m-d',strtotime($res[$key]['Date']));
    		$res[$key]['Date'] = $time;
    		$res[$key]['Price']='1';
    		$order_active=M('active')->where('ac_id!='.$res[$key]['ac_id'])->select();//
    		foreach ($order_active as $key1=>$val1)
    		{
    			$temptime = date('Y-m-d',strtotime($order_active[$key1]['start_time']));
    			if($temptime==$time)
    			{
    				//查询出当前记录的ac_id 根据这个ac_id找到res数组中对应的记录
    				$ac_id=$order_active[$key1]['ac_id'];
    				foreach ($res as $key2=>$val)
    				{
    					if($res[$key2]['ac_id']==$ac_id)
    					{
    						unset($res[$key2]);
    					}
    				}
    				$temp=(int)$res[$key]['Price'];
    				$temp+=1;
    				$res[$key]['Price']=$temp."";
    			} 
    		}
    		$tempactive[$key]['Date']=$res[$key]['Date'];
    		$tempactive[$key]['Price']=$res[$key]['Price'];
    		unset($res[$key]);
    	}
    	//var_dump($tempactive);exit;
    	//var_dump($res);exit;
    	echo json_encode($tempactive,true);
    }
   
    /*活动日历*/
    public function activitycalendar()
    {
    	$this->display();
    }

    /*某个活动的活动日历*/
    public function jsonReturn(){
    	
    	$id=$_GET['id'];
    	$res = M('active_meal_time') ->where('me_id='.$id)-> field('id,start_time as Date,0 as Price,join_num as state') -> select();
    	foreach($res as $key=>$val){
    		$time = $val['Date'];
    		$time = strtotime($time);
    		$time = date('Y-m-d',$time);
    		$res[$key]['Date'] = $time;
    		$entry_count=M('order')->where("time_id=".$res[$key]['id']."and me_id=".$id." and status=1")->count();
    		$total_num=$res[$key]['state'];
    		$state=$entry_count/$total_num;
    		$tmp="";
    		if($state<0.5)
    		{
    			$tmp="充足";
    		}
    		elseif($state==1)
    		{
    			$tmp="截止";
    		}
    		else 
    			$tmp="紧张";
    		$res[$key]['state']=$tmp;
    	}
    	echo json_encode($res,true);
    }
   
    /*活动日历*/
    public function jsonReturn2(){
    	$res = M('active_meal_time')-> field('id,start_time as Date,join_num as Price') -> select();
     	//$res = M('active') -> field('start_time as Date,partake_num as Price,ac_id') -> select();
    	foreach($res as $key=>$val){
            $time=date('Y-m-d',strtotime($res[$key]['Date']));
    		$res[$key]['Date'] = $time;
    		$res[$key]['Price']='1';
    		$order_active=M('active_meal_time')->where('id!='.$res[$key]['id'])->select();//
    		foreach ($order_active as $key1=>$val1)
    		{
    			$temptime = date('Y-m-d',strtotime($order_active[$key1]['start_time']));
    			if($temptime==$time)
    			{
    				//查询出当前记录的ac_id 根据这个ac_id找到res数组中对应的记录
    				$ac_id=$order_active[$key1]['id'];
    				foreach ($res as $key2=>$val)
    				{
    					if($res[$key2]['id']==$ac_id)
    					{
    						unset($res[$key2]);
    					}
    				}
    				$temp=(int)$res[$key]['Price'];
    				$temp+=1;
    				$res[$key]['Price']=$temp."";
    			} 
    		}
    		$tempactive[$key]['Date']=$res[$key]['Date'];
    		$tempactive[$key]['Price']=$res[$key]['Price'];
    		unset($res[$key]);
    	}
    	//var_dump($tempactive);exit;
    	//var_dump($res);exit;
    	echo json_encode($tempactive,true);
    }
}