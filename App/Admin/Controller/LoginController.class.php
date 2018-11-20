<?php
namespace Admin\Controller;
use Think\Controller;
class LoginController extends Controller {

    public function index(){
        if(I('username')){
             $pwd = I('pwd');
             $data['username'] = I('username');
             $user_info = M('admin') -> where($data) -> find();
             if($user_info){
                 if($user_info['password'] == md5($pwd)){
                    session('username',$user_info['username']);
                    session('user_id',$user_info['userid']);
                    //header('Location:'.session('refer'));
                    $this -> success('登录成功', U('Index/index'),1);
                    die;
                 }else{
                    $this -> success('密码错误', U('Login/index'),1);
                    die;
                 }
             }
             else{
                    $this -> success('用户不存在', U('login/index'),1);
                    die;
                 }
         }
        $this -> display();
    }

    function check_verify($code, $id = ''){
        $verify = new \Think\Verify();
        return $verify->check($code, $id);
    }

    public function verify(){
        /*
        $arr = array(
            'imageW'    =>    130,
            'imageH'    =>    34,
            'fontSize'    =>    16,    // 验证码字体大小
            'length'    =>    4,     // 验证码位数
            'useNoise'    =>    false, // 关闭验证码杂点
            'useCurve'    =>    false,
            'bg'        =>    array(238, 238, 238)
        );
        $Verify = new \Think\Verify($arr);
        $Verify->entry();
        */
        $arr = array(
            'imageW'    =>    130,
            'imageH'    =>    34,
            'fontSize'    =>    16,    // 验证码字体大小
            'length'    =>    4,     // 验证码位数
            'useNoise'    =>    false, // 关闭验证码杂点
            'useCurve'    =>    false,
            'bg'        =>    array(238, 238, 238)
        );
        $Verify =     new \Think\Verify($arr);
        // 验证码字体使用 ThinkPHP/Library/Think/Verify/ttfs/5.ttf
        $Verify->useZh = true;
        $Verify->entry();
    }

}
