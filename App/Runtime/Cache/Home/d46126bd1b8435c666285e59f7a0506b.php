<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
<head>
    <title>常用出行人</title>
    <meta charset="utf-8"/>
    <!--<meta name="viewport" content="width=device-width, initial-scale=1.0">-->
    <meta name="viewport" content="width=750px,target-densitydpi=device-dpi,user-scalable=no,maximum-scale=1.0">
    <link rel="stylesheet" href="/Public/pintuer/pintuer.css">
    <link rel="stylesheet" href="/Public/css/page.css">
    <style>
        body{
            background: #EBEBEB;
        }
        h1.text-white{
            font-size: 2.4rem;
        }
        .data_list ul{
            list-style: none;
            padding:1rem 2rem ;
            font-size: 2rem;
            background: #fff;
            position: relative;
        }
        .data_list ul img{
            position: absolute;
            top: 3rem;
            right: 2rem;
        }
        .sex{
            font-size: 1.8rem;
            margin-top: 0.5rem;
            border:2px solid #F79B08;
            padding-left: 0.5rem;
        }
        .sex span{
            border-left:2px solid #F79B08;
            padding-left: 0.5rem;
        }
        .data_list .x9{
           color: #B2B2B2;
        }
        .IDNumber{
            margin-top: 0.5rem;
        }
        .add{
            display: block;
            width: 75%;
            margin: 0 auto;
            background: #FC9A03;
            font-size: 2.2rem;
            margin-top: 1.6rem;
            padding: 2rem;
            border-radius: 1rem;
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
                <h1 class="text-white">常用出行人</h1>
            </div>
        </div>
        <?php if(is_array($list)): foreach($list as $key=>$vo): ?><div class="data_list margin-little-bottom clearfix">
	            <ul class="x3">
	                <li><?php echo ($vo["name"]); ?></li>
	                <li class="sex radius-big">
	                    <?php echo ($vo["is_child"]); ?><span ><?php echo ($vo["sex"]); ?></span>
	                </li>
	            </ul>
	            <ul class="x9">
	                <li><?php echo ($vo["ID_type"]); ?></li>
	                <a href="/Home/Min/contact_update/id/<?php echo ($vo["id"]); ?>"> <img src="/Public/images/right.png" alt="" class="img-responsive"></a>
	                <li class="IDNumber">
	                    <span><?php echo ($vo["ID_card"]); ?></span>
	                </li>
	            </ul>
	        </div><?php endforeach; endif; ?>
         <div class="pages" style="height: 80px;font-size:1.5rem;">    
　　                           <?php echo ($page); ?>
        </div>
        <a href="/Home/Min/contact_add" class="add text-center text-white "><span>+</span> 新增加人员</a>
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