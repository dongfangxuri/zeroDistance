<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
<head>
    <title>修改出行人</title>
    <meta charset="utf-8"/>
    <!--<meta name="viewport" content="width=device-width, initial-scale=1.0">-->
    <meta name="viewport" content="width=750px,target-densitydpi=device-dpi,user-scalable=no,maximum-scale=1.0">
    <!--<link rel="stylesheet" href="css/bootstrap.min.css">-->
    <link rel="stylesheet" href="/Public/pintuer/pintuer.css">
    <link href="/Public/css/mobiscroll.custom-2.16.1.min.css" rel="stylesheet" type="text/css" />
    <style>
        body{
            background: #EBEBEB;
        }
        h1.text-white{
            font-size: 2.4rem;
        }
        .data_list_content ul li{
            list-style: none;
            margin-bottom: 0.2rem;
            background: #fff;
            font-size: 2.4rem;
            height: 5.5rem;
            line-height: 5.5rem;
            position: relative;
        }
        .data_list_content ul li img{
            position: absolute;
            top: 40%;
            right: 3%;
            z-index: 10;
        }
        .data_list_content ul label{
            padding-left: 2.5rem;
            color: #141414;
        }
        .data_list_content input{
            border: none;
            background: #fff;
        }
        .data_list_content ul li select{
            appearance:none;
            -moz-appearance:none;
            -webkit-appearance:none;
            -ms-appearance:none;
            border:none;
            background: #fff;
        }
        .sele_text{
            color:#999999 ;
        }
        .mbsc-bootstrap .dw{
            padding:2rem 1rem 1rem 3rem;
        }

       .popover-title{
          height: 40px;
           line-height: 40px;
           margin-top: 1rem;
       }
        .dw{
            background: #fff;
            font-size: 3em;
            color: #000;
            width: 45%;
            height: 30%;
            border-radius:1rem;

        }
        #confirm{
            color: #fff;
            background: #FC9A03;
            font-size: 3rem;
            width: 75%;
            margin-top: 2rem;
            padding: 1.3rem 0;
            border-radius: 1rem;
           margin-left: 5rem;
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
                <h1 class="text-white">常用出行人</h1>
            </div>
        </div>
        <form action="/Home/Min/contact_update/id/1" class="data_list_content left" method="post">
           <ul class="clearfix">
               <li>
                   <label class="x4">出行人姓名</label>
                   <input name="name" value="<?php echo ($model["name"]); ?>" type="text" placeholder="请输入真实姓名" >
               </li>
               <li>
                   <label class="x4">性别</label>
                   <img src="/Public/images/right.png" alt="" class="float-right">
                   <div  id="demo_cont_select" class="x8">
                       <select name="sex" id="demo_select" >
                           <option value="0" selected="selected"><span class="sele_text">请选择性别</span></option>
                           <option value="1" >男</option>
                           <option value="2">女</option>
                       </select>
                   </div>
               </li>
               <li>
                   <label class="x4 ">出生日期</label>
                   <img src="/Public/images/right.png" alt="" class="float-right">
                   <div   id="demo_cont_date" class="x8 sele_text">
                       <input type="text" name="born" id="demo_date"  value="<?php echo ($model["born"]); ?>"  class="sele_text" />
                   </div>
               </li>
               <li>
                  <label  class="x4">证件类型</label>
                   <img src="/Public/images/right.png" alt="" class="float-right">
                   <select name="ID_type"class="sele_text" >
                       <option value="0" selected="selected">点击请选择证件</option>
                       <option value="1" >身份证</option>
                       <option value="2">临时身份证</option>
                       <option value="3">军官证</option>
                       <option value="4">士兵证</option>
                       <option value="5">回乡证</option>
                       <option value="6">台胞证</option>
                       <option value="7">港澳通行证</option>
                   </select>
               </li>
               <li>
                   <label class="x4">证件号码</label>
                   <input type="text" name="ID_num" value="<?php echo ($model["ID_card"]); ?>" placeholder="请输入证件号码" >
               </li>
           </ul>
            <input type="hidden" name="id" value="<?php echo ($model["id"]); ?>">
            <input type="submit" value="修改" id="confirm">
        </form>




    </div>
    <script src="/Public/pintuer/jquery.js"></script>
    <script src="/Public/pintuer/pintuer.js"></script>
    <script src="/Public/js/mobiscroll.custom-2.16.1.min.js" type="text/javascript"></script>
    <script>
        $(function () {
            function init() {
                // Select demo initialization
                $('#demo_select').mobiscroll().select({
                    theme: theme,     // Specify theme like: theme: 'ios' or omit setting to use default
                    mode: mode,       // Specify scroller mode like: mode: 'mixed' or omit setting to use default
                    display: display, // Specify display mode like: display: 'bottom' or omit setting to use default
                    lang: lang        // Specify language like: lang: 'pl' or omit setting to use default
                });

                // Date demo initialization
                $('#demo_date').mobiscroll().date({
                    theme: theme,     // Specify theme like: theme: 'ios' or omit setting to use default
                    mode: mode,       // Specify scroller mode like: mode: 'mixed' or omit setting to use default
                    display: display, // Specify display mode like: display: 'bottom' or omit setting to use default
                    lang: lang        // Specify language like: lang: 'pl' or omit setting to use default
                });
           }
            // -------------------------------------------------------------------
            // Demo page code START, you can ignore this in your implementation
            var demo, theme, mode, display, lang;
            theme = "bootstrap",
                    lang = "zh";
            $("#demo_cont_" + demo).show();
            init();
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