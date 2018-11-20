<?php
namespace PC\Controller;
use Think\Controller;
class IndexController extends Controller {

    public function index(){

        $list = $this -> getList(4);
        $list3 = $this -> getList(3);
        $list5 = $this -> getList(5);
        $list2 = $this -> getList(2);
        $list1 = $this -> getList(1);
        //$list = $this -> getList(4);
        //$list = $this -> getList(4);
        $this -> assign('list',$list);
        $this -> assign('list3',$list3);
        $this -> assign('list5',$list5);
        $this -> assign('list2',$list2);
        $this -> assign('list1',$list1);
        $this -> display();
    }

    public function registere(){
        if(I("login_phone")){
            $data['phone'] = I('login_phone');
            $data['statue'] = 1;
            $res = M('user') -> where($data) -> find();

            if($res) {
                $pwd = md5(I('password'));
                if ($pwd == $res['pwd']) {
                    $this->success('登录成功', U('Index/index'), 1);
                    session('user_id', $res['uid']);
                    session('star', $res['star']);
                    session('nick_name', $res['nick_name']);
                    session('header_img',$res['header_img']);
                    session('user_addr',$res['address']);
                    session('sex_v',$res['sex']);

                    if($res['sex'] == 1){
                        $res['sex'] = '男';
                    }elseif($res['sex'] == 2){
                        $res['sex'] = '女';
                    }else{
                        $res['sex'] = '保密';
                    }
                    session('sex',$res['sex']);
                    die;
                }
            }else{
                $this->success('用户不存在', U('Index/registere'), 1);
                die;
            }
        }
        if(I()){
            //dump(I());
            $data['phone'] = I('phone');
            $res = M("user") -> where($data) -> find();
            if($res){
                $this -> success('手机号已注册',U('Index/registere'),1);
                die;
            }
            $data['pwd'] = md5(I('pwd'));
            $res = M('user') -> add($data);
            if($res){
                $this -> success('注册成功',U('Index/InfoEdit'),1);
                die;
            }else{
                $this -> success('注册失败',U('Index/registere'),1);
                die;
            }
        }
        $this -> display();
    }

    public function detail(){

        if(I()){
            $data['ac_id'] = I('id');
            $img_list = M("activelun") -> where($data) -> field("pic_path") -> limit(3) -> select();
            $info = M('active') -> where($data) -> find();
            $info["start_time"] = date('m月d日',strtotime($info["start_time"]));
            $info["end_time"] = date('m月d日',strtotime($info["end_time"]));
            $img = json_decode($info['ac_img'],true);
            $img = $img['bg_img'];
            $this -> assign("img",$img);
            $this -> assign("img_list",$img_list);
            $this->assign('info',$info);
        }

        $fine = M('active') -> where('type=1') -> field('ac_id,ac_title') -> limit(3) -> select();
        foreach($fine as $key=>$val){
            $active_img = json_decode($val['ac_img'],true);
            $fine[$key]['ac_img'] = $active_img['bg_img'];
        }
        dump($fine);

/*
        $list = M('contact') -> where($data) -> select();
        foreach($list as $key=>$val){
            if($val['sex'] == 1){
                $list[$key]['sex'] = '男';
            }else{
                $list[$key]['sex'] = '女';
            }
            if($val['ID_type'] == 1){
                $list[$key]['ID_type'] = '身份证';
            }elseif($val['ID_type'] == 2){
                $list[$key]['ID_type'] = '军官证';
            }
        }
        $this -> assign('list',$list);
*/

        $this -> display();
    }

    public function Min(){

        $this -> display();
    }

    public function forgetPwd(){
        $this -> display();
    }

    public function mentality(){
        $this -> display();
    }

    public function message(){
        $this -> display();
    }

    public function activeRili(){
        $this -> display();
    }

    public function publicActive(){

        $this -> display();
    }

    public function InfoEdit(){

        $this -> display();
    }

    public function getList($category){

        $ac_list = M('active') -> where('category='.$category) -> order('addTime asc') -> limit(6) -> select();
        $ac_list = $this -> get_small($ac_list);

        foreach($ac_list as $key=>$val){

            $ac_list[$key]['ac_title'] = substr($val['ac_title'],0,30);
            $num1 = strtotime($val['start_time']);
            $num2 = strtotime($val['end_time']);
            $num = $num2 - $num1;

            $date = floor($num / 86400);
            $ac_list[$key]['datas'] = $date;
            $ac_list[$key]['ye'] = (int)$date -1;
        }


        return $ac_list;

    }

    public function getImg(){
/*
        var imgs=[
            {"i":0,"img":"http://local.qz.com/public/pc/images/banner/banner-1.png"},
            {"i":1,"img":"http://local.qz.com/public/pc/images/banner/banner-2.png"},
            {"i":2,"img":"http://local.qz.com/public/pc/images/banner/banner-3.png"},
            {"i":3,"img":"http://local.qz.com/public/pc/images/banner/banner-4.png"},
            {"i":4,"img":"http://local.qz.com/public/pc/images/banner/banner-5.png"},
        ];
        */
        
        $list = M('lun') -> field('pic_path') -> select();
        $json = array();
        foreach($list as $key=>$val){
            $active_img = json_decode($list[$key]['pic_path'],true);
            $data['i'] = $key;
            $data['img'] = 'http://'.$_SERVER['HTTP_HOST'].'/'.$active_img['bg_img'];
            $json[] = $data;
        }
        echo json_encode($json,true);

    }

    public function get_small($ac_list){

        foreach($ac_list as $key=>$val){
            $active_img = json_decode($ac_list[$key]['ac_img'],true);
            $ac_list[$key]['ac_img'] = $active_img['sm_img'];
        }
        return $ac_list;
    }

    public function get_big($ac_list){

        foreach($ac_list as $key=>$val){
            $active_img = json_decode($ac_list[$key]['ac_img'],true);
            $ac_list[$key]['ac_img'] = $active_img['bg_img'];
        }
        return $ac_list;
    }

}