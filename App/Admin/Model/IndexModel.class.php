<?php
namespace Admin\Model;
use Think\Model;

class IndexModel extends Model
{

    public function upload($path,$is_small)
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
                $image->open($upload->rootPath . $info['photo']['savepath'] . $info['photo']['savename']);
                //将图片裁剪为400x400并保存为corp.jpg
                $image->thumb(150, 150)->save($upload->rootPath . $info['photo']['savepath'] . 'sm_' . $info['photo']['savename']);

                $arr['sm_img'] = 'Uploads/' . $info['photo']['savepath'] . 'sm_' . $info['photo']['savename'];

            }
            $arr['bg_img'] = 'Uploads/' . $info['photo']['savepath'] . $info['photo']['savename'];

            return $arr;
        }
    }












}

?>