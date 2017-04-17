<?php
namespace Admin\Controller;
use Think\Controller;
class SysuserController extends  CommonController {
	/*系统用户列表*/
	public function lists(){
		$sql="1=1";
		if($_POST){
			$username=I('username');
			if($username!=''){
				$sql="username like '$username%'";
				}
			}
			$uid=$_SESSION['uid'];

	$count=M("sysuser s")->join("role_user ru on s.id=ru.user_id")->join("role r on ru.role_id=r.id")->where("s.id!=$uid and $sql")->count();
	$Page       = new \Think\Page($count,15);
$show       = $Page->show();// 分页显示输出
	$data=M("sysuser s")->join("role_user ru on s.id=ru.user_id")->join("role r on ru.role_id=r.id")->where("s.id!=$uid and $sql")->limit($Page->firstRow.','.$Page->listRows)->field("s.*,r.name")->select();
	
	$this->assign('data',$data);
	//print_r($data);
	$this->assign('page',$show);// 赋值分页输出
	$this->display();	
	}
	
	public function addsysuser(){
		if($_POST){
			$username=I('username');
			$num=M("sysuser")->where(array('username'=>$username))->count();
			if($num!=0){
			$this->error('此用户名已被占用');	
			}else{
				$password=md5(I('password'));
				$role_id=I("role_id");
				
				$addarr=array(
				'username'=>$username,
				'password'=>$password,
				'creattime'=>date("Y-m-d H:i:s")
				);
				if($role_id==1){
					$addarr['issys']=1;
					}
				$uid=M("sysuser")->add($addarr);
				if(!empty($uid)){
					$rolearr=array(
					'user_id'=>$uid,
					'role_id'=>$role_id
					);
					$res=M("role_user")->add($rolearr);
					if($res==true){
						$this->success("添加用户成功",u('Sysuser/lists'));
						}else{
							$this->error('添加用户失败');
							}
				}else{
					$this->error('添加用户失败');
					}
				}
			//print_r($_POST);
		}else{
			$rlist=M("role")->where(array('status'=>1))->select();
			//print_r($rlist);
			$this->assign('rlist',$rlist);
			$this->display();
			}
		
		}
	
	
		public function editsysuser(){
		if($_POST){
			$username=I('username');
			$uid=I('uid');
			$num=M("sysuser")->where(array('username'=>$username,'id'=>array('neq',$uid)))->count();
			if($num!=0){
			$this->error('此用户名已被占用');	
			}else{
			    
				 $password=md5($_POST['password']); 
				$role_id=I("role_id");
				if(empty($_POST['password']))
				{
				    $editarr=array(
				        'username'=>$username,
				        'islock'=>I('islock'),
				    );
				}
				else 
				{
				    $editarr=array(
				        'username'=>$username,
				        'password'=>$password,
				        'islock'=>I('islock'),
				    );
				}
				if($role_id==1){
					$editarr['issys']=1;
					}
				M("sysuser")->where(array('id'=>$uid))->save($editarr);
			
					$rolearr=array(
					'role_id'=>$role_id
					);
					$res=M("role_user")->where(array('user_id'=>$uid))->save($rolearr);
					
						$this->success("修改用户成功",u('Sysuser/lists'));
			
				}
			
		}else{
			$id=I('id');
			if(!empty($id)){
			$rlist=M("role")->where(array('status'=>1))->select();
			//print_r($rlist);
			$this->assign('rlist',$rlist);
			$data=M("sysuser s")->join("role_user ru on s.id=ru.user_id")->where("s.id=$id")->field("s.*,ru.role_id")->find();
			//print_r($data);
			$this->assign('data',$data);
			$this->display();
			}else{
				$this->error('错误操作');
				}
		}
		
		}
	
	
	//重置密码
	public function resetpwd(){
			$id=I('id');
			if(!empty($id)){
			$edit=array(
			'password'=>md5('12345678')
			);
			$res=M("sysuser")->where(array('id'=>$id))->save($edit);
			if($res==true){
					$this->success('密码重置成功');
				}else{
					$this->error('密码重置失败');
					
					}
			}else{
				$this->error('错误操作');
				}
		}
	//删除用户
	public function delsysuser(){
	$id=I('id');
			if(!empty($id)){
			
			$res=M("sysuser")->where(array('id'=>$id))->delete();
			M("role_user")->where(array('user_id'=>$id))->delete();
			if($res==true){
					$this->success('删除用户成功');
				}else{
					$this->error('删除用户失败');
					
					}
			}else{
				$this->error('错误操作');
				}	
		}
		
		
		//用户角色
		public function rolelists(){
			$rolelist=M("role")->select();
			$this->assign('rolelist',$rolelist);
            $this->display();
		}


       //添加用户角色
	   public function addrole(){
		   if($_POST){
			   $name=I('name');
			   $nodeids=I('node_id');
			   $adata=M("role")->where(array('name'=>$name))->find();
			   if(empty($adata)){
				   $add=array(
				   'name'=>$name,
				   'status'=>1
				   );
				   $rid=M("role")->add($add);
				   if($rid==true){
					      if(!empty($nodeids)){
							  foreach($nodeids as $val){
								  $adds=array('role_id'=>$rid,'node_id'=>$val);
								  $res=M("role_node")->add($adds);
								  }
								  $this->success("添加角色成功",U('rolelists'));
							  }
					   }else{
						   $this->error("添加角色失败");
						   }
				}else{
				   $this->error("该角色名称已添加");	   
				}
			   }else{
		  $nodelist=$this->nodes();
		  $this->assign('nodelist',$nodelist);
		  $this->display();
			   }
		   }


    //所有权限列表
      function nodes(){
		  $rolelist=M("nodes")->where(array('parentid'=>0,'status'=>1))->select();
		 // echo M("nodes")->getlastsql();
//		  print_r($rolelist);
		 return $rolelist;
		  } 

    //编辑用户角色
	public function editrole(){
		if($_POST){
			$id=I('id');
			  $name=I('name');
			   $nodeids=I('node_id');
			   $adata=M("role")->where(array('name'=>$name,'id'=>"neq $id"))->find();
			   if(empty($adata)){
				   $add=array(
				   'name'=>$name,
				   'status'=>I('status')
				   );
				   $re=M("role")->where(array('id'=>$id))->save($add);
				   //先删掉原来对应的节点再添加新的
				   M("role_node")->where(array('role_id'=>$id))->delete();
				   if(!empty($nodeids)){
					    foreach($nodeids as $val){
								  $earray=array('role_id'=>$id,'node_id'=>$val);
								  $res=M("role_node")->add($earray);
								  }
					   }
					  $this->success("修改成功",U('rolelists'));
			   }
			}else{
		$id=I('id');
		if(empty($id)){
			$this->error('错误操作');
		}else{
		 $data=M("role")->where(array('id'=>$id))->find();
		 if(empty($data)){
			 $this->error("此数据已删除");
			 }else{
			$this->assign('data',$data);
			 $nodelist=$this->nodes();
			 foreach($nodelist as $key=>$val){
				 $num=M("role_node")->where(array('role_id'=>$id,'node_id'=>$val['id']))->count();
				// echo M("role_node")->getlastsql();
				 if($num!=0){
					 $nodelist[$key]['type']=1;
					 }
				 }
		  $this->assign('nodelist',$nodelist);
			$this->display();
				 }	
				}
		}
	}

   //锁定角色
   public function locakrole(){
	   $id=I("id");
	   if(empty($id)){
			$this->error('错误操作');
		}else{
		$edit=array('status'=>0);
		$re=M("role")->where(array('id'=>$id))->save($edit);
		if($re==true){
			$this->success("锁定成功");
			}else{
				$this->error("锁定失败");
				}
		}
	   }
//删除角色
public function delrole(){
	   $id=I("id");
	   if(empty($id)){
			$this->error('错误操作');
		}else{
		//删除该角色下的用户
		M("sysuser")->where("id in (select user_id from role_user where role_id=$id)")->delete();
		//删除用户及角色之间的关系
		M("role_user")->where(array('role_id'=>$id))->delete();
		//删除角色及节点之间的关系
		M("role_node")->where(array('role_id'=>$id))->delete();
		//删除该条角色信息
		M("role")->where(array('id'=>$id))->delete();
		$this->success("删除成功");
		}
	}

}


?>