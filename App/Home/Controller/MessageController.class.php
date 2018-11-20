<?php
namespace Home\Controller;
class MessageController extends HomeBaseController {
    
	/*首页*/
	public function index(){
        $uid=session('user_id');
        $m = M('msg');
        $where = 'u_id='.$uid." and is_read=0";
        $count = $m->where($where)->count();
        $p = getpage($count,5);
        $list = $m->field(true)->where($where)->order('addTime desc')->limit($p->firstRow, $p->listRows)->select();
        //$list=$this->getActiveinfo($list);
        $this->assign('list', $list); // 赋值数据集
        $this->assign('page', $p->show()); // 赋值分页输出
        $this -> assign('msg_count',$count);
        $this -> display();
    }

    /*消息详情页*/
    public function message_detail(){

        $data['id'] = I('id');
        $sys_info = M('msg') -> where($data)-> find();
		$sys_info['addTime']=date('Y-m-d h:m:s',$sys_info['addTime']);
        $data1['is_read']=1;
        M('msg')->where($data)->save($data1);
        $this -> assign('vo',$sys_info);
        $this -> display();
    }

}