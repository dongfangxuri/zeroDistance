<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
<head>
    <title>了解童军</title>
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
            line-height: 5rem;
        }
        .text_conter{
            font-size: 2.4rem
        }
        .honor_list{
            font-size: 2rem;
        }
        .honor_list li{
            padding:1rem 0 1rem 5rem;
            border-bottom: 1px solid #ededed;
            color: #FD6703;
        }
        .honor_list li span{
            color: #444444;
            display: inline-block;
            width: 32%;

        }
        .honor_list li img{
            display: inline-block;
        }
        div.tu{
            position: relative;
        }
        div.tu>img{
            position: absolute;
            right: 5rem;
            top:5rem;
        }
        .spirit_list-right, .spirit_list{
            font-size: 2rem;
        }
        .spirit_list li{
            list-style: none;
           text-align: right;
            padding-right: 2rem;
        }
        .spirit_list-right li{
            text-align: left;
            padding-left: 2rem;
            list-style: none;
        }

    </style>
</head>
<body>
    <div class="layout">
        <div class="line">
            <a href="javascript:history.back(-1);" class="x2"><img src="/Public/images/idex.png" alt="" class="img-responsive padding-big retreat" > </a>
            <p class="x8">
                <img src="/Public/images/logo.png" alt="" class="img-responsive x2  padding-big" style="width: 20%;padding-right: 0">
                <img src="/Public/images/ojltj.png" alt="" class="img-responsive x9 padding-big ">
            </p>
            <a href="/Home/Min" class="x2"><img src="/<?php echo ($usermodel["header_img"]); ?>" alt="" class="img-responsive padding-big myhome"></a>
        </div>
        <p class="text-center padding-big honor">
            <!--图片-->
            <img src="/Public/images/bg_huizhang_top.png" alt="" class="img-responsive" style="display: inline-block;">
            <span class="text-white" >童军荣誉</span>
        </p>
        <p class="text-center border-bottom text_conter padding-big">
            一次经历 一次成长
        </p>
        <div class="line tu">
        <img src="/Public/images/bg_kid.png" alt="" class="img-responsive float-right" >
            <ul class="honor_list">
            <?php if(is_array($list)): foreach($list as $key=>$vo): ?><li><span><?php echo ($vo["number"]); ?>徽章</span><?php echo ($vo["remarks"]); ?> <img src="/<?php echo ($vo["pic"]); ?>" alt="" class="img-responsive"></li><?php endforeach; endif; ?>
            </ul>             
        </div>
        <p class="text-center border-bottom text_conter padding-big">
            童子军精神
        </p>
        <div class="line">
            <ul class="spirit_list x6">
                <li>值得信赖</li>
                <li>乐于助人</li>
                <li>谦恭有礼</li>
                <li>服从命令</li>
                <li>勤俭节约</li>
                <li>整洁纯朴</li>
            </ul>
            <ul class="spirit_list-right x6">
                <li>忠诚可靠</li>
                <li>为人友善</li>
                <li>平易近人</li>
                <li>乐观豁达</li>
                <li>乐观无畏</li>
                <li>虔诚恭敬</li>
            </ul>
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