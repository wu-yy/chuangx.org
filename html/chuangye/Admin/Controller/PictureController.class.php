<?php
namespace Admin\Controller;
use Think\Controller;

class PictureController extends CommonController {
      public function index(){

		  //干货，轮播，导师各取6个
		  //干货
	        $drysalterylist=M("drysaltery")->order("ordernum desc,createtime desc")->select();	  
		  //轮播
		  $pictureslist=M("pictures")->limit(6)->order("ordernum asc,createtime desc")->select();	  
		  //导师
		  $tutorlists=M("teacher")->where(array('istutor'=>1))->limit(6)->order("createtime desc")->select();	
		  //活动
		  $huodong=M('new_activity')->where('is_delect != 1')->order('id desc')->select();
		  
		  
		  $this->assign('drysalterylist',$drysalterylist); 
		  $this->assign('huodong',$huodong);
		  $this->assign('pictureslist',$pictureslist);  
		  $this->assign('tutorlists',$tutorlists); 

		  $this->display();
		  }

	//添加轮播
		public function addpictures(){
		   if($_POST){
			   set_time_limit(0);  
			  if($_FILES){
		     $upload = new \Think\Upload();// 实例化上传类
     $upload->exts      =     array('jpg', 'png', 'gif','jpeg');// 设置附件上传类型
    $upload->rootPath  =     'Uploads/'; // 设置附件上传根目录
    $upload->savePath  =     'picture/'; // 设置附件上传（子）目录
    $upload->subName   =   array('date','Ymd');
    $info   =   $upload->upload();
	  $file_name=$info['picurl']['savepath'].$info['picurl']['savename'];
                    $save_name=$info['picurl']['savename'];
                if (!$info) {
                    $this->error($upload->getError());
                } else {
				}
			  }else{
				  $this->error("请上传图片");
				  }
		$add=array(
		'picurl'=> $file_name,
		'title'=>I('title'),
		'url'=>I('url'),
		'ordernum'=>I('ordernum'),
		'createtime'=>date("Y-m-d H:i:s")
		);		  
		$res=M("pictures")->add($add);
		if($res==true){
			$this->success("添加成功",U('index'));
			}else{
				$this->error("添加失败");
				}
		  }else{
			  $orders=M("pictures")->max('ordernum');
			  $this->assign('ordernum',$orders+1);
			 $this->display();	   
	           			   
			}	
		}
	
	
	//添加干货
		public function adddrysaltery(){
		   if($_POST){
			   set_time_limit(0);  
			  if($_FILES){
		     $upload = new \Think\Upload();// 实例化上传类
     $upload->exts      =     array('jpg', 'png', 'gif','jpeg');// 设置附件上传类型
    $upload->rootPath  =     'Uploads/'; // 设置附件上传根目录
    $upload->savePath  =     'picture/'; // 设置附件上传（子）目录
    $upload->subName   =   array('date','Ymd');
    $info   =   $upload->upload();
	  $file_name=$info['picurl']['savepath'].$info['picurl']['savename'];
                    $save_name=$info['picurl']['savename'];
                if (!$info) {
                    $this->error($upload->getError());
                } else {
				}
			  }else{
				 /*  $this->error("请上传图片"); */
				  }
		$add=array(
		/* 'picurl'=> $file_name, */
		'title'=>I('title'),
		'url'=>I('url'),
		'ordernum'=>I('ordernum'),
		'createtime'=>date("Y-m-d H:i:s"),
		'isnav'=>I('isnav')
		);		  
		$res=M("drysaltery")->add($add);
		if($res==true){
			$this->success("添加成功",U('index'));
			}else{
				$this->error("添加失败");
				}
		  }else{
			  $orders=M("drysaltery")->max('ordernum');
			  $this->assign('ordernum',$orders+1);
			 $this->display();	   
	           			   
			}	
		}
	
	//添加导师
	public function addtutor(){
		if($_POST){
			  set_time_limit(0);  
			  if($_FILES){
		     $upload = new \Think\Upload();// 实例化上传类
     $upload->exts      =     array('jpg', 'png', 'gif','jpeg');// 设置附件上传类型
    $upload->rootPath  =     'Uploads/'; // 设置附件上传根目录
    $upload->savePath  =     'picture/'; // 设置附件上传（子）目录
    $upload->subName   =   array('date','Ymd');
    $info   =   $upload->upload();
	  $file_name=$info['picurl']['savepath'].$info['picurl']['savename'];
                    $save_name=$info['picurl']['savename'];
                if (!$info) {
                    $this->error($upload->getError());
                } else {
				}
			  }else{
				  $this->error("请上传图片");
				  }
				$add=array(
		'image'=> $file_name,
		'name'=>I('name'),
		'job'=>I('job'),
		'firm'=>I('firm'),
		'istutor'=>I('istutor')
		);		  
		$res=M("teacher")->add($add);
		if($res==true){
			$this->success("添加成功",U('index'));
			}else{
				$this->error("添加失败");
				}  
			}else{
				
				$this->display();
				}
		}
		
		
		
		public function editpictures(){
			if($_POST){
				$id=I("id");
				if($_FILES['picurl']['name']!=""){
		     $upload = new \Think\Upload();// 实例化上传类
     $upload->exts      =     array('jpg', 'png', 'gif','jpeg');// 设置附件上传类型
    $upload->rootPath  =     'Uploads/'; // 设置附件上传根目录
    $upload->savePath  =     'picture/'; // 设置附件上传（子）目录
    $upload->subName   =   array('date','Ymd');
    $info   =   $upload->upload();
	  $file_name=$info['picurl']['savepath'].$info['picurl']['savename'];
                    $save_name=$info['picurl']['savename'];
                if (!$info) {
                   $this->error($upload->getError());
                } else {
				}
			  }else{
				 $file_name=I('olurl');
				 }
				 $edit=array(
				 'picurl'=>$file_name,
				 'title'=>I('title'),
				 'url'=>I('url'),
				 'ordernum'=>I('ordernum')
				 );
				$res=M("pictures")->where(array('id'=>$id))->save($edit);
		if($res==true){
			$this->success("修改成功",U('index'));
			}else{
				$this->error("修改失败");
		
				  }
			}else{
				$id=I("id");
				if(empty($id)){
					$this->error('错误操作');
					}else{
				$data=M("pictures")->where(array('id'=>$id))->find();
				$this->assign('data',$data);
				$this->display();
				}
				}
			
			}
			
			
			
			public function editdrysaltery(){
		   if($_POST){
			 $id=I("id");
				if($_FILES['picurl']['name']!=""){
		     $upload = new \Think\Upload();// 实例化上传类
     $upload->exts      =     array('jpg', 'png', 'gif','jpeg');// 设置附件上传类型
    $upload->rootPath  =     'Uploads/'; // 设置附件上传根目录
    $upload->savePath  =     'picture/'; // 设置附件上传（子）目录
    $upload->subName   =   array('date','Ymd');
    $info   =   $upload->upload();
	  $file_name=$info['picurl']['savepath'].$info['picurl']['savename'];
                    $save_name=$info['picurl']['savename'];
                if (!$info) {
                    $this->error($upload->getError());
                } else {
				}
			  }else{
				 $file_name=I('olurl');
				 }
				 $edit=array(
				 /* 'picurl'=>$file_name, */
				 'title'=>I('title'),
				 'url'=>I('url'),
				 'ordernum'=>I('ordernum')
				 );
				$res=M("drysaltery")->where(array('id'=>$id))->save($edit);
		if($res==true){
			$this->success("修改成功",U('index'));
			}else{
				$this->error("修改失败");
		
				  }
		  }else{
			 $id=I("id");
				if(empty($id)){
					$this->error('错误操作');
					}else{
				$data=M("drysaltery")->where(array('id'=>$id))->find();
				$this->assign('data',$data);
			 $this->display();	   
	           			   
			}	
		}
			}
			
			
			
/* 				public function edittutor(){
		   if($_POST){
			 $id=I("id");
				if($_FILES['picurl']['name']!=""){
		     $upload = new \Think\Upload();// 实例化上传类
     $upload->exts      =     array('jpg', 'png', 'gif','jpeg');// 设置附件上传类型
    $upload->rootPath  =     'Uploads/'; // 设置附件上传根目录
    $upload->savePath  =     'picture/'; // 设置附件上传（子）目录
    $upload->subName   =   array('date','Ymd');
    $info   =   $upload->upload();
	  $file_name=$info['picurl']['savepath'].$info['picurl']['savename'];
                    $save_name=$info['picurl']['savename'];
                if (!$info) {
                    $this->error($upload->getError());
                } else {
				}
			  }else{
				 $file_name=I('olurl');
				 }
				 $edit=array(
				 'picurl'=>$file_name,
				'name'=>I('name'),
		'job'=>I('job'),
		'firm'=>I('firm'),
		'istutor'=>I('istutor')
				 );
				$res=M("teacher")->where(array('id'=>$id))->save($edit);
		if($res==true){
			$this->success("修改成功",U('index'));
			}else{
				$this->error("修改失败");
		
				  }
		  }else{
			 $id=I("id");
				if(empty($id)){
					$this->error('错误操作');
					}else{
				$data=M("tutors")->where(array('id'=>$id))->find();
				$this->assign('data',$data);
			 $this->display();	   
	           			   
			}	
		}
			} */
		
		public function deltutor(){
			 $id=I("id");
				if(empty($id)){
					$this->error('错误操作');
					}else{
					    $data['is_delect']=1;
				$res=M("new_activity")->where("id=$id")->save($data);
			if($res==true){
			$this->success("删除成功");
			}else{
				$this->error("删除失败");
		
				  }
	           			   
			}	
			}
			

			
			public function deldrysaltery(){
			 $id=I("id");
				if(empty($id)){
					$this->error('错误操作');
					}else{
				$res=M("drysaltery")->where(array('id'=>$id))->delete();
			if($res==true){
			$this->success("删除成功");
			}else{
				$this->error("删除失败");
		
				  }
	           			   
			}	
			}
			
			
			public function delpictures(){
			 $id=I("id");
				if(empty($id)){
					$this->error('错误操作');
					}else{
				$res=M("pictures")->where(array('id'=>$id))->delete();
			if($res==true){
			$this->success("删除成功");
			}else{
				$this->error("删除失败");
		
				  }
	           			   
			}	
			}
			//添加活动
			function huodong()
			{
			    $data['name']=I('name');
			    
			    $data['url']= I('url');
			    
			    $photo=$_FILES['picurl'] ;
			    
			    $data['img']= $this->getphoto($photo);
			    
			    $data['time']=time();
			    
			    $data['is_delect']=0;
			    
			    $list=M('new_activity')->add($data);
			    
			    if(!empty($list))
			        $this->success("添加成功");
			    else 
			        $this->error("添加失败"); 
			    
			    
			}
			//修改活动
			function savehuodong()
			{
			    header("Content-Type:text/html;charset=UTF-8");
			    $id=I('id');
			    
			    if(!empty($_POST['name']))
			         $data['name']=I('name');
			    if(!empty($_POST['url']))
			        $data['url']=I('url');
			    if(!empty($_FILES['picurl']['name']))
			        $data['img']= $this->getphoto($_FILES['picurl']);
			    if(empty($data))
			        $this->error('没有更改的内容');
			    else 
			        $list=M('new_activity')->where("id=$id")->save($data);
			    if(empty($list))
			         $this->error('修改失败');
			    else 
			        $this->success('修改成功',U('Picture/index'));
			}
			public function edittutor(){
			    
			    $id=I('id');
			    
			    $huodong=M('new_activity')->where("id=$id and is_delect != 1")->order('id desc')->select();
			    
			    $this->assign('huodong',$huodong);
			    
			    $this->assign('id',$id);
			    
			    $this->display();
			}
			/*
			 *
			 *  上传资讯图片
			 *
			 *  */
			function getphoto($photo)
			{
			    header("Content-Type:text/html;charset=UTF-8");  // 解决乱码问题
			    $upload = new \Think\Upload();// 实例化上传类
			    $upload->maxSize   =     3145728 ;// 设置附件上传大小
			    $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
			    $upload->rootPath  =     './Uploads/information/'; // 设置附件上传根目录
			    $upload->saveName  = time().'_'.mt_rand(10,99);
			    $upload->autoSub = false;
			    // 上传文件
			    $info   =   $upload->uploadOne($photo);
			    if(!$info) {// 上传错误提示错误信息
			        return ;
			    }else{// 上传成功
			        return  $image='./Uploads/information/'.$info['savename'];
			    }
			}
			
            
            
            
}
?>