<?php
namespace Admin\Controller;

class UserController extends AdminBaseController {

    public function user_list()
	{
		if(isset($_POST['nick_name']))
		{			
			$nick_name=$_POST['nick_name'];
			$filter="nick_name like '%$nick_name%'";
			$list = M('user')->where($filter) -> select();
			$count = M('user')->where($filter) -> count();
		}
	   else{
          $list = M('user') -> select();
		  $count = M('user') -> count();
		}
		foreach($list as $key=>$val)
		{
			if($list[$key]['sex']==0)
			{
				$list[$key]['sex']="保密";
			}
			else if($list[$key]['sex']==1)
			{
				$list[$key]['sex']="男";
			}
			else if($list[$key]['sex']==2){
				$list[$key]['sex']="女";
			}
			//$image=json_decode($list[$key]['header_img']);
			//$list[$key]['header_img']=$image['sm_img'];
		}
		$this->assign('list',$list);
		$this->assign('count',$count);
		$this->display(); 
	}
	
	public function user_del()
	{
		if(isset($_GET['uid']))
		{
			$uid=$_GET['uid'];
			$filter['uid']=$uid;
			$count=M('user')->where($filter)->delete();
			if($count>0)
			{
				$this->success('删除成功',U('User/user_list'),1);
			}
			else{
				$this->error('删除失败',U('User/user_list'),1);
			}
		}
		else{
			$this->error('请先选择要删除的订单',U('User'),1);
		}
	}
	
	public function user_add()
	{
		if($_SERVER['REQUEST_METHOD']=="GET")
		{
			$this->display();
		}
		else{
			$data['nick_name'] = I('username');
			if(!I('username'))
			{
				$this->error('添加失败，请填写用户名',U('User/user_add'),1);
			}
			if(!I('password'))
			{
				$this->error('添加失败，请设置密码',U('User/user_add'),1);
			}
			if(!I('addr'))
			{
				$this->error('添加失败，请填写地址',U('User/user_add'),1);
			}
			$data['pwd'] = md5(I('password'));
            $data['sex'] = (int)I('sex');
            $data['phone'] = I('mobile');
            $data['star'] = I('star_amount');
            $data['address'] = I('addr');
            $path = $this -> upload('User','header_img',true);
            $data['header_img'] = $path['sm_img'];
            $res = M('user') -> add($data);
            if($res){
                $this -> success('添加成功', U('User/user_list'),1);
                die;
            }else{
                $this -> error('添加失败，请重新添加', U('User/user_add'),1);
                die;
            }			
		}
	}
	
	public function change_pwd()
	{
		if($_SERVER["REQUEST_METHOD"]=="GET")
		{
		   $filter['uid']=(int)$_GET['uid'];
		   $model=M('user')->where($filter)->limit(1)->select();
		   $this->assign("model",$model[0]);
		   $this->display();
		}
		else{
		   $uid=(int)$_POST['uid'];
		   $filter['uid']=$uid;
		   $newpwd1=$_POST['newpassword'];
		   $newpwd2=$_POST['newpassword2'];
		   if($newpwd1!=$newpwd2)
		   {
			   $this->error('两次输入的密码不一致,请重新修改',U('User/user_list'),1);
		   }
		   else{
			   $data['pwd']=md5($newpwd1);
			   $model=M('user')->where($filter)->select();
			   if($model['pwd']==$data['pwd'])
			   {
				   $this->success('请设置新的密码',U('User/user_list'),1);
			   }
			   $count=M('user')->where($filter)->save($data);
			   if($count>0)
			   {
				   $this->success('密码修改成功',U('User/user_list'),1);
			   }
			   else{
				   $this->error('密码修改失败',U('User/user_list'),1);
			   }
		   }
		}
	}
	
	public function user_update(){
		if($_SERVER['REQUEST_METHOD']=="GET")
		{
			$uid=isset($_GET['uid'])?$_GET['uid']:0;
			$model=M('user')->where('uid='.$uid)->limit(1)->select(); 
			$this->assign('model',$model[0]);
			$this->assign('sex',$model[0]['sex']);
			$this -> display();
		}
		else{
			$filter['uid']=(int)$_POST['uid'];
			if(!I('addr'))
			{
				$this->error('添加失败，请填写地址',U('User/user_add'),1);
			}
            $data['sex'] = (int)$_POST['sex'];
            $data['phone'] = I('mobile');
            $data['star'] = (int)I('star_amount');
            $data['address'] = I('addr');
            $path = $this -> upload('User','header_img',true);
            $data['header_img'] = $path['sm_img'];
            $model=M('user')->where($filter)->save($data);
			if($model>0)
			{
				$this -> success('修改成功', U('User/user_list'),1);
			}
			else{
				$this -> error('修改失败', U('User/user_list'),1);
			}
		}
    }
	
	
    public function badge_list(){

        $list = M('badge') -> select();

        $this -> assign('list',$list);
        $this -> display();
    }

    public function hui_edit(){
        if(I(ac_nick)){
            dump(I());
            $ac_nick = I('ac_nick');
             session('a_uid',I('ac_id'));
        }
        if(I('star')){
            $data['star'] = I("star");
            $data['badge_num'] = I("badge_num");
            $data['uid'] = session('a_uid');
            $res = M('user') -> save($data);

            if($res){
                $this -> success('修改成功', U('Index/member_list'),1);
                die;
            }else{
                $this -> success('修改失败', U('Index/hui_edit'),1);
                die;
            }

        }
        $this -> assign('nick',$ac_nick);
        $this -> display();
    }

    public function badge_del(){
        $data['id'] = I('id');
        $res = M('badge') -> where($data) -> delete();

        if($res){
            $this -> success('图片删除成功', U('Index/badge_list'),1);
            die;
        }else{
            $this -> success('图片删除失败', U('Index/badge_list'),1);
            die;
        }
    }

    public function badge_set(){
        $data['uid'] = I('uid');

        $this -> display();
    }


    public function badge_add(){

        if(I('img_title')){

            $data['remarks'] = I('img_title');
            $path = $this -> upload('Badge','pic_path',true);
            $data['pic'] = $path['sm_img'];

            $res = M('badge') -> add($data);
            if($res){
                $this -> success('图片上传成功', U('Index/badge_list'),1);
                die;
            }else{
                $this -> success('图片上传失败', U('Index/badge_add'),1);
                die;
            }
        }

        $this -> display();
    }


    public function goodcomment_list(){

        $list = M('ordercomment') -> join('ze_simulation on ze_ordercomment.oid=ze_simulation.id') -> select();
        $this -> assign('list',$list);
        $this -> display();
    }

    public function article_list(){
        $list = M('article') -> select();
        foreach($list as $key=>$val){
            $img = json_decode($val['title_img'],true);
            $list[$key]['title_img'] = $img['sm_img'];
        }

        $this -> assign('list',$list);
        $this -> display();
    }

    public function article_add(){
        if(I('title')){
            $data['title'] = I('title');
            $data['author'] = I('author');
            $data['type'] = I('type');
            $data['content'] = I('content');
            $path = $this -> upload('Article','title_img',true);
            $data['title_img'] = json_encode($path,true);
            $res = M('article') -> add($data);
            if($res){
                $this -> success('添加成功', U('Index/article_list'),1);
                die;
            }else{
                $this -> success('添加失败', U('Index/article_add'),1);
                die;
            }
        }
        $this -> display();
    }

    public function order_list(){
        $list = M('simulation') -> select();
        foreach($list as $key=>$val){
            $list[$key]['start_time'] = date('Y-m-d H:i',$val['start_time']);
            $list[$key]['end_time'] = date('Y-m-d H:i',$val['end_time']);
        }
        $this -> assign('list',$list);
        $this -> display();
    }

    public function order_add(){

        if(I('title')){

            $data['title'] = I('title');
            $data['start_time'] = strtotime(I('start_time'));
            $data['end_time'] = strtotime(I('end_time'));
            $data['meal_peaple'] = I('meal_peaple');
            $data['meal_title'] = I('meal_title');
            $data['addr'] = I('addr');
            $data['price'] = I('price');

            $path = $this -> upload('Order','pic',true);
            
            $data['pic'] = $path['sm_img'];

            $res = M('simulation') -> add($data);

            if($res){
                $this -> success('添加成功', U('Index/order_list'),1);
                die;
            }else{
                $this -> success('添加失败，请重新添加', U('Index/order_add'),1);
                die;
            }

        }
        $this -> display();
    }

    public function index(){
        $this -> assign('username',session('username'));
        $this -> display();
    }

    public function message_list(){

        $res = M('msg') -> select();
        foreach($res as $key=>$val){
            if($res[$key]['ms_type'] == 1){
                $res[$key]['ms_type'] = '系统消息';
            }else{
                $res[$key]['ms_type'] = '优惠活动消息';
            }
        }
        $this -> assign('list',$res);
        $this -> display();
    }

    public function partake_list(){
        $res = M('partake') -> select();
        $this -> assign('list',$res);
        $this -> display();
    }

    public function partake_add(){
        if(I('user_id')){
            $data['uid'] = session('user_id');
            $data['title'] = I('title');
            $data['ti_name'] = I('ti_name');
            $data['job_name'] = I('job_name');
            $data['slogan'] = I('slogan');
            $data['intro'] = I('intro');

            $path = $this -> upload('Partake','pic_path',flase);
            $data['pic_path'] = $path['bg_img'];

            $res = M('partake') -> add($data);
            if($res){
                $this -> success('添加成功', U('Index/partake_list'),1);
                die;
            }else{
                $this -> success('添加失败', U('Index/partake_add'),1);
                die;
            }

        }
        $this -> display();
    }

    public function about_list(){
        $list = M('about') -> order('addTime desc') -> select();
        $this -> assign('list',$list);
        $this -> display();
    }

    public function about_add(){

        if(I('title')){
            $data['title'] = I('title');
            $data['content'] = I('content');
            $data['phone'] = I('phone');
            $data['qq'] = I('qq');
            $data['email'] = I('email');
            $res = M('about') -> add($data);
            if($res){
                $this -> success('添加成功', U('Index/about_list'),1);
                die;
            }else{
                $this -> success('添加失败', U('Index/about_add'),1);
                die;
            }
        }
        $this -> display();
    }

    public function active_picture(){
        $list = M('activelun') -> select();
        $this -> assign('list',$list);
        $this -> display();
    }

    public function active_picture_add(){

        if(I('id')){
            cookie('ac_id',I('id'));
        }

        if(I('img_title')){
            $data['ac_id'] = cookie('ac_id');
            $num = M('activelun') -> where($data) -> count();
            if($num > 3){
                $this -> success('每个项目最多允许上传三张图片', U('Index/active_picture'),1);
                die;
            }
            $data['img_title'] = I('img_title');
            $path = $this -> upload('Lunbo','pic_path',false);
            $data['pic_path'] = $path['bg_img'];
            $res = M('activelun') -> add($data);
            if($res){
                $this -> success('图片上传成功', U('Index/active_picture'),1);
                die;
            }else{
                $this -> success('图片上传失败', U('Index/active_picture_add'),1);
                die;
            }
        }
        $this -> display();
    }

    public function meal_list(){
        $list = M('meal') -> select();
        foreach($list as $key=>$val){
            $list[$key]['ac_title'] = M('active') -> where('ac_id='.$val['ac_id']) -> getField('ac_title');
            $list[$key]['type_id'] = M('mealtype') -> where('id='.$val['type_id']) -> getField('title');
            $list[$key]['price'] = M('mealtype') -> where('id='.$val['type_id']) -> getField('price');
        }
        $this -> assign('list',$list);
        $this -> display();
    }

    public function meal_add(){
        if(I('ac_id')){
            $data['ac_id'] = I('ac_id');
            $data['type_id'] = I('type_id');
            $data['num'] = I('num');
            $data['content'] = I('content');
            $data['start_time'] = I('start_time');

            $data['me_title'] = I('me_title');
            $data['days'] = I('days');
            $res = M('meal') -> add($data);
            if($res){
                $this -> success('套餐添加成功', U('Index/meal_list'),1);
                die;
            }else{
                $this -> success('套餐添加失败', U('Index/meal_add'),1);
                die;
            }
        }

        $this -> display();
    }

    public function message_del(){

        if(I('ms_title')){
            $data['ms_title'] = I('ms_title');
            $data['ms_type'] = I('ms_type');
            $data['title'] = I('title');
            $data['content'] = I('content');
            $data['active_id'] = (int)I('active_id');

            $res = M('msg') -> add($data);

            if($res){
                $this -> success('消息添加成功', U('Index/message_list'),1);
                die;
            }else{
                $this -> success('消息添加失败', U('Index/message__add'),1);
                die;
            }
        }
        $this -> display();

    }

    public function active_list(){
		if(isset($_POST['active_name']))
		{
			$active_name=$_POST['active_name'];
			$filter="ac_title like '%$active_name%'";
			$list = M('active')->where($filter) -> select();
		}
		else{
          $list = M('active') -> select();
		}
        foreach($list as $key=>$val){
            if($val['category'] == 1){
                $list[$key]['category'] = '门票';
            }elseif($val['category'] == 2){
                $list[$key]['category'] = '酒店';
            }elseif($val['category'] == 3){
                $list[$key]['category'] = '夏令营';
            }elseif($val['category'] == 4){
                $list[$key]['category'] = '游学';
            }elseif($val['category'] == 5){
                $list[$key]['category'] = '学院';
            }elseif($val['category'] == 6){
                $list[$key]['category'] = '公益活动';
            }
        }
        $this -> assign('list',$list);
        $this -> display();
    }

    public function active_update(){
		if($_SERVER['REQUEST_METHOD']=="GET")
		{
			$ac_id=isset($_GET['ac_id'])?$_GET['ac_id']:0;
			$model=M('active')->where('ac_id='.$ac_id)->limit(1)->select();
			$model[0]['ac_content']= html_entity_decode($model[0]['ac_content']);  
			//var_dump($model[0]);exit;
			$this->assign('model',$model[0]);
			$this -> display();
		}
		else{
			$filter['ac_id']=(int)$_POST['ac_id'];
			$data['ac_title'] = I('ac_title');
			$data['partake_num'] = intval(I('partake_num'));
			$data['lable'] = I('lable');
			$data['fit_age'] = I('fit_age');
			$data['addr'] = I('addr');
			$data['single_price'] = intval(I('single_price'));
			$data['ac_intro'] = I('ac_intro');
			$data['ac_content'] = htmlentities(I('ac_content'));
            $model=M('active')->where($filter)->save($data);
			if($model>0)
			{
				$this -> success('修改成功', U('Index/active_list'),1);
			}
			else{
				$this -> success('修改失败', U('Index/active_list'),1);
			}
		}
    }

    public function active_add(){
		
		if($_SERVER['REQUEST_METHOD']=="GET")
		{
			$this -> display();
		}
		else{
			$data['ac_title'] = I('ac_title');
			$data['partake_num'] = intval(I('partake_num'));
			$data['lable'] = I('lable');
			$data['fit_age'] = I('fit_age');
			$data['addr'] = I('addr');
			$data['category'] = I('category');
			$data['view_addr'] = I('view_addr');
			$data['ac_intro'] = I('ac_intro');
			$data['start_time'] = I('start_time');
			$data['end_time'] = I('end_time');
			$data['type'] = I('type');
			$data['ac_content'] = addslashes(I('ac_content'));
			$data['single_price'] = intval(I('single_price'));
			$path = $this -> upload('Active','ac_img',true);
			$data['ac_img'] = json_encode($path);
			$res = M('active') -> add($data);
			if($res){
				$this -> success('添加成功', U('Index/active_list'),1);
				die;
			}else{
				$this -> success('添加失败', U('Index/active_add'),1);
				die;
			}
		}
        
    }

    public function active_del(){
        if(isset($_GET['ac_id']))
		{
            $data['ac_id'] = $_GET['ac_id'];
            $res = M('active') -> where($data) -> delete();
            if($res){
                $this -> success('删除成功', U('Index/active_list'),1);
                die;
            }else{
                $this -> success('删除失败', U('Index/active_list'),1);
                die;
            }
        }
		else{
			$this -> error('删除失败,请选择具体的活动!', U('Index/active_list'),1);
		}
        $this -> display();
    }

    public function picture_add(){
        if(I('img_title')){
            $data['img_title'] = I('img_title');
            $path = $this -> upload('Lunbo','pic_path',true);
            $data['pic_path'] = json_encode($path,true);
            $res = M('lun') -> add($data);
            if($res){
                $this -> success('图片上传成功', U('Index/picture_list'),1);
                die;
            }else{
                $this -> success('图片上传失败', U('Index/picture_add'),1);
                die;
            }
        }
        $this -> display();
    }

    public function picture_list(){
        $pic_list = M('lun') -> select();

        foreach($pic_list as $key=>$val){
            $img_path = json_decode($pic_list[$key]['pic_path'],true);
            $pic_list[$key]['pic_path'] = $img_path['sm_img'];
        }
        $this -> assign('list',$pic_list);

        $this -> display();
    }


    public function product_add(){
        $this -> display();
    }

    public function welcome(){
        $this -> display();
    }

    public function view_add(){
        if(I('ac_id')){
            $data['ac_id'] = I('ac_id');
            $data['title'] = I('title');
            $data['content'] = I('content');
            $res = M('view') -> add($data);
            if($res){
                $this -> success('添加成功', U('Index/view_list'),1);
                die;
            }else{
                $this -> success('添加失败', U('Index/view_add'),1);
                die;
            }
        }
        $this -> display();
    }

    public function view_list(){
        $list = M('view') -> select();
        $this -> assign('list',$list);
        $this -> display();
    }

    public function contact_list(){

        $list = M('contact') -> select();
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
        $this -> display();
    }


    public function contact_add(){
        if(I('uid')){
            $data['uid'] = I('uid');
            $data['name'] = I('name');
            $data['sex'] = I('sex');
            $data['ID_type'] = I('ID_type');
            $data['ID_card'] = I('ID_card');
            $res = M('contact') -> add($data);
            if($res){
                $this -> success('添加成功', U('Index/contact_list'),1);
                die;
            }else{
                $this -> success('添加失败', U('Index/contact_add'),1);
                die;
            }

        }
        $this -> display();
    }

    public function product_brand(){
        $this -> display();
    }

    public function product_category(){
        $this -> display();
    }

    public function product_list(){
        $this -> display();
    }

    public function member_list(){
        $info = M('user') -> select();
        foreach($info as $key=>$val){
            if($val['sex'] == 1){
                $info[$key]['sex'] = '男';
            }elseif($val['sex'] == 2){
                $info[$key]['sex'] = '女';
            }else{
                $info[$key]['sex'] = '保密';
            }
        }
        $this -> assign('list',$info);
        $this -> display();
    }

    public function member_del(){
        $this -> display();
    }

    public function feedback_list(){
        $list = M('suggest') -> select();
        $this -> assign('list',$list);
        $this -> display();
    }

    public function feedback_list2(){
        $list = M('comment') -> select();
        foreach($list as $key=>$val){
            $list[$key]['nick_name'] = M('user') -> where('uid='.$val['uid']) -> getField('nick_name');
        }
        $this -> assign('list',$list);
        $this -> display();
    }

    public function member_record_browse(){
        $this -> display();
    }

    public function member_record_download(){
        $this -> display();
    }

    public function member_record_share(){
        $this -> display();
    }


    public function system_base(){
        $this -> display();
    }

    public function system_category(){
        $this -> display();
    }

    public function system_log(){
        $this -> display();
    }

    public function system_data(){
        $this -> display();
    }

    public function admin_list(){
        $this -> display();
    }

    public function admin_role(){
        $this -> display();
    }

    public function admin_permission(){
        $this -> display();
    }

    public function test(){

        if($_POST){

            $arr = $this -> Index_db -> upload('shouye',true);
            echo '<pre>';
            print_r($arr);
            echo '</pre>';
            echo '<br/>'.json_encode($arr);
        }

        $this -> display();
    }


    public function upload($path,$file_name,$is_small)
    {

        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize = 3145728;// 设置附件上传大小
        $upload->exts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->rootPath = $_SERVER['DOCUMENT_ROOT'] . '/Uploads/';// 设置附件上传根目录
        $upload->savePath = $path.'/'.time() . '/'; // 设置附件上传（子）目录
        $upload->autoSub = false;
        // 上传文件
        $info = $upload->upload();
        if (!$info) {// 上传错误提示错误信息
            $this->error($upload->getError());
        } else {// 上传成功 获取上传文件信息
            if($is_small){
                $image = new \Think\Image();
                $image->open($upload->rootPath . $info[$file_name]['savepath'] . $info[$file_name]['savename']);
                //将图片裁剪为400x400并保存为corp.jpg
                $image->thumb(150, 150)->save($upload->rootPath . $info[$file_name]['savepath'] . 'sm_' . $info[$file_name]['savename']);
                $arr['sm_img'] = 'Uploads/' . $info[$file_name]['savepath'] . 'sm_' . $info[$file_name]['savename'];

            }
            $arr['bg_img'] = 'Uploads/' . $info[$file_name]['savepath'] . $info[$file_name]['savename'];

            return $arr;
        }
    }


}
