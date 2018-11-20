<?php
namespace Admin\Controller;

class CommentController extends AdminBaseController {

	    public function index(){
			$this -> assign('username',session('username'));
			$this -> display();
        }
		
        /*订单评论列表*/
	    public function comment_list(){
			$list = M('comment') -> select();
			$count=M('comment')->count();
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
		
        /*订单评论添加*/
		public function comment_add()
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
				    $this -> success('添加成功', U('Comment/comment_list'),1);
				    die;
				}else{
					$this -> success('添加失败', U('Comment/comment_list'),1);
					die;
				}
			}
		}
		
		/*批量删除*/
		public function comment_deleteall()
		{
			$ids=$_POST['ids'];var_dump($ids);exit;
			if(count($ids)==0)
			{
				$this->error('请选择要删除的数据');die;
			}
			foreach($ids as $key=>$val)
			{
				$data['id'] = $ids[$key];
                M('comment') -> where($data) -> delete();
			}
			$this -> success('活动评论批量删除成功', U('Comment/comment_list'),1);
		}
		/*活动评论删除*/
		public function comment_del(){
			$data['id'] = I('id');
			$res = M('comment') -> where($data) -> delete();
			if($res){
				$this -> success('活动评论删除成功', U('Comment/comment_list'),1);
				die;
			}else{
				$this -> error('活动评论删除失败', U('Comment/comment_list'),1);
				die;
			}
		}
		
		/*批量删除*/
		public function groupcomment_del()
		{
			$ids=$_POST['ids'];
			foreach ($ids as $key=>$val)
			{
			   $res=M('comment')->where('id='.$ids[$key])->delete();
			}
		}
		/*活动评论回复*/
		public function comment_update(){
		if($_SERVER['REQUEST_METHOD']=="GET")
		{
			$id=isset($_GET['id'])?$_GET['id']:0;
			$this->assign('id',$id);
			$model=M('comment')->where('id='.$id)->find();
			$this->assign('model',$model);
			$title=M('active')->where('ac_id='.$model['ac_id'])->field('ac_title')->find();
			$this->assign('title',$title['ac_title']);
			$user=M('user')->where('uid='.$model['uid'])->field('nick_name')->find();
			$this->assign('nick_name',$user['nick_name']);
			$this -> display();
		}
		else{
			$filter['id']=(int)$_POST['id'];
			$data['response_content']=$_POST['content'];
			$data['response_time']=time();
			$data['is_response']=1;
            $model=M('comment')->where($filter)->save($data);
			if($model>0)
			{
				$model=M('comment')->where('id='.(int)$_POST['id'])->find();
				$data1['u_id']=$model['uid'];
				$data1['ms_type']=1;
				$data1['active_id']=$model['ac_id'];
				$data1['ms_title']='订单评论回复';
				$data1['title']='订单评论回复';
				$data1['content']=$_POST['content'];
				$data1['addTime']=time();
				$res=M('msg')->add($data1);
				$this -> success('回复成功', U('Comment/comment_list'),1);
			}
			else{
				$this -> success('回复失败', U('Comment/comment_list'),1);
			}
		}
    }
}
