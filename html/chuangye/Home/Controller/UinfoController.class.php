<?php
namespace Home\Controller;

use Think\Controller;

class UinfoController extends Controller {
    
    function _initialize()
    {
        red301();
        
        if(is_weixin()==true)
        {
            $_SESSION['url']=get_url();
        
            redirect(U('Index/phone_code'));
        }
        
        cookie_login();
        
        $id=session('id');
         
        if(empty($id))
        {
            redirect(U('Index/index'));
        }
        
        $phone_nu=$this->is_phone(9910);
        
        $this->assign('phone_nu',$phone_nu);
        
        $name=username();
        
        $this->assign('username',$name);
         
        $userimg=userimg();
        
        $userimg=sevheardimage($userimg);
         
        $this->assign('userimg',$userimg);
        
        $this->assign('phone_head','uinfo');
        
        $user_group=fenzhan();
        
        $this->assign('user_group',$user_group);
    }

	function index()
	{
	    
	    if(!empty($_GET['u']))
	    {
	        $this->assign('u',$_GET['u']);
	    }
	    
	    $email_nu=$this->is_email(9979);
	    
	    $getuseruinfo=getuseruinfo(6978);
	    
	    $im=sevheardimage($getuseruinfo['image']);
	    
	    $this->assign('image',$im);
	    
	    $this->assign('name',$getuseruinfo['nikename']);
	    
	    $this->assign('email_nu',$email_nu);
	    
	    $list=$this->profession();
	    
	    $list_course_count=count($list);
	    
	    $this->assign('list_course',$list);
	    
	    //print_r($list);return;
	    
	    $this->assign('list_course_count',$list_course_count);
	    
	    if(empty($list[0]['title']))
	   {
	       $a='';
	   }
	   else 
	   {
	       $a='111';
	   }
	   
	   $joined_group=$this->joined_group();
	   
	   if(empty($joined_group[0]['id']))
	   {
	       $this->assign('joined_group','');
	   }
	   else
	   {
	       $this->assign('joined_group',1);
	   }
	   
	   $this->assign('a',$a);
	   
	   $jifen=jifen();
	        
	   $this->assign('jifen',$jifen);

	   if(is_vip())
	   {
	       $this->assign('vip',1);
	   }
    
         if(isMobile())
        {
            $this->display('phone_index');
        }
        else
        {
            $this->display();
        } 
	}
    

	
	function mail()
	{
	    $tel=$this->is_phone(9910);
	    
	    if(empty($tel)){redirect(U('Uinfo/index'));}    

		$this->unsetsession();
		
		$_SESSION['uinfo']='mail';
		
		$pattern = '/(\d{3})(\d{4})(\d{4})/i';
		$replacement = '$1****$3';
		$tel=preg_replace($pattern, $replacement,$tel);
		$this->assign('phone',$tel);
		
		$this->display();
	}
	function pw()
	{
	    $tel=$this->is_phone(9910);
	     
	    if(empty($tel)){redirect(U('Uinfo/index'));}
	
	    $this->unsetsession();
	
	    $_SESSION['uinfo']='pw';
	    
	    $pattern = '/(\d{3})(\d{4})(\d{4})/i';
	    $replacement = '$1****$3';
	    $tel=preg_replace($pattern, $replacement,$tel);
	    $this->assign('phone',$tel);
	    
	
	    $this->display();
	}

	
	/*
	 *蔡政
	 *20151213
	 *邮箱是否已注册，如果未注册，保存邮箱，输出：1为已注册，0插入失败，2二为保存邮箱成功
	 *  */
	function checkmail()
	{
		
		(empty($_GET['mail'])) && $this->error("参数错误","../Index/index");
		
		$mail=$_GET['mail'];
		
		$user_mail=$this->is_email(9979);
		
		if($mail != $user_mail)
		{
		    $this->error('参数错误',U('index'));
		    
		    return;
		}
		else 
		{
		    $_SESSION['mail']=$mail;
		    
		    if($_SESSION['mail'] !=null)
		    {
		        echo 1;
		    }
		    else 
		    {
		        echo 0;
		    }
		}
		    
		
	}
	/*
	 *蔡政
	 *20151213
	 *用户是否已绑定邮箱，输出：用户邮箱
	 *  */
	function is_email($key)
	{
	    $id=session('id');
	
	    (empty($id)) && $this->error("请登录！！","../Index/index");
	
	    (!($key==9979)) && $this->error("禁止访问!!","../Index/index");
	
	    $user=M('user');
	
	    $where['id']=$id;
	
	    $list=$user->where($where)->find();
	
	    return $list['useremail'];
	
	}
	function changemail()
	{
	    $id=session('id');
	    
	    (empty($id)) && $this->error("请登录",U('Index/index'));
	    
        $mail=session('change_tel');
        if($mail=='mail')
        {   
            $this->display();
        }
	    else 
	    {
	        redirect(U('Uinfo/index'));
	    }
	        
	    
	}
	
	function up_mail()
	{
	    
	    $mail=session('change_tel');
	    if($mail!='mail')
	    {
	        echo 0;
	        return;
	    }
	    $mail=$_GET['srk'];
	    
	    $list=checkName1($mail);
	    
	    if(empty($list))
	    {
	        $user=M('user');
	        	
	        $id=session('id');
	        	
	        $where_save['id']=$id;
	        	
	        $data['useremail']=$mail;
	        	
	        if($user->where($where_save)->save($data))
	        {
	            
	            
	            unset($_SESSION['change_tel']);
	            
	            echo 1;
	            
	            return;
	        }
	        else
	        {
	            echo 0;
	            
	            return;
	        }
	    }
	    else
	    {
	         echo 0;
	         
	         return;
	    }
	}
	/*
	 *蔡政
	 *20151213
	 *
	 *  */
	function phone()
	{
		
		$id=session('id');
		
		(empty($id)) && $this->error("请登录！！","../Index/index");
		
		$this->unsetsession();
		
		$_SESSION['uinfo']='phone';
		
		$tel=$this->is_phone(9910);
		
		if(empty($tel))
		{
		    
		    $this->redirect('g_phone');
		
		    return;
		}
		$pattern = '/(\d{3})(\d{4})(\d{4})/i';
        $replacement = '$1****$3';
        $tel=preg_replace($pattern, $replacement,$tel);
		
		$this->assign('phone',$tel);
		
		$this->display();
	}

	/* 修改手机号 */
	function up_phone()
	{
	    
	    $id=session('id');
		
		(empty($id)) && $this->error("请登录！！","../Index/index");
		
		$phone=$this->is_phone(9910);
		
		if(!empty($phone)){echo 0; return;}
		
		$u=$_SESSION['change_tel'];
		
		if($u!='g_phone'){echo 0; return;}
		
		$tel=$_SESSION['g_phone_tel'];
		
		if(empty($tel)){echo 0; return;}
		
		$is_login=checkName1($tel);
		
		if(!empty($is_login)){echo 0; return;}
		
		$user=M('user');
		
		$data['usermobilenum']=$tel;
		
		$list=$user->where("id=$id")->save($data);
		
		if($list)
		{
		    echo 1;
		    unset($_SESSION['change_tel']);
		    unset($_SESSION['g_phone_tel']);
		}
		else 
		{
		    echo 0;
		}
		
		
	}

	/*
	 *蔡政
	 *20151213
	 *用户是否已绑定手机，输出：用户手机号
	 *  */
	function is_phone($key)
	{
		$id=session('id');
		
		(empty($id)) && $this->error("请登录！！","../Index/index");
	
		(!($key==9910)) && $this->error("禁止访问!!","../Index/index");
	
		$user=M('user');
	
		$where['id']=$id;
	
		$list=$user->where($where)->find();
	
		return $list['usermobilenum'];
	
	}

	function g_phone()
	{
	    
	    $id=session('id');
	    (empty($id)) && $this->error("请登录！！",U('Index/index'));
	    
	    $tel=$this->is_phone(9910);
	    
	    if(empty($tel))
	    {
	        $_SESSION['uinfo']='g_phone';
	        $this->display();
	         
	        return;
	    }
	    else 
	    {
	        $ct=$_SESSION['change_tel'];
	        if($ct=='phone')
	        {
	            $_SESSION['uinfo']='g_phone';
	            $this->display();
	        }
	        else 
	        {
	            redirect(U('Uinfo/index'));
	        }
	    }
	     
	}
	function checkphone()
	{
	    $id=session('id');
	    (empty($id)) && $this->error("请登录！！","../Index/index");
	    
	    $tel=$this->is_phone(9910);
	    
	    $name=$_GET['name'];
	    
	    if($tel==$name)
	    {
	        echo 1;
	    }
	    else 
	    {
	        echo 0;
	    }
	}
	function password()
	{
	    $ct=$_SESSION['change_tel'];
	    
	    if($ct!='pw')
	    {
	        redirect(U('Uinfo/index'));
	    }
	    else
	    {
	        $this->display();
	    }
		
		
	}

	/*
	 * 蔡政
	 * 20151213
	 * 修改密码
	 * 输入原始密码，新密码，确认密码，1为修改成功，0为修改失败
	 *  */
	function insert_pw()
	{
	    $ct=$_SESSION['change_tel'];
	     
	    if($ct!='pw') { return 0;}
		
		if(empty($_GET['npw']) || empty($_GET['cpw'])){return 0;}
		
		if($_GET['npw']!=$_GET['cpw']){return 0;};
		
		$user=M('user');
		
		$id=session('id');
		
		$where['id']=$id;
		
		$data['password']=md5($_GET['npw']);
		
		if($user->where($where)->save($data))
		{
		    echo 1;
		    unset($_SESSION['change_tel']);
		}
		else 
		{
		    echo 0;
		}	
		
	}
	function personal()
	{
	    $getuseruinfo=getuseruinfo(6978);
	    
	    $im=sevheardimage($getuseruinfo['image']);
	    
	    $this->assign('nname',$getuseruinfo['nikename']);
	    
	    $this->assign('uname',$getuseruinfo['username']);
	    
	    $this->assign('jianjie',$getuseruinfo['brief_introduction']);
	    
	    $this->assign('image',$im);
	    

	    if(isMobile())
	    {
	        $this->display('phone_personal');
	    }
	    else
	    {
	        $this->display();
	    }

	}
	/* 
	 * 蔡政
	 * 20151214
	 * 将用户信息插入uinfo表中
	 * 1表示插入成功，0表示插入失败 
	 *  */
	function insertuinfo()
	{
	    $where1["userid"]=session('id');
	    
	    if(empty($where1["userid"])){echo 0;return;}
	    
	    $uinfo1=M('uinfo');
	    
	    $list=$uinfo1->where($where1)->select();
	    
	    if(empty($list[0]['nikename']))
    	    if(empty($_GET['nikename']))
    	    {
    	        echo 2;
    	        return;
    	    }

	        
	        
	    if(!empty($_GET['username']))
	    {
	        $username=$_GET['username'];
	        $data['username']=$username;

	    }
	    if(!empty($_GET['jianjie']))
	    {
	        $jianjie=$_GET['jianjie'];
	        
	        $data['brief_introduction']=$jianjie;

	    }
	    if(!empty($_GET['nikename']))
	    {
	        $nikename=$_GET['nikename'];
	         
	        $data['nikename']=$nikename;
	    
	    }
	    
	    $uinfo=M('uinfo');
	    $where["userid"]=session('id');
	    $data['updatatime']=time();
	    
	    if($getuseruinfo=getuseruinfo(6978))
	        $list1=$uinfo->where($where)->save($data);
	    else 
	    {
	        $data['userid']=session('id');
	        $data['addtime']=time();
	        $list1=$uinfo->where($where)->data($data)->add();
	    }
	    if(empty($list1))
	       echo 0;
	    else 
	    {
	        if($_GET['nikename']!=$list[0]['nikename'])
	        {
	            $this->user_log('nikename', $list[0]['nikename'], $_GET['nikename']);
	        }
	        if($_GET['username']!=$list[0]['username'])
	        {
	            $this->user_log('name', $list[0]['username'], $_GET['username']);
	        }
	        if($_GET['jianjie']!=$list[0]['brief_introduction'])
	        {
	            $this->user_log('intro', $list[0]['brief_introduction'], $_GET['jianjie']);
	        }
	       echo 1;
	    }      
	}
	/* 
	 * 蔡政
	 * 20151214
	 * 图片上传，0为上传失败，1为上传成功 
	 *  */
	public function upload(){
	    header("Content-Type:text/html;charset=UTF-8");  // 解决乱码问题
	    $upload = new \Think\Upload();// 实例化上传类
	    $upload->maxSize   =     3145728 ;// 设置附件上传大小
	    $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
	    $upload->saveName  = time().'_'.session('id').'_'.mt_rand(10,99);
	    $upload->rootPath  =     './Uploads/headuser/'; // 设置附件上传根目录
	    $upload->autoSub = false;
	    // 上传文件
	    $info   =   $upload->uploadOne($_FILES['photo']);
	    if(!$info) {// 上传错误提示错误信息
	        echo $upload->getError();
	    }else{// 上传成功
	       $image='./Uploads/headuser/'.$info['savename'];
	       
	       $uinfo=M('uinfo');
	       $data['image']=$image;
	       $where["userid"]=session('id');
	       $user_uinfo=$uinfo->where($where)->find();
	       if($getuseruinfo=getuseruinfo(6978))
	       {
	           $list=$uinfo->where($where)->save($data);
	       }
	       else
	       {
	           $data['userid']=session('id');
	           $data['addtime']=time();
	           $list=$uinfo->where($where)->data($data)->add();
	       }
	       if(empty($list))
	           echo "网络繁忙，请稍候再试";
	       else{
	           $this->user_log('intro', $user_uinfo['image'], $image);
	           redirect(U('Uinfo/personal'));
	       }
	    }
	}
	/* 
	 * 用户关注的课程
	 *  */
	function profession()
	{
	    
	   $id=session('id');
	   
	   (empty($id)) && $this->error("请登录！！","../Index/index");
	   
	   $course_user=M('course_user');
	   
	   $where['uid']=$id;
	   
	   $where['end_time']=array('gt',time());
	   
	   $list=$course_user->where($where)->field ('cid,id')->order('id desc')->select();
	   
	   $a=0;
	   
	   foreach ($list as $k=>$v)
	   {
	       $arr[$a]=$v['cid'];
	       
	       if($a==0)
	       {
	           $cid_str=$v['cid'];
	       }
	       else 
	       {
	           $cid_str=$cid_str.','.$v['cid'];
	       }
	       $a++;
	   }
	   
	   if(empty($arr))
	   {
	       return;
	   }
	   
	   $course=M('course');
	   
	   $where_course['id']=array(in,$arr);

	   $list_course=$course->where($where_course)->where(array('type'=>1,'is_delect'=>0))->field('id,image,title,brief,mark_bit')->order("field(id,$cid_str)")->select();
	   
	   $course_teacher=M('course_teacher');
	   
	   $b=0;
	   
	   foreach ($list_course as $k=>$v)
	   {
	   
	   
	       $where_course_teacher['cid']=$v['id'];
	   
	       $list_course_teacher=$course_teacher->where($where_course_teacher)->select();
	   
	       $a=0;
	   
	       unset($arr);
	   
	       foreach ($list_course_teacher as $k=>$v)
	       {
	            
	           $arr[$a]=$v['tid'];
	   
	           $a++;
	   
	       }
	   
	       if(!empty($arr))
	       {
	   
	           $teacher=M('teacher');
	   
	           $where_teacher['id']=array('in',$arr);
	   
	           $list_teacher=$teacher->where($where_teacher)->select();
	            
	   
	           $a=0;
	   
	           unset($arr_teacher_name);
	   
	           foreach ($list_teacher as $k=>$v)
	           {
	               $arr_teacher_name[$a]=$v['name'];
	   
	               $a++;
	           }
	   
	           $all_teacher_name=implode(',',$arr_teacher_name);
	   
	           $list_course[$b]['teacher_name']=$all_teacher_name;
	       }
	       else
	       {
	           $list_course[$b]['teacher_name']="导师信息暂无";
	       }
	   
	       
	       
	       if($list_course[$b]['start_time']<=time())
	       {
	           if($list_course[$b][mark_bit]==0)
	           {
	               $list_course[$b][mark_bit]=1;
	           }
	           if($list_course[$b][mark_bit]==3)
	           {
	               $list_course[$b][mark_bit]=2;
	           }
	       }
	       
	       
	       $b++;
	   }
	   
	   return $list_course;
	   

	}
    function user_log($type,$beforechange,$afterthechange)
    {
        $id=session('id');
        
        $user=M('user')->where(array('id'=>$id))->find();
       
        $data=array(
            'uid'=>$id,
            'type'=>$type,
            'beforechange'=>$beforechange,
            'afterthechange'=>$afterthechange,
            'logtime'=>time(),
            'createtime'=>$user['createtime'],
            'logip'=>$_SERVER["REMOTE_ADDR"],
            'createip'=>$user['createip'],
        );
         
        $add=M('user_log')->data($data)->add();
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
    function checkcode($pw,$name)
    {
    
        $code=session('code');
    
        if(check_verify($pw,$id=''))
        {
            echo 1;
            $_SESSION['uinfo_code']=$_SESSION['uinfo'];
        }
        else
        {
            echo 0;
        }
    
    
    }
/*     function test()
    {
        echo 'uinfo&nbsp;&nbsp;&nbsp;&nbsp;'.session('uinfo');
        echo '<br/>';
        echo 'change_tel&nbsp;&nbsp;&nbsp;&nbsp;'.$_SESSION['change_tel'];
        echo '<br/>';
        echo 'g_phone_tel&nbsp;&nbsp;&nbsp;&nbsp;'.$_SESSION['g_phone_tel'];
        echo '<br/>';
        echo 'uinfo_code&nbsp;&nbsp;&nbsp;&nbsp;'.$_SESSION['uinfo_code'];
        echo '<br />';
        echo 'uinfo_phone_code$nbsp;$nbsp;$nbsp;$nbsp;$nbsp;'.$_SESSION['uinfo_phone_code'];
    } */
    function unsetsession()
    {
        unset($_SESSION['uinfo']);
        unset($_SESSION['change_tel']);
        unset($_SESSION['g_phone_tel']);
        unset($_SESSION['uinfo_code']);
        unset($_SESSION['uinfo_phone_code']);
    }
    function check_uinfo()
    {
        $name=$_POST['name'];
        
        $uinfo=session('uinfo_code');
        
        if($uinfo==$name)
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
        $u=$_SESSION['uinfo'];
        if(empty($u)){echo 0;return;}
        
        $n=session('uinfo_code');
         
        if(empty($n)){echo 0; return;}
        
        $name=$_POST['name'];
        
        $_SESSION['g_phone_tel']=$name;
             
        if(empty($name)){echo 0;return;}
        
        if($u!='g_phone')
        {
            $tel=$this->is_phone(9910);
        
            if($tel !=$name)
            {
                echo 0;
                return;
            }
        }
    
        $word=array(7,8,5,2,1,3,6,0,7,6,9,8,1,2,7,9,2,1,4,5,3,2);
        	
        for($a=0;$a<4;$a++)
        {
            $number[$a]=$word[rand(0, 21)];//用随机数取得验证码
        }
    	
        $number1=implode($number); //将数组转化成字符串
        
        $_SESSION['uinfo_phone_code']=$number1;
        
        if(sendSms($name,$number1))
        {
            echo 1;
        }
        else
        {
            echo 1;
        }
        
        unset($_SESSION['uinfo_code']);
    }
    
    /*
     * 蔡政
     * 20151210
     * 验证用户输入验证码
     * 输入用户输入验证码，输入错误返回0，输入正确返回1；
     *  */
    function check_yzm()
    {
        
        $u=$_SESSION['uinfo'];
        if(empty($u)){echo 0;return;}
    
        $rank=$_POST['rank'];
    
        $number1=$_SESSION['uinfo_phone_code'];
    
        if($rank==$number1)
        {
            echo 1;
            $_SESSION['change_tel']=$u;
            unset($_SESSION['uinfo']);
            unset($_SESSION['uinfo_phone_code']);
            
        }
        else
        {
            echo 0;
            return;
        }
        
    }
    
    function check_code()
    {
        header("Content-Type:text/html;charset=UTF-8");  // 解决乱码问题
        
        $code=$_POST['code'];
        
       if(empty($code))
       {
           return;
       }
       
       $uid=session('id');
       
       if(empty($uid))
       {
           redirect(U('Index/index'));
           return;
       }
       
       $arr_code=M('code')->where(array('name'=>'group','type'=>1,'code'=>$code))->find();
       
       if(empty($arr_code['id']))
       {
           $arr=array(0,'邀请码不存在');
           echo json_encode($arr);
           return;
       }
       
       if($arr_code['is_delect']!=0)
       {
           
           $arr=array(0,'邀请码被删除');
           echo json_encode($arr);
           return;

       }
       
       if($arr_code['end_time']<time())
       {
           
           $arr=array(0,'邀请码失效');
           echo json_encode($arr);
           return;
       }
       
       if($arr_code['use'] !=0)
       {
           $arr=array(0,'邀请码已被使用');
           echo json_encode($arr);
           return;
       }
       
       $group=M('group1')->where(array('id'=>$arr_code['eid'],'is_delect'=>0))->find();
       
       if(empty($group['id']))
       {
           $arr=array(0,'该群组不存在，请联系管理员');
           echo json_encode($arr);
           return;
       }
       
       if(!($this->check_user_nu_group($arr_code['eid'])))
       {
           $arr=array(0,'该组人数达到上限');
           echo json_encode($arr);
           return;
       }
       
       $user_group=M('user_group')->where(array('gid'=>$arr_code['eid'],'is_delect'=>0,'uid'=>$uid))->find();
       
       if(!empty($user_group['id']))
       {
           $arr=array(0,'您已加入该群组');
           echo json_encode($arr);
           return;
       }
       
       $save_code=M('code')->where(array('id'=>$arr_code['id']))->data(array('uid'=>$uid,'use'=>1))->save();
       
       if(!empty($save_code))
       {
           
           $add_user_group=M('user_group')->data(array('uid'=>$uid,'gid'=>$arr_code['eid'],'time'=>time(),'type'=>'1','is_delect'=>0))->add();
            
           if(!empty($add_user_group))
           {
               $str= '添加成功';
               
               if(!empty($arr_code['money']))
               {
               
                   if(money(10234, $arr_code['money'],4))
                   {
                       $str=$str.'充值成功,您充值的积分为'.$arr_code['money'];
                       //return;
                   }
                   else
                   {
                       $str=$str.'充值失败，您的积分充值码已失效，请与管理员联系';
                       //return;
                   }
               
               }
               $arr=array(1,$str);
               echo json_encode($arr);
               return;
           }
           else 
           {
               $arr=array(0,'添加失败，邀请码已失效，请联系管理员！');
               echo json_encode($arr);
               return;
           }
       }
       else
       {
           $arr=array(0,'网络繁忙请稍候再试');
           echo json_encode($arr);
           return;
       }
           
       
       //$add_user_group
       
       //print_r($user_group);
       
    }
    function recharge()
    {
        header("Content-Type:text/html;charset=UTF-8");  // 解决乱码问题
        
        $code=$_POST['code'];
        
        if(empty($code))
        {
            return;
        }
         
        $uid=session('id');
         
        $arr_code=M('code')->where(array('name'=>'recharge','type'=>1,'code'=>$code))->find();
         
        if(empty($arr_code['id']))
        {
            $arr=array(0,'邀请码不存在');
            echo json_encode($arr);
            return;
        }
         
        if($arr_code['is_delect']!=0)
        {
            $arr=array(0,'邀请码被删除');
            echo json_encode($arr);
            return;
        }
         
        if($arr_code['end_time']<time())
        {
            $arr=array(0,'邀请码失效');
            echo json_encode($arr);
            return;
        }
         
        if($arr_code['use'] !=0)
        {
            $arr=array(0,'邀请码已被使用');
            echo json_encode($arr);
            return;
        }
        
        $save_code=M('code')->where(array('id'=>$arr_code['id']))->data(array('uid'=>$uid,'use'=>1))->save();
         
        if(!empty($save_code))
        {
        
            if(money(10234, $arr_code['money'],3))
            {
                $jifen=jifen();
                $arr=array(1,'充值成功,您充值的积分为'.$arr_code['money'],$jifen);
                echo json_encode($arr);
                return;
            }
            else 
            {
                $arr=array(0,'充值失败，您的积分充值码已失效，请与管理员联系');
                echo json_encode($arr);
                return;
            }
        
        }
        else 
        {
            $arr=array(0,'网络繁忙请稍候再试');
            echo json_encode($arr);
            return;
        }
        //print_r($arr_code);
    }
    

    
    function security_center()
    {
        $uid=session('id');
        $user=M('user')->where(array('id'=>$uid))->find();
        $this->assign('weixin',$user['openid']);
        $this->assign('xuetang',$user['xuetang_id']);
        $this->display();
    }
    
    function code()
    {
        $uid=session('id');
        
        if(empty($uid)){redirect(U('Index/index'));return;}
        
        $user=M('user')->where(array('id'=>$uid))->find();
        
        if(!empty($user['openid'])){redirect(U('Uinfo/result',array('str'=>'该帐号已绑定微信','type'=>0)));return;}
        
        $sever=UrlEncode(C('uinfo_weixin_url'));
        $appid=C('appid');
        $url="https://open.weixin.qq.com/connect/qrconnect?appid=$appid&redirect_uri={$sever}&response_type=code&scope=snsapi_login&state=STATE#wechat_redirect";        
        Header("Location: $url");
    }
    
    function weixin()
    {

        $code = $_GET['code'];
        if(empty($code))
        {
            redirect(U('Uinfo/result',array('str'=>'扫描二维码失败，请重新扫描','type'=>0)));return;
            
            return;
        }
    
        $uinfo=R('Index/uinfo',array($code,1));
        
        $uid=session('id');
        
        if(empty($uid)){redirect(U('Index/index'));return;}
        
        $user=M('user')->where(array('openid'=>$uinfo['unionid']))->find();
        
        if(!empty($user['id'])){redirect(U('Uinfo/result',array('str'=>'该微信号已注册','type'=>0)));return;}
    
        if(is_array($uinfo))
        {
    
            if(!empty($uinfo['unionid']))
            {
                
                $user=M('user')->where(array('id'=>$uid))->data(array('openid'=>$uinfo['unionid']))->save();
                
                if(!empty($user))
                {
                    redirect(U('Uinfo/result',array('str'=>'绑定成功','type'=>1)));return;
                }
                else 
                {
                    redirect(U('Uinfo/result',array('str'=>'服务器繁忙，绑定失败，请稍候再试','type'=>0)));return;
                }
            }
            else 
            {
                redirect(U('Uinfo/result',array('str'=>'服务器繁忙，绑定失败，请稍候再试1','type'=>0)));return;
                
            }    
                    	
        }
    }
    
    function xuetangzaixian()
    {
        $uid=session('id');
        
        $user=M('user')->where(array('id'=>$uid))->find();
        
        if(!empty($user['xuetang_id'])){redirect(U('Uinfo/result',array('str'=>'该帐号已绑定学堂在线账号','type'=>0)));return;}
        
        $client_id=C('client_id');
    
        $client_secret=C('client_secret');
    
        $sever=C('xuetang');
    
        $url="http://www.xuetangx.com/api/oauth2/authorize/?state='uinfo'&nonce='222'&redirect_uri=$sever&response_type=code&client_id=$client_id&scope=openid+profile";
        	
        Header("Location: $url");
    }
    function xuetang()
    {
        $code=$_GET['code'];
        
        if(empty($code)){redirect(U('Uinfo/result',array('str'=>'学堂在线登录失败，请重新登陆','type'=>0)));return;}
    
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
    
        if(empty($user_obj['sub']))
        {
            redirect(U('Uinfo/result',array('str'=>'学堂在线登录失败，请重新登陆','type'=>0)));return; 
        }
    
        //print_r($user_obj['sub']);
    
        $list=M('user')->where(array('xuetang_id'=>$user_obj['sub']))->field('id')->find();
    
        if(!empty($list['id']))
        {
        
             redirect(U('Uinfo/result',array('str'=>'该学堂在线账号已注册','type'=>0)));return;
    
        }
        else
        {
            $uid=session('id');
            
            $data=array(
                'xuetang_id'=>$user_obj['sub'],
            );
            $re=M('user')->where(array('id'=>$uid))->data($data)->save();
            
            if(!empty($re))
            {
                redirect(U('Uinfo/result',array('str'=>'绑定成功','type'=>1)));return;
            }
            else 
            {
                redirect(U('Uinfo/result',array('str'=>'服务器繁忙，绑定失败，请稍候再试','type'=>0)));return;
            }
        }
    }
    function result()
    {
        $this->assign('type',$_GET['type']);
        
        $this->assign('str',$_GET['str']);
        
        $this->display();
    }
    function joined_group()
    {
        $uid=session('id');
        
        $list=M('group1 g')->join('left join user_group ug on ug.gid=g.id')->where(array('ug.uid'=>$uid,'ug.is_delect'=>0,'g.is_delect'=>0))->order('ug.time desc')->field('g.id,g.name,g.image')->select();    
    
        return $list;
    }
    
    function joined_my_group()
    {
        $uid=session('id');
    
        $list=M('group1 g')->join('left join user_group ug on ug.gid=g.id')->where(array('ug.uid'=>$uid,'ug.is_delect'=>0,'ug.type'=>2,'g.is_delect'=>0))->order('ug.time desc')->field('g.id,g.name,g.image')->select();
    
        return $list;
    }
    
    function uinfo_group()
    {
        $joined_group=$this->joined_group();
        
        $this->assign('joined_group',$joined_group);
        
        $joined_my_group=$this->joined_my_group();
        
        if(empty($joined_my_group[0]['id']))
        {
            $this->assign('joined_my_group','');
        }
        else 
        {
            $this->assign('joined_my_group',1);
        }
        
        //print_r($joined_group);return;
        
        $this->display();
    }
    
    function uinfo_my_group()
    {
        $joined_group=$this->joined_my_group();
    
        $this->assign('joined_group',$joined_group);
    
        //print_r($joined_group);return;
    
        $this->display();
    }
    
    function uinfo_course_group()
    {
    	header("Content-Type:text/html;charset=UTF-8");  // 解决乱码问题
    	
        $gid=$_GET['gid'];
        
        if(empty($gid) || is_numeric($gid)==false)
        {
            redirect('index');return;
        }
        
        $uid=session('id');
        
        $list=M('group1 g')->join('left join user_group ug on ug.gid=g.id')->where(array('ug.gid'=>$gid,'ug.uid'=>$uid,'ug.is_delect'=>0,'ug.type'=>2,'g.is_delect'=>0))->select();
        
        if(empty($list[0]['id'])){redirect('uinfo_my_group');return;}
        
        $this->assign('list',$list);
        
        $count=M('user_group')->where(array('gid'=>$gid,'is_delect'=>0))->count();
        
        $this->assign('count',$count);
        
        $course_group=$this->add_course_group($gid);
        
        $this->assign('course_group',$course_group);
        
        $add_bao=$this->add_bao($gid);
        
        $this->assign('add_bao',$add_bao);
        
        $this->assign('gid',$gid);
        
        $this->display();

    }
    function uinfo_user_group()
    {
    	
    	
        $gid=$_GET['gid'];
    
        if(empty($gid) || is_numeric($gid)==false)
        {
            redirect('index');return;
        }
    
        $uid=session('id');
    
        $list=M('group1 g')->join('left join user_group ug on ug.gid=g.id')->where(array('ug.gid'=>$gid,'ug.uid'=>$uid,'ug.is_delect'=>0,'ug.type'=>2,'g.is_delect'=>0))->select();
    
        if(empty($list[0]['id'])){redirect('uinfo_my_group');return;}
    
        $this->assign('list',$list);
    
        $count=M('user_group')->where(array('gid'=>$gid,'is_delect'=>0))->count();
    
        $this->assign('count',$count);
    
        $group_user=$this->group_user($gid);
    
        $this->assign('group_user',$group_user);
        
        $this->assign('gid',$gid);
        
        //print_r($group_user);return;
    
        $this->display();
    
    }
    function group_user($id)
    {
        //$id=$_GET['gid'];
         
        if(empty($id) || is_numeric($id)==false)
        {
            //$this->error('参数错误');
            return;
        }
         
        $list1=M('group1')->where(array('id'=>$id))->find();
    
        if(empty($list1['name']))
        {
            //$this->error('参数错误');
            return;
        }
        $list=M('user_group ug')->join('left join user u on u.id=ug.uid')->join('left join uinfo uf on uf.userid=ug.uid')->where(array('ug.gid'=>$id,'ug.is_delect'=>0))->order('ug.id asc')->field('u.useremail,u.usermobilenum,ug.id,ug.type,u.id as uid,uf.nikename,uf.username,uf.image')->select();
    
        return $list;
    }
    function add_course_group($id)
    {
        //$id=$_GET['gid'];
         
        if(empty($id) || is_numeric($id)==false)
        {
            //$this->error('参数错误');
            return;
        }
    
        $list1=M('group1')->where(array('id'=>$id))->find();
    
        if(empty($list1['name']))
        {
            //$this->error('参数错误');
            return;
        }
         
        $list=M('course_group cg')->join('left join course c on c.id=cg.cid')->where(array('cg.gid'=>$id,'cg.type'=>1,'cg.is_delect'=>0))->order('cg.end_time asc')->field('cg.id,c.image,c.title,cg.time,cg.end_time')->select();
    
        return $list;
    }
    function add_bao($id)
    {
        //$id=$_GET['gid'];
         
        if(empty($id) || is_numeric($id)==false)
        {
            //$this->error('参数错误');
            return;
        }
         
        $list1=M('group1')->where(array('id'=>$id))->find();
    
        if(empty($list1['name']))
        {
            //$this->error('参数错误');
            return;
        }
    
        $list=M('course_group cg')->join('left join admin_tag c on c.id=cg.cid')->join('left join course_admin_tag cat on cat.tid=c.id')->join('left join course co on co.id=cat.cid')->where(array('cg.gid'=>$id,'cg.type'=>2,'cg.is_delect'=>0,'c.is_delect'=>0,'cat.is_delect'=>0,'co.is_delect'=>0))->order('cg.end_time asc')->field('cg.id,cg.time,c.name as name,cg.end_time,cat.cid,co.image,co.title')->select();
    
        return $list;
    }
    function add_group_user()
    {
        $id=$_GET['name'];
         
        $gid=$_GET['gid'];
    
        if(empty($id) || empty($gid) || is_numeric($gid)==false)
        {
            $arr=array(0,'参数错误');
            echo json_encode($arr);
            return;
        }
    
        $group=M('group1')->where(array('id'=>$gid))->count();
         
        if(empty($group))
        {
            $arr=array(0,'该组不存在');
            echo json_encode($arr);
            return;
        }
        
        if(!($this->check_user_nu_group($gid)))
        {
            $arr=array(0,'该组人数达到上限');
            echo json_encode($arr);
            return;
        }
    
        $mail=strlen($id) > 6 && preg_match("/^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/", $id);
        $phone=strlen($id) == 11 && preg_match("/^1[3|4|5|8][0-9]\d{8}$/", $id);
    
        if($mail || $phone)
        {
            if($mail)
            {
                $user_mail=M('user')->where(array('useremail'=>$id))->find();
    
                if(empty($user_mail['id']))
                {
                    $arr=array(0,'该邮箱号未注册');
                    echo json_encode($arr);
                    return;
                }
                else
                {
                    $uid=$user_mail['id'];
                }
            }
            if($phone)
            {
                $user_mail=M('user')->where(array('usermobilenum'=>$id))->find();
    
                if(empty($user_mail['id']))
                {
                    $arr=array(0,'该手机号未注册');
                    echo json_encode($arr);
                    return;
                }
                else
                {
                    $uid=$user_mail['id'];
                }
            }
    
            $user_group=M('user_group')->where(array('uid'=>$uid,'gid'=>$gid,'is_delect'=>0))->find();
    
            if(!empty($user_group['id']))
            {
                $arr=array(0,'该用户已加入群组');
                echo json_encode($arr);
                return;
            }
            else
            {
                $list=M('user_group')->data(array('uid'=>$uid,'gid'=>$gid,'time'=>time(),'type'=>1,'is_delect'=>0))->add();
    
                if(empty($list))
                {
                    $arr=array(0,'添加失败未知错误');
                    echo json_encode($arr);
                    return;
                }
                else
                {
                    $user_group_list=M('user_group ug')->join('left join user u on u.id=ug.uid')->where(array('ug.id'=>$list))->order('ug.id desc')->field('u.useremail,u.usermobilenum,ug.id,ug.uid')->find();
                    $arr=array(1,$list,$user_group_list['usermobilenum'],$user_group_list['useremail'],$user_group_list['uid']);
                    echo json_encode($arr);
                    return;
                }
            }
        }
    
        $arr=array(0,'请输入正确的邮箱账号或手机账号');
        echo json_encode($arr);
        return;
    
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
    function buylist()
    {
    	header("Content-Type:text/html;charset=UTF-8");  // 解决乱码问题
    	
    	$uid=session('id');
    	
    	$user_course=M('course_user cu')->join('left join credit_log cl on cl.user_course_id=cu.id')->join('left join course c on c.id=cu.cid')->where(array('cu.uid'=>$uid,'cl.uid'=>$uid))->order('cu.id desc')->field('cl.id,c.title,c.image,cu.time,cu.end_time,cl.spend,cl.type')->select();
    	
    	$user_login_credit=M('credit_log')->where(array('uid'=>$uid,'type'=>array('neq',1)))->field('id,time,spend,type')->select();
    	
    	$nu=count($user_course);
    	
    	foreach ($user_login_credit as $v)
    	{
    		$user_course[$nu]=$v;
    		
    		$nu++;
    	}
    	
    	$a=0;
    	
    	foreach ($user_course as $v)
    	{
    	    $arr[]=$v['id'];
    	}
    	
    	//print_r($user_course);return;

    	//array_multisort($user_course,SORT_DESC);
    	
    	array_multisort($arr, SORT_DESC, $user_course);
    	
    	$this->assign('list',$user_course);
    	
    	$jifen=jifen();
    	
    	$this->assign('jifen',$jifen);
  
         if(isMobile())
        {
            $this->display('phone_buylist');
        }
        else
        {
            $this->display();
        } 
    }
    function phone_user_course()
    {
        $list=$this->profession();
         
        $list_course_count=count($list);
         
        $this->assign('list_course',$list);
         
        $this->assign('list_course_count',$list_course_count);
        
        if(empty($list[0]['id']))
        {
            $a='';
        }
        else
        {
            $a='111';
        }

        $this->assign('a',$a);
        
        $this->display();
    }
    function phone_user_safer()
    {
        $id=session('id');
	    (empty($id)) && $this->error("请登录！！",U('Index/index'));
	    
	    if(!(isMobile()))
	    {
	        
	        redirect(U('Uinfo/index'));
	        
	        return;
	    }

	    
	    $tel=$this->is_phone(9910);
	    
	    
 	    if(empty($tel))
	    {
	        $_SESSION['uinfo']='g_phone';
	        
	        $this->assign('type',1);
	        
	        $this->display();
	         
	        return;
	    }
	    else 
	    {
	        $this->assign('type',0);
	         
	        $this->display();
	        
	        return;
	    } 
    }
    function associator()
    {
        if(is_vip())
        {
        
            $end_time=is_vip();
            
            $this->assign('end_time',$end_time);
            
            $this->display();
        
        }
        else 
        {
            redirect('noassociator');
        }
    }
    function noassociator()
    {
        if(is_vip())
        {
            redirect('associator');
        }
        else 
        {
            $this->display();
        }
        
        
    }

    
}