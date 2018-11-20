<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
<head>
    <title>我的收藏</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=750px,target-densitydpi=device-dpi,user-scalable=no,maximum-scale=1.0">
    <link rel="stylesheet" href="/Public/pintuer/pintuer.css">
    <link rel="stylesheet" href="/Public/css/page.css">
    <style>
        body{
            background: #eee;
        }
        .apply{
            position: relative;
        }
       .apply{
            width: 75px;
            height: 88px;
        }
        .apply a img:last-child{
            width: 100%;
            height: 100%;
        }
        .apply  .up_img{
             width: 65%;
            background-size:60%;
            position: absolute;
            top: 6%;
            left:0%;
            z-index: 10;
        }
      dl.clearfix{
            padding-bottom: 0;
            margin-bottom: 10px;
        }
        .title{
            color:#FC9A03 ;
            font-size: 2.2rem;
        }
        p.margin-top{
            font-size: 1.8rem;
        }
        h1.text-white{
            font-size: 2.6rem;
        }
        .nodate{
            width: 100%;
            height: 100%;
            position: absolute;
            top:6%;
            z-index: 100;
            background:url("/Public/images/nodata.png")no-repeat center 50%;
        }
        .nodate h1{
            text-align: center;
            position: absolute;
            top:58%;
            left: 44%;
        }
    </style>
</head>
<body>
 <?php if($count == 0): ?><div class="nodate" >
    <h1>
        暂无收藏
    </h1>
</div>
    <div class="layout">
        <div  class="line text-center padding " style="background: #FC9A03">
            <div class="x1">
                <a href="javascript:history.back(-1);"><img src="/Public/images/ht.png" alt="" class="img-responsive"style="width: 40%"></a>
            </div>
            <div class="x11 ">
                <h1 class="text-white">我的收藏</h1>
            </div>
        </div>
 </div>
        <?php else: ?>
            <div class="layout">
        <div  class="line text-center padding " style="background: #FC9A03">
            <div class="x1">
                <a href="javascript:history.back(-1);"><img src="/Public/images/ht.png" alt="" class="img-responsive"style="width: 40%"></a>
            </div>
            <div class="x11 ">
                <h1 class="text-white">我的收藏</h1>
            </div>
        </div>
        <!--收藏内容-->
        <?php if(is_array($list)): foreach($list as $key=>$vo): ?><div class="margin border-bottom clearfix">
	            <dl>
	                <dd class="x3 apply">
	                    <a href="/Home/Index/detail/ac_id/<?php echo ($vo["ac_id"]); ?>"> 
	                      <?php if($vo["status"] == 0): ?><img src="/Public/images/ongoing.png" alt="" class="img-responsive up_img">
	                      <?php else: ?>
	                          <img src="/Public/images/ending.png" alt="" class="img-responsive up_img"><?php endif; ?>
	                     <img src="/<?php echo ($vo["ac_img"]); ?>" alt="" class="img-responsive">
	                     </a>
	                </dd>
	                <dt class="x9 padding-left margin-small-top">
	                      <p class="content"><?php echo ($vo["ac_title"]); ?></p>
	                    <p><?php echo ($vo["category_id"]); ?> | <?php echo ($vo["view_addr"]); ?> | <span><?php echo ($vo["fit_age"]); ?></span>岁</p>
	                    <p class="float-left">累计<span><?php echo ($vo["count"]); ?></span>人报名</p>
	                    <p class="float-right "><span class="pic">￥</span><span class="text-red text-large"><?php echo ($vo["single_price"]); ?></span><span class="pic">起</span></p>
	                </dt>
	            </dl>
	            <a href="/Home/Min/collection_del/ac_id/<?php echo ($vo["ac_id"]); ?>" class="float-right cancel">取消收藏</a>
	        </div><?php endforeach; endif; ?>
    </div><?php endif; ?>
     <div class="pages" style="height: 80px;font-size:1.5rem;">    
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