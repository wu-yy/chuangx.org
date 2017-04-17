<?php
namespace Home\Model;
use Think\Model;
class SysuserModel extends Model{
	//所有角色
	public function allrole(){
		$rlist=M("role")->where(array('status'=>1))->select();
		if(empty($rlist)){
			return false;
		}else{
			return $rlist;
		}
	}
}

?>