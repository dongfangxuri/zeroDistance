<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
<head>
    <title>消息中心</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=750px,target-densitydpi=device-dpi,user-scalable=no,maximum-scale=1.0">
    <link rel="stylesheet" href="/Public/pintuer/pintuer.css">
    <link rel="stylesheet" href="/Public/css/page.css">
    <style>
        body{
            background: #eee;
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
 <?php if($msg_count == 0): ?><div class="nodate" >
    <h1>
        暂无消息
    </h1>
</div>
    <div class="layout">
        <div  class="line text-center padding " style="background: #FC9A03">
            <div class="x1">
                <a href="javascript:history.back(-1);"><img src="/Public/images/ht.png" alt="" class="img-responsive"style="width: 40%"></a>
            </div>
            <div class="x11 ">
                <h1 class="text-white">消息中心</h1>
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
                <h1 class="text-white">消息中心</h1>
            </div>
        </div>
        <!--消息中心内容-->
        <?php if(is_array($list)): foreach($list as $key=>$vo): ?><div class="line">
            <dl class="clearfix bg-white padding">
                <dt class="x2"><img src="/Public/images/logo.png" alt="" class="img-responsive margin " style="width: 90%"></dt>
                <dd class="x10 padding-big-left">
                    <a href="/Home/Message/message_detail/id/<?php echo ($vo["id"]); ?>">
                        <span class="title"><?php echo ($vo["title"]); ?></span>
                        <img src="/Public/images/right.png" alt="" class="img-responsive float-right margin-big-top" style="width: 5%">
                        <p class="margin-top text-more padding-small-bottom"><?php echo ($vo["content"]); ?></p>
                    </a>
                </dd>
            </dl>
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