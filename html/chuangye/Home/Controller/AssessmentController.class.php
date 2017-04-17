<?php
namespace Home\Controller;

use Think\Controller;

use Think\Log;

class AssessmentController extends Controller {
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
    
        $this->assign('phone_head','Assessment');
    }
    
    function index()
    {
        $jssdk=A("Jssdk");
        $signPackage = $jssdk->GetSignPackage();
        $this->assign('appid_fenxiang',$signPackage['appId']);
        $this->assign('timestamp_fenxiang',$signPackage['timestamp']);
        $this->assign('nonceStr_fenxiang',$signPackage['nonceStr']);
        $this->assign('signature_fenxiang',$signPackage['signature']);
        $this->assign('url_fenxiang',$signPackage['url']);
        $this->assign('img_fenxiang',C('headimg').'./images/320chuang.png');
        $this->assign('title_fenxiang',$weike['title']);
        $this->assign('desc_fenxiang','');
        $this->display();
    }
    
}
?>