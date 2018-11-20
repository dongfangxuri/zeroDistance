<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
<head>
    <title>首页</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <link rel="stylesheet" href="/Public/pintuer/pintuer.css">
    <link rel="stylesheet" type="text/css" href="/Public/css/swiper.min.css">
    <link rel="stylesheet" href="/Public/css/index.css">
</head>
    <style>
            .swiper-slide a {
                display: inline-block;
                width: 70px;
                height: 70px;
                overflow: hidden;
            }
            .swiper-slide a img{
                display: inline-block;
                width: 100%;
                height: 100%;              
            }
    </style>
    <style>
        .text_color{
            color: #555;
        }
    </style>
<body>
<!--头部信息-->
    <header class="layout header" >
        <div class="line text-center">
           <div class="x3">
               <input type="text"  id='city-picker' class="text-center " placeholder="<?php echo ($cityname); ?>" onchange="upperCase()"/>
               <input type="hidden"  id='hidd' name="cityname"/>
               <!--开通城市-->
               <div class="layout city_down">
                    <h2>已开通城市</h2>
                   <ul>
				   <?php if(is_array($citylist)): foreach($citylist as $key=>$vo): ?><li><a href="/Home/Index/index/cityid/<?php echo ($vo["areaid"]); ?>"><?php echo ($vo["name"]); ?></a></li><?php endforeach; endif; ?>
                   </ul>
                    <h3>更多城市即将开通</h3>
               </div>
           </div>
            <div class="x6">
               <form action="/Home/Index/search" class="search">
                   <input id="index_search_keyword" type="text" name="keyword" placeholder="请输入关键词"   class="text-white border border-white border-small radius-big input-small" >
                   <input type="submit" class="submit_btn" value="">
               </form>
           </div>
           <div class="x3 ">
               <a href="<?php echo U('Index/Login');?>">
	              <?php if(empty($header_img)): ?><img src="/Public/images/btn_user.png" class="margin-small-bottom">
	              <?php else: ?> 
	                 <img src="/<?php echo ($header_img); ?>" class="margin-small-bottom" style="width:2.1rem;height:2.1rem;border-radius:50%"><?php endif; ?>
               </a>
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
        <div class="line">
		  <?php if(is_array($menu1)): foreach($menu1 as $key=>$vo): ?><div class="x3 text-center">
                  <dl>
                      <dd>
                          <a href="<?php echo ($vo["url"]); ?>/id/<?php echo ($vo["id"]); ?>">
                          <img style="background-color:white;display:inline-block;border-radius:50%" src="/<?php echo ($vo["image_url"]); ?>"></a>
                      </dd>
                      <dt class="text_color"><?php echo ($vo["menu_name"]); ?></dt>
                  </dl>
              </div><?php endforeach; endif; ?>
           </div>
        <div class="line">
		  <?php if(is_array($menu2)): foreach($menu2 as $key=>$vo): ?><div class="x3 text-center">
                  <dl>
                      <dd>
                          <a href="<?php echo ($vo["url"]); ?>/id/<?php echo ($vo["id"]); ?>"><img style="background-color:white;display:inline-block;border-radius:50%" src="/<?php echo ($vo["image_url"]); ?>"></a>
                      </dd>
                      <dt class="text_color"><?php echo ($vo["menu_name"]); ?></dt>
                  </dl>
              </div><?php endforeach; endif; ?>
            </div>
        <!--水平线-->
        <hr class="level">
        <!--累计报名人数
        <div class="line release">
            <div class="x4">
                <span class="text-center">最新发布 :</span>
            </div>
            <div class="x8">
                <div class="slide-wrap">
                    <div class="slide-mask">
                        <ul class="slide-group ">
                        <?php if(is_array($articlelist)): foreach($articlelist as $key=>$vo): ?><li class="slide"><a href="#" class="text-more"><?php echo ($vo["title"]); ?></a></li><?php endforeach; endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div> -->
        <!--旅游地址-->
        <div class="container-layout">
        <?php if(is_array($qinzilist)): foreach($qinzilist as $key=>$vo): ?><div class="line">
                <ul>
                    <li class="apply text-center">
                        <a href="/Home/Index/detail/ac_id/<?php echo ($vo["ac_id"]); ?>"><img style="width:100%" src="/<?php echo ($vo["ac_img"]); ?>" class="img-responsive"></a>
                        <p class="apply-num  ">
                            累计报名人数:<b> <?php echo ($vo["count"]); ?> </b>人
                        </p>
                        <p class="apply-pic"><?php echo ($vo["least_price"]); ?>元起</p>
                    </li>
                    <li class="text-more margin-small-top margin-small-bottom">
                        <?php echo ($vo["ac_title"]); ?>
                    </li>
                    <li>
                       <h6 class="text-gray margin-small-bottom">  <?php echo ($vo["ac_intro"]); ?></h6>
                    </li>
                    <li class="qzy text-center">
                        <p class="margin-big-right text-white radius">亲子游</p>
                        <p class="margin-big-right text-white radius"><?php echo ($vo["view_addr"]); ?></p>
                        <p class="margin-big-right text-white radius"><?php echo ($vo["fit_age"]); ?>岁</p>
                        <hr class="bg-back">
                    </li>
                </ul>
            </div>
            <foreachelse><?php endforeach; endif; ?>
        </div>
        <!--亲子住宿-->
        <div class="container-layout stay">
            <img src="/Public/images/scenic.png" class="img-responsive">
            <h1 class="text-center text-white ">景区门票直购</h1>
            <p class="text-center text-white">乐山乐水乐行 | 便捷出行</p>
           <h5>
               <a href="/Home/Index/category/id/4" class="radius border-white text-center">
                   查看全部
               </a>
           </h5>
        </div>
        <div class="container-layout scenic-box margin-small-top">
            <div class="scenic">
                <div class="swiper-container2">
                    <div class="swiper-wrapper">
                      <?php if(is_array($ticketlist_recommend)): foreach($ticketlist_recommend as $key=>$vo): ?><div class="swiper-slide">
                            <a href="/Home/Index/detail/ac_id/<?php echo ($vo["ac_id"]); ?>"><img src="/<?php echo ($vo["ac_img"]); ?>" class="img-responsive "></a>
                            <p class="text-center text-more"><?php echo ($vo["ac_title"]); ?></p>
                            <p class="text-center">￥<span><?php echo ($vo["single_price"]); ?></span>元</p>
                        </div><?php endforeach; endif; ?>
                    </div>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div>
            </div>
        </div>
        <!--亲子酒店-->
        <div class="container-layout stay">
            <img src="/Public/images/grogshop.png " class="img-responsive">
            <h1 class="text-center text-white ">亲子酒店推荐</h1>
            <p class="text-center text-white">省力省心省钱丨每周更新</p>
            <h5>
                <a href="/Home/Index/category/id/5" class="radius border-white text-center">
                    查看全部
                </a>
            </h5>
        </div>
        <div class="container-layout scenic-box margin-small-top">
            <div class="scenic">
                <div class="swiper-container2">
                    <div class="swiper-wrapper">
                    <?php if(is_array($jiudianlist_recommend)): foreach($jiudianlist_recommend as $key=>$vo): ?><div class="swiper-slide">
                            <a href="/Home/Index/detail/ac_id/<?php echo ($vo["ac_id"]); ?>"><img src="/<?php echo ($vo["ac_img"]); ?>"></a>
                            <p class="text-more"><?php echo ($vo["ac_title"]); ?></p>
                            <p>￥<span><?php echo ($vo["single_price"]); ?></span>元起</p>
                        </div><?php endforeach; endif; ?>
                    </div>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div>
            </div>
        </div>

        <div style="height: 80px"></div>
    </section>
<!--页脚-->
    <footer class="layout fixed-bottom  footer">
     <div class="layout">
        <ul class="line">
            <li class="x3"><a href="<?php echo U('Index/index');?>"><img src="/Public/images/footer/home_active.png" class="img-responsive" style="width:80%"></a></li>
            <li class="x3"><a href="<?php echo U('Rili/activitycalendar');?>"><img src="/Public/images/footer/calendaer.png" class="img-responsive" style="width:80%"></a></li>
            <li class="x3"><a href="<?php echo U('Message/index');?>"><img src="/Public/images/footer/message.png" class="img-responsive" style="width:80%"></a></li>
            <li class="x3"><a href="<?php echo U('Min/index');?>"><img src="/Public/images/footer/user.png" class="img-responsive" style="width:80%"></a></li>
        </ul>
    </div>
    </footer>
<script src="/Public/pintuer/jquery.js"></script>
<script src="/Public/pintuer/pintuer.js"></script>
<script type="text/javascript" src="/Public/js/swiper.jquery.min.js"></script>
<script src="/Public/js/zepto1.js"></script>
<script src="/Public/js/jquery-ui.js"></script>
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
                                //$("#city-picker").val(address).css("color","#fff");
                                $("#hidd").val(address);

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
        function upperCase(){
        	var cityid=$("#city-picker").val();
        	alert(cityid);
            $.ajax({ 
            	url: "/Home/Index/index", 
            	type:"get",
            	dataType: "json",  
            	data: {"cityid":cityid},  
            	success: function(){
                    $(this).addClass("done");
                }
            });
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