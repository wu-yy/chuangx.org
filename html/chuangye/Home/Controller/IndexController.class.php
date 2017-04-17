<?php
namespace Home\Controller;

use Think\Controller;

use Think\Log;

class IndexController extends Controller {
    
    function _initialize()
    {
        red301();

        if(is_weixin()==true)
        {
            
            $_SESSION['url']=get_url();
            
            redirect(U('Index/phone_code'));
            
        }        
        
        cookie_login();
        
        $name=username();
        
        $this->assign('username',$name);
        	
        $userimg=userimg();
        
        $userimg=sevheardimage($userimg);
        	
        $this->assign('userimg',$userimg);
        
        $this->assign('phone_head','index');
    }
	public function index()
	{
	        
	    redirect(U('Index/homepage'));
    
	}
    function homepage()
    {
        
        
        header("Content-Type:text/html;charset=UTF-8");  // 解决乱码问题
        
        $id=$_SESSION['id'];       
        
        //log信息
        write_log('index',0);
        
        $username=$_GET['name'];
        
        $this->assign('name',$username);
        
        $list_nice_course=get_nice_course();
        
        $this->assign('list_nice_course',$list_nice_course);
        
        $new_course=$this->get_new_course();
        
        $this->assign('new_course',$new_course);
        
        $information_new_nu=$this->new_information();
        
        /*banner*/
        $balist=M("pictures")->where("picurl!=''")->order("ordernum asc")->select();
        $this->assign('balist',$balist);
        
        /*创业干货*/
        $drysaltery=M("drysaltery")->where("isnav=1")->order("ordernum asc")->select();
        $this->assign('drysaltery',$drysaltery);
        
        /*创业导师*/
        $teacherlist=M("teacher")->where(array("istutor"=>1))->select();
        
        $nu=count($teacherlist);
        
        if($nu>12)
        {
           $arrr=NoRand(0,$nu-1,12);

            $a=0;
            
            foreach ($arrr as $k=>$v)
            {
                $teacherarr[$a]=$teacherlist[$v];
                $a++;
            }
            $this->assign('teacherlist',$teacherarr);
        }
        else 
        {
            $this->assign('teacherlist',$teacherlist);
        }

        //活动
        $huodong=M('new_activity')->where('is_delect != 1')->order('id desc')->select();
        if(empty($huodong[0]['id']))
        {
            $this->assign('null_huodong',1);
        }
        $this->assign('huodong',$huodong);
        
        //群组
        //$user_group=M('user_group ug')->join('left join group1 g on g.id=ug.gid')->where(array('ug.uid'=>$id,'ug.is_delect'=>0,'g.is_delect'=>0,'g.type'=>1))->order('ug.id desc')->select();
        
        $user_group=M('group1 g')->where(array('g.is_delect'=>0,'g.type'=>1))->order('g.id desc')->select();
        
        
        $this->assign('user_group',$user_group);
        
        
       $gid=$_SESSION['gid'];
       
       if($gid !=$id && !empty($id))
       {
           $user_group1=M('user_group ug')->join('left join group1 g on g.id=ug.gid')->where(array('ug.uid'=>$id,'ug.is_delect'=>0,'g.is_delect'=>0,'g.type'=>1))->order('ug.id desc')->find();
            if(!empty($user_group1['gid']))
            {
                redirect(U('group',array('gid'=>$user_group1['gid'])));
                 
                return;
            }
           
       }

        $this->assign('information_new_nu',$information_new_nu);
        
        $this->assign('aaa','asdsadasdsa');
        
        if(isMobile())
        {
            if(is_ios()=='ios')
            {
                $this->assign('is_phone','ios');
            }
            
            $this->display('phone_homepage');
        }
        else
        {
            $this->display();
        }
        
        //$this->display();
    }

    //wenjing
	//
	function group_login(){
		$code = $_GET['code'];
		if(empty($code))
			$this->assign('groupname', '空');
		else{
			$group = M('group1')->where(array('code'=>$code, 'is_delect'=>0))->find();
			if(empty($group['id']))
				$this->assign('groupname', '空');
			else{
				$this->assign('groupname', $group['name']);
				$_SESSION['gid'] = $group['id'];//传给g_login()
			}
		}
		$this->display();
	}

	function g_login(){
		header("Content-Type:text/html;charset=UTF-8");  // 解决乱码问题
		//$url = $_POST['url'];
		$gid = session('gid');
		if(empty($gid)){
			echo 0;
			return;
		}
		$uid = session('id');//登录时传递的uid
		if(empty($uid))
        {
            //redirect(U('Index/index'));
            echo 0;
            return;
        }
        
        $group=M('group1')->where(array('id'=>$gid,'is_delect'=>0))->find();
       
        if(empty($group['id']))
        {
            $arr=array(0,'该群组不存在，请联系管理员');
            echo json_encode($arr);
            //echo 1;
            return;
        }
        if(!($this->check_user_nu_group($gid)))
        {
            $arr=array(0,$gid,'该组人数达到上限');
            echo json_encode($arr);
            //echo 2;
            return;
        }
        $user_group=M('user_group')->where(array('gid'=>$gid,'is_delect'=>0,'uid'=>$uid))->find();
       	if(!empty($user_group['id']))
       	{
           	$arr=array(1,$gid,'您已加入该群组');
           	echo json_encode($arr);
           	//echo 3;
           	return;
       	}
       	$add_user_group = M('user_group')->data(array('uid'=>$uid,'gid'=>$gid,'time'=>time(),'type'=>'1','is_delect'=>0))->add();
       	if(!empty($add_user_group))
        {
        	$arr=array(1,$gid,'添加成功');
            echo json_encode($arr);
            //echo 4;
            return;
        }
        else
        {
            $arr=array(0,'网络繁忙请稍候再试');
            echo json_encode($arr);
            //echo 5;
            return;
        }
	}

	function check_user_nu_group($gid)
    {
        $group=M('group1')->where(array('id'=>$gid))->find();
        
        if(empty($group['max_nu'])){return false;}
        
        $count=M('user_group')->where(array('gid'=>$gid,'is_delect'=>0))->count();

        if($count+1>$group['max_nu'])
        {
            return false;
        }
        
        else 
        {
            return true;
        }
    }


    /* 
     * 蔡政
     * 20151208
     * 检测用户是否已注册 
     * 输入：用户名，
     * 输出：是否已注册标示 1为已注册，0为未注册 
     * e.g:输入 username,输出1（标示已注册） 
     *  */
	public function checkName(){
		
		$name=$_GET['name'];
		
		$user=M('user');
		
		$where_usermail['useremail']=$name;//邮箱
		
		$list_user_email=$user->where($where_usermail)->count();
		
		$where_usermobilenum['usermobilenum']=$name;//手机
		
		$list_user_usermobilenum=$user->where($where_usermobilenum)->count();
		
		if(empty($list_user_email)&&empty($list_user_usermobilenum))
		{
			echo  0;
		}
		else
		{
			echo  1;
		}
	}

	/*
	 * 蔡政
	 * 20151208
	 * 注册新用户
	 * 输入：用户名，密码
	 * 输出：是否插入成功，1为成功，0为失败
	 * e.g:输入 username，password,输出1（标示插入数据库成功）
	 *  */
	public function sub_user(){
	
		$name=$_GET['name'];
	
		$pw=$_GET['pw'];
		
		$is_user=$_GET['isUser'];
		
		if(empty($name) || empty($pw) || empty($is_user))
		{	
			echo 0;
			return;
		}
			
		$ch=checkName1($name);
		
  		if($ch==1)
		{
			echo 0;
			return;
		} 
			
		$user=M('user');
		
		$data['password']=md5($pw);
		
		if($is_user=='mail')
		{
			$data['useremail']=$name;
		}
		if($is_user=='tel')
		{
			$data['usermobilenum']=$name;
		}
		
		$data['usertype']=0;
		
		$data['createtime']=time();
		
		$data['credit']=c('initialize_credit');
		
		$data['loginnu']=1;
		
		$data['createip']=$_SERVER["REMOTE_ADDR"];
		
		$check=$user->data($data)->add();
		
		if($check)
		{
			echo 1;
		}
		else 
		{
			echo 0;
		}
		
		$data_credit_log['uid']=$check;
		
		$data_credit_log['time']=time();
		
		$data_credit_log['type']=0;
		
		$data_credit_log['spend']=c('initialize_credit');
		
		M('credit_log')->add($data_credit_log);
		
		write_log('log','0');
		
		
	}
	/* 最新课程
	 * */
	function get_new_course()
	{
	    $icn=C('index_course_nu');
	
	    header("Content-Type:text/html;charset=UTF-8");  // 解决 POST变量乱码问题
	
	    $course=M('course');
	
	    /* $list_nice_course=$course->where('is_delect != 1')->order('id desc')->limit($icn)->select(); */
	    $list_nice_course=$course->where('is_delect != 1 and type=1')->order("start_time desc")->page("0,$icn")->select();
	    $a=0;
	
	    foreach ($list_nice_course as $k=>$v)
	    {
	        $list_nice_course[$a]['nu_add']=$v['course_user_add']+$v['nu'];
	
	        $a++;
	    }
	
	    return $list_nice_course;
	}
 	/* 最新课程
	 * */
	function get_new_course1()
	{
	    $icn=C('index_course_nu')/2;
	
	    header("Content-Type:text/html;charset=UTF-8");  // 解决 POST变量乱码问题
	
	    $course=M('course');
	
	    /* $list_nice_course=$course->where('is_delect != 1')->order('id desc')->limit($icn)->select(); */
	    $list_nice_course=$course->where('is_delect != 1')->order("start_time desc")->page("2,$icn")->select();
	    $a=0;
	
	    foreach ($list_nice_course as $k=>$v)
	    {
	        $list_nice_course[$a]['nu_add']=$v['course_user_add']+$v['nu'];
	
	        $a++;
	    }
	
	    return $list_nice_course;
	}

	/*
	 * 蔡政
	 * 20151208
	 * 用户登录
	 * 输入：用户名，密码
	 * 输出：是否登录验证标示 1验证成功，0为验证失败
	 * e.g:输入 username,password输出1（用户登录验证成功）
	 *  */
	public function checkuser(){
        
	    $xuanzhong=$_GET['xuanzhong'];//xz 是否tenfree,十天免登陆
	    
	    $name=$_GET['name'];
		
		$pw=$_GET['pw'];
		
		$is_user=$_GET['isUser'];
		
		if(empty($name) || empty($pw) || empty($is_user))
		{
			echo 0;
			return;
		}
		
 		$ch=checkName1($name);
		
		if($ch==0)
		{
			echo 0;
			return;
		}
			
		$user=M('user');
		
  		$where['password']=md5($pw); 
  		if($is_user!='mail' && $is_user!='tel')
  		{
  		    echo 0;
  		    return;
  		}
		
 		if($is_user=='mail')
		{
			$where['useremail']=$name;
			
		}
		if($is_user=='tel')
		{
			$where['usermobilenum']=$name;
		} 

		$check=$user->where($where)->find();
		
		if(empty($check))
		{
			echo 0;
		}
		else
		{
		    
			$_SESSION['id']=$check['id'];
			$this->jilu_user(3356);
			if($xuanzhong=="xz")
			{
			    $this->cookie_user($name,md5($pw),$is_user);
			}
			
			
			echo 1;
		} 

	}
	function  jilu_user($key)
	{
	    if($key != 3356){return;}
	    $id=session('id');
	    $list=M('user')->where(array('id'=>$id))->find();
	    if(empty($list['createip']))
	    {
	        $data=array(
	            'logintime'=>time(),
	            'loginip'=>$_SERVER["REMOTE_ADDR"],
	            'createip'=>$_SERVER["REMOTE_ADDR"],
	            'loginnu'=>$list['loginnu']+1,
	        );
	    }
	    else 
	    {
	        $data=array(
	            'logintime'=>time(),
	            'loginip'=>$_SERVER["REMOTE_ADDR"],
	            'loginnu'=>$list['loginnu']+1,
	        );
	    }  
	    M('user')->where(array('id'=>$id))->save($data);
	    
	    
	}
	function cookie_user($name,$pw,$is_user)
	{
	    setcookie("name", $name, time()+3600*24*10,"/");
	    setcookie("pw", $pw, time()+3600*24*10,"/");
	    setcookie("is_user", $is_user, time()+3600*24*10,"/");
	}

	/* 
	 * 蔡政
	 *  20151209
	 *  跳转到微信登录注册页
	 *  */
	function code()
	{
	    header("Content-Type:text/html;charset=UTF-8");  // 解决乱码问题
	    
		 $sever=UrlEncode(C('weixin_url')); 
		
		//$sever=UrlEncode("http://test.chuangedu.com.cn/index.php/Home/Index/weixin"); 
		$appid=C('appid');
		$url="https://open.weixin.qq.com/connect/qrconnect?appid=$appid&redirect_uri={$sever}&response_type=code&scope=snsapi_login&state=STATE#wechat_redirect";

		//$url="https://open.weixin.qq.com/connect/qrconnect?appid=wxb2752728527c79e5&redirect_uri={$sever}&response_type=code&scope=snsapi_login&state=STATE#wechat_redirect";
		
		
		Header("Location: $url");
	}
	function phone_code()
	{	    	    
		$sever=UrlEncode(C('phone_weixin_url')); 
	    $appid=C('phone_appid');
	    $url="https://open.weixin.qq.com/connect/oauth2/authorize?appid=$appid&redirect_uri=$sever&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect";
	    Header("Location: $url");
	}
	/* 
	 * 蔡政
	 * 20151209 
	 * 输入用户code 
	 * 用户登录，跳转到主页 
	 *  */
	function weixin(){
	
		$code = $_GET['code'];

		if(empty($code))
		{
			echo "扫描二维码失败，请重新扫描";
			return;
		}
	
		$uinfo=$this-> uinfo($code,1);

		if(is_array($uinfo))
		{	
	
		$openid=$uinfo['unionid'];
		
		$this->disanfang($openid,'weixin',$uinfo);
			
		}
	}
	/*
	 * 蔡政
	 * 20151209
	 * 输入用户code
	 * 用户登录，跳转到主页
	 *  */
	function phone_weixin(){
	
	    $code = $_GET['code'];
	
	    if(empty($code))
	    {
	        echo "扫描二维码失败，请重新扫描";
	        return;
	    }
	
	    $uinfo=$this-> uinfo($code,0);
	
	    if(is_array($uinfo))
	    {
	        
	        //print_r($uinfo);return;
	
	        $openid=$uinfo['unionid'];
	
	        $this->disanfang($openid,'weixin',$uinfo);
	        	
	    }
	}
	/* 
	 * 蔡政
	 *  输入userid，nikename，headimgurl
	 *  将数据插入unfio表中
	 *  
	 *  */
	function addunfio($key,$id,$nickname,$headimgurl)
	{
	    header("Content-Type:text/html;charset=UTF-8");//解决乱码问题
	    ($key != 110911) && $this->error('禁止访问','../Index/index');
	    
	   // E("$nickname");//wenjing
	    $uinfo=M('uinfo');
	     
	    $data['userid']=$id;
	     
	    $data['nikename']=$nickname;
	     
	    $data['image']=$headimgurl;
	    
	    $data['addtime']=time();
	     
	    $uinfo->data($data)->add();
	}
	/* 
	 * 获取第三方注册用户基本信息
	 *  
	 *  
	 *  */
	function dejson($key,$arr,$id,$type)
	{
	    header("Content-Type:text/html;charset=UTF-8");//解决乱码问题
	    ($key != 110120) && $this->error('禁止访问','../Index/index');
	     
	    (empty($arr) || empty($id) || empty($type)) && $this->error('参数错误','../Index/index');
	    
	    $arr['head'] = str_replace('+', '/', $arr['head']);//img url 链接恢复！！
	   // E("test break!");
	    if($type == 2)
	    	$this->addunfio(110911, $id, $arr['nick'], $arr['head']);
	    if($type==3)
	    $this->addunfio(110911,$id,$arr['nickname'],$arr['headimgurl']);
	    if($type==1)
	    $this->addunfio(110911,$id,$arr['nick'],$arr['head']);
	}		
	/*
	 * 蔡政
	 * 20151012  
	 * 第三方自动注册登录  
	 * 输入:openid 
	 * 用户登录或注册  
	 *   */
	function disanfang($openid,$type,$uinfo)
		{
			header("Content-Type:text/html;charset=UTF-8");//解决乱码问题
			$uinfo = json_decode($uinfo, true);
			//var_dump($uinfo);//wenjing	
			(empty($openid)||empty($type)) && $this->error('参数错误','../Index/index');
					
			$user=M('user');
				
			$where['openid']=$openid;
				
			$list=$user->where($where)->find();
				
			if(empty($list['id']))
			{
				$data['openid']=$openid;
				$data['phone_openid']=$uinfo['nick'];
				if($type=='qq')
				{
					$data['usertype']=1;
				}
				if($type=='weibo')
				{
					$data['usertype']=2;
				}
				if($type=='weixin')
				{
					$data['usertype']=3;
				}	
				$data['createtime']=date(time());
				
				$data['loginnu']=1;
				
				$data['logintime']=time();
				
				$data['loginip']=$_SERVER["REMOTE_ADDR"];
				
				$data['createip']=$_SERVER["REMOTE_ADDR"];
				
				$data['credit']=c('initialize_credit');
				
				$user->data($data)->add();
				
				write_log('log','0');
				
				if($list=$user->where($where)->find())
				{
						
					$_SESSION['id']=$list['id'];
					
					$data_credit_log['uid']=$list['id'];
					
					$data_credit_log['time']=time();
					
					$data_credit_log['type']=0;
					
					$data_credit_log['spend']=c('initialize_credit');
					
					M('credit_log')->add($data_credit_log);
					
					$this->dejson(110120,$uinfo,$list['id'],$data['usertype']);
					
					$this->jump_url();
					
				}
				else
				{
					echo "网络繁忙，注册失败，请重新注册";
				}
			}
			else
			{
			    
			    $data['logintime']=time();
			    
			    $data['loginip']=$_SERVER["REMOTE_ADDR"];
			    
			    $data['loginnu']=$list['loginnu']+1;
			    
			    if(weixin_login())
			    {
                     $data['phone_openid']=$uinfo['openid'];
			    }
			   
/*  
				$data=array(
				    'logintime'=>time(),
				    'loginip'=>$_SERVER["REMOTE_ADDR"],
				    'loginnu'=>$list['loginnu']+1,
				    'phone_openid'=>$uinfo['openid'],
				); */

				$_SESSION['id']=$list['id'];
				
				$id=$list["id"];

				$user->where("id=$id")->save($data);
				
                $this->jump_url();
			}
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
		
		$number1=$_SESSION['number1'];
		
 		if($rank==$number1)
 		{
 			echo 1;
 		}
 		else 
 		{
 			echo 0;
 		}
		
	}
	/* 
	 * 蔡政
	 * 20151210 
	 * 发送验证码
	 * 输入手机号，发送验证码到用户手机，session中存储验证码 
	 *  */
	function yzm()
	{
	    
	    $n=session('name');
	    
 	    if(empty($n)){echo 0; return;} 
	    
		$name=$_GET['name'];
		
		session_start();
		
		$word=array(7,8,5,2,1,3,6,0,7,6,9,8,1,2,7,9,2,1,4,5,3,2);
			
		for($a=0;$a<4;$a++)
		{
		$number[$a]=$word[rand(0, 21)];//用随机数取得验证码
		}
			
		$number1=implode($number); //将数组转化成字符串
		
		$_SESSION['number1']=$number1;
		
  		if(sendSms($name,$number1))
  		{
  		    echo "发送成功，请注意查收";
  		} 
  		else 
  		{
  		    echo "发送失败，未知错误";
  		}
  		
  		unset($_SESSION['name']);
	}
	/*
	 *蔡政
	 *20151210
	 *删除验证码
	 *  */
	function unse()
	{
		unset($_SESSION['number1']);
	}
	/*
	 *蔡政
	 *20151210
	 *用户退出 输出  1为退出成功，0为失败
	 *  */
	function userout()
	{
		unset($_SESSION['id']);
		
		if(!(session(id)))
		{
			echo 1;
		}
		else
		{
			echo 0;
		}
	}
	function check_yzm_sub()
	{
	    $name=session('name');
	    
	    if(empty($name))
	    {
	        echo 0;
	    }
	    else
	    {
	        echo 1;
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

		$n=session('name');
		
		if(empty($n)){echo 0; return;}
		
		$word=array(7,8,5,2,1,3,6,0,7,6,9,8,1,2,7,9,2,1,4,5,3,2);
			
		for($a=0;$a<4;$a++)
		{
		$number[$a]=$word[rand(0, 21)];//用随机数取得验证码
		}
			
		$number1=implode($number); //将数组转化成字符串
		
		$_SESSION['number1']=$number1;
		
		$title="创业学院网站邮箱注册验证码";
		
		$content="您的注册码为：".$number1."请勿将验证码向他人泄露，如非本人操作，请忽略此邮件";
		
		$mail=$_GET['mail'];
	
		if(sendMail("$mail","$title","$content"))
			echo '1';
		else
			echo '0';
		
		unset($_SESSION['name']);
		
		return ;
	 
	}
	/* 
	 * 蔡政
	 * 最新资讯
	 * 
	 *  */
	function new_information()
	{
	    $information_new_nu=C('information_new_nu');
	    
	    $information=M('information');
	    
	    $list=$information->order('time desc')->page(1,$information_new_nu)->where('is_delect != 1 and  type=0 ')->select();
	    
	    $a=0;
	    
	    foreach ($list as $k=>$v)
	    {
	        $time_ad=time_ad($v['time']);
	    
	        $list[$a]['time_ad']=$time_ad;

	        $list[$a]['nu_add']=$v['information_user_add']+$v['nu'];
	        
	        $a++;
	    }
	    
	    return $list;
	}

	
	function uinfo($code,$type)
	{
		header("Content-Type:text/html;charset=UTF-8");  // 解决乱码问题
	    if($type==1)
	    {
	        $appid=C('appid');
	        
	        $secret=C('weixin_secret');
	    }
	    else 
	    {
	        $appid=C('phone_appid');
	        
	        $secret=C('phone_weixin_secret');
	    }
/* 		$appid = "wxb2752728527c79e5";
		$secret = "336cb781cd2114179c1d0c981accd27d"; */
		$get_token_url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$appid&secret=$secret&code=$code&grant_type=authorization_code";
	
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$get_token_url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
		$res = curl_exec($ch);
		curl_close($ch);
		$json_obj = json_decode($res,true);
	
		//根据openid和access_token查询用户信息
		$access_token = $json_obj['access_token'];
		$_SESSION['access_token']=array($access_token,time());
		$openid = $json_obj['openid'];
		$get_user_info_url = "https://api.weixin.qq.com/sns/userinfo?access_token=$access_token&openid=$openid&lang=zh_CN";
	
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$get_user_info_url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
		$res = curl_exec($ch);
		curl_close($ch);
	
		//解析json
		$user_obj = json_decode($res,true);
		return $user_obj;
		/*Header("Location: $url");*/
	}
	//登录地址
	public function login($type = null){
		empty($type) && $this->error('参数错误','../Index/index');
	
		import("Org.ThinkSDK.ThinkOauth");
		//加载ThinkOauth类并实例化一个对象
		$sns  = \ThinkOauth::getInstance($type);
	
		//跳转到授权页面
		redirect($sns->getRequestCodeURL());
	}
	
	//授权回调地址 , 要把ThinkSDK加入到回调地址的那个服务器下！！！
	public function callback($type = null, $code = null){
		(empty($type) || empty($code)) && $this->error('参数错误','../Index/index');
	
		import("Org.ThinkSDK.ThinkOauth");
		//加载ThinkOauth类并实例化一个对象
		$sns  = \ThinkOauth::getInstance($type);//出错是因为回调服务器下没有sdk
	
		//腾讯微博需传递的额外参数
		$extend = null;
		if($type == 'tencent'){
			$extend = array('openid' => I('get.openid'), 'openkey' => I('get.openkey'));
		}
	
		//请妥善保管这里获取到的Token信息，方便以后API调用
		//调用方法，实例化SDK对象的时候直接作为构造函数的第二个参数传入
		//如： $qq = ThinkOauth::getInstance('qq', $token);
		$token = $sns->getAccessToken($code , $extend);
	
		//获取当前登录用户信息
		if(is_array($token)){
			$user_info = D('Type', 'Service')->$type($token);
			
			$openid=$token['openid'];
			
			$json=json_encode($user_info, JSON_UNESCAPED_UNICODE);
			//$json = $user_info;//wenjing
			$json=str_replace('\/','+',$json);

			$this->redirect("/Home/Index/disanfang/openid/".$openid."/type/weibo/uinfo/".$json);//wenjing ../type/qq/json/.. => ../type/weibo/uinfo/..
		}
	}
    function log()
    {

        $uinfo=user_uinfo(9166);

        if(!empty($uinfo))
        {
            $log='time:'.date('Y-m-d H:i:s').'   ip:'.$_SERVER["REMOTE_ADDR"].'   userid:'.$uinfo['id'].'   createtime:'.date('Y-m-d H:i:s', $uinfo['createtime']).'  url:'.$_POST['url'].'   region:'.$_POST['head'].'   point:'.$_POST['Jump_page'];
        
        }
        else
        {
            $log='time:'.date('Y-m-d H:i:s').'    ip:'.$_SERVER["REMOTE_ADDR"].'   state:Not Logged In'.'  url:'.$_POST['url'].'   region:'.$_POST['head'].'   point:'.$_POST['Jump_page'];
        
        }

        echo 'wenjing';
        \Think\Log::write_onclick($log,'onclick');

    }
    
    function search_log()
    {
        $uinfo=user_uinfo(9166);
        
        if(!empty($uinfo))
        {
            $log='time:'.date('Y-m-d H:i:s').'   ip:'.$_SERVER["REMOTE_ADDR"].'   userid:'.$uinfo['id'].'   createtime:'.date('Y-m-d H:i:s', $uinfo['createtime']).'  url:'.$_POST['url'].'   region:'.$_POST['head'].'   point:'.$_POST['Jump_page'];
        
        }
        else
        {
            $log='time:'.date('Y-m-d H:i:s').'    ip:'.$_SERVER["REMOTE_ADDR"].'   state:Not Logged In'.'  url:'.$_POST['url'].'   region:'.$_POST['head'].'   point:'.$_POST['Jump_page'];
        
        }
        
        \Think\Log::write_search($log,'search');
    }
    function url_weixin()
    {
        
        $_SESSION['url']=$_POST['url'];
        

    }
    
    function p_url_weixin()
    {
        echo $_SESSION['url'];
        unset($_SESSION['url']);
    }

    function xuetangzaixian()
    {
        $client_id=C('client_id');
        
        $client_secret=C('client_secret');
        
        $sever=C('xuetang');
                
		$url="http://www.xuetangx.com/api/oauth2/authorize/?state='123'&nonce='456'&redirect_uri=$sever&response_type=code&client_id=$client_id&scope=openid+profile";
			
		Header("Location: $url");//跳转页面
    }
    function xuetang()
    {
        $code=$_GET['code'];
        
      //  echo $_GET['state'].'<br />';return;
        
        if(strpos($_GET['state'],"uinfo"))
        {
            redirect(U('Uinfo/xuetang',array('code'=>$code)));
            return;
        }
        
        $client_id=C('client_id');
        
        $client_secret=C('client_secret');
        
        $sever=C('xuetang');
        
        $uri = "http://www.xuetangx.com/api/oauth2/access_token/"; 

        $data = array ( 

        'nonce'=>'123',

        'redirect_uri'=>$sever,

        'code' => $code,
            
        'grant_type'=>'authorization_code',

        'client_id'=>$client_id,
            
        'client_secret'=>$client_secret,
        
        ); 

        $ch = curl_init (); 
        
        curl_setopt( $ch, CURLOPT_URL, $uri ); 
        
        curl_setopt ( $ch, CURLOPT_POST, 1 ); 
        
        curl_setopt ( $ch, CURLOPT_HEADER, 0 ); 
        
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 ); 
        
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data ); 
        
        $return = curl_exec ( $ch ); 
        
        curl_close ( $ch );

        $arr=json_decode($return,true);
        
//        print_r($arr);echo '<br />';
        
        $token=$arr['access_token'];

        $get_poenid_url = "http://www.xuetangx.com/api/oauth2/user_info/";
        
        $headers = array(
        
            'Authorization: Bearer '.$token,
        );
        
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$get_poenid_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $res = curl_exec($ch);
        curl_close($ch);
        
        //解析json
        $user_obj = json_decode($res,true);
        
//        print_r($user_obj); echo '<br />';
        
        if(empty($user_obj['sub']))
        {
            redirect(U('Index/index'));
        }
        
//        echo $user_obj["sub"].'<br />';
        
        $list=M('user')->where(array('xuetang_id'=>$user_obj['sub']))->find();
        
//        print_r($list);return; 
        
        if(!empty($list['id']))
        {
            $_SESSION['id']=$list['id'];
            
            $url_weixin=$_SESSION['url'];
            
            if(empty($url_weixin))
            {
                redirect(U('Index/index'));
            }
            else
            {
                unset($_SESSION['url']);
                redirect($url_weixin);
            }
        }
        else 
        {
            $data=array(
                'usertype'=>0,
                'createtime'=>time(),
                'credit'=>c('initialize_credit'),
                'loginnu'=>1,
                'createip'=>$_SERVER["REMOTE_ADDR"],
                'xuetang_id'=>$user_obj['sub'],
                'logintime'=>time(),
                'loginip'=>$_SERVER["REMOTE_ADDR"],
                
            );
            $re=M('user')->data($data)->add();
            
            $_SESSION['id']=$re;
            
            $data_info=array(
                'userid'=>$re,
                'nikename'=>$user_obj['nickname'],
                'image'=>$user_obj['picture'],
                'addtime'=>time(),
                'updatatime'=>time(),
            );
            
            M('uinfo')->data($data_info)->add();
            
            $url_weixin=$_SESSION['url'];
            
            if(empty($url_weixin))
            {
                redirect(U('Index/index'));
            }
            else
            {
                unset($_SESSION['url']);
                redirect($url_weixin);
            }
        }
            
    }
    function test()
    {
        $str='img src=\"/Pub\l\i\c/js/Plugin/kindeditor/attached/image/20160405115801_93226.jpg\" alt=\"\" />';
        
        /* $str=str_replace("\\","",$str); */
        
        $str=stripslashes($str);
        
        echo $str;
    }
    function group()
    {
        header("Content-Type:text/html;charset=UTF-8");  // 解决乱码问题
        
        $gid=$_GET['gid'];

         $_SESSION['gid']=$_SESSION['id']; 
         if(empty($gid) || is_numeric($gid)==false)
        {
            redirect(U('Index/homepage'));
        }
             
            
        $user_group=M('group1 g')->where(array('g.id'=>$gid,'g.is_delect'=>0,'g.type'=>1))->field('g.*,g.id as gid')->find();
        if(empty($user_group['gid']))
        {
            redirect(U('Index/homepage'));
        }
        
        /* 
        
        $user_group=M('user_group ug')->join('left join group1 g on g.id=ug.gid')->where(array('ug.uid'=>$id,'ug.is_delect'=>0,'g.is_delect'=>0))->order('ug.id desc')->find(); */
        
        $this->assign('logo',$user_group['img_logo']);
        
        $this->assign('img',$user_group['img']);
        
        $this->assign('name',$user_group['name']);
        
        $course_danjie=M('course_group cg')->join('left join course c on c.id=cg.cid')->where(array('cg.gid'=>$user_group['gid'],'cg.type'=>1,'cg.is_delect'=>0,'cg.end_time'=>array('gt',time()),'c.is_delect'=>array('neq',1)))->select();
        
        $course_bao=M('course_group cg')->join('left join admin_tag at on at.id=cg.cid')->where(array('cg.gid'=>$user_group['gid'],'cg.type'=>2,'cg.is_delect'=>0,'at.is_delect'=>0,'cg.end_time'=>array('gt',time())))->order('cg.id desc')->select();
        
        $a=0;
        
        foreach ($course_bao as $k=>$v)
        {
           $bao_id[$a]=$v['cid'];

           $a++;
        }
        
        if(!empty($bao_id[0]))
        {

        
        $bao_course=M('course_admin_tag at')->join('left join course c on c.id=at.cid')->join('left join admin_tag a on a.id=at.tid')->where(array('at.tid'=>array('in',$bao_id),'at.is_delect'=>0,'at.type'=>1,'c.is_delect'=>0,'a.is_delect'=>0))->field('c.*,at.*,a.name as bao_name')->select();
        
        $a=0;
        
        foreach ($bao_course as $k=>$v)
        {
            foreach ($bao_id as $k1=>$v1)
            {
                if($v['tid']==$v1)
                {
                    $arr_bao_course[$v1][$a]=$v;
                    
                    $a++;
                    
                    break;
                }
            }
        }
        
        $at_name=M('admin_tag')->where(array('id'=>array('in',$bao_id),'is_delect'=>0))->select();
        
        $a=0;
        
        foreach ($at_name as $k=>$v)
        {
            $arrname[$v['id']]['name']=$v['name'];
            $arrname[$v['id']]['id']=$v['id'];
            
        } 
        }
        $this->assign('arrname',$arrname);
        
        //print_r($arr_bao_course);return;
        
        $this->assign('abc',$arr_bao_course);
        
        
        
        $this->assign('course_danjie',$course_danjie);
        
        if(empty($course_danjie[0]['id']))
        {
            $t=0;
        }
        else 
        {
            $t=1;
        }
         
        $this->assign('t',$t);
        
        $information=M('course_group cg')->join('left join information c on c.id=cg.cid')->where(array('cg.gid'=>$user_group['gid'],'cg.type'=>3,'cg.is_delect'=>0))->order('c.id desc')->select();
        
        if(empty($information[0]['id']))
        {
            $this->assign('null_information',1);
        }
        
        $this->assign('information',$information);
        
        /*创业导师*/
        $teacherlist=M("teacher")->where(array("istutor"=>1))->select();
        
        $nu=count($teacherlist);
        if($nu>9)
        {
            $arrr=NoRand(0,$nu-1,9);
        
            $a=0;
        
            foreach ($arrr as $k=>$v)
            {
                $teacherarr[$a]=$teacherlist[$v];
                $a++;
            }
            $this->assign('teacherlist',$teacherarr);
        }
        else
        {
            $this->assign('teacherlist',$teacherlist);
        }
       //$this->display('phone_group');return;
        if(isMobile())
        {
            $this->display('phone_group');
        }
        else
        {
            $this->display();
        }
        
        
    }
    function phone_login()
    {
        if(weixin_login())
        {
            $type='1';
        }
        
        $this->assign('type',$type);
        
        $this->display();
    }
    function phone_signin()
    {
        if(weixin_login())
        {
            $type='1';    
        }
        
        $this->assign('type',$type);
        
        $this->display();
    }

    
    function jump_url()
    {
        $url_weixin=session('url');
        
        $s = parse_url($url_weixin);
        
        $s = strtolower($s['host']) ;
        
        $url_weixin=str_replace($s,C('url301'),$url_weixin);

        if(empty($url_weixin))
        {
            redirect(U('Index/index'));
        }
        else
        {
            unset($_SESSION['url']);
            redirect($url_weixin);
        }
    }
}
