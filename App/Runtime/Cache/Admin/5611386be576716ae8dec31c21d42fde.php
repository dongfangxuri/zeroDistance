<?php if (!defined('THINK_PATH')) exit();?><!--_meta 作为公共模版分离出去-->
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
<LINK rel="Bookmark" href="/favicon.ico" >
<LINK rel="Shortcut Icon" href="/favicon.ico" />
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
<!--/meta 作为公共模版分离出去-->

<title>修改活动 - 活动管理 - 零距离童军</title>
<meta name="keywords" content="零距离童军">
<meta name="description" content="零距离童军。">
</head>
<body>
<article class="page-container">
	<form action='/Admin/Active/active_update/ac_id/110' method='post' class="form form-horizontal" id="form-article-add">
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>活动标题：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="<?php echo ($model["ac_title"]); ?>" placeholder="" id="ac_title" name="ac_title">
			</div>
		</div>
			
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">活动标签：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="<?php echo ($model["lable"]); ?>" placeholder="" id="" name="lable">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">活动景区：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="<?php echo ($model["view_addr"]); ?>" placeholder="" id="" name="view_addr">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">活动类别：</label>
			<div class="formControls col-xs-8 col-sm-9"> <span class="select-box">
				<select class="select" name="category">
					<?php if(is_array($list)): foreach($list as $key=>$vo): ?><option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["category_name"]); ?></option><?php endforeach; endif; ?>
				</select>
				</span> </div>
		</div>

		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">类别：</label>
			<div class="formControls col-xs-8 col-sm-9"> <span class="select-box">
				<select class="select" id="type" name="type" onchange="Change();">
					<option value="1" select="selected">热卖</option>
					<option value="2">头条</option>
					<option value="3">推荐</option>
					<!-- <option value="4">推荐</option>  -->
				</select>
				</span> </div>
		</div>
		
		<div class="row cl" id="reason" style="display:none;">
			<label class="form-label col-xs-4 col-sm-2">推荐原因：</label>
			<div class="formControls col-xs-6 col-sm-7">
				<input type="text" class="input-text" value="" placeholder="" id="" name="recommend_reason">
			</div>
		</div>
		
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">置顶：</label>
			<div class="formControls col-xs-8 col-sm-9">
			  <span class="select-box">
				<select class="select" name="is_top">
				<?php if($is_top == 1): ?><option value="1" select="selected">置顶</option>
					<option value="2">不置顶</option>
				<?php else: ?>
				    <option value="2" select="selected">不置顶</option>
					<option value="1">置顶</option><?php endif; ?>
				</select>
			  </span> 
			</div>
		</div>
        <div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">半天活动：</label>
			<div class="formControls col-xs-8 col-sm-9">
			  <span class="select-box">
				<select class="select" id="day" name="is_half_active" onchange="Changehalf();">
					<option value="0" select="selected">否</option>
					<option value="1" >是</option>
				</select>
			  </span> 
			</div>
		</div>
		
		<div class="row cl" id="half" style="display:none;">
			<label class="form-label col-xs-4 col-sm-2">上午半天活动时间：</label>
			<div class="formControls col-xs-2 col-sm-2">
				<input type="text" class="input-text" value="" placeholder="" id="" name="morning_half_time">
			</div>
		    <label class="form-label col-xs-4 col-sm-2">下午半天活动时间：</label>
			<div class="formControls col-xs-2 col-sm-2">
				<input type="text" class="input-text" value="" placeholder="" id="" name="after_half_time">
			</div>
			<span>时间格式：09:00-12:00</span>
		</div>
		
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">排序id：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="<?php echo ($model["sort_id"]); ?>" placeholder="" id="" name="sort_id">
			</div>
		</div>
		
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">年龄限制：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="<?php echo ($model["fit_age"]); ?>" placeholder="" id="" name="fit_age">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>开通城市：</label>
			<div class="formControls col-xs-6 col-sm-7">	
				<?php if(is_array($citylist)): foreach($citylist as $key=>$vo): ?><input type="checkbox" name="city_id[]" value="<?php echo ($vo["areaid"]); ?>"><?php echo ($vo["name"]); ?>&nbsp;&nbsp;<?php endforeach; endif; ?>
			</div>
			
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">活动简介：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<textarea name="ac_intro" cols="" rows="" class="textarea"  placeholder="<?php echo ($model["ac_intro"]); ?>" datatype="*10-100" dragonfly="true" nullmsg="备注不能为空！" onKeyUp="textarealength(this,200)"></textarea>
				<p class="textarea-numberbar"><em class="textarea-length">0</em>/200</p>
			</div>
		</div>

		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">活动内容：</label>
			<div class="formControls col-xs-8 col-sm-9"> 
				<script type="text/plain" id="editor" name="ac_content" style="width:100%;height:400px;">
				<?php echo ($model["ac_content"]); ?>
				</script>
			</div>
		</div>
		<div class="row cl">
			<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
			    <<input type="hidden" name="ac_id" value="<?php echo ($model["ac_id"]); ?>"> </input>>
				<input onClick=" return article_save_submit();" class="btn btn-primary radius" type="submit"> </input>
				<!--
				<button onClick="article_save();" class="btn btn-secondary radius" type="button"><i class="Hui-iconfont">&#xe632;</i> 保存草稿</button>
				<button onClick="removeIframe();" class="btn btn-default radius" type="button">&nbsp;&nbsp;取消&nbsp;&nbsp;</button> -->
			</div>
		</div>
	</form>
</article>

<!--_footer 作为公共模版分离出去-->
<script type="text/javascript" src="/Public/lib/jquery/1.9.1/jquery.min.js"></script> 
<script type="text/javascript" src="/Public/lib/layer/2.1/layer.js"></script> 
<script type="text/javascript" src="/Public/lib/icheck/jquery.icheck.min.js"></script> 
<script type="text/javascript" src="/Public/lib/jquery.validation/1.14.0/jquery.validate.min.js"></script> 
<script type="text/javascript" src="/Public/lib/jquery.validation/1.14.0/validate-methods.js"></script> 
<script type="text/javascript" src="/Public/lib/jquery.validation/1.14.0/messages_zh.min.js"></script> 
<script type="text/javascript" src="/Public/static/h-ui/js/H-ui.js"></script> 
<script type="text/javascript" src="/Public/static/h-ui.admin/js/H-ui.admin.js"></script> 
<!--/_footer /作为公共模版分离出去-->

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="/Public/lib/My97DatePicker/WdatePicker.js"></script>  
<script type="text/javascript" src="/Public/lib/webuploader/0.1.5/webuploader.min.js"></script> 
<script type="text/javascript" src="/Public/lib/ueditor/1.4.3/ueditor.config.js"></script> 
<script type="text/javascript" src="/Public/lib/ueditor/1.4.3/ueditor.all.min.js"> </script> 
<script type="text/javascript" src="/Public/lib/ueditor/1.4.3/lang/zh-cn/zh-cn.js"></script>
<script type="text/javascript">
$(function(){
	$('.skin-minimal input').iCheck({
		checkboxClass: 'icheckbox-blue',
		radioClass: 'iradio-blue',
		increaseArea: '20%'
	});
	$list = $("#fileList"),
	$btn = $("#btn-star"),
	state = "pending",
	uploader;

	var uploader = WebUploader.create({
		auto: true,
		swf: '/Public/lib/webuploader/0.1.5/Uploader.swf',
	
		// 文件接收服务端。
		server: 'fileupload.php',
	
		// 选择文件的按钮。可选。
		// 内部根据当前运行是创建，可能是input元素，也可能是flash.
		pick: '#filePicker',
	
		// 不压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
		resize: false,
		// 只允许选择图片文件。
		accept: {
			title: 'Images',
			extensions: 'gif,jpg,jpeg,bmp,png',
			mimeTypes: 'image/*'
		}
	});
	uploader.on( 'fileQueued', function( file ) {
		var $li = $(
			'<div id="' + file.id + '" class="item">' +
				'<div class="pic-box"><img></div>'+
				'<div class="info">' + file.name + '</div>' +
				'<p class="state">等待上传...</p>'+
			'</div>'
		),
		$img = $li.find('img');
		$list.append( $li );
	
		// 创建缩略图
		// 如果为非图片文件，可以不用调用此方法。
		// thumbnailWidth x thumbnailHeight 为 100 x 100
		uploader.makeThumb( file, function( error, src ) {
			if ( error ) {
				$img.replaceWith('<span>不能预览</span>');
				return;
			}
	
			$img.attr( 'src', src );
		}, thumbnailWidth, thumbnailHeight );
	});
	// 文件上传过程中创建进度条实时显示。
	uploader.on( 'uploadProgress', function( file, percentage ) {
		var $li = $( '#'+file.id ),
			$percent = $li.find('.progress-box .sr-only');
	
		// 避免重复创建
		if ( !$percent.length ) {
			$percent = $('<div class="progress-box"><span class="progress-bar radius"><span class="sr-only" style="width:0%"></span></span></div>').appendTo( $li ).find('.sr-only');
		}
		$li.find(".state").text("上传中");
		$percent.css( 'width', percentage * 100 + '%' );
	});
	
	// 文件上传成功，给item添加成功class, 用样式标记上传成功。
	uploader.on( 'uploadSuccess', function( file ) {
		$( '#'+file.id ).addClass('upload-state-success').find(".state").text("已上传");
	});
	
	// 文件上传失败，显示上传出错。
	uploader.on( 'uploadError', function( file ) {
		$( '#'+file.id ).addClass('upload-state-error').find(".state").text("上传出错");
	});
	
	// 完成上传完了，成功或者失败，先删除进度条。
	uploader.on( 'uploadComplete', function( file ) {
		$( '#'+file.id ).find('.progress-box').fadeOut();
	});
	uploader.on('all', function (type) {
        if (type === 'startUpload') {
            state = 'uploading';
        } else if (type === 'stopUpload') {
            state = 'paused';
        } else if (type === 'uploadFinished') {
            state = 'done';
        }

        if (state === 'uploading') {
            $btn.text('暂停上传');
        } else {
            $btn.text('开始上传');
        }
    });

    $btn.on('click', function () {
        if (state === 'uploading') {
            uploader.stop();
        } else {
            uploader.upload();
        }
    });
	
	var ue = UE.getEditor('editor');
	
});
</script>
<script>
 	function article_save_submit()
	{
	   var addr=$("#addr").val();
	   var ac_title=$("#ac_title").val();
	   if(ac_title=="")
	   {
	      alert("请输入活动标题！");return false;
	   }
	   else if(addr=="")
	   {
	      alert("请输入活动地址！");return false;
	   }
	   return true;
	}
 	function Change()
 	{
 		var temp=$("#type").val();
 		if(temp==3)
 		{
 			$('#reason').css('display','block');
 		}
 		else
 		{
 			$('#reason').css('display','none');
 		}
 	}
 	
 	function Changehalf()
 	{
 		var temp=$("#day").val();
 		if(temp==1)
 		{
 			$('#half').css('display','block');
 		}
 		else
 		{
 			$('#half').css('display','none');
 		}
 	}
</script>
<!--/请在上方写此页面业务相关的脚本-->
</body>
</html>