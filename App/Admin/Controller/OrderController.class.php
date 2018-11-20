<?php
namespace Admin\Controller;

class OrderController extends AdminBaseController {

    public function order_list(){
	  
	  if(isset($_POST['order_sn']))
		{			
			$order_sn=$_POST['order_sn'];
			$filter="order_sn like '%$order_sn%'";
			$list = M('order')->where($filter) -> select();
			$count = M('order')->where($filter) -> count();
		}
	  else{
          $list = M('order') -> select();
		  $count = M('order') -> count();
		}
 	    foreach($list as $key=>$val){ //0 待付款 1 未出行订单 2 待评价 3 已完成 4 订单取消
			if($list[$key]['status']==0) 
			{
			   $list[$key]['status']="待付款";
			   $list[$key]['pay_time']="NAN";
			}
			else if($list[$key]['status']==1) 
			{
			   $list[$key]['status']="未出行";
			   $list[$key]['pay_time']=date('Y-m-d H:m:s',$list[$key]['pay_time']);
			}
			else if($list[$key]['status']==2) 
			{
			   $list[$key]['status']="待评价";
			   $list[$key]['pay_time']=date('Y-m-d H:m:s',$list[$key]['pay_time']);
			}
		    else if($list[$key]['status']==3) 
			{
			   $list[$key]['status']="已完成";
			   $list[$key]['pay_time']=date('Y-m-d H:m:s',$list[$key]['pay_time']);
			}
			else if($list[$key]['status']==4) 
			{
			   $list[$key]['status']="订单取消";
			}
			if((int)$list[$key]['star_amount']<=0)
			{
				$list[$key]['star_amount']=0;
			}
        } 
		$this->assign('list',$list);
		$this->assign('count',$count);
		$this->display(); 
    }

	public function order_detail()
	{
		$order_sn=$_GET['order_sn'];
		$model=M('order')->where("order_sn='".$order_sn."'")->limit(1)->select();
		if($model[0]['status']==0) 
			{
			   $model[0]['status']="待付款";
			   $model[0]['pay_time']="NAN";
			   $model[0]['pay_type']="NAN";
			}
		else if($model[0]['status']==1) 
			{
			   $model[0]['status']="未出行";
			}
		else if($model[0]['status']==2) 
			{
			   $model[0]['status']="待评价";
			}
		else if($model[0]['status']==3) 
			{
			   $model[0]['status']="已完成";
			}
		else if($model[0]['status']==4) 
			{
			   $model[0]['status']="订单取消";
		}
		if($model[0]['pay_type']==0) 
		{
			$model[0]['pay_type']="微信支付";
		}
		else if($model[0]['pay_type']==1) 
		{
			$model[0]['pay_type']="支付宝支付";
		}
		else if($model[0]['pay_type']==2) 
		{
			$model[0]['pay_type']="银联支付";
		}
		$this->assign("model",$model[0]);
		$this->display();
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
            //$path = $this -> upload('Order','pic',true);
            //$data['pic'] = $path['sm_img'];
            $res = M('simulation') -> add($data);
            if($res){
                $this -> success('添加成功', U('Order/order_list'),1);
                die;
            }else{
                $this -> success('添加失败，请重新添加', U('Order/order_add'),1);
                die;
            }
        }
        $this -> display();
    }

	public function order_del()
	{
		if(isset($_GET['order_id']))
		{
			$order_id=$_GET['order_id'];
			$filter['oid']=$order_id;
			$count=M('Order')->where($filter)->delete();
			if($count>0)
			{
				$this->success('删除成功',U('Order/order_list'),1);
			}
			else{
				$this->error('删除失败',U('Order/order_list'),1);
			}
		}
		else{
			$this->error('请先选择要删除的订单',U('Order/order_list'),1);
		}
	}
	
    public function index(){
        $this -> assign('username',session('username'));
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
