<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
<head>
    <title>待付款订单</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=750px,target-densitydpi=device-dpi,user-scalable=no,maximum-scale=1.0">
    <link rel="stylesheet" href="/Public/pintuer/pintuer.css">
    <link rel="stylesheet" href="/Public/css/page.css">
    <style>
        h1.text-white{
            font-size: 2.6rem;
        }
        p.text-more{
            font-size:2rem;
            line-height:2rem;
            font-weight: normal;
        }
        dt.x9 p:not(:first-child){
            color: #AAAAAA;
            font-size:1.6rem;
            line-height:1.6rem;
            font-weight: normal;
            margin-top: 1.6rem;
        }
        dd.x3{
            padding-bottom:0 ;
        }
        .sj b{
            font-weight: normal;
        }
        div.line>a{
            font-size: 2rem;
            color: #AAAAAA;
            border-right: none;
        }
        div.line>a:last-child{
            color: #F16649;
        }
        dt.x12 p{
            font-size: 2rem;
            font-weight: normal;
            padding: 10px 20px;
            color: #6F6F6F;
        }
        /*弹出框*/
        #alert_content{
            position:absolute;
            z-index: 100;
            width: 100%;
             height: 100%;
            background: rgba(0,0,0,0.5);
            display: none;
        }
        #alert_content .line{
            background: #fff;
            width: 60%;
            position: absolute; left: 50%; top: 50%;
            margin-top: -200px;
            margin-left: -212px;

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
    </style>
</head>
<body>
   <?php if($count == 0): ?><div class="nodate">
	    <h1>
	        暂无订单
	    </h1>
	</div><?php endif; ?>
   <!--  <div id="alert_content" class="layout">
        <div class="line radius-big">
            <p class="padding-big text-center text-large height-big">订单删除后无法恢复，确定要删除此次报名吗？</p>
            <a href="#" class="x6 text-center border padding-big callOff">取消</a>
            <a href="#" class="x6 text-center border padding-big callOn">确定</a>
        </div>
    </div>  -->
    <div class="layout">
        <div  class="line text-center padding " style="background: #FC9A03">
            <div class="x1">
                <a href="javascript:history.back(-1);"><img src="/Public/images/ht.png" alt="" class="img-responsive"style="width: 40%"></a>
            </div>
            <div class="x11 ">
                <h1 class="text-white">待付款订单</h1>
            </div>
        </div>
        <?php if(is_array($list)): foreach($list as $key=>$vo): ?><div class="line margin-big-bottom border-top" style="margin-top: 3px">
	            <dl class="clearfix">
	                <dd class="x3 padding-big"><a href="/Home/Index/detail/ac_id/<?php echo ($vo["ac_id"]); ?>"><img src="/<?php echo ($vo["pic"]); ?>" alt="" class="img-responsive"></a></dd>
	                <dt class="x9 padding-top">
	                    <p class="text-more margin-left margin-top">
	                        <a href="#" class="margin-small-left ">
	                             <?php echo ($vo["ac_title"]); ?>
	                        </a>
	                    </p>
	                    <p class="margin-small-left sj">
	                        活动时间<span class="margin-left"><?php echo ($vo["start_time"]); ?></span>
	                    </p>
	                    <p class="margin-small-left sj">
	                        活动人数<span class="margin-left">
	                       <!--  <b>1</b>成人<b>1</b>儿童  -->
	                       <?php echo ($vo["meal_string"]); ?>
	                    </span>
	                    </p>
	                </dt>
	                <dt class="x12">
	                    <p class="float-left padding">待付款</p>
	                    <p class="float-right padding "><span class="text-red"><?php echo ($vo["order_amount"]); ?>元</span></p>
	                </dt>
	            </dl>
	            <a onclick="return confirm('订单删除后无法恢复，确定要取消此次报名吗？');" href="/Home/Min/cancle_order/orderid/<?php echo ($vo["oid"]); ?>" class="x6 text-center border padding-big order">取消订单</a>
	            <a href="/Home/Min/continue_pay/orderid/<?php echo ($vo["oid"]); ?>" class="x6 text-center border padding-big">继续支付</a>
	        </div><?php endforeach; endif; ?>
    </div>
       <div class="pages" style="height:80px;font-size:1.5rem;">    
　　                           <?php echo ($page); ?>
        </div>
<script src="/Public/pintuer/jquery.js"></script>
<script src="/Public/pintuer/pintuer.js"></script>
    <script>
        $(".order").on("click",function(e){
            var target=e.target;
            $("#alert_content").show();
            $(".callOff").on("click",function(){
                $("#alert_content").hide();
            });
            $(".callOn").on("click",function(){
                $(target).parent().remove();
                $("#alert_content").hide();
            });
        });
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