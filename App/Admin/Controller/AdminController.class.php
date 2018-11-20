<?php
namespace Admin\Controller;

class AdminController extends AdminBaseController {

	public function admin_list()
	{
		if(isset($_POST['name']))
		{
			$name=$_POST['name'];
			$sql.="username like '%$name%'";
			$list = M('admin')->where($sql) ->select();
			$count = M('admin')->where($sql) -> count();
		}
		else{
            $count=M('admin')->where($sql)->count();
		    $list=M('admin')->where($sql)->select();
		}
		foreach($list as $key=>$val)
		{
		  $temp=M('admin_role')->where('id='.$list[$key]['roleid'])->limit(1)->select();
		  $list[$key]['roleid']=$temp[0]['role_name'];
		}
		$this->assign('list',$list);
		$this->assign('count',$count);
		$this->display();
	}
   
    public function admin_add()
	{
		if($_SERVER['REQUEST_METHOD']=="GET")
		{	
			$sql="parentid!=0 and state=1";
			$citylist=M('area')->where($sql)->select();
			$list=M('admin_role')->select();
			$this->assign('list',$list);
			$this->assign('citylist',$citylist);
			$this->display();
		}
		else{
			$data['username']=$_POST['username'];
			$data['realname']=$_POST['realname'];
			$data['phone']=$_POST['phone'];
			$data['password']=$_POST['password'];
			$repassword=$_POST['repassword'];
			if($repassword!=$_POST['password'])
			{
				$this->error('两次密码不一致');
			}
			$data['city_string'] = implode(',',$_POST['city_id']);
			$data['roleid']=$_POST['roleid'];
			$data['eamil']=$_POST['email'];
			$count=M('admin')->add($data);
			if($count>0)
			{
				$this -> success('管理员添加成功', U('Admin/admin_list'),1);
                die;
			}
			else{
				$this -> success('管理员添加失败', U('Admin/admin_list'),1);
                die;
			}
		}
	}
   
    public function admin_del(){
        if(isset($_GET['id']))
		{
            $data['userid'] = $_GET['id'];
            $res = M('admin') -> where($data) -> delete();
            if($res){
                $this -> success('删除成功', U('Admin/admin_list'),1);
                die;
            }else{
                $this -> error('删除失败', U('Admin/admin_list'),1);
                die;
            }
        }
		else{
			$this -> error('删除失败,请选择具体的管理员!', U('Admin/admin_list'),1);
		}
    }
    
	public function admin_role_list()
	{ 
		$list=M('admin_role')->select();
		$count=M('admin_role')->count();
		$this->assign('list',$list);
		$this->assign('count',$count);
		$this->display();
	}
	
	public function admin_role_add()
	{
		if($_SERVER['REQUEST_METHOD']=="GET")
		{	
			$this->display();
		}
		else{
			
		}
	}
	
	public function welcome(){
        $this -> display();
    }
}
