<?php
namespace Home\Controller;
use Think\Controller;
class KidController extends Controller {
    
    public function index(){
		
		$data['uid'] = session('user_id');
        if(!$data['uid']){
            $this -> error('请登录',U('Index/login'),1);
            die;
        }
        if(session()){
            $info['name'] = session('nick_name');
            $info['addr'] = session('user_addr');
            $info['sex'] = session('sex');
        }
		$data['uid'] = session("user_id");
		$kid_list = M("kid_list") -> where($data) -> select();
		foreach($kid_list as $key=>$val){
			
			if(intval($val['sex']) == 1){
				$kid_list[$key]['sex'] = '男';
			}else{
				$kid_list[$key]['sex'] = '女';
			}
		}

        $partake = M('partake') -> field('id,pic_path,title') -> limit(3) -> select();

		$this -> assign('kid_list',$kid_list);
        $this -> assign('user',$info);
        $this -> assign('list',$partake);

        $this -> display();
    }

    /*孩子成长*/
    public function child()
    {
    	$data['uid'] = session('user_id');
    	if(!$data['uid']){
    		$this -> success('请登录',U('Index/login'),1);
    		//echo '<script type="text/javascript"> alert("请登录");window.location.href="Index/login"</script>';
    		die;
    	}
    	$childlist=M('kids')->where($data)->select();
    	foreach ($childlist as $key=>$val)
    	{
    		if($childlist[$key]['sex']==1)
    		{
    			$childlist[$key]['sex']="男";
    		}
    		else if($childlist[$key]['sex']==2){
    			$childlist[$key]['sex']="女";
    		}
    		else {
    			$childlist[$key]['sex']="保密";
    		}
    		//if($childlist[$key]['header_img'])
    	}
    	//$this->assign('header_img',)
    	$this->assign('kidlist',$childlist);
    	$this->display();
    }

    /*孩子成长详情*/
    public function childGrowUp()
    {
    	if($_SERVER['REQUEST_METHOD']=="GET")
    	{
	    	$data['id']=$_GET['id'];
	    	$model=M('kids')->where($data)->find();
	    	if($model['sex'] == 1){
	    		$model['sex'] = '男';
	    	}elseif($model['sex'] == 2){
	    		$model['sex'] = '女';
	    	}else{
	    		$model['sex'] = '保密';
	    	}
	    	$usermodel=M('user')->where('uid='.session('user_id'))->find();
	    	$this->assign('usermodel',$usermodel);
	    	$this->assign('header_img',$model['header_img']);
	    	$this->assign('model',$model);
	    	//$rank=M('badge')->where('id='.$model['rank_id'])->find();
	    	//根据获得徽章个数判断级别
	    	$count=$model['badge_number'];
	    	$badge_name="";
	    	//$badgelist=M('badge')->select();
// 	    	foreach ($badgelist as $key=>$val)
// 	    	{
// 	    		$temp=mb_substr($badgelist[$key]['number'],0,strlen($badgelist[$key]['number'])-2,'utf-8');
// 	    		var_dump($temp);exit;
// 	    		$temparr=explode('-', $temp);
// 	    		var_dump($temparr);exit;
// 	    		if(count($temparr)==1)
// 	    		{
// 	    			$badge_name=$badgelist[$key]['remarks'];
// 	    			break;
// 	    		}
// 	    		else if($count>=(int)$temparr[0]&&$count<=$temparr[1])
// 	    		{
// 	    			$badge_name=$badgelist[$key]['remarks'];
// 	    			break;
// 	    		}
// 	    	}
            if($count>=1 && $count<=7)
            {
            	$badge_name="一级童军";
            	$id=1;
            }
            else if($count>=8 && $count<=15)
            {
            	$badge_name="二级童军";
            	$id=2;
            }
            else if($count>=16 && $count<=22)
            {
            	$badge_name="三级童军";
            	$id=3;
            }
            else if($count>=23 && $count<=29)
            {
            	$badge_name="狮级童军";
            	$id=4;
            }
            else{ 
            	$badge_name="雄狮童军";
                $id=5;
            }
            $rank=M('badge')->where('id='.$id)->find();
	    	$temp=json_decode($rank['pic'],true);
	    	$rank['pic']=$temp['sm_img'];
	    	$this->assign('rank',$rank);
	    	/*成长经历*/
	    	$activelist = M()->table('ze_active as a')->join('ze_active_kids as b on b.ac_id=a.ac_id')->where("b.kid=".$_GET['id']." and is_evalute=1" )->select();	
	    	foreach ($activelist as $key=>$val)
	    	{
	    		if(strlen($activelist[$key]['ac_title'])>10)
	    		{
	    			$activelist[$key]['ac_title']=mb_substr($activelist[$key]['ac_title'], 0,10,'utf-8');
	    		}
	    		$temp=json_decode($activelist[$key]['ac_img'],true);
	    		$activelist[$key]['ac_img']=$temp['bg_img'];
	    	}
	    	$this->assign('activelist',$activelist);
	    	$this->display();
    	}
    	else
    	{
    		/*19号修改*/
    	    if($_FILES['header_img']['name']){
    		  $path = $this -> upload('header','header_img',true);
    		  $data['header_img'] = $path['bg_img'];
    	    }
    		$filter['id']=$_POST['id'];
    		if(!$_POST['childsex'])
    		{
    			$this->error('请输入性别');
    		}
    		if($_POST['childsex']!='男' && $_POST['childsex']!='女')
    		{
    			$this->error('请输入正确的性别');
    		}
    		$data['name']=trim($_POST['childname']);
    		$data['sex']=trim($_POST['childsex'])=='男'?1:2;
    		$data['addr']=trim($_POST['childaddr']);
//     		$path = $this -> upload('header_img','header_img',true);
//     		$temp=json_encode($path);
//     		$data['header_img'] = $temp['bg_img'];
    		$res=M('kids')->where($filter)->save($data);
    		if($res)
    		{
    			$this->success('修改成功');die;
    		}
    		else		
    		{
    			$this->success('修改失败');die;
    		}
    	}
    }
    
    /*了解童子军*/
    public function know()
    {
    	$badgelist=M('badge')->select();
    	foreach ($badgelist as $key=>$val)
    	{
    		$temp=json_decode($badgelist[$key]['pic'],true);
    		$badgelist[$key]['pic']=$temp['sm_img'];
    	}
    	$usermodel=M('user')->where('uid='.session('user_id'))->find();
    	$this->assign('usermodel',$usermodel);
    	$this->assign('list',$badgelist);
    	$this->display();
    }
    
    /*孩子删除*/
    public function kids_dele()
    {
    	$id=$_GET['kid'];
    	$res=M('kids')->where('id='.$id)->delete();
    	if($res)
    	{
    		$this->success('删除成功',U('Min/Index'),1);die;
    	}
    	else
    	{
    		$this->success('删除失败',U('Min/Index'),1);die;
    	}
    }
    
    /*孩子信息修改*/
    public function kids_update(){
		if($_FILES["header_img"]["name"]){				
			$path = $this -> upload('header','header_img',true);
			$data['header_img'] =$path['bg_img'];
		}
		$filter['id']=$_POST['kid'];
        $data['name'] = I('name');
        $data['sex'] = I('sex');
        $data['addr'] = I('addr');
        $res = M('kids') ->where($filter)-> save($data);
        if($res){
            $this -> success('修改成功');
			die;
        }else{
            $this -> success('修改失败');
			die;
        }
    }

	public function info_edit2(){
		if(I("kid_id")){
			session("kid_id",I("kid_id"));
			$data['id'] = I("kid_id");
			$info = M("kid_list") -> where($data) -> find();
			$this -> assign("info",$info);
		}
		if(I('name')){
			if($_FILES["h_img"]["name"]){
				$path = $this -> upload('header','h_img',false);
				$data['header_img'] = $path['bg_img'];				
			}

            $data['name'] = I('name');
            $data['sex'] = I('sex');
            $data['addr'] = I('addr');
            $data['id'] = session('kid_id');
            $res = M('kid_list') -> save($data);
            if($res){
                $this -> success('修改成功',U('Kid/index'),1);
				die;
            }else{
                $this -> success('修改失败',U('Kid/info_edit2'),1);
				die;
            }
        }
		$this -> display();
	}
		
	public function info_add(){
		if(I('name')){
			
			$path = $this -> upload('header','h_img',false);
            $data['header_img'] = $path['bg_img'];
			$data['name'] = I('name');
            $data['sex'] = I('sex');
            $data['addr'] = I('addr');
			$data['uid'] = session("user_id");
			$res = M("kid_list") -> add($data);
			if($res){
				$this -> success('添加成功',U('Kid/index'),1);
				die;
			}else{
				$this -> success('添加失败',U('Kid/info_add'),1);
				die;
			}
		}
		$this -> display();
	}
	
    public function kid_grow(){
        if(I('id')){
            $data['id'] = I('id');
            $res = M('partake') -> where($data) -> find();
            $this -> assign('pk',$res);
        }
        $this -> display();
    }

    public function honor(){
        $this -> display();
    }

    public function upload($path,$file_name,$is_small){

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