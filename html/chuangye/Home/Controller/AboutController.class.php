<?php
namespace Home\Controller;

use Think\Controller;

class AboutController extends Controller {
    
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
        
        $user_group=fenzhan();
        
        $this->assign('user_group',$user_group);
    }
    
    function index()
    {
        
        
        $aid=$_GET['aid'];
        
        
        if(empty($aid))
        {
            $aid=1;
        }
        
        $this->assign('aid',$aid);
        
        $this->display();
    }
    
}