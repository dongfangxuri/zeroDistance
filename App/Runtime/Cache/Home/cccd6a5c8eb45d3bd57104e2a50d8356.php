<?php if (!defined('THINK_PATH')) exit(); if(C('LAYOUT_ON')) { echo ''; } ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>系统提示</title>
    <style type="text/css">
        *{ padding: 0; margin: 0; }
        body{ background: #fff; font-family: '微软雅黑'; color: #333; font-size: 16px; }
        .system-message{width:400px;height:250px;border: 1px #dcdcdc solid;margin: 10% 40%;}
        .system-message h3{width:400px;height:40px;line-height: 40px;background: #333;borer-bottom:1px solid #333;font-size: 18px;font-weight: normal;color:#fff;text-align: left;text-indent: 10px;}
        .system-message h1{ font-size: 80px; font-weight: normal; line-height: 100px; margin-bottom: 10px; text-align: center;}
        .system-message .jump{text-align: center; padding-top: 10px}
        .system-message .jump a{ color: #333;}
        .system-message .success,.system-message .error{ line-height: 3.8em;text-align: center; font-size: 22px }
        .system-message .detail{ font-size: 12px; line-height: 20px; margin-top: 12px; display:none}

    </style>
</head>
<body>
<div class="system-message">
    <h3>系统信息</h3>
    <?php if(isset($message)): ?><p class="success"><?php echo($message); ?></p>
        <?php else: ?>
        <p class="error"><?php echo($error); ?></p><?php endif; ?>
    <p class="detail"></p>
    <p class="jump">
        页面自动 <a id="href" style="color:red;" href="<?php echo($jumpUrl); ?>">跳转</a> 等待时间： <b id="wait"><?php echo($waitSecond); ?></b>
    </p>
</div>
<script type="text/javascript">
    (function(){
        var wait = document.getElementById('wait'),href = document.getElementById('href').href;
        var interval = setInterval(function(){
            var time = --wait.innerHTML;
            if(time <= 0) {
                location.href = href;
                clearInterval(interval);
            };
        }, 1000);
    })();
</script>
</body>
</html>