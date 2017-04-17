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
        $nu=$_GET['nu'];
        
        if(is_numeric($nu)==false || empty($nu))
        {
            $nu=1;
        }
        
        $teacher_list_nu=C('teacher_list_nu');
        
        $count=M('Teacher')->count();
        
        $int=floor($count/$teacher_list_nu);
        
        $foot=$count/$teacher_list_nu;
        
        if($foot>$int)
        {
            $int++;
        }
        
        if($nu>$int)
        {
            $nu=1;
        }
        
        for($a=1;$a<=$int;$a++)
        {
            
            $arr[$a]=$a;
        
        }
        
        $this->assign('arr',$arr);
        
        $this->assign('end',$int);
        
        $this->assign('nu',$nu);
        
        //$list=M('Teacher')->page($nu,$teacher_list_nu)->select();

        $list=M('Teacher')->select();

        $this->assign('list',$list);
        //$this->display('phone_tutor_list');return;
        if(isMobile())
        {
            $this->display('phone_tutor_list');
        }
        else 
        {
            $this->display('daoshilist');
        }
        
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
        //return;
        $this->assign('course',$course);
        
        $this->assign('list',$list);

        //$this->display('phone_detail');return;
        if(isMobile())
        {
            $this->display('phone_detail');
        }
        else 
        {
            $this->display();
        }
    }
    
    function teacher_course($tid)
    {
        if(empty($tid) || is_numeric($tid)==false)
        {
            return;
        }
        
        $course_teacher=M('course_teacher ct')->join('left join course c on c.id=ct.cid ')->where(array('ct.tid'=>$tid,'c.type'=>1))->field('c.id,c.title,c.image')->select();

//         foreach ($course_teacher as $k=>$v)
//         {
//             $cid[$k]=$v['cid'];
//         }

        $nu=count($course_teacher);

        if($nu>2)
        {
            $arrr=NoRand(0,$nu-1,2);

            $a=0;
        
            foreach ($arrr as $k=>$v)
            {
                $course[$a]=$course_teacher[$v];
                $a++;
            }

            
        }
        else 
        {
            $course=$course_teacher;
        }
        
        //$course=M('course')->where(array('id'=>array('in',$cidarr)))->field('id,title,image')->select();

        return $course;
    }

}
