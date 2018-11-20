<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
<head>
    <title>孩子成长</title>
    <meta charset="utf-8"/>
    <!--<meta name="viewport" content="width=device-width, initial-scale=1.0">-->
    <meta name="viewport" content="width=750px,target-densitydpi=device-dpi,user-scalable=no,maximum-scale=1.0">
    <link rel="stylesheet" href="/Public/pintuer/pintuer.css">
    <style>
        body{
            background: #E7E7E7;
        }
        h1.text-white{
            font-size: 2.4rem;
        }

        .child_data img:first-child{
            width:15%;
        }
        .child_data img{
           width:4%;
        }
        .child_data p{
            font-size: 2.4rem;
            line-height: 5rem;
            padding-left:10%;
        }
        .child_data p span{
            margin-right:6%;
        }

    </style>
</head>
<body>
    <div class="layout">
        <div  class="line text-center padding-big " style="background: #FC9A03">
            <div class="x1">
                <a href="javascript:history.back(-1);"><img src="/Public/images/ht.png" alt="" class="img-responsive margin-big-left"style="width: 50%"></a>
            </div>
            <div class="x11 ">
                <h1 class="text-white">孩子成长</h1>
            </div>
        </div>
        <!---->
        <?php if(is_array($kidlist)): foreach($kidlist as $key=>$vo): ?><div class="line padding-big  bg-white child_data margin-little-bottom">
            <a href="/Home/Kid/childGrowUp/id/<?php echo ($vo["id"]); ?>">
               <?php if(empty($vo["header_img"])): ?><img src="/Public/images/btn_photo.png" alt="" class="img-responsive x2">
               <?php else: ?>
                <img src="/<?php echo ($vo["header_img"]); ?>" alt="" class="img-responsive x2"><?php endif; ?>
                <p class="x8 ">
                    <span class="child_name"> <?php echo ($vo["name"]); ?> </span>
                    <span class="child_sex"> <?php echo ($vo["sex"]); ?> </span>
                    <span class="chils_school"> <?php echo ($vo["addr"]); ?></span>
                </p>
                <img src="/Public/images/right.png" alt="" class="img-responsive margin-big-top float-right x2 margin-big-right">
            </a>
        </div><?php endforeach; endif; ?>
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