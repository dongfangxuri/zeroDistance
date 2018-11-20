<?php
namespace Admin\Controller;

class LeaMsgController extends AdminBaseController {

	    public function index(){
			$this -> assign('username',session('username'));
			$this -> display();
        }
		
        /*留言列表*/
	    public function leamsg_list(){
			$list = M('leavemsg') -> select();
			$count=M('leavemsg')->count();
			$this -> assign('count',$count);
			foreach($list as $key=>$val){
				$list[$key]['uid'] = M('user') -> where('uid='.$val['uid']) -> getField('nick_name');
				$list[$key]['ac_id'] = M('active') -> where('ac_id='.$val['ac_id']) -> getField('ac_title');
			}
			foreach ($list as $key=>$val)
			{
				$list[$key]['addTime']=date('y-m-d h:m:s',$list[$key]['addTime']);
			}
			$this -> assign('list',$list);
			$this -> display();
        }
		
        /*添加留言*/
		public function leamsg_add()
		{
			if($_SERVER['REQUEST_METHOD']=="GET")
			{
				$list=M('active')->field('ac_id,ac_title')->select();
			    $this->assign('list',$list);
				$user=M('user')->field('uid,nick_name')->select();
			    $this->assign('user',$user);
				$this->display();
			}
			else
			{
				$data['uid']=$_POST['uid'];
				$data['ac_id']=$_POST['ac_id'];
				$data['content']=$_POST['content'];
				$count=M('comment')->add($data);
				if($count){
				    $this -> success('添加成功', U('LeaMsg/leamsg_list'),1);
				    die;
				}else{
					$this -> success('添加失败', U('LeaMsg/leamsg_list'),1);
					die;
				}
			}
		}
		
		/*批量删除*/
		public function leamsg_deleteall()
		{
			$ids=$_POST['ids'];
			if(count($ids)==0)
			{
				$this->error('请选择要删除的数据');die;
			}
			foreach($ids as $key=>$val)
			{
				$data['id'] = $ids[$key];
                M('leavemsg') -> where($data) -> delete();
			}
			$this -> success('活动留言批量删除成功', U('LeaMsg/leamsg_list'),1);
		}
		
		/*删除留言*/
		public function leamsg_del(){
			$data['id'] = I('id');
			$res = M('leavemsg') -> where($data) -> delete();
			if($res){
				$this -> success('活动留言删除成功', U('LeaMsg/leamsg_list'),1);
				die;
			}else{
				$this -> error('活动留言删除失败', U('LeaMsg/leamsg_list'),1);
				die;
			}
		}
		
		/*回复留言*/
		public function leamsg_update(){
			if($_SERVER['REQUEST_METHOD']=="GET")
			{
				$id=isset($_GET['id'])?$_GET['id']:0;
				$this->assign('id',$id);
				$model=M('leavemsg')->where('id='.$id)->find();
				$title=M('active')->where('ac_id='.$model['ac_id'])->field('ac_title')->find();
				$this->assign('title',$title['ac_title']);
				$user=M('user')->where('uid='.$model['uid'])->field('nick_name')->find();
				$this->assign('nick_name',$user['nick_name']);
				$this -> display();
			}
			else{
				$filter['id']=(int)$_POST['id'];
				$data['response']=$_POST['content'];
				$data['is_response']=1;
				$data['responsetime']=time();
	            $model=M('leavemsg')->where($filter)->save($data);
				if($model>0)
				{
					
					$model=M('leavemsg')->where('id='.(int)$_POST['id'])->find();
					$filter2['u_id']=$model['uid'];
					$filter2['active_id']=$model['ac_id'];
					$count=M('msg')->where($filter2)->count();
					if($count)
					{
						$data1['content']=$_POST['content'];
						$data1['is_read']=0;
						$data1['addTime']=time();
						$res=M('msg')->where($filter2)->save($data1);
						if($res)
						{
							$this -> success('回复成功', U('LeaMsg/leamsg_list'),1);
						}
						else
						{
							$this -> success('回复失败', U('LeaMsg/leamsg_list'),1);
						}
					}
					else{
						$data1['u_id']=$model['uid'];
						$data1['ms_type']=1;
						$data1['active_id']=$model['ac_id'];
						$data1['ms_title']='留言回复';
						$data1['title']='留言回复';
						$data1['addTime']=time();
						$data1['content']=$_POST['content'];
						$res=M('msg')->add($data1);
						if($res){
						    $this -> success('回复成功', U('LeaMsg/leamsg_list'),1);
						}
						else{
							$this -> success('回复失败', U('LeaMsg/leamsg_list'),1);
						}
				    }	
			    }
            }
		}
 
}
