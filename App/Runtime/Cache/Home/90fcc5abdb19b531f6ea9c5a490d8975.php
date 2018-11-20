<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="renderer" content="webkit">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=0">
	<title>亲子网站</title>
	<!-- <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon"> -->
	<link rel="stylesheet" href="/Public/css/public.css">
    <style type="text/css">
        #main{background: #f7f7f7;}
        header{background: #fff;}   
        .nav p{font-size: 20px;color: #fe7e97;text-align: center;height: 44px;line-height:44px;}
        .nav {position: relative;}
        .back{max-width:16px;height: 22px;text-decoration: none;display: inline-block;position: absolute;top: 10px;left: 5%;}
        .back img{height: 100%;}
       .message-detail{padding: 0.75rem;}
       .message-detail h3{font-size:0.9rem;color: #595959;text-align: center; }
       .message-detail h4{margin-top: 1rem;font-size:0.75rem; color: #808080;text-align: center; }
        .message-detail p{font-size: 0.75rem;color: #595959;margin-top:2rem; }
        .message-detail h5{margin-top: 0.5rem; text-align: right;}
         .message-detail h5 a{ font-size: 0.75rem; color: #ed2f2f;}
        }
    </style>
	
	<!--[if lt IE 9]>
	<script src="/Public/js/html5shiv.min.js"></script>
	<script src="/Public/js/respond.min.js"></script>
	<![endif]-->
</head>
<body>
    <div id="main">
        <header>
          <div class="nav">
           <a href="javascript:history.back(-1)" class="back"><img src="/Public/images/back.png"></a>
            <p>消息详情</p>
          </div>
        </header>
        <div class="message-detail">
            <h3><?php echo ($vo["title"]); ?></h3>
            <h4>发布时间：<span><?php echo ($vo["addTime"]); ?></span></h4>
            <p>&nbsp;&nbsp;&nbsp;<?php echo ($vo["content"]); ?>～</p>
        </div>
    </div>

        <!--
        <div class="message-detail">
            <h3>国庆旅游活动预定折扣已开始</h3>
            <h4>发布时间：<span>2016/09/01</span></h4>
            <p>&nbsp;&nbsp;&nbsp;“零距离童军10.1全国游”活动已隆重开启，即日起您可以登录手机端、电脑端官网进行活动预定，最高可享受5折优惠，还有更多惊喜等着您来领取，会员可以享受更多优厚的回馈呦～</p>
            <h5><a href="<?php echo U('Index/detail');?>">查看详情》</a></h5>
        </div>
     </div>
             -->
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