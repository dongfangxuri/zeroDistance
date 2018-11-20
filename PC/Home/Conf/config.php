<?php
return array(
	'LAYOUT_ON'=>true,
    'LAYOUT_NAME'=>'layout',
	'alipay_config'=>array(
			'partner'		=> '2088221665193520',
			//收款支付宝账号，以2088开头由16位纯数字组成的字符串，一般情况下收款账号就是签约账号
			'seller_id'	=> '2088221665193520',
			// MD5密钥，安全检验码，由数字和字母组成的32位字符串，查看地址：https://b.alipay.com/order/pidAndKey.htm
			'key'		=> 'td419uyuq4jlrw297ovlezcagvyotzhv',
			// 服务器异步通知页面路径  需http://格式的完整路径，不能加?id=123这类自定义参数，必须外网可以正常访问
			//$alipay_config['notify_url'] = "http://商户网关网址/alipay.wap.create.direct.pay.by.user-PHPUTF-8/notify_url.php";
			'notify_url'=> "http://m.imweixi.com/Home/Wappay/notifyurl",
			// 页面跳转同步通知页面路径 需http://格式的完整路径，不能加?id=123这类自定义参数，必须外网可以正常访问
			//$alipay_config['return_url'] = "http://商户网址/alipay.wap.create.direct.pay.by.user-PHP-UTF-8/return_url.php";
			'return_url'=> "http://m.imweixi.com/Home/Min/pay_finish",
			//签名方式
			'sign_type' =>'MD5',
			//字符编码格式 目前支持utf-8
			'input_charset'=> strtolower("utf-8"),
			//ca证书路径地址，用于curl中ssl校验
			//请保证cacert.pem文件在当前文件夹目录中
			'cacert'    => getcwd().'\\cacert1.pem',
			//访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
			'transport'    => 'http',
			// 支付类型 ，无需修改
			'payment_type' => "1",
			// 产品类型，无需修改
			'service' => "alipay.wap.create.direct.pay.by.user"
	)
);