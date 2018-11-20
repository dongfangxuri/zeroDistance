<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
<head>
    <title>注册</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="stylesheet" href="/Public/pintuer/pintuer.css">
    <style>
        body{
            background: #f7f7f7;
        }
        h2{
            color: #FC9A03;
        }
        input[type="password"],input[name="admin"]{
            padding-left: 8%;
            width: 70%;
            margin: 0 auto;
        }
        .input-help{
            list-style: none;
            padding-left: 20%;
        }

        input[name="admin"]{
            background: url(/Public/images/user_name.png) no-repeat 3px 4px ;
            background-size: 24px;
        }
        input[name="passcode"]{
            padding-left:22%;
            background: url(/Public/images/icon_yzm@2x.png) no-repeat 3px 4px ;
            background-size: 24px;
        }
        input[ name="password"]{
            padding-left:8%;
            background: url(/Public/images/password.png) no-repeat 3px 4px ;
            background-size:18px;
        }
        button[type="button"]{
            background:#0073D8;
            color:#fff
        }
        .zc{
            width: 70%;
            margin: 0 auto;
            background: #FB9A02;
        	border:none; 
        }
		#user_name
		{
		  width: 70%;
		  margin: 0 auto;
		}
    </style>
</head>
<body>
<div align="center">
    <form action="/Home/Index/register" method="post" onsubmit='return checkform();'>
        <div class="panel " style="width: 100%;text-align: left;">
            <div class="text-center">
                <h2 class="text-center padding-big bg-white margin-bottom"><a href="javascript:history.back(-1);"><img src="/Public/images/btn_back_arrow_orange.png" alt="" class="img-responsive float-left margin-small-top" style="display: inline-block;width: 3%" ></a>欢迎来到零距离童军</h2>
              </div>
            <div class="" >
                <div class="form-group">
                    <div class="field field-icon-right">
                        <input type="text" class="input" id="user_name" name="phone" placeholder="手机号码"maxlength="11" data-validate="required:请填写手机号码,mobile:请填写正确的手机号码" />
                    </div>
                </div>
                <div class="form-group">
                    <div class="field">
                        <div class="line" style="width: 70%;margin: 0 auto">
                            <div class="input-group padding-little-top">
                                <input type="text" class="input verify" id="verify" name="passcode" maxlength="6" placeholder="短信验证码" data-validate="required:请填写手机收到的短信验证码" />
							<span class="addbtn yzm">
			                    <button type="button" class="button" id="code" onclick="return checkForm();">
                                    获取验证码</button>
			                </span>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="form-group">
                    <div class="field field-icon-right">
                        <input type="password" class="input" name="password" maxlength="32" placeholder="登录密码" data-validate="required:请填写密码,length#>=6:密码长度不符合要求" />
                    </div>
                </div>
                <div class="form-group">
                    <div class="field field-icon-right">
                        <input type="password" class="input" name="password" maxlength="32" placeholder="重复密码" data-validate="required:请填写密码,length#>=6:密码长度不符合要求" />
                    </div>
                </div>
                <div class="form-group">
                    <div class="field">
                        <button class="button button-block bg-main text-big zc">立即注册</button>
                    </div>
                </div>
                <div class="form-group">
                    <div class="field text-center">
                        <p class="text-muted text-center"><a class="" href="/Home/Index/login">已有帐号，去登录</a>
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </form>
</div>
<script src="/Public/pintuer/jquery.js"></script>
<script src="/Public/pintuer/pintuer.js"></script>
 <script src="/Public/js/jquery-1.11.3.js"></script>
    <script>
    function checkform(){
        var user = $('#user_name').val();
        var pwd = $('#password').val();
        var code = $('#verify').val();
        if(user==""){
            alert('请输入手机号码!');return false;
        }else if(user.match(/^1[3458]\d{9}$/g)==null){
            alert('手机号码格式不正确!');return false;
        }else if(pwd ==''){
            alert('请输入登录密码!');return false;
         }
    	 else if(code==""){
    	    alert('请输入验证码!');return false;
    	 }
    	 else if(code.match(/^\d{4}$/)==null){
    	    alert('验证码格式不正确!');return false;
    	 }
        }
     function checkForm(){
 	    var mobile=$('#user_name').val();
		var reg=/^1(3|4|5|7|8)\d{9}$/ ;
		if(mobile!=""&&reg.test(mobile)){
			$.ajax({
			   type:"get",
			   url:"/Home/Sms/sendSMS",
			   data: {"mobile":mobile},
			   dataType:"json",
			   success:function(data){
				   alert(data);
				   }
			   }
			);
			return true;
		}
		else{
		   return false;
		}
	}
    $("#user_name").on("blur",function(){
        var userName = $('#user_name').val();
        var reg=/^1(3|4|5|7|8)\d{9}$/ ;
        if(userName!=""&&reg.test(userName)){
            $("#code").css("background","#c40c0c");
			//$("#msgcode").attr("href","/Home/Sms/sendSMS?phone="+userName); 
            var validCode=true;
            $("#code").click (function() {
                var time=60;
                var code=$(this);
                if (validCode) {
                    validCode=false;
                    code.addClass("msgs1");
                    var t=setInterval(function  () {
                        time--;
                        code.html(time+"秒");
                        if (time==0) {
                            clearInterval(t);
                            code.html("重新获取");
                            validCode=true;
                            code.removeClass("msgs1");
                        }
                    },1000)
                }
              return true;
			}); 
        }else{
            $("#code").css("background","#ddd");
        }
    });


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