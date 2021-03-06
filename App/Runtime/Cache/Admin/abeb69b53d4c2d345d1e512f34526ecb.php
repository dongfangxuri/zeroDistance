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
	<title>活动留言管理</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 评论管理 <span class="c-gray en">&gt;</span> 活动留言管理 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
	<div class="text-c">
		<!-- <a href="/Admin/LeaMsg/leamsg_add"></span>
		<button type="button" class="btn btn-success" id="" name="" onClick="picture_colume_add(this);">
		<i class="Hui-iconfont">&#xe600;</i> 添加</button>  -->
		</a>
	</div>
	<div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l"><a href="javascript:;" onclick="datadel()" class="btn btn-danger radius">
	<i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a></span>  
	<span class="r">共有数据：<strong><?php echo ($count); ?></strong> 条</span> </div>
	<form id="form1" action="/Admin/LeaMsg/leamsg_deleteall" method="post">
	  <div class="mt-20">
		<table class="table table-border table-bordered table-bg table-sort">
			<thead>
			<tr class="text-c">
				<th width="25"><input type="checkbox" name="ids[]" value=""></th>
				<th width="60">Id</td>
				<th width="150">活动</th>
				<th>留言内容</th>
				<th width="120">留言时间</th>
				<th width="60">留言会员</th>
				<th width="100">操作</th>
			</tr>
			</thead>
			<tbody>
			<?php if(is_array($list)): foreach($list as $key=>$vo): ?><tr class="text-c">
					<td><input name="ids[]" type="checkbox" value="<?php echo ($vo["id"]); ?>"></td>
					<td><?php echo ($vo["id"]); ?></td>
					<td><?php echo ($vo["ac_id"]); ?></td>
					<td><?php echo ($vo["content"]); ?></td>
					<td><?php echo ($vo["addTime"]); ?></td>
					<td class="text-l"><?php echo ($vo["uid"]); ?></td>
					<td class="f-14 product-brand-manage">
					<?php if($vo["is_response"] == 0): ?><a style="text-decoration:none" href="/Admin/LeaMsg/leamsg_update/id/<?php echo ($vo["id"]); ?>" title="回复留言">
					<i class="Hui-iconfont">&#xe6df;</i></a>
					   <?php else: ?>
					      <span>已回复 </span><?php endif; ?>
					<a style="text-decoration:none" class="ml-5" onClick="return confirm('确定要删除此条留言吗?');" href="/Admin/LeaMsg/leamsg_del/id/<?php echo ($vo["id"]); ?>" title="删除">
					<i class="Hui-iconfont">&#xe6e2;</i></a></td>
				</tr><?php endforeach; endif; ?>
			</tbody>
		</table>
	</div>
    </form>
</div>
<script type="text/javascript" src="/Public/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="/Public/lib/layer/2.1/layer.js"></script><script type="text/javascript" src="/Public/lib/laypage/1.2/laypage.js"></script>
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
			{"orderable":false,"aTargets":[0,6]}// 制定列不参与排序
		]
	});
	function datadel()
	{
	   $('#form1').submit();
	    //$("table input[type=checkbox]").each(function(){
		//	if($(this).attr("checked")==true){
		//		alert($("table input:checkbox").index(this))
		//	}
       // })
	}
</script>
</body>
</html>