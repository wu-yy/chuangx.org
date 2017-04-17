<?php
namespace Admin\Controller;
use Think\Controller;

class TeacherController extends CommonController {
    public function teacherlist(){
        $sql="1=1";
        if($_POST){
            $username=I('name');
            if($username!=''){
                $sql="name like '$username%'";
            }
        }
        	
        $count=M("teacher")->where($sql)->count();
        $Page       = new \Think\Page($count,15);
        $show       = $Page->show();// 分页显示输出
        $data=M("teacher")->where($sql)->limit($Page->firstRow.','.$Page->listRows)->order("createtime desc")->select();
    
        $this->assign('data',$data);
        //print_r($data);
        $this->assign('page',$show);
        $this->display();
    
    }
    public function addteacher(){
        if($_POST){
            //print_r($_POST);
            if($_FILES){
                $upload = new \Think\Upload();// 实例化上传类
                $upload->exts      =     array('jpg', 'png', 'gif','jpeg');// 设置附件上传类型
                $upload->rootPath  =     'Uploads/'; // 设置附件上传根目录
                $upload->savePath  =     'headteacher/'; // 设置附件上传（子）目录
                $upload->subName   =   array('date','Ymd');
                $info   =   $upload->upload();
                $file_name='/Uploads/'.$info['picurl']['savepath'].$info['picurl']['savename'];
                $save_name=$info['picurl']['savename'];
                if (!$info) {
                    $this->error($upload->getError());
                } else {
                }
            }else{
                $this->error("请上传图片");
            }
            
            $brief=I('brief');
            
            $brief=str_replace(array("\r\n", "\r", "\n"), "<br />", $brief);
            
            $brief=str_replace(array(" "), "&nbsp", $brief);

            $body=stripslashes($_POST['body']);
            
            $body=str_replace(array("\r\n", "\r", "\n"), "<br />", $body);
            
            $body=str_replace('\'','"',$body);
            
            $add=array(
                'image'=> $file_name,
                'name'=>I('name'),
                'job'=>I('job'),
                //'firm'=>I('firm'),
                'brief'=>$brief,
                'istutor'=>I('istutor'),
                'body'=>$body,
            );
            $res=M("teacher")->add($add);
            if($res==true){
                $this->success("添加成功",U('teacherlist'));
            }else{
                $this->error("添加失败");
            }
            	
            	
            	
        }else{
            $this->display();
        }
    
    }
    public function editteacher(){
        if($_POST){
            $id=I("id");
            if($_FILES['picurl']['name']!=""){
                $upload = new \Think\Upload();// 实例化上传类
                $upload->exts      =     array('jpg', 'png', 'gif','jpeg');// 设置附件上传类型
                $upload->rootPath  =     'Uploads/'; // 设置附件上传根目录
                $upload->savePath  =     'picture/'; // 设置附件上传（子）目录
                $upload->subName   =   array('date','Ymd');
                $info   =   $upload->upload();
                $file_name='/Uploads/'.$info['picurl']['savepath'].$info['picurl']['savename'];
                $save_name=$info['picurl']['savename'];
                if (!$info) {
                    $this->error($upload->getError());
                } else {
                }
            }else{
                $file_name=I('olurl');
            }
            
            $brief=I('brief');
            
            $brief=str_replace(array("\r\n", "\r", "\n"), "<br />", $brief);
            
            $brief=str_replace(array(" "), "&nbsp", $brief);
            
            $body=stripslashes($_POST['body']);
            
            $body=str_replace(array("\r\n", "\r", "\n"), "<br />", $body);
            
            $body=str_replace('\'','"',$body);
            
            $edit=array(
                'picurl'=>$file_name,
                'name'=>I('name'),
                'job'=>I('job'),
                //'firm'=>I('firm'),
                'body'=>$body,
                'brief'=>$brief,
                'istutor'=>I('istutor')
            );
            $res=M("teacher")->where(array('id'=>$id))->save($edit);
            if($res==true){
                $this->success("修改成功",U('teacherlist'));
            }else{
                $this->error("修改失败");
    
            }
        }else{
            $id=I("id");
            if(empty($id)){
                $this->error('错误操作');
            }else{
                $data=M("teacher")->where(array('id'=>$id))->find();
                $data['body']=str_replace(array("\r\n", "\r", "\n"), "<br />", $data['body']);
                $data['body']=str_replace('\'','"',$data['body']);
                $this->assign('data',$data);
                $this->display();
    
            }
        }
    }
    public function delteacher(){
        $id=I("id");
        if(empty($id)){
            $this->error('错误操作');
        }else{
            $image=M("teacher")->where(array('id'=>$id))->getfield('image');
            //删除图片
            unlink($image);
            $res=M("teacher")->where(array('id'=>$id))->delete();
            if($res==true){
                $this->success("删除成功");
            }else{
                $this->error("删除失败");
    
            }
    
        }
    }

}
?>