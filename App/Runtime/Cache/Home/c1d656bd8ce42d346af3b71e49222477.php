<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
<head>
    <title>登录</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="stylesheet" href="/Public/pintuer/pintuer.css">

    <style>
        body{
            background: #f7f7f7;
        }
        .passcode {
            position: absolute;
            right: 0;
            top: 0;
            height: 32px;
            margin: 1px;
            border-left: solid 1px #ddd;
            text-align: center;
            line-height: 32px;
            border-radius: 0 4px 4px 0;
        }
        h1,h2{
            color: #F69C14;
        }
       #password,#username{
            width: 70%;
            margin: 0 auto;
            height: 40px;
           padding-left: 10%;

        }

        .btn,.wx_btn{
            width: 70%;
            background: #FC9A03;
            color: #fff;
            font-size:16px;
            height: 40px;
            line-height:40px;
            padding: 0;
            margin: 15px auto 0;
        	border:none;
        }
        .wx_btn{
            background: #3EB034;
         }
        #username{
            background: url(/Public/images/user_name.png) no-repeat 3px 4px ;
            background-size: 26px;
        }
        #password{
            background: url(/Public/images/password.png) no-repeat 3px 4px ;
            background-size: 26px;
        }
        .input-help{
            list-style: none;
            padding-left: 20%;
        }
    </style>
</head>
<body>
<div class="layout">
    <div align="center">
        <form action="#index.html" method="post">
            <div class="panel " style="width: 100%;text-align: left;">
                <div class="text-center">
                    <h1 class="text-center bg-white padding-big" ><a href="/Home/Index/index"><img src="/Public/images/btn_back_arrow_orange.png" alt="" class="img-responsive float-left margin-small-top" style="display: inline-block;width: 3.5%" ></a>登录</h1>
                    <h2 class="text-center padding-big">欢迎来到零距离童军</h2>
                    </div>
                <div class="">
                    <div class="form-group">
                        <div class="field field-icon-right">
                            <input type="text" class="input" id="username" name="username" placeholder="登录账号" data-validate="required:请填写账号,length#>=5:账号长度不符合要求" />
                            <span class="icon_neme"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="field field-icon-right">
                            <input type="password" class="input" id="password" name="password" placeholder="登录密码" data-validate="required:请填写密码,length#>=6:密码长度不符合要求" />
                            <span class="icon_key"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="field text-center">
                            <p class="text-muted text-center"><a class="text-blue" href="register">注册新账号</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a class="text-red" href="/Home/Index/forgetPwd"><small>忘记密码了？</small></a>
                            </p>
                        </div>
                    </div>
                    <div class="form-group  text-center">
                        <div class="field">
                            <button class="button button-block bg-main text-big  btn">立即登录</button>
                            <?php if($isweixin == 1): ?><a href="https://mp.weixin.qq.com" class="button button-block bg-main text-big wx_btn">微信一键登录</a><?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </form>
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