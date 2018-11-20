<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
<head>
    <title>详情</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=750px,target-densitydpi=device-dpi,user-scalable=no,maximum-scale=1.0">
    <meta charset="utf-8">
    <link rel="stylesheet" href="/Public/pintuer/pintuer.css">
    <link rel="stylesheet" type="text/css" href="/Public/css/swiper.min.css">
    <link rel="stylesheet" href="/Public/css/index.css">
    <link rel="stylesheet" href="/Public/css/detail.css">
    <style>
        .swiper-container {
        width: 100%;
       /* height: 300px;*/
        margin: 0px auto;
    }
    .swiper-slide {
        text-align: center;
        font-size: 18px;
        background: #fff;
        /*line-height: 300px;*/
    }
    .swiper-button-next, .swiper-button-prev {
        position: absolute;
        top: 53%;   
    }
    .swiper-container-horizontal > .swiper-pagination-bullets, .swiper-pagination-custom, .swiper-pagination-fraction {
        text-align:center;
        color: #fff;
    }
       .collect{
            position: absolute;
            width: 5rem;
            height: 5rem;
            top:1rem;
            right: 0rem;
            background: url("/Public/fav_white.png")no-repeat;
            z-index: 100;
        }
    
    </style>
</head>
<body>
<!--头部信息-->
    <header class="layout header_box clearfix" >
        <div class="line">
            <a href="javascript:history.back(-1);" class="x2"><img src="/Public/images/idex.png" alt="" class="img-responsive padding retreat"  style="width: 75%"> </a>
            <p class="x8">
                <img src="/Public/images/logo.png" alt="" class="img-responsive x2  padding" style="width: 15%;padding-right: 0">
                <img src="/Public/images/ojltj.png" alt="" class="img-responsive x9 padding " style="width: 75%">
            </p>
            <a href="/Home/Min/index" class="x2">
               <?php if(empty($header_img)): ?><img src="/Public/images/fx.png" alt="" class="img-responsive padding myhome" style="width: 75% ;">
               <?php else: ?>
               <img src="/<?php echo ($header_img); ?>" alt="" class="img-responsive padding myhome" style="width: 75% ;border-radius:50%"><?php endif; ?>
             </a>
        </div>
    </header>

<!--主体内容-->
    <section class="layout margin-little-top" style="overflow: auto">
           <div class="swiper-container">
        <div class="swiper-wrapper">
                <div class="swiper-slide"> <img style="width:100%" src="/<?php echo ($activemodel["ac_img"]); ?>" alt=""></div>
        </div>
        <i class="collect"></i>
        <!-- Add Pagination -->
        <div class="swiper-pagination"></div>
        <!-- Add Arrows -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>

        



        <!--分类-->
        <div class="layout content_text">
            <p class="margin-top">
                <?php echo ($activemodel["ac_title"]); ?>
            </p>
            <h6>
                 <?php echo ($activemodel["ac_intro"]); ?>
            </h6>
           <div class="jiaqian">
               <sup>¥</sup><span ><?php echo ($leastprice); ?>元</span> 起 
               <?php if($activemodel["status"] == 0): ?><span class="float-right ">活动报名中</span>
                 <?php else: ?>
                  <span class="float-right ">报名截止</span><?php endif; ?>
           </div>
        </div>
        <ul class="detail_list">
            <li><img src="/Public/images/ic_child.png" alt="" class="img-responsive">适合<span><?php echo ($activemodel["fit_age"]); ?></span>岁孩子参加</li>
            <li><img src="/Public/images/ic_time.png" alt="" class="img-responsive"><span><?php echo ($activemodel["start_time"]); ?>-<?php echo ($activemodel["end_time"]); ?></span></li>
            <li><img src="/Public/images/ic_didian.png" alt="" class="img-responsive"><?php echo ($activemodel["view_addr"]); ?></li>
            <li><img src="/Public/images/ic_dongtai.png" alt="" class="img-responsive">客服微信：<span>18951310488</span> 星星</li>
            <li><img src="/Public/images/ic_dongtai.png" alt="" class="img-responsive"><a href="tel:0513-85221106">想为孩子和小伙伴包场吗？<img src="/Public/images/right.png" alt="" class="img-responsive float-right"></a></li>
			<?php if($contentcount == 0): else: ?>
			<?php if(is_array($contentlist)): foreach($contentlist as $key=>$vo1): ?><li>
                <img src="/Public/images/ic_dongtai.png" alt="" class="img-responsive"><?php echo ($vo1["content"]); ?>
            </li><?php endforeach; endif; endif; ?>
        </ul>
        <h6 class="xian"></h6>
        <div class="sell clearfix">
            累计已售<span><?php echo ($activemodel["count"]); ?></span>份
            <div class="clearfix">
            <?php if(is_array($userlist)): foreach($userlist as $key=>$vo): ?><img src="/<?php echo ($vo["header_img"]); ?>" alt="" class="img-responsive"><?php endforeach; endif; ?>
            </div>
        </div>
        <h6 class="xian"></h6>
        <div class="choice clearfix">
            <p id="jingxuan">精选套餐</p>
            <?php if(is_array($taocanlist)): foreach($taocanlist as $key=>$vo): ?><ul class="line setMeal">
                <li class="x9">
                     <p><?php echo ($vo["me_title"]); ?></p>
                     <p><?php echo ($vo["me_info"]); ?></p>
                </li>
                <li class="x3">
                   <p> <sup>¥</sup><span><?php echo ($vo["leastprice"]); ?></span>元</p>
                    <a href="/Home/Min/join/id/<?php echo ($vo["id"]); ?>" class="text-white text-center">选择日期</a>
                </li>
            </ul><?php endforeach; endif; ?>
        </div>
        <h6 class="xian"></h6>
        <div class="tab">
            <div class="tab-head clearfix">
                <ul class="tab-nav clearfix tab_list">
                    <li class="active x4"><a href="#tab-start5">详情</a> </li>
                    <li class="x4"><a href="#tab-css5">评价<i>（<?php echo ($commentcount); ?>）</i></a> </li>
                    <li class="x4"><a href="#tab-units5">留言<i>（<?php echo ($leamsgcount); ?>）</i></a> </li>
                </ul>
            </div>
            <!--标签页1-->
            <div class="tab-body">
                <div class="tab-panel active " id="tab-start5">
					<?php echo ($activcontent); ?>
                </div>
                <!--标签页2-->
                <div class="tab-panel" id="tab-css5">
                    <p class="text-center">整体评分 
                        <?php if($average_star == 2): ?><img src="/Public/images/star2.png" alt="" class="img-responsive" style="display: inline-block">   
                           <span class="part"><?php echo ($average_star); ?>分</span>
                         <?php elseif($average_star == 3): ?>
                           <img src="/Public/images/star3.png" alt="" class="img-responsive" style="display: inline-block"> 
                           <span class="part"><?php echo ($average_star); ?>分</span>
                         <?php elseif($average_star == 4): ?>
                           <img src="/Public/images/star4.png" alt="" class="img-responsive" style="display: inline-block"> 
                           <span class="part"><?php echo ($average_star); ?>分</span>
                         <?php else: ?>
                          <img src="/Public/images/star5.png" alt="" class="img-responsive" style="display: inline-block"> 
                          <span class="part">5分</span><?php endif; ?>
                         
                    </p>
                    <?php if(is_array($commentlist)): foreach($commentlist as $key=>$vo): ?><div class="messageBoard line">
                        <img src="/<?php echo ($vo["header_img"]); ?>" alt="" class="img-responsive x2 float-left radius-circle padding">
                        <div class="x10 border-bottom">
                            <p><?php echo ($vo["nick_name"]); ?>
                                 <?php if($vo["star"] == 2): ?><img src="/Public/images/star2.png" alt="" class="img-responsive float-right" style="display: inline-block">   
		                         <?php elseif($vo["star"] == 3): ?>
		                           <img src="/Public/images/star3.png" alt="" class="img-responsive float-right" style="display: inline-block"> 
		                         <?php elseif($vo["star"] == 4): ?>
		                           <img src="/Public/images/star4.png" alt="" class="img-responsive float-right" style="display: inline-block"> 
		                         <?php else: ?>
		                          <img src="/Public/images/star5.png" alt="" class="img-responsive float-right" style="display: inline-block"><?php endif; ?>
                             </p>
                            <h6><?php echo ($vo["addTime"]); ?></h6>
                            <div class="text-break clearfix">
							    <?php echo ($vo["content"]); ?>
                            </div>
                        </div>
                    </div><?php endforeach; endif; ?>
                </div>
                <!--标签页3-->
                <div class="tab-panel  " id="tab-units5">
                    <div class="liuyanbox clearfix" style="background: #f8f8f8;">
                        <form action="/Home/Min/leamsg" method="post">
                            <textarea class="put0" rows="4" name="leavemsg" placeholder="请输入您的留言,零距离童军客服会尽快回复您哦~"></textarea>     
                                  <input type="submit" value="我要留言">
                                  <input type="hidden" name="id" value="<?php echo ($activemodel["ac_id"]); ?>">
                            <div class="nocontent" style="display: none" >
                                <p>
                                    请输入留言内容<br>
                                    <a href="#" class="Determine">确定</a>
                                </p>
                            </div>
                        </form>
                    </div>
                    <?php if(is_array($leamsglist)): foreach($leamsglist as $key=>$vo): ?><div class="line liuyanContent border-bottom padding-big">
	                        <img src="/<?php echo ($vo["header_img"]); ?>" alt="" class="img-responsive radius-circle x2">
	                        <div class="x10">
	                            <p><?php echo ($vo["nick_name"]); ?> <span class="liuyandate"><?php echo ($vo["addTime"]); ?></span> </p>
	                            <h6 class="text-large padding-bottom ">
	                                <?php echo ($vo["content"]); ?>
	                            </h6>
	                            <div class="huifucontent padding ">
	                                <span><em></em></span>
	                                <ul class="line">
	                                    <li class="x2"><img src="/Public/images/logo.png" alt="" class="img-responsive "></li>
	                                    <li class="x10">
	                                                                                                    零距离童军
	                                        <span><?php echo ($vo["responsetime"]); ?></span>
	                                        <p class="CustomerService">
	                                            <?php echo ($vo["response"]); ?>
	                                        </p>
	                                    </li>
	                                </ul>
	                            </div>
	                        </div>
	                    </div><?php endforeach; endif; ?>
                </div>
            </div>
        </div>
    </section>
<div style="height:10rem">

</div>
<!--页脚-->
    <footer class="layout fixed-bottom  footer" style="position: fixed;bottom: 0">
        <div class="layout">
        <ul class="line footimg text-center" >
            <li class="x3"><a href="tel:0513-85221106"><img src="/Public/images/btn_kefu.png" class="img-responsive" >客服</a></li>
            <li class="x3"><a href="/Home/Min/share"><img src="/Public/images/btn_fenxiang.png" class="img-responsive" >分享 <span>+5</span></a></li>
	            <?php if($activemodel["status"] == 0): if($count != 1): ?><li class="x6 "><a href="#jingxuan" class="xuanzetaocan text-center text-white">选择套餐</a></li>
                  <?php else: ?>
                     <li class="x6 "><a href="/Home/Min/join/id/<?php echo ($mealmodel["id"]); ?>" class="xuanzetaocan text-center text-white">我要报名</a></li><?php endif; ?>
	            <?php else: ?>
	                <li class="x6 "><a href="#" class="xuanzetaocan text-center text-white" style="background:#ddd;">我要报名</a></li><?php endif; ?>
         </ul>
        </div>

    </footer>
<script src="/Public/pintuer/jquery.js"></script>
<script src="/Public/pintuer/pintuer.js"></script>
<script src="http://api.map.baidu.com/api?v=2.0&ak=iNRD8iIAjCuobjHgg72ukB5ghbKpsaj4"></script>
 <script src="/Public/js/swiper.min.js"></script>
 <script>
    var swiper = new Swiper('.swiper-container', {
        nextButton: '.swiper-button-next',
        prevButton: '.swiper-button-prev',
        pagination: '.swiper-pagination',
        paginationType: 'fraction'
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