<?php

/*获取活动详细信息*/
   function getAvtiveInfo($qinzilist) {
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
   
   function getActiveInfo1($filter_unpay_list) {
	foreach($filter_unpay_list as $key=>$val){
		/*时间*/
		$startdate1=date('Y/m/d ',strtotime($filter_unpay_list[$key]['start_time']));
		$filter_unpay_list[$key]['start_time1']=$startdate1.$filter_unpay_list[$key]['start_hour'];
		$startdate2=date('m/d ',strtotime($filter_unpay_list[$key]['start_time']));
		$filter_unpay_list[$key]['start_time2']=$startdate2.$filter_unpay_list[$key]['start_hour'];
		$enddate=date('m/d ',strtotime($filter_unpay_list[$key]['end_time']));
		$filter_unpay_list[$key]['end_time']=$enddate.$filter_unpay_list[$key]['end_hour'];
		/*标题*/
		if(strlen($filter_unpay_list[$key]['ac_title'])>20)
		{
			$filter_unpay_list[$key]['ac_title']=mb_substr($filter_unpay_list[$key]['ac_title'], 0,20,'utf-8');
		}
		/*图片*/
		$active_img = json_decode($filter_unpay_list[$key]['ac_img'],true);
		$filter_unpay_list[$key]['pic'] = $active_img['sm_img'];
		/*统计大人儿童数量*/
		$array=explode(',', $filter_unpay_list[$key]['meal_string']);
		$filter_unpay_list[$key]['meal_str']="";
		foreach ($array as $ke=>$val)
		{
			$temp=M('meal')->where('id='.$array[$ke])->field('type_id')->find();
			$id=(int)$temp;
			$meal_name=M('mealtype')->where('id='.$id)->field('title')->find();
			$person+=(int)substr($meal_name['title'], 0,1);
			$child+=(int)substr($meal_name['title'], 3,1);
		}
		$filter_unpay_list[$key]['meal_str'].=$person."成人".$child."儿童";
	}
	return $filter_unpay_list;
}

   /*获取活动详细信息*/
   function getAvtiveInfo2($qinzilist) {
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
   /*分页*/
   function getpage($count, $pagesize = 5) {
	$p = new Think\Page($count, $pagesize);
	$p->setConfig('header', '<li class="rows">共<b>%TOTAL_ROW%</b>条记录&nbsp;第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页</li>');
	$p->setConfig('prev', '上一页');
	$p->setConfig('next', '下一页');
	$p->setConfig('last', '末页');
	$p->setConfig('first', '首页');
	$p->setConfig('theme', '%FIRST%%UP_PAGE%%LINK_PAGE%%DOWN_PAGE%%END%%HEADER%');
	$p->lastSuffix = false;//最后一页不显示为总页数
	return $p;
}