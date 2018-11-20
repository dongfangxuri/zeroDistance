<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
<head>
    <title>填写订单</title>
    <meta charset="utf-8"/>
    <!--<meta name="viewport" content="width=device-width, initial-scale=1.0">-->
    <meta name="viewport" content="width=750px,target-densitydpi=device-dpi,user-scalable=no,maximum-scale=1.0">
    <link rel="stylesheet" href="/Public/pintuer/pintuer.css">
    <style>
        body{
            height:100%;
        }
        h1.text-black{
            font-size: 2.4rem;
        }
        .detail{
            list-style: none;
            background: #FC9A03;
            padding:3% 0 4% 10% ;
            color: #fff;
            font-size: 2.4rem;
            line-height: 4rem;
        }
        .layout form>p{
            font-size: 2rem;
            color:#FCA51E;
            border-bottom: 1px solid #ddd;
            margin: 0;
            padding: 1.3rem 2rem ;
            background: #F8F8F8;
            line-height: 3.8rem;
        }

        /*出行人 联系人*/
        .trip,.linkman{
            list-style: none;
            background: #fff;
            padding:0 2rem;
            font-size: 2rem;
            line-height: 5rem;

        }
        .trip{
            padding-right:5rem;
            position: relative;
        }
        .trip li input,.linkman li input{
            border: none;
            color: #959595;
        }
        .trip li a input{
            border: none;
            color: #959595;
            background: #fff;
        }
        .trip img{
            position: absolute;
            top:4rem;
            right: 2rem;
        }
            /*积分 备注*/
        .jifen,.xuqiu{
            width: 100%;
            border: none;
            height: 4rem;
            padding-left: 2rem;
            font-size: 1.8rem;
            border: 1px solid#EDEDED;
        }
        .xuqiu{
            height: 8rem;
            padding-bottom: 3rem;
        }
        .pay{
            position: fixed;
            bottom: 0rem;
            width: 100%;
        }
        .pay p,.pay .gopay{
            margin: 0;
            height: 7rem;
            line-height: 7rem;
            font-size: 2.2rem;
            padding-left: 2rem;
        }
        .pay a{
            padding-left: 0rem;
        }
        .pay p sup{
            margin-left: 2rem;

        }
        .pay p span {
            color: #E08236;
        }
        .pay .gopay{
            background: #FC9A03;
            border:none;
        }
    </style>
</head>
<body>
    <div class="layout clearfix">
        <div  class="line text-center padding-big ">
            <div class="x1">
                <a href="javascript:history.back(-1);"><img src="/Public/images/btn_arrow_back_green.png" alt="" class="img-responsive margin-big-left"style="width: 40%"></a>
            </div>
            <div class="x11 ">
                <h1 class="text-black">填写订单</h1>
            </div>
        </div>
        <!--订单详情-->
       <ul class="line detail">
            <li><?php echo ($title); ?></li>
           <li>时间：<span><?php echo ($during); ?></span></li>
       </ul>
        <form action="/Home/Min/pay" method="post">
            <p class="">出行人</p>
            <ul class="trip clearfix border-bottom">
                <li class="x3">成人</li>
                <li class="x9">
                <a href="/Home/Min/choosecontact"><input type="text" value="<?php echo ($personstring); ?>" disabled="disabled"></a></li>
                <a href="/Home/Min/choosecontact"> <img src="/Public/images/right.png" alt="" class="img-responsive float-right"> </a>
                <hr>
                <li class="x3">儿童</li>
                <li class="x9"><a href="/Home/Min/choosecontact"><input type="text"value="<?php echo ($childstring); ?>" disabled="disabled"></a></li>
            </ul>
            <p class="">联系人信息</p>
               <ul class="linkman clearfix">
                   <li class="x3">姓名</li>
                   <li class="x9"><input type="text" name="name" value="<?php echo ($usermodel["nick_name"]); ?>"></li>
                   <hr>
                   <li class="x3">手机</li>
                   <li class="x9"><input type="text" name="phone" value="<?php echo ($usermodel["phone"]); ?>"></li>
               </ul>
            <p class="">可使用积分 <span class="text-red margin-big-left " id="totalstar"><?php echo ($usermodel["star"]); ?></span>积分</p>
            <input type="text" placeholder="<?php echo ($starmax); ?>" name="star" class="jifen" id="star" onchange="changemoney();">
            <p class="">备注</p>
            <input type="text" placeholder="请告诉我们您的特殊需求" name="content" class="xuqiu  text-break">
            <div class="pay">
                <p class=" bg-black text-white x9">需支付<sup class="text-white">&yen;</sup><span id="money"><?php echo ($ordermodel["order_amount"]); ?></span></p>
                <!--<a href="#" class="gopay text-center text-white x3">去支付</a>-->
                <input type="hidden" name="total_price" id="total_price" value="<?php echo ($ordermodel["order_amount"]); ?>"/>
                <input type="hidden" name="maxstar" id="maxstar" value="<?php echo ($maxstar); ?>">
                <input type="submit" value="去支付"  class="gopay text-center text-white x3">
            </div>
        </form>
    </div>
    <div style="height: 10rem"></div>
<script src="/Public/pintuer/jquery.js"></script>
<script src="/Public/pintuer/pintuer.js"></script>
<script>
     function changemoney()
     {
    	 var totalstar=parseInt($("#totalstar").html());
    	 var star=parseInt($("#star").val());
    	 var maxstar=parseInt($("#maxstar").val());
    	 var totalmoney=parseInt($("#total_price").val());
    	 var money=parseInt($("#money").html());
    	 if(star%300!=0)
    		{
    		   alert('请输入300的整数倍');
    		}
    	 else if(star>totalstar)
    		 {
    		   alert('输入积分不能超过可使用积分');
    		 }
    	 else if(star>maxstar)
    		 {
    		   alert('输入积分不能超过订单最大允许积分数');
    		 }
    	 else
    		{
    		   var intemoney=star/300;
    		   totalmoney-=intemoney;
    		   if(totalmoney<=0)
    			 {
    			   $("#money").html(0);
        		   $("#total_price").val(0);
    			 }
    		   else
    			 {
    			   $("#money").html(totalmoney);
        		   $("#total_price").val(totalmoney);
    			 }
    		}
     }
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