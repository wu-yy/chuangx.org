<?php
namespace Home\Controller;

use Think\Controller;

class TeacherController extends Controller {
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
    
    function alltutor_list()
    {
        $list=M('Teacher')->select();
        
        $this->assign('list',$list);
        
        //print_r($list);return;
        
        $this->display();
    }
    
    function alltutor()
    {
        $tid=$_GET['tid'];
        
        if(empty($tid) || is_numeric($tid)==false)
        {
            redirect(U('alltutor_list'));return;
        }
        
        $list=M('Teacher')->where(array('id'=>$tid))->find();
        
        if(empty($list['id']))
        {
            redirect(U('alltutor_list'));return;
        }
        
        $list['body']=str_replace(array("\r\n", "\r", "\n"), "<br />", $list['body']);
        
        $list['body']=str_replace('\'','"',$list['body']);
        
        $course=$this->teacher_course($tid);
        
        $this->assign('course',$course);
        
        $this->assign('list',$list);
        
        $this->display();
    }
    
    function teacher_course($tid)
    {
        if(empty($tid) || is_numeric($tid)==false)
        {
            return;
        }
        
        $course_teacher=M('course_teacher')->where(array('tid'=>$tid))->select();
        
        foreach ($course_teacher as $k=>$v)
        {
            $cid[$k]=$v['cid'];
        }
        
        $nu=count($cid);
        
        if($nu>2)
        {
            $arrr=NoRand(0,$nu-1,2);
        
            $a=0;
        
            foreach ($arrr as $k=>$v)
            {
                $cidarr[$a]=$cid[$v];
                $a++;
            }
            
            
        }
        else 
        {
            $cidarr=$cid;
        }
        
        $course=M('course')->where(array('id'=>array('in',$cidarr)))->field('id,title,image')->select();
        
        return $course;
    }

}
