<?php
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

/*计算某个活动的最低价格*/
/*当活动的某个套餐未设置价格时会导致最低价格为null*/
function getleastprice($id)
{
	$meallist=M('active_meal')->where('ac_id='.$id)->select(); //查询该活动的所有套餐
	$tempmodel1=M('active_meal_time')->where('me_id='.$meallist[0]['id'])->field('id')->find();	
	$tempmodel2=M('active_meal_price')->where('time_id='.$tempmodel1['id'])->field('price')->find();
	$leastprice=$tempmodel2['price'];
	
	foreach ($meallist as $key1=>$val1)
	{
		//查询某个套餐下的最低价格
		$tempmodel3=M('active_meal_time')->where('me_id='.$meallist[$key1]['id'])->field('id')->select();//查询套餐所有时间
		
		foreach ($tempmodel3 as $key2=>$val2)
		{
			$tempmodel4=M('active_meal_price')->where('time_id='.$tempmodel3[$key2]['id'])->field('price')->select();
			sort($tempmodel4);
			if($tempmodel4[0]['price']<$leastprice&&$tempmodel4[0]['price']>=0)
			{
				$leastprice=$tempmodel4[0]['price'];
			}
		}
	}
	return $leastprice;
}

/*获取活动详细信息*/
function getActiveinfo($qinzilist,$small=false) {
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
		$qinzilist[$key]['least_price']=getleastprice($qinzilist[$key]['ac_id']);
		/*活动报名人数*/
		$entry_count=M('order')->where("ac_id=".$qinzilist[$key]['ac_id']." and status=1")->count();
		$qinzilist[$key]['count']=$entry_count;
		/*截断标题、简介*/
		if(strlen($qinzilist[$key]['ac_title'])>35)
		{
			$qinzilist[$key]['ac_title']=mb_substr($qinzilist[$key]['ac_title'],0,35,'utf-8')."...";
		}
		if(strlen($qinzilist[$key]['ac_intro'])>35)
		{
			$qinzilist[$key]['ac_intro']=mb_substr($qinzilist[$key]['ac_intro'],0,35,'utf-8')."...";
		}
	}
	return $qinzilist;
}

/*获得小图*/
function get_small($ac_list){

	foreach($ac_list as $key=>$val){
		$active_img = json_decode($ac_list[$key]['ac_img'],true);
		$ac_list[$key]['ac_img'] = $active_img['sm_img'];
		$ac_list[$key]['ac_content'] = stripslashes($ac_list[$key]['ac_content']);
	}
	return $ac_list;
}

/*获取大图*/
function get_big($ac_list){

	foreach($ac_list as $key=>$val){
		$active_img = json_decode($ac_list[$key]['ac_img'],true);
		$ac_list[$key]['ac_img'] = $active_img['bg_img'];
	}
	return $ac_list;
}

/*时间格式转换*/
function time2string($second){
	$day = floor($second/(3600*24));
	$second = $second%(3600*24);//除去整天之后剩余的时间
	$hour = floor($second/3600);
	$second = $second%3600;//除去整小时之后剩余的时间
	$minute = floor($second/60);
	$second = $second%60;//除去整分钟之后剩余的时间
	//返回字符串
	return $day.'天'.$hour.'小时'.$minute.'分';
}

/*日期插件时间格式转换*/
function timetospan($timestring)
{
	
}

/*普通文件上传*/
function upload($path,$file_name,$is_small){

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

/*活动图片上传*/
function active_upload($path,$file_name,$is_small)
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
	} else {
		if($is_small){
			 
			$image = new \Think\Image();
			$image->open($upload->rootPath . $info[$file_name]['savepath'] . $info[$file_name]['savename']);
			//将图片裁剪为400x400并保存为corp.jpg
			$image->thumb(150, 150)->save($upload->rootPath . $info[$file_name]['savepath'] . 'sm_' . $info[$file_name]['savename']);
			$arr['sm_img'] = 'Uploads/' . $info[$file_name]['savepath'] . 'sm_' . $info[$file_name]['savename'];
			$image->open( $arr['sm_img'] )->text('零距离童军','data/1.otf',3,'#EE0000',\Think\Image::IMAGE_WATER_SOUTHWEST)->save( $arr['sm_img'] );
		}
		$arr['bg_img'] = 'Uploads/' . $info[$file_name]['savepath'] . $info[$file_name]['savename'];
		$image->open( $arr['bg_img'] )->text('零距离童军','data/1.otf',3,'#EE0000',\Think\Image::IMAGE_WATER_SOUTHWEST)->save( $arr['bg_img'] );
		return $arr;
	}
}
?>