<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
<head>
    <title>选择时间数量</title>
    <meta charset="utf-8"/>
    <!--<meta name="viewport" content="width=device-width, initial-scale=1.0">-->
    <meta name="viewport" content="width=750px,target-densitydpi=device-dpi,user-scalable=no,maximum-scale=1.0">
    <link rel="stylesheet" href="/Public/pintuer/pintuer.css">
    <style>
        body{
            background: #F8F8F8;
            height: 100%;
        }
        h1.text-black{
            font-size: 2.2rem;
        }
        .date{
            height: 7rem;
            background: #FC9A03;
            padding-left: 3.3rem;
            font-size: 1.8rem;
            margin: 0;
            padding-top: 1rem;

        }
        .the{
            width: 40%;
            border:2px solid #FC9A03;
            margin: 3rem 0 2rem 3rem;
            border-radius: 0.8rem;
            padding: 1rem 1.5rem;
            font-size: 2rem;
        }
        .the p{
            line-height: 2.4rem;
        }
        .the span{
            color:#FC9A03;
        }
        .active{
            background: url(/Public/images/bg_choose_right_down.png)no-repeat right bottom ;
        }




        .table .xuanze{
            font-size: 2rem;
            padding-left: 3rem;
            line-height: 3rem;
            margin-bottom: 1.3rem;
            font-weight:normal;
            border: none;
        }
        .table tr td {
            text-align: center;
            font-size: 2rem;
        }
         .table tr td:first-child{
            width: 20%
         }
          .table tr td:list-child{
            width: 20%
         }
        .table{
            color:#000;
        }
        .table tr td{
            padding: 0;
            line-height: 6rem;
            position: relative;

        }
        .table tbody tr td:last-child{
          padding:0 2rem ;

        }

        .group_list tr td input:nth-child(1){
            background: url("/Public/images/jbtn_minus_gray.png")no-repeat 1px 1px;
            background-size:95% ;
            border:none;
            width: 2.6rem;
            height:2.5rem;

        }
        .group_list tr td  input:nth-child(3){
            background: url("/Public/images/jbtn_plus.png")no-repeat 1px 1px;
            background-size:95% ;
            border:none;
            width: 2.6rem;
            height:2.5rem;

        }
        .group_list tr td  input:nth-child(2){
            border: none;
            color: #000;
            width: 3.8rem;
            height:3.2rem;
            line-height: 4.2rem;
            background: #F8F8F8;
            text-align: center;
        }
        .group_list tfoot{
            position: fixed;
            bottom: 0;
        }
        .group_list tfoot tr td:nth-child(1){
            background: #2F2F2F;
            color:#fff;
            width:40%;
            text-align: left;
             padding: 2rem;
        }
        .group_list tfoot tr td:nth-child(2){
            background: #FC9A03;
            width:15%;
            text-align: center;
            padding: 0rem;
        }
        .group_list tfoot tr td button[type="submit"] {
            background: #FC9A03;
            color:#fff;
            padding: 2rem 3rem;
            border:none;
        }


    </style>
</head>
<body>
    <div class="layout clearfix">
        <div  class="line text-center padding-big bg-white ">
            <div class="x1">
                <a href="javascript:history.back(-1);"><img src="/Public/images/btn_arrow_back_green.png" alt="" class="img-responsive margin-big-left"style="width: 50%"></a>
            </div>
            <div class="x11">
                <h1 class="text-black">选择时间数量</h1>
            </div>
        </div>
        <!--订单详情-->
        <form action="/Home/Index/choosemeal" class="clearfix" method="post">
            <div class="text-white date">
                <p><?php echo ($model["ac_title"]); ?></p>
                活动日期：<span><?php echo ($model["start_time1"]); ?></span>
            </div>
           <div class="line">
             <?php if($model["is_half_active"] == 0): ?><!-- 非半天活动 -->
               <div class="the x6 active">
                   <p><?php echo ($model["during"]); ?></p>
                   <span><?php echo ($state); ?></span>
               </div>
             <?php else: ?> <!-- 半天活动 -->
	                 <div class="the x6 active">
	                   <p><?php echo ($morning_arr["morning_half_time"]); ?></p>
	                   <span><?php echo ($morning_arr["state"]); ?></span>
	                 </div>
	                 
	                 <div class="the x6">
	                   <p><?php echo ($after_arr["after_half_time"]); ?></p>
	                   <span><?php echo ($after_arr["state"]); ?></span>
	                 </div>
                </foreach><?php endif; ?>
           </div>

            <div class="table-responsive">
                <table class="table group_list" cellspacing="1" cellpadding="0">
                    <thead>
                       <tr>
                        <th class="xuanze">
                           选择数量
                        </th>
                    </tr> 
                    </thead>
                    <tbody id="goods">
                     <?php if(is_array($meallist)): foreach($meallist as $key=>$vo): ?><tr>
	                        <td>
	                          <?php echo ($vo["me_title"]); ?>
	                        </td>
	                        <td>
	                           <span><?php echo ($vo["price"]); ?></span>元/组
	                        </td>
	                        <td>
	                            <input type="button" value="" onclick="change(this, -1);"/>
	                            <input type="text" size="3" name="meal<?php echo ($vo["id"]); ?>" readonly value="0"/>
	                            <input type="button" value="" onclick="change(this, 1);"/>
	                        </td>
	                    </tr><?php endforeach; endif; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                           <td rowspan="2" >
                                                                                              总价：<span id="total">0</span>元 
                           </td> 
                            <td>
                             <input type="hidden" name="half_time" id="half_time" value="<?php echo ($morning_arr["morning_half_time"]); ?>" />
                             <input type="hidden" name="ac_id" value="<?php echo ($model["ac_id"]); ?>" />
                             <input type="hidden"  name="totalprice" id="totalprice"/>
                            <button type="submit" >确定</button>
                            </td>
                        </tr>
                    </tfoot>   
                </table>
            </div>
        </form>
    </div>
    <div style="height: 20rem">
        
    </div>
<script src="/Public/pintuer/jquery.js"></script>
<script src="/Public/pintuer/pintuer.js"></script>
    <script>
      $(".the").on("click",function(){
          $(this).addClass('active').siblings().removeClass('active').addClass('.active');
          var time= $(this).children("p").get(0).innerHTML;
          $("#half_time").val(time);
          
      });
      function change(btn, n) {
        var t = $(btn).next().length==0? $(btn).prev() : $(btn).next();
        var amount = parseInt(t.val());
       //console.log(amount)
        if(amount<=0 && n<0) {
          return;
        }        
        t.val(amount+n);
        amount = t.val();
         // alert(amount);
        var tds = $(btn).parent().siblings();
    
        var price = tds.eq(1).children().html();
        var m = price*amount;
         var trs = $(btn).parent().parent().siblings();
         for(var i=0;i<trs.length;i++){
               var pri = trs.eq(i).children().eq(1).children().html(); 
                var acu = trs.eq(i).children().eq(2).children("input").eq(1).val();
               m+=pri*acu; 
         }
        $("#total").html(m);
        $("#totalprice").val(m);

        }
         $("button[type='submit']").click(function(){
           
         var html= $("#total").html();
          if(html!=0){
            return true;
           
          }else{  return false;
           console.log("订单不能为0");
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