<?php
namespace Admin\Controller;

class WxController extends AdminBaseController {

    public function index(){
        $this -> assign('username',session('username'));
        $this -> display();
    }
	
	
	public function config_set()
	{
		if($_SERVER['REQUEST_METHOD']=="GET")
		{
		  $this->display();
		}
		else
		{
			$appid=$_POST['appid'];
			$appsecret=$_POST['appsecret'];
			$token=$_POST['token'];
			if($appid==""||$appsecret==""||$token=="")
			{
				$this->error('请将信息填写完整',U('Wx/config_set'),1);
				die;
			}
			$data['appid']=$appid;
			$data['appsecret']=$appsecret;
			$data['token']=$token;
			$count=M('wx_config')->where('id=1')->save($data);
			if($count>0)
			{
				//$this->success('设置成功',U('Index/Index'),1);
				echo "<script type='text/javascript'>alert('设置成功');</script>";
				die;
			}
			else{
				//$this->error('设置失败',U('Wx/config_set'),1);
				echo "<script type='text/javascript'>alert('设置失败');</script>";
				die;
			}
		}
	}
}
