<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
<head>
    <title>个人中心</title>
    <meta charset="utf-8"/>
    <!--<meta name="viewport" content="width=device-width, initial-scale=1.0">-->
    <meta name="viewport" content="width=750px,target-densitydpi=device-dpi,user-scalable=no,maximum-scale=1.0">
    <link rel="stylesheet" href="/Public/pintuer/pintuer.css">
      <style>
        body{
            background: #F8F8F8;
        }
        ul{
            list-style: none;
        }
        .header-box{
            background: #FC9A03;
            padding: 1.8rem;
            height: 16rem;
            font-size: 2.2rem;
            color: #fff;
        }
        .userName{
            height: 4rem;
            padding-top:1rem ;
        }
        .userName img{
            margin-left: 1rem;
        }
        .exit{
            color: #fff;
        }
        p.text-center{
            font-size: 2rem;
            line-height: 2.6rem;
            margin: 0;
        }
        .inden_list{
            list-style: none;
            height:9rem;
            background: #fff;
            margin-bottom: 3rem;
        }
        .inden_list li p{
            font-size: 1.6rem;
            margin: 0;
            margin-top: 1rem;
        }
        .inden_list img{
            width: 25%;
            display: inline;
           /* border-radius: 50%;*/
        }
        .inden_list img:first-child{
            margin-left: 1.3rem;
        }

        .inden_list span{
           margin-bottom: 3rem;
          border: 2px solid red;
            color:red;
            background: #fff;
            border-radius: 50%;
            font-size: 1rem;
        	width: 2rem;
		    height: 2rem;
		    line-height: 1.3rem;
        }
        .mse_all li{
            list-style: none;
            border-bottom: 1px solid #ddd;
            background: #fff;
            padding-left: 1rem;
            font-size: 1.8rem;
            padding: 2rem;
        }
        .mse_all li a img{
            margin-right: 1rem;
        }
        .mse_all li a img:last-child{
            margin-top: 0.3rem;

        }

        .amendName{
            position: absolute;
            width: 100%;
            height: 100%;
            z-index: 10;
            background: rgba(0,0,0,0.5);
            display: none;
        }
        .amendName>div{
            background: #fff;
            width: 80%;
            height: 40rem;
            margin: 10rem auto;
            border-radius:1rem;
            position: relative;
        }
        .xgxx{
            font-size: 2.4rem;
            color: #FC9A03;
        }

        .xg_box ul{
            margin: 0 2rem;
        }
        .xg_box ul li{
            list-style: none;
            height:6rem;
            line-height: 6rem;
            padding-left: 1rem;
            font-size: 2rem;
            border-bottom: 1px solid#ddd;
        }
        .shangchuan {
            height: 8rem;
            border-bottom: 1px solid #ddd;
        }
        .xg_box p{
            font-size: 2rem;
            float: left;
            width: 12rem;
            margin-top: 3rem;
            line-height: 3rem;
            padding-left: 3rem;
        }
        .shangchuan img{
            position: absolute;
            top:5rem;
            right: 1rem;
            width: 6rem;
            height: 6rem;
            border-radius: 50%;
        }
        #imgs{
            position: absolute;
            width: 6rem;
            height: 6rem;
            top:5rem;
            right: 1rem;
            opacity: 0;
        	z-index:10;
        }
        li input[type="text"]{
            font-size: 2rem;
            border: none;
        }
        .abolish{
            display: inline-block;
            width: 13rem;
            height: 4rem;
            margin-left:5rem;
            border-radius: 0.5rem;
            background: #FC9A03;
            color: #fff;
            margin-top: 2rem;
            padding: 1rem 2rem;
            font-size: 2rem;
            text-align: center;
        }

        #subbtn{
            float:right;
            width: 13rem;
            height: 4rem;
            font-size: 2rem;
            margin-top: 2rem;
            margin-right: 3rem;
            border: none;
            background: #43B83D;
            color: #fff;
            border-radius: 0.5rem;
        }

    </style>

</head>
<body>
    <div class="amendName" >
       <div>
           <form action="/Home/Min/changeinfo" class="xg_box" enctype="multipart/form-data" method="post">
               <h1 class="text-center padding xgxx" >修改信息</h1>
               <p>修改头像</p>
               <div class="shangchuan"> 
                   <input type="file" name="header_img" onchange="previewImage(this)" id="imgs"/>
                   <div id="preview">
                         <?php if(empty($$model["header_img"])): ?><img id="imghead" border=0 src='/Public/pc/images/child.png' class="preview">
                         <?php else: ?>
                           <img src="/<?php echo ($model["header_img"]); ?>" alt=""><?php endif; ?>
                   </div>
               </div>
               <ul>
                   <li>  昵称：<input type="text" name="nick_name" value="<?php echo ($model["nick_name"]); ?>" class="nicheng"></li>
                   <li>
                       <label><span class="sex">性别：</span>
                           <input type="radio" name="sex" value="男" checked="" class="forsex"><span class="sex_text">男</span>
                       </label>
                       <label>
                           <input type="radio" name="sex" value="女"  class="forsex"> <span class="sex_text">女</span>
                       </label>
                   </li>
                   <li>  地区：<input type="text" name="address" value="<?php echo ($model["address"]); ?>" class="nicheng"></li>

               </ul>
               <a href="#" class="abolish">取消</a>
               <input type="hidden" name="uid" value="<?php echo ($model["uid"]); ?>"/>
               <input type="submit" value="提交" id="subbtn">
           </form>
       </div>
    </div>
    <div class="layout clearfix">
        <div  class="line text-center padding-big header-box">
            <div class="x2">
                <a href="/Home/Index/changePwd"><img src="/Public/images/btn_set@2x.png" alt="" class="img-responsive margin-big-left"style="width: 50%"></a>
            </div>
            <div class="x8">
               
                <img src="/<?php echo ($model["header_img"]); ?>" alt="" class="radius-circle">
                <p class="userName">
                  <a href="#" class="text-white amend" ><?php echo ($model["nick_name"]); ?><img src="/Public/images/modify.png" alt=""></a>
                </p>
            </div>
            <div class="x2 ">
                <a href="/Home/Min/userexit"  class="exit">退出</a>
            </div>
        </div>
        <!--我的订单-->
        <div class="layout">
            <p class="text-center padding bg-white ">我的订单</p>
            <ul class=" line text-center inden_list ">
                <li class="x4"><a href="<?php echo U('Min/no_payment');?>"><img src="/Public/images/integral.png" alt="" class="img-responsive"><span class=" badge"><?php echo ($filter_unpay_num); ?></span></a><p>待付款订单</p></li>
                <li class="x4"><a href="<?php echo U('Min/no_assessment');?>"><img src="/Public/images/icon_no_way.png" alt="" class="img-responsive"><span class=" badge"><?php echo ($filter_uncomment_num); ?></span></a><p>待评价订单</p></li>
                <li class="x4"><a href="<?php echo U('Min/pay_finish');?>"><img src="/Public/images/icon_done.png" alt="" class="img-responsive" style="margin-left: 0"><span class=" badge"><?php echo ($filter_ok_num); ?></span></a><p>已完成订单</p></li>
            </ul>
        </div>
        <ul class="mse_all">
                <li><a href="/Home/Min/collection_list"><img src="/Public/images/icon_fav.png" alt="">我的收藏 <img src="/Public/images/right.png" alt="" class="float-right img-responsive"></a> </li>
                <li><a href="/Home/Message/index"><img src="/Public/images/icon_my_2.png" alt="" style="width: 7%">我的消息 <img src="/Public/images/right.png" alt="" class="float-right img-responsive"></a> </li>
                <li><a href="/Home/Min/integral"><img src="/Public/images/icon_my_3.png" alt="" style="width: 7%">我的积分 <img src="/Public/images/right.png" alt="" class="float-right img-responsive"></a> </li>
                <li><a href="/Home/Min/contact_list"><img src="/Public/images/icon_my_4.png" alt="" style="width: 7%">常用出行人 <img src="/Public/images/right.png" alt="" class="float-right img-responsive"></a> </li>
                <li><a href="/Home/Min/AboutUs" class="text-black"><img src="/Public/images/icon_about.png" alt="" >关于零距离童军 <img src="/Public/images/right.png" alt="" class="float-right img-responsive"></a> </li>

        </ul>
    </div>
    <!--页脚-->
    <footer class="layout fixed-bottom  footer">
     <div class="layout">
        <ul class="line">
            <li class="x3"><a href="<?php echo U('Index/index');?>"><img src="/Public/images/footer/home_active.png" class="img-responsive" ></a></li>
            <li class="x3"><a href="<?php echo U('Rili/activitycalendar');?>"><img src="/Public/images/footer/calendaer.png" class="img-responsive" ></a></li>
            <li class="x3"><a href="<?php echo U('Message/index');?>"><img src="/Public/images/footer/message.png" class="img-responsive" ></a></li>
            <li class="x3"><a href="<?php echo U('Min/index');?>"><img src="/Public/images/footer/user.png" class="img-responsive" ></a></li>
        </ul>
    </div>
    </footer>
<script src="/Public/pintuer/jquery.js"></script>
<script src="/Public/pintuer/pintuer.js"></script>
    <script type="text/javascript">
        $(".amend").click(function(){
            $(".amendName").show();
            $(".abolish").click(function(){
                $(".amendName").hide();
            });
        });
        //图片上传预览    IE是用了滤镜。
        function previewImage(file)
        {
            var MAXWIDTH  =90;
            var MAXHEIGHT = 90;
            var div = document.getElementById('preview');
            if (file.files && file.files[0])
            {
                div.innerHTML ='<img id=imghead>';
                var img = document.getElementById('imghead');
                img.onload = function(){
                    var rect = clacImgZoomParam(MAXWIDTH, MAXHEIGHT, img.offsetWidth, img.offsetHeight);
                    img.width  =  rect.width;
                    img.height =  rect.height;
                    img.style.marginTop = rect.top+'px';
                }
                var reader = new FileReader();
                reader.onload = function(evt){img.src = evt.target.result;}
                reader.readAsDataURL(file.files[0]);
            }
            else //兼容IE
            {
                var sFilter='filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale,src="';
                file.select();
                var src = document.selection.createRange().text;
                div.innerHTML = '<img id=imghead>';
                var img = document.getElementById('imghead');
                img.filters.item('DXImageTransform.Microsoft.AlphaImageLoader').src = src;
                var rect = clacImgZoomParam(MAXWIDTH, MAXHEIGHT, img.offsetWidth, img.offsetHeight);
                status =('rect:'+rect.top+','+rect.left+','+rect.width+','+rect.height);
                div.innerHTML = "<div id=divhead style='width:"+rect.width+"px;height:"+rect.height+"px;"+sFilter+src+"\"'></div>";
            }
        }
        function clacImgZoomParam( maxWidth, maxHeight, width, height ){
            var param = {top:0, left:0, width:width, height:height};
            if( width>maxWidth || height>maxHeight )
            {
                rateWidth = width / maxWidth;
                rateHeight = height / maxHeight;

                if( rateWidth > rateHeight )
                {
                    param.width =  maxWidth;
                    param.height = Math.round(height / rateWidth);
                }else
                {
                    param.width = Math.round(width / rateHeight);
                    param.height = maxHeight;
                }
            }

            param.left = Math.round((maxWidth - param.width) / 2);
            param.top = Math.round((maxHeight - param.height) / 2);
            return param;
        }


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