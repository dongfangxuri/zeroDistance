<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
<head>
    <title><?php echo ($title); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <link rel="stylesheet" href="/Public/pintuer/pintuer.css">
    <link rel="stylesheet" type="text/css" href="/Public/css/swiper.min.css">
    <link rel="stylesheet" href="/Public/css/index.css">
    <link rel="stylesheet" href="/Public/css/page.css">
    <style>
        .apply{
            position: relative;
        }
        .apply b{
            display: block;
            height: 90px;
            width: 90px;
            background: url(/Public/images/ongoing.png)no-repeat;
            background-size:60%;
            position: absolute;
            top: 4%;
            left:0%;
            z-index: 10;
        }
        .content{
            height: 48px;
            overflow: hidden;
        }
        .annualCard{
            display: inline-block;
            background: #85C43F;
            color: #fff;
            font-weight: bold;
            height: 1.2rem;
        }
        dt.x9 p{
            font-weight: normal;
            font-size: 16px;
            margin-bottom: 5px;
        }
        dt.x9 p:not(:first-child){
            margin-bottom: 0px;
            font-size: 14px;
            color: #BFBFBF;
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
    </style>

</head>
<body>
<!--头部信息-->
    <header class="layout" >
        <div  class="line text-center padding " style="background: #FC9A03">
            <div class="x1">
                <a href="javascript:history.back(-1);"><img src="/Public/images/ht.png" alt="" class="img-responsive"style="width: 40%"></a>
            </div>
            <div class="x11 ">
                <h1 class="text-white"><?php echo ($title); ?></h1>
            </div>
        </div>
    </header>

<!--主体内容-->
    <section class="layout margin-little-top">
        <!--轮播-->
        <div class="swiper-container">
            <div class="swiper-wrapper">
 			<?php if(is_array($lun)): foreach($lun as $key=>$vo): ?><div class="swiper-slide">
                    <img style="width:100%" src="/<?php echo ($vo["pic_path"]); ?>" alt="">
                </div><?php endforeach; endif; ?>
            </div>
            <!-- 如果需要分页器 -->
            <div class="swiper-pagination"></div>
        </div>
        <!--分类-->
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
	                <p class="content"> <a href="/Home/Index/detail/ac_id/<?php echo ($vo["ac_id"]); ?>"><?php echo ($vo["ac_title"]); ?></a></p>
	                <p>亲子游 | <?php echo ($vo["view_addr"]); ?> | <span><?php echo ($vo["fit_age"]); ?></span>岁</p>
	                <p class="float-left">累计<span><?php echo ($vo["count"]); ?></span>人报名</p>
	                <p class="float-right "><sup>&yen;</sup><span class="text-red text-large"><?php echo ($vo["least_price"]); ?></span><span class="pic">起</span></p>
	                </dt>
	            </dl>
	        </div><?php endforeach; endif; ?>
               <div class="pages" style="height: 80px">    
　　                           <?php echo ($page); ?>
        </div>
    </section>
<!--页脚-->
    <!--<footer class="layout fixed-bottom  footer">-->
     <!--<div class="layout">-->
        <!--<ul class="line">-->
            <!--<li class="x3"><a href="index.html"><img src="images/footer/home_active.png" class="img-responsive" ></a></li>-->
            <!--<li class="x3"><a href="rili.html"><img src="images/footer/calendaer.png" class="img-responsive" ></a></li>-->
            <!--<li class="x3"><a href="message.html"><img src="images/footer/message.png" class="img-responsive" ></a></li>-->
            <!--<li class="x3"><a href="user.html"><img src="images/footer/user.png" class="img-responsive" ></a></li>-->
        <!--</ul>-->
    <!--</div>-->
<!--</footer>-->
<script src="/Public/pintuer/jquery.js"></script>
<script src="/Public/pintuer/pintuer.js"></script>
<script type="text/javascript" src="/Public/js/swiper.jquery.min.js"></script>
<script src="/Public/js/zepto1.js"></script>
<script src="/Public/js/sm1.js"></script>
<script src="http://api.map.baidu.com/api?v=2.0&ak=iNRD8iIAjCuobjHgg72ukB5ghbKpsaj4"></script>
<script src="/Public/js/index.js"></script>
<script>
        //通过IP地址获取城市名称
        $(function() {
            function getadress() {
                var geolocation = new BMap.Geolocation();
                geolocation.getCurrentPosition(function (r) {   //定位结果对象会传递给r变量
                    if (this.getStatus() == BMAP_STATUS_SUCCESS) {  //通过Geolocation类的getStatus()可以判断是否成功定位。
                        var myGeo = new BMap.Geocoder();
                        // 根据坐标得到地址描述
                        myGeo.getLocation(new BMap.Point(r.point.lng, r.point.lat), function (result) {
                            if (result) {
                                var address = result.addressComponents.city.replace(/市/g, "");
                                $("#city-picker").val(address).css("color","#fff");

                            }
                        });
                    }
                    else {
                        alert('failed' + this.getStatus());
                    }
                }, {enableHighAccuracy: true});
            }
            getadress();
        });

        //改变事件
        function upperCase(val){
            $.ajax({ url: "test.html", context: document.body, success: function(){
                $(this).addClass("done");
            }});
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