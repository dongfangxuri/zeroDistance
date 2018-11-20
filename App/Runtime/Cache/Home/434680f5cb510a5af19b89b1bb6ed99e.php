<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
<head>
    <title>分享</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=750px,target-densitydpi=device-dpi,user-scalable=no,maximum-scale=1.0">
    <link rel="stylesheet" href="/Public/pintuer/pintuer.css">
    <style>
        .myhome,.retreat{
            width: 90%;
        }
        .honor{
            background: #FC9A03;
            font-size: 2.4rem;
            margin-bottom: 0;
        }
        p.x8{
            margin: 0;
        }
        .share{
            font-size: 2rem;
            color: #FA7C03;
        }
        .friend{
            font-size: 2rem;
            margin-top: 1rem;
            margin-bottom: 2rem;
            color: #000;
        }
        .integral{
            font-size: 2rem;
            line-height: 2.6rem;
            color: #000;
            margin-bottom: 5rem;
        }
        .way{
            font-size: 2rem;
        }
        .wx_friend{
            margin:0 1.2rem 0 2.6rem;

            width:7.5rem;
            height: 8.7rem;
            background: url(/Public/images/share.png)no-repeat 5% 50%;
        }
        .friend_circle{
            margin:0 1.2rem 0 2.6rem;
            margin-top: 0;
            width:7.5rem;
            height: 8.7rem;
            background: url(/Public/images/share.png)no-repeat 34% 50%;
        }
        .Qzone{
            margin:0 1.2rem 0 2.6rem;

            width:7.5rem;
            height: 8.7rem;
            background: url(/Public/images/share.png)no-repeat 34% 12%;
        }
        .QQ_friend{
            margin:0 1.2rem 0 2.6rem;

            width:7.5rem;
            height: 8.7rem;
            background: url(/Public/images/share.png)no-repeat 4% 11%;
        }

    </style>
</head>
<body>
    <div class="layout">
        <div class="line border-bottom">
            <a href="javascript:history.back(-1);" class="x2"><img src="/Public/images/idex.png" alt="" class="img-responsive padding-big retreat" > </a>
            <p class="x8">
                <img src="/Public/images/logo.png" alt="" class="img-responsive x2  padding-big" style="width: 20%;padding-right: 0">
                <img src="/Public/images/ojltj.png" alt="" class="img-responsive x9 padding-big ">
            </p>
            <a href="/Home/Min/index" class="x2">
             <?php if(empty($header_img)): ?><img src="/Public/images/fx.png" alt="" class="img-responsive padding-big myhome">
             <?php else: ?>
               <img src="/<?php echo ($header_img); ?>" alt="" class="img-responsive padding-big myhome" style="border-radius:50%"><?php endif; ?>              
             </a>
        </div>
      <p style="width:500px;margin: 0 auto">
          <!--图片-->
          <img src="/Public/images/bg_box.png" alt="" class="img-responsive">
      </p>
        <div class="text-center">
           <span class="share">分享有礼</span>
            <ul class="friend">
                <li>微信好友，群：10积分</li>
                <li>Q Q好友，群：10积分</li>
                <li>微信圈：&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;30积分</li>
                <li>Q Q空间：&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;30积分</li>
            </ul>
            <p class="integral">每天最高可获得300积分<br>积分可抵消活动费用</p>
        </div>
        <div class="margin-big-top clearfix">
            <p class="x3 border-bottom margin-top"></p>
            <p class="x6 way text-center height-large">通过以下方式进行分享</p>
            <p class="x3 border-bottom margin-top" ></p>
        </div>
        <div class="line  text-center friend_list">
            <a href="#" class="x3 wx_friend"></a>
            <a href="#" class="x3 friend_circle"></a>
            <a href="#" class="x3 Qzone"></a>
            <a href="#" class="x3 QQ_friend"></a>
        </div>




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