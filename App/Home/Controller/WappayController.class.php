<?php
namespace Home\Controller;
use Think\Controller;
class WappayController extends Controller{
       //在类初始化方法中，引入相关类库    
       public function _initialize() {
        vendor('Alipay_wap.Corefunction');
        vendor('Alipay_wap.Md5function');
        vendor('Alipay_wap.Notify');
        vendor('Alipay_wap.Submit');    
      }
    
         //doalipay方法
         /*该方法其实就是将接口文件包下alipayapi.php的内容复制过来
          然后进行相关处理
         */
		public function index()
		{
			echo "this is just a test!";exit;
		}
        public function doalipay(){
        	 \Think\Log::write('进入支付流程!','WARN');
				/*********************************************************
				把alipayapi.php中复制过来的如下两段代码去掉，
				第一段是引入配置项，
				第二段是引入submit.class.php这个类。
			   为什么要去掉？？
				第一，配置项的内容已经在项目的Config.php文件中进行了配置，我们只需用C函数进行调用即可；
				第二，这里调用的submit.class.php类库我们已经在PayAction的_initialize()中已经引入；所以这里不再需要；
				*****************************************************/
		    // require_once("alipay.config.php");
		    // require_once("lib/alipay_submit.class.php");
		    
		    //这里我们通过TP的C函数把配置项参数读出，赋给$alipay_config；
			$alipay_config=C('alipay_config');  
			//var_dump($alipay_config);exit;
			
			/**************************请求参数**************************/

			$payment_type = "1"; //支付类型 //必填，不能修改
			//$notify_url = C('alipay.notify_url'); //服务器异步通知页面路径
			$notify_url=$alipay_config['notify_url'];
			//$return_url = C('alipay.return_url'); //页面跳转同步通知页面路径
			$return_url=$alipay_config['return_url'];
			//$seller_id = C('alipay.seller_id');//卖家支付宝帐户必填
			$seller_id=$alipay_config['seller_id'];
			/**************************请求参数**************************/
			$filter['oid']=$_GET['oid'];
			$model=M('order')->where($filter)->find();
			//0 待付款 1 未出行订单 2 待评价 3 已完成
		    //$ordermodel = M("order") -> where($filter) ->find();
		     if($model['status']!=0){
				 $this->error('该订单已支付');exit;
			}
			//商户订单号，商户网站订单系统中唯一订单号，必填
			$out_trade_no =$model['oid'];
			//订单名称，必填
			//$subject = I("subject");
			$subject = "零距离童军订单支付";
			//付款金额，必填
			$total_fee =$model['order_amount']-($model['star_amount']/300);
			//$total_fee = I("total_fee");
			//收银台页面上，商品展示的超链接，必填
			$show_url = '00155';
			//商品描述，可空
			//$body = $_POST['WIDbody'];
			$body="零距离童军订单支付";
			/************************************************************/
			//构造要请求的参数数组，无需改动
		    $parameter = array(
				"service"       => $alipay_config['service'],
				"partner"       => $alipay_config['partner'],
				"seller_id"  => $seller_id,
				"payment_type"	=> $payment_type,
				"notify_url"	=> $notify_url,
				"return_url"	=> $return_url,
				"_input_charset"	=> trim(strtolower($alipay_config['input_charset'])),
				"out_trade_no"	=> $out_trade_no,
				"subject"	=> $subject,
				"total_fee"	=> $total_fee,
				"show_url"	=> $show_url,
				//"app_pay"	=> "Y",//启用此参数能唤起钱包APP支付宝
				"body"	=> $body,
			    //其他业务参数根据在线开发文档，添加参数.文档地址:https://doc.open.alipay.com/doc2/detail.htm?spm=a219a.7629140.0.0.2Z6TSk&treeId=60&articleId=103693&docType=1
			    //如"参数名"	=> "参数值"   注：上一个参数末尾需要“,”逗号。
			);
			//var_dump($parameter);exit;
			//建立请求
			$alipaySubmit = new \AlipaySubmit($alipay_config);
			$html_text = $alipaySubmit->buildRequestForm($parameter,"get", "确认");
			echo $html_text;

	    }
    
		/**
		 * 验证订单状态
		 */
	   private function checkorderstatus($out_trade_no)
	   {
		  $ordermodel = M("order") -> where('oid='.$out_trade_no) ->find();
		  //0 待付款 1 未出行订单 2 待评价 3 已完成
		  if($ordermodel['status']==0)
		  {
			   return 1;
		  }
		  return 0;
	   }
	   /**
		* 订单状态处理
		*/
	   private function orderhandle($out_trade_no)
	   {
			$data1['status']=1;
			$data1['pay_time']=time();
			$data1['pay_type']=1;
			//修改订单状态为已支付
			$filter1['oid']=$out_trade_no;
			$res= M("order") -> where($filter1) ->save($data1);
			//减少用户的积分账户金额
			$ordermodel=M("order") -> where($filter1)->field('star_amount,uid')->find();
			$filter['uid']=$ordermodel['uid'];
			$usermodel=M('user')->where($filter)->field('star')->find();
			$data2['star']=$usermodel['star']-$ordermodel['star_amount'];
			$res2=M('user')->where($filter)->save($data2);
	   }
        /******************************
        服务器异步通知页面方法
        其实这里就是将notify_url.php文件中的代码复制过来进行处理
        
        *******************************/
       function notifyurl(){
                /*
                同理去掉以下两句代码；
                */ 
                //require_once("alipay.config.php");
                //require_once("lib/alipay_notify.class.php");
                
                //这里还是通过C函数来读取配置项，赋值给$alipay_config
        $alipay_config=C('alipay_config');
        //var_dump('进入异步通知页面');exit;
        //计算得出通知验证结果
        $alipayNotify = new \AlipayNotify($alipay_config);
        $verify_result = $alipayNotify->verifyNotify();
//         $out_trade_no   = $_POST['out_trade_no'];      //商户订单号
//         if($this->checkorderstatus($out_trade_no))
//         {
//         	$this->orderhandle($out_trade_no);
//         }
        if($verify_result) {
        	//var_dump('验证成功1!');
           //验证成功
           //获取支付宝的通知返回参数，可参考技术文档中服务器异步通知参数列表
           $out_trade_no   = $_POST['out_trade_no'];      //商户订单号
           $trade_no       = $_POST['trade_no'];          //支付宝交易号
           $trade_status   = $_POST['trade_status'];      //交易状态
           $total_fee      = $_POST['total_fee'];         //交易金额
           $notify_id      = $_POST['notify_id'];         //通知校验ID。
           $notify_time    = $_POST['notify_time'];       //通知的发送时间。格式为yyyy-MM-dd HH:mm:ss。
           $buyer_email    = $_POST['buyer_email'];       //买家支付宝帐号；
           $parameter = array(
             "out_trade_no"     => $out_trade_no, //商户订单编号；
             "trade_no"     => $trade_no,     //支付宝交易号；
             "total_fee"     => $total_fee,    //交易金额；
             "trade_status"     => $trade_status, //交易状态
             "notify_id"     => $notify_id,    //通知校验ID。
             "notify_time"   => $notify_time,  //通知的发送时间。
             "buyer_email"   => $buyer_email,  //买家支付宝帐号；
           );
           if($_POST['trade_status'] == 'TRADE_FINISHED') {
           }
           else if ($_POST['trade_status'] == 'TRADE_SUCCESS') {  
             	//\Think\Log::write('验证成功3!','WARN');
               if($this->checkorderstatus($out_trade_no))
               {
               	   $this->orderhandle($out_trade_no);
               }
           }
                echo "success";        //请不要修改或删除
         }else {
                //验证失败
                echo "fail";
        }    
    }
    /*
        页面跳转处理方法；
        这里其实就是将return_url.php这个文件中的代码复制过来，进行处理； 
        */
    function returnurl(){
//     	$out_trade_no=125;
//         if($this->checkorderstatus($out_trade_no))
//         {
//         	$this->orderhandle($out_trade_no);
//         }
        //头部的处理跟上面两个方法一样，这里不罗嗦了！
        $alipay_config=C('alipay_config');
        $alipayNotify = new \AlipayNotify($alipay_config);//计算得出通知验证结果
        $verify_result = $alipayNotify->verifyReturn();
       if($verify_result) {//验证成功
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			//请在这里加上商户的业务逻辑程序代码
			
			//——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
			//获取支付宝的通知返回参数，可参考技术文档中页面跳转同步通知参数列表
			//商户订单号
			$out_trade_no = $_GET['out_trade_no'];
			//支付宝交易号
			$trade_no = $_GET['trade_no'];
			//交易状态
			$trade_status = $_GET['trade_status'];

			if($_GET['trade_status'] == 'TRADE_FINISHED' || $_GET['trade_status'] == 'TRADE_SUCCESS') {
				
				if($this->checkorderstatus($out_trade_no))
				{
					$this->orderhandle($out_trade_no);
				}
				//判断该笔订单是否在商户网站中已经做过处理
					//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
					//如果有做过处理，不执行商户的业务程序
				$this->redirect('/Home/Min/pay_success');//跳转到配置项中配置的支付成功页面；
			}
			else {
			  echo "trade_status=".$_GET['trade_status'];
			}
		    //——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
        }
		else {
			//验证失败
			//如要调试，请看alipay_notify.php页面的verifyReturn函数
			//echo "验证失败";
			 // $aaaaaaa=C('alipay.errorpage');
			 // var_dump($aaaaaaa);exit;
			$this->redirect('/Home/Min/pay_fail');//跳转到配置项中配置的支付失败页面；
		}
}
}
?>