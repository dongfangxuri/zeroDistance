<?php
namespace Admin\Controller;

class IndexController extends AdminBaseController {

	public function lunbo_list()
	{
		if(isset($_POST['title']))
		{
			$title=$_POST['title'];
			$filter="img_title like '%$title%'";
			$list = M('lun')->where($filter) ->order('sort_id')-> select();
			$count = M('lun')->where($filter) -> count();
		}
		else{
          $list = M('lun')->order('sort_id') -> select();
		  $count = M('lun') -> count();
		}
		
 	    foreach($list as $key=>$val){
			$active_img = json_decode($list[$key]['pic_path'],true);
            $list[$key]['pic_path'] = $active_img['sm_img'];
        } 
		$this->assign('list',$list);
		$this->assign('count',$count);
		$this->display(); 
	}
	
	public function lunbo_add()
	{
		if($_SERVER['REQUEST_METHOD']=="GET")
		{
			$this->display();
		}
		else{
			$data['img_title']=$_POST['img_title'];
			$data['url']=$_POST['url'];
			$data['sort_id']=(int)$_POST['sort_id'];
			$path = $this -> upload('lun','pic_path',true);
			$data['pic_path'] = json_encode($path);
			$data['addTime'] = time();
			$count=M('lun')->add($data);
			if($count>=1)
			{
				$this -> success('添加成功', U('Index/lunbo_list'),1);
			}
			else{
				$this -> error('添加失败', U('Index/lunbo_add'),1);
			}
		}
	}
	
	public function lunbo_del()
	{
		if(isset($_GET['id']))
		{
            $data['img_id'] = $_GET['id'];
            $res = M('lun') -> where($data) -> delete();
            if($res){
                $this -> success('删除成功', U('Index/lunbo_list'),1);
                die;
            }else{
                $this -> success('删除失败', U('Index/lunbo_list'),1);
                die;
            }
        }
		else{
			$this -> error('删除失败,请选择具体的轮播图!', U('Index/lunbo_list'),1);
		}
	}
	
	public function lunbo_update()
	{
		if($_SERVER['REQUEST_METHOD']=="GET")
		{
			$id=isset($_GET['id'])?$_GET['id']:0;
			$model=M('lun')->where('img_id='.$id)->limit(1)->select();
			$this->assign('model',$model[0]);
			$this -> display();
		}
		else{
			$filter['img_id']=(int)$_POST['id'];
			if(!I('img_title'))
			{
				echo '<script type="text/javascript"> alert("请输入轮播图标题");</script>';
				die();
			}
			if(!I('sort_id'))
			{
				echo '<script type="text/javascript"> alert("请输入排序编号");</script>';
				die();
			}
			$data['url'] = I('url');
			$data['img_title'] = I('img_title');
			$data['sort_id']=intval(I('sort_id'));
			$path = $this -> upload('lun','pic_path',true);
			$data['pic_path'] = json_encode($path);
            $model=M('lun')->where($filter)->save($data);
			if($model>0)
			{
				$this -> success('修改成功', U('Index/lunbo_list'),1);
			}
			else{
				$this -> success('修改失败', U('Index/lunbo_list'),1);
			}
		}
	}
	
	public function menu_list()
	{
		if(isset($_POST['menu_name']))
		{
			$menu_name=$_POST['menu_name'];
			$filter="menu_name like '%$menu_name%'";
			$list = M('menu')->where($filter) -> select();
			$count = M('menu')->where($filter) -> count();
		}
		else{
          $list = M('menu') -> select();
		  $count = M('menu') -> count();
		}
 	    foreach($list as $key=>$val){
			$active_img = json_decode($list[$key]['image_url'],true);
            $list[$key]['image_url'] = $active_img['sm_img'];
        } 
		$this->assign('list',$list);
		$this->assign('count',$count);
		$this->display(); 
	}	
	
	public function menu_add()
	{
		if($_SERVER['REQUEST_METHOD']=="GET")
		{
			$this->display();
		}
		else{
			$data['menu_name']=$_POST['menu_name'];
			$data['url']=$_POST['url'];
			$data['sort_id']=(int)$_POST['sort_id'];
			$path = $this -> upload('menu','image_url',true);
			$data['image_url'] = json_encode($path);
			$count=M('menu')->add($data);
			if($count>=1)
			{
				$this -> success('添加成功', U('Index/menu_list'),1);
			}
			else{
				$this -> error('添加失败', U('Index/menu_add'),1);
			}
		}
	}
	
	public function menu_del(){
        if(isset($_GET['id']))
		{
            $data['id'] = $_GET['id'];
            $res = M('menu') -> where($data) -> delete();
            if($res){
                $this -> success('删除成功', U('Index/menu_list'),1);
                die;
            }else{
                $this -> success('删除失败', U('Index/menu_list'),1);
                die;
            }
        }
		else{
			$this -> error('删除失败,请选择具体的套餐!', U('Index/menu_list'),1);
		}
    }
	
	public function menu_update(){
		if($_SERVER['REQUEST_METHOD']=="GET")
		{
			$ac_id=isset($_GET['id'])?$_GET['id']:0;
			$model=M('menu')->where('id='.$ac_id)->limit(1)->select();
			$this->assign('model',$model[0]);
			$this -> display();
		}
		else{
			$filter['id']=(int)$_POST['mid'];
			if(!I('menu_name'))
			{
				echo '<script type="text/javascript"> alert("请输入菜单名称");</script>';
				die();
			}
			if(!I('sort_id'))
			{
				echo '<script type="text/javascript"> alert("请输入排序编号");</script>';
				die();
			}
			$data['menu_name'] = I('menu_name');
			$data['url'] = I('url');
			$data['sort_id']=intval(I('sort_id'));
			$path = $this -> upload('menu','image_url',true);
			$data['image_url'] = json_encode($path);
            $model=M('menu')->where($filter)->save($data);
			if($model>0)
			{
				$this -> success('修改成功', U('Index/menu_list'),1);
			}
			else{
				$this -> success('修改失败', U('Index/menu_list'),1);
			}
		}
    }
		
    public function badge_list(){

	   if(isset($_POST['badge_name']))
		{			
		  $remark=$_POST['badge_name'];
		  $filter="remarks like '%$remark%'";
		  $list = M('badge')->where($filter) -> select();
		  $count = M('badge')->where($filter) -> count();
		}
	  else{
          $list = M('badge') -> select();
		  $count = M('badge') -> count();
		}
		foreach($list as $key=>$val)
		{
			$image=json_decode($list[$key]['pic'],true);
			$list[$key]['pic']=$image['sm_img'];
		}
        $this -> assign('list',$list);
		$this -> assign('count',$count);
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
            $this -> success('徽章删除成功', U('Index/badge_list'),1);
            die;
        }else{
            $this -> error('徽章删除失败', U('Index/badge_list'),1);
            die;
        }
    }

    public function badge_set(){
        $data['uid'] = I('uid');
        $this -> display();
    }
	
    public function badge_update(){
		if($_SERVER['REQUEST_METHOD']=="GET")
		{
			$ac_id=isset($_GET['id'])?$_GET['id']:0;
			$model=M('badge')->where('id='.$ac_id)->limit(1)->select();
			$this->assign('model',$model[0]);
			$this -> display();
		}
		else{
			$filter['id']=(int)$_POST['id'];
			if(!I('remarks'))
			{
				//echo '<script type="text/javascript"> alert("请输入徽章描述");</script>';
				$this -> error('修改失败', U('Index/badge_list'),1);
				die();
			}
			$data['number'] = I('number');
			$data['remarks'] = I('remarks');
			$data['addTime']=time();
			$path = $this -> upload('Badge','pic_path',true);
			$data['pic'] = json_encode($path);
            $model=M('badge')->where($filter)->save($data);
			if($model>0)
			{
				$this -> success('修改成功', U('Index/badge_list'),1);
			}
			else{
				$this -> error('修改失败', U('Index/badge_list'),1);
			}
		}
    }
   
    public function badge_add(){

        if(I('img_title')){
            $data['remarks'] = I('img_title');
            $data['number'] = I('number');
            $path = $this -> upload('Badge','pic_path',true);
            $data['pic'] =json_encode($path);
            $res = M('badge') -> add($data);
            if($res){
                $this -> success('添加成功', U('Index/badge_list'),1);
                die;
            }else{
                $this -> error('添加失败', U('Index/badge_add'),1);
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
    	$count=M('article') -> count();
        $list = M('article') -> select();
//         foreach($list as $key=>$val){
//             $img = json_decode($val['title_img'],true);
//             $list[$key]['title_img'] = $img['sm_img'];
//         }
        $this -> assign('list',$list);
        $this -> assign('count',$count);
        $this -> display();
    }
    
    public function article_add(){
    	if($_SERVER['REQUEST_METHOD']=="GET")
    	{
    		$this -> display();
    	}
    	else {
    		$data['title'] = $_POST['title'];
    		$data['author'] = $_POST['author'];
    		$data['type'] = (int)$_POST['type'];
    		$data['content'] = stripslashes($_POST['content']);
    		$data['is_top'] = (int)$_POST['is_top'];
    		$data['is_show'] = (int)$_POST['is_show'];
    		$res = M('article') -> add($data);
    		if($res){
    			$this -> success('添加成功', U('Index/article_list'),1);
    			die;
    		}else{
    			$this -> success('添加失败', U('Index/article_add'),1);
    			die;
    		}
    	}
    }

    public function article_update(){
    	if($_SERVER['REQUEST_METHOD']=="GET")
    	{
    		$ac_id=isset($_GET['id'])?$_GET['id']:0;
    		$model=M('article')->where('id='.$ac_id)->limit(1)->select();
    		$this->assign('model',$model[0]);
    		$this -> display();
    	}
    	else{
    		$filter['id']=(int)$_POST['id'];
    		$data['title'] = $_POST['title'];
    		$data['author'] = $_POST['author'];
    		$data['type'] = (int)$_POST['type'];
    		$data['content'] = stripslashes($_POST['content']);
    		$data['is_top'] = (int)$_POST['is_top'];
    		$data['is_show'] = (int)$_POST['is_show'];
    		$model=M('article')->where($filter)->save($data);
    		if($model>0)
    		{
    			$this -> success('修改成功', U('Index/article_list'),1);
    		}
    		else{
    			$this -> success('修改失败', U('Index/article_list'),1);
    		}
    	}
    }
    
    public function article_del(){
    	$data['id'] = I('id');
    	$res = M('article') -> where($data) -> delete();
    	if($res){
    		$this -> success('删除成功', U('Index/article_list'),1);
    		die;
    	}else{
    		$this -> error('删除失败', U('Index/article_list'),1);
    		die;
    	}
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

		if(isset($_POST['title']))
		{
			$title=$_POST['title'];
			$filter="title like '%$title%'";
			$list = M('msg')->where($filter) -> select();
			$count = M('msg')->where($filter) -> count();
		}
		else{
          $list = M('msg') -> select();
		  $count = M('msg') -> count();
		}
        foreach($list as $key=>$val){
            if($list[$key]['ms_type'] == 1){
                $list[$key]['ms_type'] = '系统消息';
            }else{
                $list[$key]['ms_type'] = '优惠活动消息';
            }
			$active_name=M('active')->where('ac_id='.$list[$key]['active_id'])->limit(1)->select();
			$usermodel=M('user')->where('uid='.$list[$key]['u_id'])->limit(1)->select();
			$list[$key]['active_id']=$active_name[0]['ac_title'];
			$list[$key]['u_id']=$usermodel[0]['nick_name'];
        }
        $this -> assign('list',$list);
		//var_dump($list);exit;
		$this -> assign('count',$count);
        $this -> display();
    }

	public function message_add()
	{
		if($_SERVER['REQUEST_METHOD']=="GET")
		{
			$list=M('active')->field('ac_id,ac_title')->select();
			$this->assign('list',$list);
			$this -> display();
		}
		else{
			$u_id=$_POST['u_id'];
			$count=M('user')->where('uid='.$u_id)->count();
			if($count==0)
			{
				$this->error('该接收人不存在，请重新输入');
				die;
			}
			$data['ms_type']=(int)$_POST['ms_type'];
			$data['u_id']=$u_id;
			$data['ms_title']=$_POST['title'];
			$data['title']=$_POST['title'];
			$data['content']=$_POST['content'];
			$res = M('msg') ->add($data);
			if($res){
				$this -> success('添加成功', U('Index/message_list'),1);
				die;
			}else{
				$this -> error('添加失败', U('Index/message_list'),1);
				die;
			}
		}
	}
    
    public function message_delete(){
        $id=(int)$_GET['id'];
		$count=M('msg')->where('id='.$id)->delete();
		if($count>0)
		{
			$this -> success('删除成功', U('Index/message_list'),1);
		}
		else{
			$this -> success('删除失败', U('Index/message_list'),1);
		}
    }
	
	public function message_update(){
		if($_SERVER['REQUEST_METHOD']=="GET")
		{
			$ac_id=isset($_GET['id'])?$_GET['id']:0;
			$model=M('msg')->where('id='.$ac_id)->limit(1)->select();
			$this->assign('type',$model[0]['ms_type']);
			$this->assign('model',$model[0]);
			$this -> display();
		}
		else{
			
			$filter['id']=(int)$_POST['id'];
			$count=M('user')->where('uid='.$_POST['u_id'])->count();
			if($count==0)
			{
				$this->error('该接收人不存在，请重新输入');
				die;
			}
			$data['ms_type']=(int)$_POST['ms_type'];
			$data['u_id']=$_POST['u_id'];
			$data['ms_title']=$_POST['title'];
			$data['title']=$_POST['title'];
			$data['content']=$_POST['content'];
            $model=M('msg')->where($filter)->save($data);
			if($model>0)
			{
				$this -> success('修改成功', U('Index/message_list'),1);
			}
			else{
				$this -> success('修改失败', U('Index/message_list'),1);
			}
		}
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
            $data['right']=I('right');
            $data['service']=I('service');
            $data['email'] = I('email');
            $path2 = $this -> upload('About','wechat',flase);
            $data['wechat_img'] = $path2;
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

    public function about_update(){
    	if($_SERVER['REQUEST_METHOD']=="GET")
    	{
    		$ac_id=isset($_GET['id'])?$_GET['id']:0;
    		$model=M('about')->where('id='.$ac_id)->limit(1)->select();
    		$this->assign('model',$model[0]);
    		$this -> display();
    	}
    	else{
    			
    		$filter['id']=(int)$_POST['id'];
    		$data['title'] = I('title');
            $data['content'] = I('content');
            $data['phone'] = I('phone');
            $data['qq'] = I('qq');
            $data['right']=I('right');
            $data['service']=I('service');
            $data['email'] = I('email');
            $path2 = $this -> upload('About','wechat',flase);
            $data['wechat_img'] = $path2;
    		$model=M('about')->where($filter)->save($data);
    		if($model>0)
    		{
    			$this -> success('修改成功', U('Index/about_list'),1);
    		}
    		else{
    			$this -> success('修改失败', U('Index/about_list'),1);
    		}
    	}
    }
    
    /*关于删除*/
    public function about_delete()
    {
    	$id=(int)$_GET['id'];
    	$count=M('about')->where('id='.$id)->delete();
    	if($count>0)
    	{
    		$this -> success('删除成功', U('Index/about_list'),1);
    	}
    	else{
    		$this -> success('删除失败', U('Index/about_list'),1);
    	}
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

    public function comment_list(){
		
        $list = M('comment') -> select();
		$count=M('comment')->count();
        $this -> assign('count',$count);
		foreach($list as $key=>$val){
            $list[$key]['uid'] = M('user') -> where('uid='.$val['uid']) -> getField('nick_name');
			$list[$key]['ac_id'] = M('active') -> where('ac_id='.$val['ac_id']) -> getField('ac_title');
        }
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
