<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
<!--[if lt IE 9]>
<script type="text/javascript" src="/Public/lib/html5.js"></script>
<script type="text/javascript" src="/Public/lib/respond.min.js"></script>
<script type="text/javascript" src="/Public/lib/PIE_IE678.js"></script>
<![endif]-->
<link rel="stylesheet" type="text/css" href="/Public/static/h-ui/css/H-ui.min.css" />
<link rel="stylesheet" type="text/css" href="/Public/static/h-ui.admin/css/H-ui.admin.css" />
<link rel="stylesheet" type="text/css" href="/Public/lib/Hui-iconfont/1.0.7/iconfont.css" />
<link rel="stylesheet" type="text/css" href="/Public/lib/icheck/icheck.css" />
<link rel="stylesheet" type="text/css" href="/Public/static/h-ui.admin/skin/default/skin.css" id="skin" />
<link rel="stylesheet" type="text/css" href="/Public/static/h-ui.admin/css/style.css" />
<!--[if IE 6]>
<script type="text/javascript" src="http://lib.h-ui.net/DD_belatedPNG_0.0.8a-min.js" ></script>
<script>DD_belatedPNG.fix('*');</script>
<![endif]-->
<title>活动列表</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 活动管理 <span class="c-gray en">&gt;</span> 活动列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
	<div class="text-c">
<!--     	<span class="select-box inline">
		<select name="" class="select">
			<option value="0">全部分类</option>
			<option value="1">分类一</option>
			<option value="2">分类二</option>
		</select>
		</span> -->
        <form method="post" action ="<?php echo U('/Admin/Active/active_list');?>">
		<input type="text" name="active_name" id="" placeholder=" 活动标题" style="width:250px" class="input-text">
		<button name="" id="" class="btn btn-success" type="submit"><i class="Hui-iconfont">&#xe665;</i> 搜活动</button>
		</form>
	</div>
	<div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l">
<!-- 	  <a href="javascript:;" onclick="datadel()" class="btn btn-danger radius">
	    <i class="Hui-iconfont">&#xe6e2;</i> 批量删除
	  </a>  -->
	  <a class="btn btn-primary radius" data-title="添加活动" _href="<?php echo U('/Admin/Active/active_add');?>" onclick="Hui_admin_tab(this)" href="javascript:;">
	  <i class="Hui-iconfont">&#xe600;</i> 添加活动
	  </a></span> 
	  <span class="r">共有数据：<strong><?php echo ($count); ?></strong> 条</span> </div>
	<div class="mt-20">
		<table class="table table-border table-bordered table-bg table-hover table-sort">
			<thead>
				<tr class="text-c">
					<th width="10"><input type="checkbox" name="" value=""></th>
					<th width="100">活动编号</th>
					<th width="100">活动标题</th>
					<th width="100">活动标签</th>
					<th width="100">活动分类</th>
					<th width="150">发布时间</th>
					<!-- <th width="50">总人数</th>
					<th width="60">已报名人数</th>  -->
					<th width="100">活动城市</th>
				    <th width="120">活动状态</th>
					<th width="120">操作</th>
				</tr>
			</thead>
			<tbody>
			<?php if(is_array($list)): foreach($list as $key=>$vo): ?><tr class="text-c">
					<td><input type="checkbox" value="<?php echo ($vo["ac_id"]); ?>" name="ac_id"></td>
					<td><?php echo ($vo["ac_id"]); ?></td>
					<td class="text-l"><?php echo ($vo["ac_title"]); ?></td>
					<td><?php echo ($vo["lable"]); ?></td>
					<td><?php echo ($vo["category"]); ?></td>
					<td><?php echo ($vo["addTime"]); ?></td>
					<!-- <td><?php echo ($vo["partake_num"]); ?></td>
					<td><?php echo ($vo["count"]); ?></td>  -->
					<td class="td-status"><span class="label label-success radius"><?php echo ($vo["city_string"]); ?></span></td>
					<td><?php echo ($vo["status1"]); ?>
					<br/>
					<?php if($vo["badge"] == 1): ?><a href="/Admin/Active/badge_list/ac_id/<?php echo ($vo["ac_id"]); ?>"><span class="c-red">发放徽章</span></a>
					  <?php else: endif; ?>
					</td> 
					
					<td class="td-manage"> 
					  <?php if($vo["status"] == 5): ?><!-- 活动禁止报名中 -->
					    <a style="text-decoration:none" onClick="return confirm('确认可以开始报名吗？');" href="/Admin/Active/open_enter/ac_id/<?php echo ($vo["ac_id"]); ?>" title="开始报名"><i class="Hui-iconfont">&#xe615;</i></a>
					  <!-- 活动报名中 -->     
					  <?php elseif($vo["status"] == 0): ?>  
					      <a style="text-decoration:none" onClick="return confirm('确认要停止报名吗？');" href="/Admin/Active/stop_enter/ac_id/<?php echo ($vo["ac_id"]); ?>" title="停止报名"><i class="Hui-iconfont">&#xe615;</i></a>
					  <!-- 活动报名结束 -->
					  <?php elseif($vo["status"] == 1): ?> 
					     <!-- <a style="text-decoration:none" onClick="return confirm('确认可以开始活动吗？');" href="/Admin/Active/start_active/ac_id/<?php echo ($vo["ac_id"]); ?>" title="开始活动" ><i class="Hui-iconfont">&#xe631;</i></a> -->
					   <!-- 活动进行中 -->
					  <?php elseif($vo["status"] == 2): ?> 
					    <!--  <a style="text-decoration:none" onClick="return confirm('确认要停止活动吗？');" href="/Admin/Active/stop_active/ac_id/<?php echo ($vo["ac_id"]); ?>" title="停止活动" ><i class="Hui-iconfont">&#xe631;</i></a> --><?php endif; ?> 
					<a style="text-decoration:none" class="ml-5" onClick="article_edit('活动编辑','/Admin/Active/active_update/ac_id/<?php echo ($vo["ac_id"]); ?>','<?php echo ($vo["ac_id"]); ?>')" href="/Admin/Active/active_update/ac_id/<?php echo ($vo["ac_id"]); ?>" title="编辑"><i class="Hui-iconfont">&#xe6df;</i></a> 
					<a style="text-decoration:none" class="ml-5" onClick="return confirm('确认删除此项活动吗?');" href="/Admin/Active/active_del/ac_id/<?php echo ($vo["ac_id"]); ?>" title="删除"><i class="Hui-iconfont">&#xe6e2;</i></a></td>
				</tr><?php endforeach; endif; ?>
			</tbody>
		</table>
	</div>
</div>
<script type="text/javascript" src="/Public/lib/jquery/1.9.1/jquery.min.js"></script> 
<script type="text/javascript" src="/Public/lib/layer/2.1/layer.js"></script> 
<script type="text/javascript" src="/Public/lib/My97DatePicker/WdatePicker.js"></script> 
<script type="text/javascript" src="/Public/lib/datatables/1.10.0/jquery.dataTables.min.js"></script> 
<script type="text/javascript" src="/Public/static/h-ui/js/H-ui.js"></script> 
<script type="text/javascript" src="/Public/static/h-ui.admin/js/H-ui.admin.js"></script>
<script type="text/javascript">
$('.table-sort').dataTable({
	"aaSorting": [[ 1, "desc" ]],//默认第几个排序
	"bStateSave": true,//状态保存
	"aoColumnDefs": [
	  //{"bVisible": false, "aTargets": [ 3 ]} //控制列的隐藏显示
	  {"orderable":false,"aTargets":[0,8]}// 不参与排序的列
	]
});
</script> 
</body>
</html>