<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=750px,target-densitydpi=device-dpi,user-scalable=no,maximum-scale=1.0">
	<link rel="stylesheet" href="/Public/pintuer/pintuer.css">
<meta content="yes" name="apple-mobile-web-app-capable">     
<meta content="black" name="apple-mobile-web-app-status-bar-style">     
<meta content="telephone=no" name="format-detection">

<title>亲子网站</title>
<link href="/Public/css/datepicker1.css" rel="stylesheet" />
<script src="/Public/js/jquery-1.11.3.js"></script>
<script src="/Public/js/zlDate1.js"></script>
<style type="text/css">
*{margin:0;padding:0px;list-style: none;}
body{
	min-height:1024px;
}
	#calendar{width: 100%;height: 40px;background: url(/Public/images/rili.png) no-repeat center center;
		background-size:100%;
	}
.x11 h1{
	font-size: 2.2rem;
	color: #5D5D5D;
}
dt.x10 p{
	font-weight: normal;
	font-size: 2rem;
	margin-bottom: 5rem;
	height: 2.5rem;
	padding-top: 0.3rem;
}

</style>

</head>
<body>
<div class="layout"  >
	<div  class="line text-center padding " style="background: #fff">
		<div class="x1">
			<a href="javascript:history.back(-1);"><img src="/Public/images/btn_back_arrow_orange.png" alt="" class="img-responsive " style="width: 40%"></a>
		</div>
		<div class="x11 ">
			<h1 class="text-black">活动日历</h1>
		</div>
	</div>
</div>
<div id="rili"></div>
<input type="hidden" name="ac_id" id="ac_id" value="<?php echo ($id); ?>"/>
<script>
function AjaxTime(id){	
	$.get("/Home/Rili/jsonReturn/id/"+id,function(data) {
		pickerEvent.setPriceArr(eval("("+data+")"));
		pickerEvent.Init("rili");
	});
}
var id=$('#ac_id').val();
AjaxTime(id);

</script>

</body>
</html>

<!--<footer>
    <ul>
        <li class="active"><a href="<?php echo U('Index/index');?>"><img src="/Public/images/footer/home_active.png"></a></li>
        <li ><a href="<?php echo U('Rili/index');?>"><img src="/Public/images/footer/calendaer.png"></a></li>
        <li ><a href="<?php echo U('Message/index');?>"><img src="/Public/images/footer/message.png"></a></li>
        <li ><a href="<?php echo U('Kid/index');?>"><img src="/Public/images/footer/baby.png"></a></li>
        <li ><a href="<?php echo U('Min/index');?>"><img src="/Public/images/footer/user.png"></a></li>
    </ul>
</footer>
<script src="http://lib.sinaapp.com/js/jquery/2.0.2/jquery-2.0.2.min.js"></script>
<script type="text/javascript" src="/Public/js/swiper.jquery.min.js"></script>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=YcYT3uNlm5gomMRk8tunRvbQBzmWvGOH"></script>

<script src="/Public/js/zepto1.js"></script>
<script src="/Public/js/sm1.js"></script>
<script src="/Public/js/2.js"></script>
<script type="text/javascript" src="/Public/js/index1.js"></script>
<script type="text/javascript" src="/Public/js/index.js"></script>
</body>
</html>

<footer>
    <ul>
        <li class="active"><a href="<?php echo U('Index/index');?>"><img src="/Public/images/footer/home_active.png"></a></li>
        <li ><a href="<?php echo U('Rili/index');?>"><img src="/Public/images/footer/calendaer.png"></a></li>
        <li ><a href="<?php echo U('Message/index');?>"><img src="/Public/images/footer/message.png"></a></li>
        <li ><a href="<?php echo U('Kid/index');?>"><img src="/Public/images/footer/baby.png"></a></li>
        <li ><a href="<?php echo U('Min/index');?>"><img src="/Public/images/footer/user.png"></a></li>
    </ul>
    </footer>
<script src="http://lib.sinaapp.com/js/jquery/2.0.2/jquery-2.0.2.min.js"></script>
<script type="text/javascript" src="/Public/js/swiper.jquery.min.js"></script>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=YcYT3uNlm5gomMRk8tunRvbQBzmWvGOH"></script>
<script src="/Public/js/zepto1.js"></script>
<script src="/Public/js/sm1.js"></script>
<script src="/Public/js/2.js"></script>
<script type="text/javascript" src="/Public/js/index1.js"></script>	
</body>
</html>  -->