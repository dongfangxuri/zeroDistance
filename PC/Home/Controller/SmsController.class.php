<?php
namespace Home\Controller;
use Think\Controller;
class SmsController extends Controller {
	
   function index()
   {
	   //$data['status']=1;
				//$ordermodule=M('order')->where('oid='.$notify->data["out_trade_no"])->select();
				//$ordermodule->save($data);
	  //$notify->data["out_trade_no"]=13;
	  //$ordermodel = M("order") -> where('oid='.$notify->data["out_trade_no"])->save($data);
	  //$ordermodel->save($data);
	  //var_dump($ordermodel);exit;
   	  echo  "<script type='text/javascript'>alert('发送成功');</script>";
   }
   function sendSMS ($mobile)
	{
		
		$mobile=$_GET['mobile'];
		include 'alidayu/TopSdk.php';
		date_default_timezone_set('Asia/Shanghai');
		$c = new \TopClient;
		$c->appkey = "23544925";
		$c->secretKey = "d5030b00cf1b081df23cf950bf9a63fd";
		$req = new \AlibabaAliqinFcSmsNumSendRequest;
		$req->setSmsType("normal");
		$v_code = mt_rand(1000,9999);       //生成四位随机数
		$req->setSmsFreeSignName("注册验证");
		$req->setSmsParam("{\"code\":\"".$v_code."\",\"product\":\"亲子网站\"}");
		$req->setRecNum($mobile);
		$req->setSmsTemplateCode("SMS_27770073");
		$resp = $c->execute($req);
		if($resp->result->success)
		{
			$_SESSION['code']=$v_code;
			return true;
		}return false;
		
	}
}
?>