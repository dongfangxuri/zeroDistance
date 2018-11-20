<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
<head>
    <title>积分</title>
    <meta charset="utf-8"/>
    <!--<meta name="viewport" content="width=device-width, initial-scale=1.0">-->
    <meta name="viewport" content="width=750px,target-densitydpi=device-dpi,user-scalable=no,maximum-scale=1.0">
    <link rel="stylesheet" href="/Public/pintuer/pintuer.css">
    <style>

        h1.text-white{
            font-size: 2.4rem;
        }
        .totalPoints{
            margin: 0;
            font-size: 2.4rem;
            line-height:5.2rem;
        }
        .totalPoints img{
            width:10%;
            display: inline-block;
            margin-left: 20%;

        }
        .text-color{
            color:#FD4F64;
        }
        .share{
            font-size: 2.6rem;
            padding-left: 6%;
            color: #222;
        }
        .friend{
            list-style: none;
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
        <div  class="line text-center padding-big " style="background: #FC9A03">
            <div class="x1">
                <a href="javascript:history.back(-1);"><img src="/Public/images/ht.png" alt="" class="img-responsive margin-big-left"style="width: 50%"></a>
            </div>
            <div class="x11 ">
                <h1 class="text-white">我的积分</h1>
            </div>
        </div>
      <p class="clearfix totalPoints">
          <!--图片-->
          <img src="/Public/images/logo.png" alt="" class="img-responsive">
                当前积分 <span class="text-color"><?php echo ($model["star"]); ?>分</span>
      </p>
        <div class="text-center">
           <span class="share border-bottom x12 padding text-left ">积分规则</span>
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
            <a href="#" class="x3 wx_friend" onclick="wxfriendshare();"></a>
            <a href="#" class="x3 friend_circle"></a>
            <a href="#" class="x3 Qzone"></a>
            <a href="#" class="x3 QQ_friend"></a>
        </div>
    </div>
<script src="/Public/pintuer/jquery.js"></script>
<script src="/Public/pintuer/pintuer.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
  /*
   * 注意：
   * 1. 所有的JS接口只能在公众号绑定的域名下调用，公众号开发者需要先登录微信公众平台进入“公众号设置”的“功能设置”里填写“JS接口安全域名”。
   * 2. 如果发现在 Android 不能分享自定义内容，请到官网下载最新的包覆盖安装，Android 自定义分享接口需升级至 6.0.2.58 版本及以上。
   * 3. 常见问题及完整 JS-SDK 文档地址：http://mp.weixin.qq.com/wiki/7/aaa137b55fb2e0456bf8dd9148dd613f.html
   *
   * 开发中遇到问题详见文档“附录5-常见错误及解决办法”解决，如仍未能解决可通过以下渠道反馈：
   * 邮箱地址：weixin-open@qq.com
   * 邮件主题：【微信JS-SDK反馈】具体问题
   * 邮件内容说明：用简明的语言描述问题所在，并交代清楚遇到该问题的场景，可附上截屏图片，微信团队会尽快处理你的反馈。
   */
  wx.config({
    debug:false,
    appId: '<?php echo $signPackage["appId"];?>',
    timestamp: <?php echo $signPackage["timestamp"];?>,
    nonceStr: '<?php echo $signPackage["nonceStr"];?>',
    signature: '<?php echo $signPackage["signature"];?>',
    jsApiList: [
      // 所有要调用的 API 都要加到这个列表中
	  	  'onMenuShareAppMessage',
		  'onMenuShareTimeline',
		  'onMenuShareQQ',
		  'onMenuShareQZone',
          //'checkJsApi'
    ]
  });
  wx.ready(function () {
		// 在这里调用 API
		wx.checkJsApi({
		   jsApiList:[
			  'onMenuShareAppMessage',
			  'onMenuShareTimeline',
			  'onMenuShareQQ',
			  'onMenuShareQZone'
		   ]
		});
		//分享到朋友圈 
		wx.onMenuShareTimeline({
		title: '零距离童军', // 分享标题
		link: 'qz.imweixi.com', // 分享链接
		imgUrl: '/Public/images/logo.png', // 分享图标
		success: function () {
		    $.get('/Home/Min/wxzoneshare');
			alert("分享成功");
			// 用户确认分享后执行的回调函数
		},
		cancel: function () {
			alert("分享取消");
			// 用户取消分享后执行的回调函数
		}
	   });
	   	//分享到微信好友 
		wx.onMenuShareAppMessage({
		title: '零距离童军', // 分享标题
		link: 'qz.imweixi.com', // 分享链接
		imgUrl: '/Public/images/logo.png', // 分享图标
		success: function () {
		    $.get('/Home/Min/wxfriend');
			alert("分享成功");
			// 用户确认分享后执行的回调函数
		},
		cancel: function () {
			alert("分享取消");
			// 用户取消分享后执行的回调函数
		}
	   });
	   
	   	//分享给qq好友
		wx.onMenuShareQQ({
			title: '零距离童军', // 分享标题
			desc: '零距离童军', // 分享描述
			link: 'qz.imweixi.com', // 分享链接
			imgUrl: '123', // 分享图标
			success: function () {
			   // 用户确认分享后执行的回调函数
			   $.get('/Home/Min/qqfriend');
		       alert("分享成功");
			},
			cancel: function () {
			   // 用户取消分享后执行的回调函数
			    alert("分享取消");
			}
		});
	   //分享到qq空间
	   wx.onMenuShareQZone({
			title: '零距离童军', // 分享标题
			desc: '零距离童军',
			link: 'qz.imweixi.com', // 分享链接
			imgUrl: '123', // 分享图标
			success: function () { 
			   $.get('/Home/Min/zoneshare');
			   alert('分享成功');
			   // 用户确认分享后执行的回调函数
			},
			cancel: function () { 
				// 用户取消分享后执行的回调函数
			}
		});
  });
wx.error(function (res) {
   alert(res.errMsg);  //打印错误消息。及把 debug:false,设置为debug:ture就可以直接在网页上看到弹出的错误提示
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