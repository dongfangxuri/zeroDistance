<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
<head>
    <title>修改密码</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--<meta name="viewport" content="width=750px,target-densitydpi=device-dpi,user-scalable=no,maximum-scale=1.0">-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="stylesheet" href="/Public/pintuer/pintuer.css">
    <style>
        body{
            background: #f7f7f7;

        }
        input[ name="password"]{
            width: 70%;
            margin: 0 auto;
            padding-left:6%;
            background: url(/Public/images/password.png) no-repeat 3px 4px ;
            background-size:18px;
        }
        .input-help{
            list-style: none;
            padding-left: 20%;
        }
        .cz{
            width: 70%;
            margin: 0 auto;
            background:#FC9A03 ;

        }
    </style>
</head>
<body>
<div align="center">
    <form action="#default.html" method="post">
        <div class="panel"  style="width:100%;text-align: left;">
            <div class="text-center margin-bottom">
                <a href="javascript:history.back(-1);"><img src="/Public/images/btn_back_arrow_orange.png" alt="" class="img-responsive float-left margin-small-top" style="display:inline-block;width: 3%;margin-top:18px;margin-left:10px;" ></a>
                <h1 class="padding genggaipwd">更改密码</h1>
            </div>
            <div class="" >
                <div class="form-group">
                    <div class="field field-icon-right">
                        <input type="password" class="input" name="password1" placeholder="新密码" maxlength="32" data-validate="required:请填写新密码,length#>=6:密码长度不符合要求" />

                    </div>
                </div>
                <div class="form-group">
                    <div class="field field-icon-right">
                        <input type="password" class="input" name="password2" placeholder="确认密码" maxlength="32" data-validate="required:请填写确认新密码,length#>=6:密码长度不符合要求" />

                    </div>
                </div>
                <div class="form-group">
                    <div class="field">
                        <button class="button button-block bg-main text-big cz">确定</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
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