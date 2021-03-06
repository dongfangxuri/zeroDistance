<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
<head>
    <title>活动评分</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">-->
    <meta name="viewport" content="width=750px,target-densitydpi=device-dpi,user-scalable=no,maximum-scale=1.0">

    <link rel="stylesheet" href="/Public/pintuer/pintuer.css">
    <style>
        body{
            background: #F5F5F5;
        }
        .apply{
            position: relative;
        }
        .content{
            height: 48px;
            height: 1.2rem;
            height: 3rem;

        }
        .annualCard{
           display: inline-block;
            background: #85C43F;
            color: #fff;
            font-weight: bold;

        }
        dt.x9 p{
            font-weight: normal;
            font-size:2rem;
            margin-bottom: 5px;
            height: 5.3rem;
            color: #000;
            line-height: 2.8rem;
            margin-bottom: 0rem;
        }
        dt.x9 p:not(:first-child){
            margin-bottom: 0px;
            font-size:1.8rem;
            color: #BFBFBF;
            height: 2rem;
            margin-top: .6rem;
        }
        span.pic {
            font-size:1rem;
        }
        span.text-red{
            font-size: 2rem;
        }
        .textcolor{
            color: #FB8718;
            font-size: 2rem;
        }

        .current{
            position: relative;
            /*background: #fff;*/
        }
        .pingfen{
            padding: 2rem;
        }
        .pingfen ul {
            list-style: none;
            position: absolute;
            top: 1.8rem;
            right: 6rem;
            overflow: hidden;
            width: 310px;
            height: 50px;
            background: url(/Public/images/star.png) no-repeat -1px 2.3px;
        }

        .pingfen ul li {
            float: left;
            width: 62px;
            height: 50px;
            text-indent: -9999px;
        }
        .pingfen p{
            margin-top: 1.6rem;
            font-size: 2.2rem;
            color: #000;
            margin-left: 2.5rem;
            line-height: 3rem;
        }
        .pingfen p span:last-child{
            margin-right: 10rem;
        }
       #result{
           color:#FD0000 ;
            background: #fff;
           width: 1.6rem;
           border: none;
        font-style: normal;
        }
        .jianpin>p.textcolor{
            padding: 2rem;
            line-height: 2rem;
        }
        #content_box{
            width: 80%;
            margin: 0 auto;
            height: auto;
            overflow: hidden;
            position: relative;
        }
        #textField{
            width: 100%;
            padding: 1rem;
            height: 15rem;
            resize: none;
            border: none;
            font-size: 2rem;
        }
        #preview{
            width: 100%;
            padding: 1rem;
            min-height: 17rem;
            padding-bottom: 6rem;
        }

        .picture{
            position: absolute;
            bottom: 1rem;
            left: 14rem;
            font-size: 2rem;
            color:#FB810F ;
            width:14rem;
            height:3.1rem;
            line-height: 3rem;



        }
        .picture img{
            margin-right: 0.6rem;
            margin-top: 1rem;
        }
        #doc{
         font-size: 2rem;
            position: absolute;
            bottom: 1rem;
            left: 14rem;
            opacity: 0;
        }
        button[type="submit"]{
            padding: 1rem 3rem;
            margin: 0 auto;
            color: #fff;
            font-size: 2rem;
            text-align: center;
            margin-left: 18rem;
            margin-top: 1rem;
            border: none;
            background:#FB810F ;
            border-radius:1rem ;
        }
		div.x11 h1{
            font-size: 2.6rem;
        }
    </style>


</head>
<body>
    <div class="layout">
        <div  class="line text-center padding " style="background: #FC9A03">
            <div class="x1">
                <a href="javascript:history.back(-1);"><img src="/Public/images/ht.png" alt="" style="width: 40%"></a>
            </div>
            <div class="x11 ">
                <h1 class="text-white">活动评分</h1>
            </div>
        </div>
        <!--评价内容-->
        <div class=" clearfix bg-white margin-big-bottom">
            <dl>
                <dd class="x3 apply">
                    <img src="/<?php echo ($model["ac_img"]); ?>" alt="" class="img-responsive">
                </dd>
                <dt class="x9 padding-left margin-small-top">
                      <p class="content"> <a href="#"><?php echo ($model["ac_title"]); ?></a></p>
                    <p><?php echo ($model["category"]); ?>| <?php echo ($model["view_addr"]); ?> | <span><?php echo ($model["fit_age"]); ?></span>岁</p>
                    <p class="float-left">累计<span><?php echo ($model["count"]); ?></span>人报名</p>
                    <p class="float-right margin-big-right "><sup>&yen;</sup><span class="text-red text-large"><?php echo ($model["single_price"]); ?></span><span class="pic">起</span></p>
                </dt>
            </dl>
        </div>
        <div class="current">
            <form action="/Home/Min/evalute/orderid/10" method="post">
                <div class="pingfen clearfix bg-white">
                    <span class="textcolor p">活动整体评分</span>
                    <ul class="star" id="star">
                        <li><a href="javascript:;" title="1" class="one-star">1</a></li>
                        <li><a href="javascript:;" title="2" class="two-stars">2</a></li>
                        <li><a href="javascript:;" title="3" class="three-stars">3</a></li>
                        <li><a href="javascript:;" title="4" class="four-stars">4</a></li>
                        <li><a href="javascript:;" title="5" class="five-stars">5</a></li>
                    </ul>
                  <p>
                      满分<span style="color:#FD0000">5</span>分
                      <span class="float-right">打分<i id="result">5</i>分</span>
                  </p>
                </div>
                <div class="jianpin">
                    <p class="textcolor margin">
                        简评
                    </p>
                    <div id="content_box" class="bg-white radius-big">
                        <textarea id="textField" name="comment"></textarea>
                       <!--  <div id="preview">
                            <div id="dd" style=" width:100%;"></div>
                            <p class="picture"><img src="/Public/images/icon_update_orange.png" alt="">上传照片</p>
                            <input type="file"  name="file" id="doc" multiple="multiple"  style="width:200px;" onchange="javascript:setImagePreviews();" accept="image/*" />
                        </div>  -->
                    </div>
                </div>
                <input type="hidden" name="star" id="star1" value="5"/>
                <input type="hidden" name="ac_id" value="<?php echo ($model["ac_id"]); ?>"/>
                <input type="hidden" name="order_id" value="<?php echo ($oid); ?>"/>
               <button type="submit">上传评价</button>
            </form>
        </div>



        </div>

    </div>
    <div style="height: 10rem">

    </div>
<script src="/Public/pintuer/jquery.js"></script>
<script src="/Public/pintuer/pintuer.js"></script>
    <script>
        $('#star li').click(function(){
            //获得当前点击的是哪个心形
            var i = $('#star li').index(this);
            console.log(this);
              console.log(i);
            var ip=-320+(i+1)*64;
            $('.star li:lt('+(i+1)+')').parent().css('background-position',ip+'px');
            $("#result").html(i+1);
            $('#star1').val(i+1);
            
        });

        //下面用于多图片上传预览功能
        function setImagePreviews(avalue) {
            var docObj = document.getElementById("doc");
            var dd = document.getElementById("dd");
            dd.innerHTML = "";
            var fileList = docObj.files;
            for (var i = 0; i < fileList.length; i++) {
                dd.innerHTML += "<div style='float:left' > <img id='img" + i + "'  style='margin: 1rem'/> </div>";
                var imgObjPreview = document.getElementById("img"+i);
                if (docObj.files && docObj.files[i]) {
                    //火狐下，直接设img属性
                    imgObjPreview.style.display = 'block';
                    imgObjPreview.style.width = '150px';
                    imgObjPreview.style.height = '180px';
                    //imgObjPreview.src = docObj.files[0].getAsDataURL();
                    //火狐7以上版本不能用上面的getAsDataURL()方式获取，需要一下方式
                    imgObjPreview.src = window.URL.createObjectURL(docObj.files[i]);
                }else {
                    //IE下，使用滤镜
                    docObj.select();
                    var imgSrc = document.selection.createRange().text;
                    alert(imgSrc)
                    var localImagId = document.getElementById("img" + i);
                    //必须设置初始大小
                    localImagId.style.width = "150px";
                    localImagId.style.height = "180px";
                    //图片异常的捕捉，防止用户修改后缀来伪造图片
                    try {
                        localImagId.style.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale)";
                        localImagId.filters.item("DXImageTransform.Microsoft.AlphaImageLoader").src = imgSrc;
                    }
                    catch (e) {
                        alert("您上传的图片格式不正确，请重新选择!");
                        return false;
                    }
                    imgObjPreview.style.display = 'none';
                    document.selection.empty();
                }
            }
            return true;
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