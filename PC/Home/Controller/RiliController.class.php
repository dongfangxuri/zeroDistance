<?php
namespace Home\Controller;
use Think\Controller;
class RiliController extends Controller {

	//日历首页
    public function index(){
		layout(false);
        $this -> display();
    }
	//选择日期
    public function chose_date(){

        if(I("ac_id")){
            session("meal_ac_id",I("ac_id"));
        }
		$filter['oid']=session('order_id');
		$data['me_id']=isset($_GET['id'])?$_GET['id']:0;
		$model=M('order')->where($filter)->save($data);
        $this -> display();
    }
    
    /*日历页面*/
    public function rili(){
    	
    	$ac_id=$_GET['ac_id'];
    	$this->assign('ac_id',$ac_id);
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
    
    public function calendar(){
		
        if(I('time')){

            $time = I('time');

            $list = M() -> query("select ac_id from ze_active where week(start_time)=week('".$time."')");
			
            $ar = array();
            foreach($list as $key=>$val){
                $ar[] = $val['ac_id'];
            }
            $map['ac_id'] = array('in',$ar);
            $list = M('active') -> where($map) -> select();
			$num = M('active') -> where($map) -> count();
			
			$current = intval(substr($time,-2));
			if($current < 10){
				$current = intval(substr($time,-1));
			}
			$shi = intval(substr($time,-2,-1));
			
			$ti = array();
			$star = $shi*10;
			$end = $shi*10+10;
			
			for($i = $star;$i < $end; ++$i){
				if($i > 31) break;
				
				$ar2['num'] = $i;
				$ar2['class'] = '';
				$ar2['num2'] = 0;
				
				if($i == $current){
					$ar2['class'] = "class='active'";
					$ar2['num2'] = $num;
				}
				
				$ti[] = $ar2;
			}
			
			$this -> assign("ti",$ti);
			
            $list = $this -> get_big($list);

            $this -> assign('list',$list);
        }
        $this -> display();
    }

    public function get_big($ac_list){

        foreach($ac_list as $key=>$val){
            $active_img = json_decode($ac_list[$key]['ac_img'],true);
            $ac_list[$key]['ac_img'] = $active_img['bg_img'];
        }
        return $ac_list;
    }

    function rand_time($a,$b)
    {
        $a=strtotime($a);
        $b=strtotime($b);
        return date( "Y-m-d H:m:s", mt_rand($a,$b));
    }
    
    /*活动搜索*/
    public function search()
    {
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
    	if(I('keyword')){
    		$keyword = I('keyword');
    		$ac_list = M() -> query("select * from ze_active where ac_title like'%".$keyword."%' or ac_content like'%".$keyword."%' or ac_intro like'%".$keyword."%' order by addTime desc");
    		var_dump($ac_list);exit;
    		if(!$ac_list){
    			$this -> assign("empty","暂无搜索结果");
    		}
    		$ac_list=$this->getActiveinfo($ac_list);
    		$this -> assign('list',$ac_list);
    	}
    	else if($_GET['date'])
    	{
    		$temp=explode('-', $_GET['date']);
    		if($temp[2]<10)
    		{
    			$temp[2]="0".$temp[2];
    		}
    		$string=implode('-', $temp);
    		$active_list=M('active')->select();
    		foreach ($active_list as $key=>$val)
    		{
    			$temptime=date('Y-m-d',strtotime($active_list[$key]['start_time']));
    			if($temptime==$string)
    			{
    				$temparray[]=$active_list[$key];
    			}
    		}
    		$temparray=getAvtiveInfo($temparray);
    		$this -> assign('list',$temparray);
    	}
        else 
        {
        	/*活动列表*/
        	$ac_list = M('active') ->order('addTime asc')-> select();
        	$ac_list=$this->getActiveinfo($ac_list);
        	$this -> assign('list',$ac_list);
        }
    	/*热点推荐*/
    	$re_list = M('active')->where('type=3') ->order('addTime asc')->limit(4)-> select();
    	$re_list=$this->getActiveinfo($re_list);
    	$this -> assign('re_list',$re_list);
    	$this->display('activitycalendar');
    }
    
    /*活动日历*/
    public function activitycalendar()
    {
    	/*活动列表*/
    	$ac_list = M('active') ->order('addTime asc')-> select();
    	$ac_list=$this->getActiveinfo($ac_list);
    	$this -> assign('list',$ac_list);
    	/*热点推荐*/
    	$re_list = M('active')->where('type=3') ->order('addTime asc')->limit(4)-> select();
    	$re_list=$this->getActiveinfo($re_list);
    	$this -> assign('re_list',$re_list);
    	$this->display();
    }
    /*某个活动的活动日历*/
    public function jsonReturn(){
    	$ac_id=$_GET['ac_id'];
    	$res = M('active') ->where('ac_id='.$ac_id)-> field('ac_id,start_time as Date,0 as Price,partake_num as state') -> select();
    	foreach($res as $key=>$val){
    		$time = $val['Date'];
    		$time = strtotime($time);
    		$time = date('Y-m-d',$time);
    		$res[$key]['Date'] = $time;
    		$entry_count=M('order')->where("ac_id=".$res[$key]['ac_id']." and status=1")->count();
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
        $list = M('active') -> field('0 as single_price,start_time') -> find();
        //$time1 = date("Y-m-d",strtotime("+1 day",strtotime($list['start_time'])));
//         $al = array();
//         $li = $list['start_time'];
//         for($i = 0; $i < 7; ++$i){
//             $li = date("Y-m-d",strtotime("+1 day",strtotime($li)));
//             $ar['Date'] = $li;
//             $ar['Price'] = $list['single_price'];
//             $ar['state'] = '充足';
//             $al[] = $ar;
//         }
        echo json_encode($list,true);
    }
    
    /* 获取活动详细信息*/
    private function getActiveinfo($qinzilist,$small=false) {
    	foreach ($qinzilist as $key=>$val)
		 {
		 	/*截断标题*/ 
		 	if(strlen($qinzilist[$key]['ac_title'])>18)
		 	{
		 	  $qinzilist[$key]['ac_title']=mb_substr($qinzilist[$key]['ac_title'],0, 18,'UTF-8')."......";
		 	}
		 	/*活动图片*/
		 	$temp=json_decode($qinzilist[$key]['ac_img'],true);
		 	
		 	$qinzilist[$key]['ac_img']=$temp['sm_img'];
		 	//var_dump($temp['sm_img']);exit();
			/*最低价格*/
			$normalleastprice=M('meal')->where('ac_id='.$qinzilist[$key]['ac_id'])->field('price')->select();
			sort($normalleastprice);
			$weekleastprice=M('meal')->where('ac_id='.$qinzilist[$key]['ac_id'])->field('week_price')->select();
			sort($weekleastprice);
			$leastprice=min($normalleastprice[0]['price'],$weekleastprice[0]['week_price']);
			$qinzilist[$key]['single_price']=$leastprice;
			/*报名人数*/
			$entry_count=M('order')->where("ac_id=".$qinzilist[$key]['ac_id']." and status=1")->count();
			$qinzilist[$key]['count']=$entry_count;
			/*活动天数*/
			$time=(strtotime($qinzilist[$key]['end_time'])-strtotime($qinzilist[$key]['start_time']))/(3600*24);
			$time=ceil($time);
			$qinzilist[$key]['time']=$time;
			/*活动月份*/
			$starttime=date("Y-m-d",strtotime($qinzilist[$key]['start_time']));
			$starttime=explode('-', $starttime);
			$endtime=date("Y-m-d",strtotime($qinzilist[$key]['end_time']));
			$endtime=explode('-', $endtime);
			$sub=(int)$endtime[1]-(int)$starttime[1];
			if($sub==0)
			{
				$qinzilist[$key]['during']=(int)$starttime[1];
			}
			else{
				$qinzilist[$key]['during']=(int)$starttime[1]."-".(int)$endtime[1]."";
			}
		 }
		 return $qinzilist;
    }
}