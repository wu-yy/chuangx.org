<?php
namespace Admin\Controller;
use Think\Controller;
class LoginController extends Controller {
    public function index(){
    	$this->display();
    }
	Public function verify() {
		ob_clean();
		$config =    array(
    'fontSize'    =>    20,    // 验证码字体大小
    'length'      =>    4,     // 验证码位数
    'bg'          =>    array(255,255,255),
    'useNoise'    =>    false, // 关闭验证码杂点
);
		$Verify = new \Think\Verify($config);
    $Verify->entry();
	}
	
	
	/**
	 * 表单登录
	 */
	Public function login() {
	
		//if(!IS_POST) halt('页面不存在');

		
		$username = I('username');
		$pwd = I('password', '', 'md5');
		
		
	   $user = M('sysuser') -> where(array('username' => $username)) -> find();
	   
        //$user=$this->portcall->callapi('/front/user/auth','SYS_user',json_encode(array('username' => $username,'pwd'=>$pwd)));
        //print_r($user);exit();

 
		
		// 检查验证码  
		$verify = I('code','');  
		if(!check_verify($verify)){  
			$this->error("亲，验证码输错了哦！");  
		}  
			if($user['islock']) $this->error('用户被锁定');
			if($pwd != $user['password']) $this->error('密码错误');

		$data = array(
			'id' => $user['id'],
			'logintime' => time(),
			'loginip' => get_client_ip()
			);
		M('sysuser') -> save($data);

		session('uid',$user['id']);
		session('username', $user['username']);
		session('issys',  $user['issys']);
//		session('lgoinip', $user['loginip']);
		
		$this->redirect('Index/index');
			}
			
			
			public function logout() {
		session_unset();
		session_destroy();
		
		$this -> redirect('Login/index');

	}
	
	
}
?>