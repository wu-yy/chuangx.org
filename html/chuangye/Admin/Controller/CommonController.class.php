<?php
namespace Admin\Controller;
use Think\Controller;
class CommonController extends Controller {
	Public function _initialize() {
		date_default_timezone_set('prc');
		if(!isset($_SESSION['uid'])) {
			$this -> redirect('Login/index');
		}else{
	    //判断权限
		  $this->checkassces($_SESSION['uid'],CONTROLLER_NAME);
		}
	}
	
	//根据控制器名称查看权限
	function checkassces($uid,$appName=APP_NAME){
	   
	   //先判断是否为超级管理员
	  $issys=M('sysuser')->where(array('id'=>$uid))->getfield('issys');
	  if($appName=='Index')
	  {
	      return;
	  }
	  if($issys!=1){  
		$data=M("role_user ru")->join("role_node rn on ru.role_id=rn.role_id")->join("nodes n on rn.node_id=n.id")->where(array('ru.user_id'=>$uid,'n.url'=>array('like',"%".$appName."%")))->find();
        
		if(empty($data['url'])){
			$this->error('该用户没有操作权限');
		}else{
			if($data['status']==0){
				$this->error('该用户角色已被锁定');
				}
			}
	  }
		}
}
?>