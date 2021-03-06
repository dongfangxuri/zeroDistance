<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
<head>
    <title>收银台</title>
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
           color: #FCAB2B;
        }
        .detail{
            list-style: none;
            background: #FC9A03;
            padding:3% 0 4% 10% ;
            color: #fff;
            font-size: 2.4rem;
            line-height: 4rem;
        }
        .oederAmount_box>div:first-child{
           /*border-bottom: 1px solid #DEDEDE;*/
            font-size: 2rem;
            padding: 1rem 2rem;
            margin: 0;
            height: 5rem;
            line-height:3rem;
            color: #000;
        }
        .down{
            margin-left: 1rem;
            color: #34E1F0;
            display: inline-block;
            width:6.6rem;
            background: url("/Public/images/icon_arrow_bule.png") no-repeat right 0.9rem;
        }
       .down.hover{
            background-position:  right -16.7rem;
        }
        .oederAmount_box div p sub{
            font-size: 2rem;
         }
        .money{
            margin-left: 0.1rem;
            color:#EA254E;
           display: inline-block;
            margin-top: 0.6rem;
        }
        #down_box{
            background: #ededed;           
            color: #000;  
            height: 10rem;
            display: none;
        }
        #down_box p{
            font-size: 2rem;
            margin-bottom:1rem;
            line-height: 4rem;
            padding-left: 2rem;
        }
        #down_box p sub{          
            margin-left: 5rem;
        }
         #down_box p span:last-child{
            color: #DD3355;
         }
         .oederAmount_box>p{
            font-size:2rem;
           padding: 0 2rem;
           margin:0;
           border-bottom: 1px solid #ededed;
           line-height: 5rem
         }
         .oederAmount_box>p span{
            float: right;
            color: #DD3355;
         }
         .oederAmount_box>p span sub{
            color:#000;
            font-size: 2rem;
            margin-right: .4rem;
         }

         .pay li{
            list-style: none;
            height:7rem;
            line-height:7rem;
            font-size: 2rem;
            border-bottom: 1px solid #ededed;
            padding: 0 2rem;

         }
         .pay li img:first-child{
            margin-top: 1rem;
            width: 5rem;
           margin-right: 1rem;
         }
       
      /*  .pay li img:last-child{
            margin-top: 1.8rem;
          
         }*/
        .btn_nochoose {  
            float: right;
             width: 3.5rem;
            height: 3.5rem;         
            background: url(/Public/images/btn_pay_choose_off.png) no-repeat center center;
          margin-top: 1.8rem;
        }
        .pay li.active .btn_nochoose{
            background: url(/Public/images/btn_right.png) no-repeat center center;
            
         }

          .pay li p{
            margin-top: 1.5rem;

          }
          .pay li p span{
            display: block;
            margin-bottom: 0.6rem
          }
          button[type="submit"]{
            position: fixed;
            bottom: 0;
            background: #FB7D02;
            border: none;
            font-size: 2rem;
            width:100%;
            padding:2rem 0;
          }
    </style>
</head>
<body>
    <div class="layout clearfix">
        <div  class="line text-center padding-big ">
            <div class="x1">
                <a href="javascript:history.back(-1);"><img src="/Public/images/btn_back_arrow_orange.png" alt="" class="img-responsive margin-big-left"style="width: 40%"></a>
            </div>
            <div class="x11 ">
                <h1 class="text-black">收银台</h1>
            </div>
        </div>
        <!--订单详情-->
       <ul class="line detail">
            <li><?php echo ($title); ?></li>
           <li>时间：<span><?php echo ($during); ?></span></li>
       </ul>
        <!--订单金额-->
        <form action="/Home/Min/paypost" method="post">
            <div class="line oederAmount_box">
            <div class="border-bottom">
                订单金额 <span class="down">明细</span>
               <p class="float-right">
                   <sub>&yen;</sub>
                   <span class="money"><?php echo ($ordermodel["order_amount"]); ?></span>
               </p>
            </div>
            <?php if(is_array($meallist)): foreach($meallist as $key=>$vo): ?><p><span><?php echo ($vo["me_title"]); ?><sub>&yen;</sub> <span><?php echo ($vo["price"]); ?></span></p><?php endforeach; endif; ?>
            <p>使用<span id="integration"><?php echo ($ordermodel["star_amount"]); ?></span>积分</p>
            <p>需支付<span><sub>&yen;</sub><?php echo ($need_price); ?></span></p>
        </div>
        <!--支付方式-->
        <ul class="pay">
            <li>支付方式</li>
            <?php if($is_weixin == 0): ?><li class="active">
	                <img src="/Public/images/icon_zhifubao_pay.png" alt="" class="img-responsive float-left">
	                <p class="float-left"> 
	                     <span>支付宝</span>
	                     支付宝账号支付 ，银行卡支付
	                </p> 
	                  <i href="#" class="btn_nochoose "></i>
	            </li><?php endif; ?>
             <li>
                <img src="/Public/images/icon_weixin_pay.png" alt="" class="img-responsive float-left">
                <p class="float-left"> 
                     <span>微信支付</span>
                     支付宝账号支付 ，银行卡支付
                </p> 
               <i href="#" class="btn_nochoose "></i>
            </li> 
             <li>
                <img src="/Public/images/icon_pay_bank.png" alt="" class="img-responsive float-left">
                <p class="float-left"> 
                     <span>银联支付</span>
                     银行卡支付
                </p> 
               <!--  <img  src="images/btn_pay_choose_off.png" alt="" class="img-responsive float-right"> -->
                <i href="#" class="btn_nochoose "></i>
            </li>             
        </ul>
            <input type="hidden" name="paytype" id="paytype" value="1"/>
            <input type="hidden" name="order_id" value="<?php echo ($ordermodel["oid"]); ?>"/>
            <button type="submit" class="text-white text-center">确定支付</button>
        </form>
    </div>
    <div style="height: 10rem"></div>
<script src="/Public/pintuer/jquery.js"></script>
<script src="/Public/pintuer/pintuer.js"></script>
<script>
 var isShown = false;
    $(".down").click(function(){        
         if(isShown){            
               $("#down_box").hide();
               $(".down").removeClass("hover")
             isShown = false;
         }else{
             $("#down_box").show();
             $(".down").addClass("hover")
            isShown = true;           
         }


    });

    $("#pay_detail").click(function (e) {
        e.preventDefault();
        $($(this).attr("href")).slideToggle(500);
        // body...
        $(this).toggleClass("active");
    })
    $(".btn_nochoose").on("click",function(e){
         e.preventDefault();
         $(this).parent().addClass("active").siblings(".active").removeClass("active");
         var temp=$(this).prev().children().eq(0).text();
         if(temp=='支付宝')
        	 {
        	    $("#paytype").val(1);
        	 }
         else if(temp=='微信支付') 
        	 {
        	    $("#paytype").val(2);
        	 }
         else 
        	    $("#paytype").val(3);
        	 
      })
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