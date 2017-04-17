<?php
namespace Home\Controller;

use Think\Controller;

class InformationController extends Controller {
    
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
        
        $this->assign('phone_head','information');
        
    }
    
    function index()
    {
        //wenjign delete
        /*if(!isMobile())
        {
            if(!is_vip())
            {
              redirect(U('Pay/result',array('str'=>'栏目正在建设(请开通会员观看干货内容)','type'=>2,'cid'=>'vip')));return;
              return;                
            }
        }*/
       	
       	$informationtop=$this->toutiao(8097);
       	
       	$uid=$informationtop['url'];
        if(is_numeric($uid)==false){}
        else
        {
       	    $toutiao=$information=M('information')->where("id=$uid")->find();
        
       	    $toutiao_img=$informationtop['img'];
       	    
       	    $toutiao_title=$toutiao['title'];
       	    
       	    $this->assign('toutiao_img',$toutiao_img);
       	    
       	    $this->assign('toutiao_title',$toutiao_title);
       	    
       	    $this->assign('toutiao_id',$toutiao['id']);
        }
       	
       	//log信息
       	write_log('information',0);
       	
       	
       	
       	$getinfor_renqi=$this->getinfor_renqi(1);
        
       	$this->assign('getinfor_renqi',$getinfor_renqi);
       	
       	$list_nice_course=get_nice_course();
       	
       	$nu=count($list_nice_course);
       	
       	if($nu>2)
       	{
       	    $arrr=NoRand(0,$nu-1,2);
       	
       	    $a=0;
       	
       	    foreach ($arrr as $k=>$v)
       	    {
       	        $arr_list_nice_course[$a]=$list_nice_course[$v];
       	        $a++;
       	    }
       	    $this->assign('list_nice_course',$arr_list_nice_course);
       	}
       	else
       	{
       	    $this->assign('list_nice_course',$arr_list_nice_course);
       	}
       		
		//banner
		$banner=M('banner')->where('is_delect != 1')->limit(1)->order('id desc')->select();
		$this->assign('banner',$banner);
       	
        //$this->display('phone_information');RETURN;

		
        if(isMobile())
        {
            if(is_ios()=='ios')
            {
                $this->assign('is_phone','ios');
            }
            
            $this->display('phone_information');
        }
        else
        {
            $this->display();
        }
    }
    /*
     * 蔡政
     * 获取头条
     *
     *  */
    function toutiao($key)
    {
        (!($key==8097)) && $this->error('禁止访问');
    
        header("Content-Type:text/html;charset=UTF-8");  // 解决乱码问题
    
        $informationtop=M('informationtop')->where('type=1')->limit(1)->order('id desc')->find();
    
        return $informationtop;
        
    }
    function information_details()
    {
        $id=$_GET['id'];
        
        //log信息
        write_log('information',$id);
        
        log_all('information',$id);
        
        $this->addrenqi(7735, $id);
        
        $getinfor=$this->getinfor(1112, $id);
        
        $this->assign('img_fenxiang',C('headimg').$getinfor[0]['img']);
        
        $this->assign('title_fenxiang',$getinfor[0]['title']);
        
        $this->assign('desc_fenxiang',$getinfor[0]['brief']);
        
        $jssdk=A("Jssdk");
        $signPackage = $jssdk->GetSignPackage();
        $this->assign('appid_fenxiang',$signPackage['appId']);
        $this->assign('timestamp_fenxiang',$signPackage['timestamp']);
        $this->assign('nonceStr_fenxiang',$signPackage['nonceStr']);
        $this->assign('signature_fenxiang',$signPackage['signature']);
        $this->assign('url_fenxiang',$signPackage['url']);
        
        $this->assign('getinfor',$getinfor);
        
        $getup['id']  = array('gt',$id);
        
        $getup['is_delect'] =array('neq',1);
        
        $getup['type'] =0;
        
        $upid=M('information')->where($getup)->order('id asc')->find();
        
        $this->assign('upid',$upid['id']);
        
        $this->assign('upname',$upid['title']);
        
        $getdown['id']  = array('lt',$id);
        
        $getdown['is_delect'] =array('neq',1);
        
        $getdown['type'] =0;
        
        $downid=M('information')->where($getdown)->order('id desc')->find();
        
        $this->assign('downid',$downid['id']);
        
        $this->assign('downname',$downid['title']);
        
        $list_nice_course=get_nice_course();
        
        $nu=count($list_nice_course);
        
        if($nu>2)
        {
            $arrr=NoRand(0,$nu-1,2);
        
            $a=0;
        
            foreach ($arrr as $k=>$v)
            {
                $arr_list_nice_course[$a]=$list_nice_course[$v];
                $a++;
            }
            $this->assign('list_nice_course',$arr_list_nice_course);
        }
        else
        {
            $this->assign('list_nice_course',$arr_list_nice_course);
        }
        
        
        //banner
        $banner=M('banner')->where('is_delect != 1')->limit(1)->order('id desc')->select();
        $this->assign('banner',$banner);
        
        //$this->display('phone_information_details'); return;
        
        if(isMobile())
        {
            $this->display('phone_information_details');
        }
        else
        {
            $this->display();
        }
    }

    /*
     * 蔡政
     * 获取资讯
     * 输入id，输出资讯信息
     *  */
    function getinfor($key,$id)
    {
        (!($key==1112)) && $this->error('禁止访问');
    
        header("Content-Type:text/html;charset=UTF-8");  // 解决乱码问题
    
        $information=M('information');
        
        $where['id']=$id;
    
        $list=$information->where($where)->select();
    
        return $list;
    }

    /* 
     * 蔡政
     * 按<!-- 人气--> 时间 获取资讯
     *  
     *  */
    function getinfor_renqi($n)
    {
        $information_nu=C('information_nu')+1;
    
        header("Content-Type:text/html;charset=UTF-8");  // 解决乱码问题
    
        $information=M('information');
    
        /* $list=$information->order('mark_bit desc,nu desc')->page($n,$information_nu)->select(); */
        
        $list=$information->order('time desc')->page($n,$information_nu)->where('is_delect !=1 and type=0')->select();
        
        $a=0;
        
        foreach ($list as $k=>$v)
        {
            $time_ad=time_ad($v['time']);
            
            $list[$a]['time_ad']=$time_ad;
            
            $list[$a]['nu_add']=$v['information_user_add']+$v['nu'];
            
            $a++;
        }
        
        
        
        if(empty($list))
        {
            echo 1;
            
            return;
        }
        
        if($n==1)
        {
/*             $a=0;
            
            foreach ($list as $k=>$v)
            {
                if($a!=0)
                {
                    $arr[$a-1]=$v;
                }
            
                $a++;
            } */
            
            return $list ;
        }
        else 
        {
            echo json_encode($list);
        }
        
    }
    function addrenqi($key,$id)
    {
        header("Content-Type:text/html;charset=UTF-8");  // 解决乱码问题
            
            (!($key==7735)) && $this->error('禁止访问','../Index/index');
            
            $information=M('information');
        
            $where['id']=$id;
        
            $list_information=$information->where($where)->find();
            
            $information_user_add=$list_information['information_user_add'];
            
            $information_user_add++;
            
            $data['information_user_add']=$information_user_add;
            
            $information->where($where)->save($data);
            
            $information_user=M('information_user');
            
            $where_information_user['inid']=$id;
            
            $where_information_user['time']=time();
            
            $uid=session('id');
            
            $where_information_user['uid']=$uid;
            
            $information_user->add($where_information_user);
    }
    
}