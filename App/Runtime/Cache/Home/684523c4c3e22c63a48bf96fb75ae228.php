<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
<head>
    <title>已完成订单</title>
  <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=750px,target-densitydpi=device-dpi,user-scalable=no,maximum-scale=1.0">
    <link rel="stylesheet" href="/Public/pintuer/pintuer.css">
    <link rel="stylesheet" href="/Public/css/page.css">
    <style>
        .x11 h1{
            font-size: 2.6rem;
        }
        dt.x10 p{
            font-weight: normal;
            font-size: 2rem;
            margin-bottom: 5px;
            height: 2.5rem;
            padding-top: 0.3rem;
        }
        dt.x10 p:not(:first-child){
            color: #acacac;
            font-size:1.8rem;
        }
        .bg_color{
            display: block;
            width: 100%;
            height: 10px;
            background: #f1f1f1;
        }
        span.margin-left{
            margin-left: 2rem;
            font-size:1.8rem;
        }

        .indent{
            list-style: none;
        }
        .indent li{
            border-bottom: 1px solid #D8D8D8;
            height: 4.8rem;
            line-height: 4.8rem;
            padding-left: 5%;
            font-size: 2rem;
            color: #000;
        }
        .indent li span{
            margin-left: 0.8rem;
        }
        .pay{
            background: #FB9A02;
            font-size: 2rem;
            height: 5rem;
            line-height: 4rem;
        }
        .nodate{
            width: 100%;
            height: 100%;
            position: absolute;
            top:5%;
            z-index: 100;
            background: rgba(0,0,0,0.1);
            background: url("/Public/images/nodata.png")no-repeat center 50%;
        }
        .nodate h1{
            text-align: center;
            position: absolute;
            top:60%;
            left: 44%;
        }
        dd.x3 a{
            display: inline-block;
            width: 136px;
            height: 136px;
        }
        dd.x3 a img{
            width: 100%;
            height: 100%;
        }
        dd.x2 a{
            display: inline-block;
            width: 136px;
            height: 136px;
        }
        dd.x2 a img{
            width: 100%;
            height: 100%;
        }
    </style>

</head>
<body>
   <?php if($count == 0): ?><div class="nodate">
	    <h1>
	        暂无订单
	    </h1>
	</div><?php endif; ?>
    <div class="layout">
        <div  class="line text-center padding " style="background: #FC9A03">
            <div class="x1">
                <a href="javascript:history.back(-1);"><img src="/Public/images/ht.png" alt=""></a>
            </div>
            <div class="x11 ">
                <h1 class="text-white">已完成订单</h1>
            </div>
        </div>
        <!--已完成订单-->
        <?php if(is_array($list)): foreach($list as $key=>$vo): ?><div class="">
	            <dl class="clearfix">
	                <dd class="x2"><a href="/Home/Index/detail/ac_id/<?php echo ($vo["ac_id"]); ?>"><img src="/<?php echo ($vo["pic"]); ?>" alt="" class="img-responsive margin-left" ></a></dd>
	                <dt class="x10 padding padding-small-bottom">
	                    <p class="text-more margin-big-left">
	                        <a href="#" class="margin-small-left">
                               <?php echo ($vo["ac_title"]); ?>
	                        </a>
	                    </p>
	                    <p class="margin-big-left ">
	                        活动时间<span class="margin-left"><?php echo ($vo["start_time"]); ?></span>
	                        <img src="/Public/images/right.png" alt="" style="width: 5%" class="float-right margin">
	                    </p>
						<p class="margin-big-left ">
	                        活动人数<span class="margin-left"><?php echo ($vo["meal_string"]); ?></span>
	                    </p>
	                    </dt>
	            </dl>
	            <b class="bg_color"></b>
	            <ul class="indent">
	                <li>订单信息</li>
	                <li>活动时间<span><?php echo ($vo["start_time"]); ?></span></li>
	                <li>活动人数<span><?php echo ($vo["meal_string"]); ?></span></li>
	                <li>活动标题 <span><?php echo ($vo["ac_title"]); ?></span></li>
	                <li>下单时间 <span><?php echo ($vo["add_time"]); ?></span></li>
	                <li>活动地点<span><?php echo ($vo["view_addr"]); ?></span></li>
	                <li>订单编号<span><?php echo ($vo["order_sn"]); ?></span></li>
	            </ul>
	            <p  class="text-center text-white padding pay ">已完成支付</p>
	        </div><?php endforeach; endif; ?>
    </div>
       <div class="pages" style="height:80px;font-size:1.5rem;">    
　　                           <?php echo ($page); ?>
        </div>
<script src="/Public/pintuer/jquery.js"></script>
<script src="/Public/pintuer/pintuer.js"></script>
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