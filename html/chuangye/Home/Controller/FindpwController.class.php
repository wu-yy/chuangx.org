<?php 
namespace Home\Controller;
use Think\Controller;
class FindpwController extends Controller {
    
    function _initialize()
    {
        red301();
    }
    
    function  index()
    {
        $this->display();
    }
	/* 
	 * 蔡政
	 * 20151210 
	 * 发送验证码
	 * 输入手机号，发送验证码到用户手机，session中存储验证码 
	 *  */
	function yzm()
	{
	    
	    $name=session('name1');
	    
 	    if(empty($name)){echo 0; return;} 
		
		$word=array(7,8,5,2,1,3,6,0,7,6,9,8,1,2,7,9,2,1,4,5,3,2);
			
		for($a=0;$a<4;$a++)
		{
		$number[$a]=$word[rand(0, 21)];//用随机数取得验证码
		}
			
		$number1=implode($number); //将数组转化成字符串
		
		$_SESSION['nu']=$number1;
		
  		if(sendSms($name,$number1))
  		{
  		    echo "1";
  		} 
  		else 
  		{
  		    echo "0";
  		}
	}
	
	/*
	 *蔡政
	 *20151210
	 *发送邮件
	 *输入用户邮箱，输出 1发送成功，0发送失败
	 *  */
	public function mail(){
	    	
	    header("Content-Type:text/html;charset=UTF-8");  // 解决 POST变量乱码问题
	
	    $mail=session('name1');
	
	    if(empty($mail)){echo 0; return;}
	
	    $word=array(7,8,5,2,1,3,6,0,7,6,9,8,1,2,7,9,2,1,4,5,3,2);
	    	
	    for($a=0;$a<4;$a++)
	    {
	        $number[$a]=$word[rand(0, 21)];//用随机数取得验证码
	}
		
	$number1=implode($number); //将数组转化成字符串
	
	$_SESSION['nu']=$number1;
	
	$title="创业学院网站邮箱注册验证码";
	
	$content="您的注册码为：".$number1."请勿将验证码向他人泄露，如非本人操作，请忽略此邮件";
/* 	
	$mail=$_GET['mail']; */
	
	if(sendMail("$mail","$title","$content"))
	    echo '1';
	else
	    echo '0';
	
	return ;
	
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
    function checkpw($pw,$name)
    {
        
        $code=session('code');
        
        //if(check_verify($pw,$id=''))检查验证码，wenjing,在此加上IP限定，防止批量注册
        if(($pw == 'no need') && check_create_time($_SERVER["REMOTE_ADDR"], time()) && check_login_time($_SERVER["REMOTE_ADDR"], time()))
        {
            echo 1;
            $_SESSION['name']=$name;
            $_SESSION['name1']=$name;
        }
        else
        {
           echo 0; 
        }
        

    }
    function sms()
    {
        
         $name=session('name1');
        
        if(empty($name)){redirect(U('Index/index'));}
        
        $this->assign('name',$name);
        
        
        $this->display();
    }
    function clapw()
    {
        unset($_SESSION['code']);
    }
/*     function tur()
    {
        $tur=$_SESSION['tur']=2;
        
        if($tur)
        {
            echo 1;
        }
        else
        {
            echo 0;
        }
    } */
    function changepw()
    {
         $tur=session('tur');
        
        if(empty($tur)){redirect(U('Index/index'));}
        
        $name=session('name1');
        
        if(empty($name)){redirect(U('Index/index'));} 
        
        $this->display();
    }
    function uppw()
    {
        $tur=session('tur');
        
        if(empty($tur)){redirect(U('Index/index'));}
        
        $name=session('name1');
        
        if(empty($name)){redirect(U('Index/index'));}
        
        $pw=$_GET['pw'];
        
        $pw1=$_GET['pwand'];
        
        if($pw != $pw1){redirect(U('Index/index'));}
        
        $where['useremail']=$name;
        
        $list=M('user')->where($where)->find();
        
        if(empty($list['id']))
        {
            $where1['usermobilenum']=$name;
            $list=M('user')->where($where1)->find();
        }
        
        $id=$list['id'];
        
        $add['password']=md5($pw);
        
        $sa=M('user')->where("id=$id")->save($add);
        
        if(empty($sa))
        {
            echo $sa;
        }
        else 
        {
            $data=array(
              'uid'=>$list['id'],
              'type'=>'password',
              'beforechange'=>$list['password'],
              'afterthechange'=>md5($pw),
              'logtime'=>time(),
              'createtime'=>$list['createtime'],
              'logip'=>$_SERVER["REMOTE_ADDR"],
              'createip'=>$list['createip'],           
            );
            
            $add=M('user_log')->data($data)->add();
            
            echo $sa;
            unset($_SESSION['name1']);
            unset($_SESSION['tur']);
        }
        
        
        
    }
    function clayzm()
    {
        unset($_SESSION['number1']);
    }
    /*
     * 蔡政
     * 20151210
     * 验证用户输入验证码
     * 输入用户输入验证码，输入错误返回0，输入正确返回1；
     *  */
    function check_yzm()
    {
    
        $rank=$_GET['rank'];
    
        session_start();
    
        $number1=$_SESSION['nu'];
    
        if($rank==$number1)
        {
            echo 1;
            unset($_SESSION['nu']);
            $_SESSION['tur']=2;
        }
        else
        {
            echo 0;
        }
    
    }    

    
}




?>