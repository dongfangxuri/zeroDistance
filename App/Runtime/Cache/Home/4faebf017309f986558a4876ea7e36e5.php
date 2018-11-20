<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
<head>
    <title>选择出行人</title>
    <meta charset="utf-8"/>
    <!--<meta name="viewport" content="width=device-width, initial-scale=1.0">-->
    <meta name="viewport" content="width=750px,target-densitydpi=device-dpi,user-scalable=no,maximum-scale=1.0">
    <link rel="stylesheet" href="/Public/pintuer/pintuer.css">
    <style>
        body{
            background: #F8F8F8;
        }
        h1.text-black{
            font-size: 2.4rem;
            padding-left: 7.6rem;
        }
        .new_add{
            font-size: 2.4rem;
            color: #F6A93F;
        }
        form p{
            background: #FF8800;
            font-size: 2.2rem;
            line-height: 2.4rem;
            margin: 0;
            padding: 2.4rem;
        }
        .personage-list{
            height: 9rem;
            background: #fff;
        }
        .personage-list a{
            background: #f8f8f8;
            display: block;
            height: 100%;
            padding: 2.2rem;
        }
        .personage-data{
            list-style: none;
            font-size: 1.8rem;
            margin-top: 0.5rem;
        }
        .personage-data li{
            margin-top: 1rem;
        }
        .personage-list>i{
            margin:2.9rem 1rem 0 0 ;
        }
        .btn_nochoose {
            /*position: absolute;*/
            /*top: 1rem;*/
            float: right;
            width: 4rem;
            height: 4rem;
            background: url(/Public/images/btn_nochoose.png) no-repeat center center;
        }
        .btn_nochoose.active{
            background: url(/Public/images/btn_choose.png) no-repeat center center;
        }
        #sub_btn{
            background:#FF8800;
            text-align: center;
            width: 100%;
            height: 7rem;
            font-size:2rem;
            color:#fff;
            position: fixed;
            bottom: 0;
        }
    </style>
</head>
<body>
    <div class="layout clearfix">
        <div  class="line text-center padding-big ">
            <div class="x1">
                <a href="javascript:history.back(-1);"><img src="/Public/images/btn_arrow_back_green.png" alt="" class="img-responsive margin-big-left"style="width: 50%"></a>
            </div>
            <div class="x8">
                <h1 class="text-black">选择出行人</h1>
            </div>
            <div class="x3 ">
                <a href="/Home/Min/contact_add"  class="new_add"><img src="/Public/images/icon_new.png" alt="" class="" style="display: inline-block;margin-right: 0.3rem">新增</a>
            </div>
        </div>
        <!--订单详情-->
        <form action="/Home/Index/confirmorder" class="clearfix" method="post">
            <p class="text-white">请选择成人<span class="num"><?php echo ($person); ?></span>名，儿童<span class="num_two"><?php echo ($child); ?></span>名</p>
            <?php if(is_array($list)): foreach($list as $key=>$vo): ?><div class="line personage-list border-bottom">
                <a href="/Home/Min/contact_update/id/<?php echo ($vo["id"]); ?>" class="x2"><img src="/Public/images/edit_trav.png" alt="" class="img-responsive"></a>
                <ul class="x8 personage-data clearfix padding-large-left">
                        <li style="display:none;"><?php echo ($vo["id"]); ?></li>
	                    <li class="x4"><?php echo ($vo["name"]); ?></li>
	                    <li class="x8"><?php echo ($vo["ID_type"]); ?></li>
	                    <li class="x4"><span><?php echo ($vo["is_child"]); ?></span>&nbsp;&nbsp;<span><?php echo ($vo["sex"]); ?></span> </li>
	                    <li class="x8"><?php echo ($vo["ID_card"]); ?></li>
                </ul>
                <i href="#" class="btn_nochoose"></i>
                <!--<img src="images/btn_choose.png" alt="" class="img-responsive x2 float-right" style="width:6%">-->
            </div><?php endforeach; endif; ?>
            <input type="hidden" name="totalperson" id="totalperson" value="<?php echo ($person); ?>" />
            <input type="hidden" name="totalchild" id="totalchild" value="<?php echo ($child); ?>" />
            <input type="hidden" name="person" id="chooseperson" value="0" />
            <input type="hidden" name="child" id="choosechild" value="0" />
            <input type="hidden" name="contact_string" id="contact_string" value="" />
            <button type="submit" id="sub_btn" onclick="return checkForm();">提交</button>
        </form>
    </div>
     <script src="/Public/pintuer/jquery.js"></script>
     <script src="/Public/pintuer/pintuer.js"></script>
    <script>
        $(".btn_nochoose").on("click",function(){
        	var person=parseInt($("#chooseperson").val());	
        	var child=parseInt($("#choosechild").val());
        	var totalperson=parseInt($("#totalperson").val());	
        	var totalchild=parseInt($("#totalchild").val());
        	var contact_string=$("#contact_string").val();
        	var temp=$(this).prev().children().eq(3).find("span:eq(0)").text();
        	var id=$(this).prev().children().eq(0).text();
        	if(temp=='成人')
        	{
            	if(person==totalperson)
            	{
               		if( $(this).attr('class')=='btn_nochoose')
        			{
               			alert('成人数量已达到上限'); 
        			}
               		else
               		  {
               			   $(this).toggleClass("active");
               			   person-=1;
               			   $("#chooseperson").val(person);
               		  }
            	}
            	else
            	{
            	  person+=1;
            	  contact_string=contact_string +id+",";
            	  $("#contact_string").val(contact_string);
        		  $("#chooseperson").val(person);
        		  $(this).toggleClass("active");
        	    }
        	}
        	else
        	{
            	if(child==totalchild)
            	{
            		
            		if( $(this).attr('class')=='btn_nochoose')
            			{
            			  alert('儿童数量已达到上限');  
            			}
               		else
             		  {
          			       child-=1;
           			       $("#choosechild").val(child);
             			   $(this).toggleClass("active");

             		  }
            	}
            	else
            	{
        		   child+=1;
        		   $("#choosechild").val(child);
             	   contact_string=contact_string +id+",";
            	   $("#contact_string").val(contact_string);
        		   $(this).toggleClass("active");
            	}
        	}
            
        })
    </script>
    <script type="text/javascript">
      function checkForm()
      {
      	  var totalperson=$("#totalperson").val();	
    	  var totalchild=$("#totalchild").val();
      	  var person=$("#chooseperson").val();	
    	  var child=$("#choosechild").val();
    	  if((totalperson!=person)||(totalchild!=child))
    		{
    		    alert('请选择对应的数量的成人、儿童出行人');
    		     return false;
    		}
    	  else{
    		  var contact_string=$("#contact_string").val();
    		  var len=contact_string.length;
    		  contact_string=contact_string.substr(0,len-1);
    		  $("#contact_string").val(contact_string);
    		  return true;
    	  }
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