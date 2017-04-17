<?php
namespace Home\Controller;

use Think\Controller;

$sousuo = "";

function console_log($data)  
{  
    if (is_array($data) || is_object($data))  
    {  
        echo("<script>console.log('".json_encode($data)."');</script>");  
    }  
    else  
    {  
        echo("<script>console.log('".$data."');</script>");  
    }  
}  

class SousuoController extends Controller {
    
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
	    $sousuo=I('sousuo');//获取表单提交时名为'sousuo'的值，即输入
	    
	    $id=$_SESSION['id'];
	    $this->assign('sousuo',$sousuo);
	    $this->assign('wenjing', 12300);
	    
        $this->display();
        
	}

	function course_show(){
		//echo "in course_show";
		$sousuo=$_GET['sousuo'];//获取表单提交时名为'sousuo'的值，即输入
	    //if($sousuo == "")
	    //	echo "ceshi";
	    //else
	    //	echo "other";
	    //$id=$_SESSION['id'];
	    
	    $numC=I('numC');
	    //echo $id;
	    if(empty($numC))
	    {
	        $numC=1;
	    }
	    $arr = $this->findcourseInAll($sousuo);
	    if(empty($arr))//没搜索到内容，就重定向到
        {
            redirect(U('no_content',array('sousuo'=>$sousuo)));
            return;
        }
        $arrwenjing = $arr;
       // echo $numC;
	    $course_nu=C('course_nu');//每页显示课程数目	    
	    $nu = ceil(count($arr)/$course_nu);//页数,向上取整
	    $course=M('course');
	    $where['id']=array('in',$arr);//'in'表示在里面，id都是course里的'id'
	    $cc = $course->where($where)->where(array('is_delect'=>0,'show_course'=>0,'type'=>1))->select();
	    $nuC = ceil(count($cc)/$course_nu);

	    $c=1;                   
        for($b=0;$b<$nuC;$b++)
        {
            $arr1[$b]['number']=$c;             
            $c++;   
        }

        $list_course=$course->where($where)->where(array('is_delect'=>0,'show_course'=>0,'type'=>1))->page($numC,$course_nu)->select();
        $course_teacher=M('course_teacher');
	    
	    $b=0;
	    foreach ($list_course as $k=>$v)//find the teacher of course found
	    {
	        $where_course_teacher['cid']=$v['id'];
	    
	        $list_course_teacher=$course_teacher->where($where_course_teacher)->select();
	    
	        $a=0;
	    
	        unset($arr);//销毁arr
	    
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
	    
	        $b++;
	    }
	    
	    $a=0;
	    
	    foreach ($list_course as $kc=>$vc)
	    {
	        $list_course[$a]['title']=str_replace($sousuo,"<font color='red'>".$sousuo.'</font>',$vc['title']);
	    	//$list_course[$a]['title']=str_replace($sousuo,'文静',$vc['title']);
	    
	        $list_course[$a]['teacher_name']=str_replace($sousuo,"<font color='red'>".$sousuo.'</font>',$vc['teacher_name']);
	        
	        $list_course[$a]['nu_add']=$vc['course_user_add']+$vc['nu'];
	        
	        $a++;
	    }
	    $this->assign('list_course',$list_course);
	    $this->assign('arrC',$arr1);
	    $add_nuC=count($arr1);
	    $this->assign('add_nuC',$add_nuC);
	    $this->assign('nuC',$numC);
	    $this->assign('sousuo',$sousuo);
	    $this->assign('wenjing', 123456789);
	    $this->assign('arr', $arr);
	    $this->assign('course_', $list_course);
	   // dump($arrwenjing);
	   // echo $arrwenjing[0];
        $this->display();
	}

	function weike_show(){

	    $sousuo=$_GET['sousuo'];//获取表单提交时名为'sousuo'的值，即输入
	    
	    $id=$_SESSION['id'];
	    
	    $numW = I('numW');
	    
	    if(empty($numW))
	    	$numW = 1;
	    
	    $arr = $this->findcourseInAll($sousuo);
	    if(empty($arr))//没搜索到内容，就重定向到
        {
            redirect(U('no_content',array('sousuo'=>$sousuo)));
            return;
        }

	    $course_nu=C('course_nu');//每页显示课程数目
	    
	    $nu = ceil(count($arr)/$course_nu);//页数,向上取整
	    
	    $course=M('course');
	    $where['id']=array('in',$arr);//'in'表示在里面，id都是course里的'id'

	    $ww = $course->where($where)->where(array('is_delect'=>0,'show_course'=>0,'type'=>2))->select();
	    $nuW = ceil(count($ww)/$course_nu);

        $c = 1;
        for($b=0;$b<$nuW;$b++)
        {
            $arr2[$b]['number']=$c;
              
            $c++;
    
        }
        
	    
	    //$con['is_delect'] = 0;
	    //$con['show_course'] = 0;
	    //$con['_string'] = 'type = 1 OR type = 2'; 
	    //$list_course=$course->where($where)->where($con)->page($num,$course_nu)->select();
	    $list_weike = $course->where($where)->where(array('is_delect'=>0,'show_course'=>0,'type'=>2))->page($numW,$course_nu)->select();
	    $course_teacher=M('course_teacher');
	    $b=0;
	    
	    foreach ($list_weike as $k=>$v)//find the teacher of course found
	    {
	    
	    
	        $where_course_teacher['cid']=$v['id'];
	    
	        $list_course_teacher=$course_teacher->where($where_course_teacher)->select();
	    
	        $a=0;
	    
	        unset($arr);//销毁arr
	    
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
	    
	            $list_weike[$b]['teacher_name']=$all_teacher_name;
	        }
	        else
	        {
	            $list_weike[$b]['teacher_name']="导师信息暂无";
	        }
	    
	        $b++;
	    }
	    
	    $a=0;
	    
	    foreach ($list_weike as $kc=>$vc)
	    {
	        $list_weike[$a]['title']=str_replace($sousuo,"<font color='red'>".$sousuo.'</font>',$vc['title']);
	    
	        $list_weike[$a]['teacher_name']=str_replace($sousuo,"<font color='red'>".$sousuo.'</font>',$vc['teacher_name']);
	        
	        $list_weike[$a]['nu_add']=$vc['course_user_add']+$vc['nu'];
	        
	        $a++;
	    }

	    $this->assign('list_weike', $list_weike);
	    
	    $this->assign('arrW', $arr2);
	   
	    $add_nuW = count($arr2);
	    $this->assign('add_nuW', $add_nuW);
	    
	    $this->assign('nuW', $numW);//num is the num  from index.html

	    $this->assign('sousuo',$sousuo);
	    $this->assign('wenjing', 123);
        
        $this->display();
	}
	//find course(course and weike) in title , teacher, and dagang 
	//return the course id array
	//wenjing 
	function findcourseInAll($sousuo){
		$findcourse=$this->findcourese($sousuo,9980);	    
	    $findteachercourse=$this->findteachercourse($sousuo, 9910);	    
	    $finddagang=$this->finddagang($sousuo, 99210);	    
		$a = 0;	    
	    foreach ($findcourse as $k=>$v)//在课程title里查找
	    {
	    	$arr[$a]=$v;
	        $a++;
	    }
	    foreach ($findteachercourse as $k1=>$v1) //老师也在查找范围内,v1表示的是该老师的课程的id
	    {
	        $arr[$a]=$v1;
	        $a++;
	    }	    
	    foreach ($finddagang as $k1=>$v1)//在课程概况里查找
	    {
	      	$arr[$a]=$v1;
	       	$a++;
	    }	    
	    $arr = array_unique($arr);//去重
	    return $arr;
	}

	//function courseTeacher($course_list)
	function findcourese($sousuo,$key)
	{
	    header("Content-Type:text/html;charset=UTF-8");  // 解决乱码问题
	    
	    (!($key==9980)) && $this->error("禁止访问!!",U('Index/index'));
	    
	    $course_nu=C('course_nu');
	    
	    $course=M('course');
	    
	    $where['title']=array('like',"%".$sousuo."%");//前后都有“%”，表示要找包含该内容的项，sousuo是输入的内容
	    
	    $con['is_delect'] = 0;
	    $con['show_course'] = 0;
	    $con['_string'] = 'type = 1 OR type = 2';
	   // $list=$course->where($where)->where(array('is_delect'=>0,'show_course'=>0,'type'=>2))->select();//该查找把微课排除掉的
	    $list=$course->where($where)->where($con)->select();

	    $a=0;
	    
	    foreach ($list as $k=>$v)
	    {
	        $arr[$a]=$v['id'];
	        
	        $a++;
	    }
	    
	    if(empty($arr[0]))
	    {
	        return;
	    }
	    else 
	    {
	        return $arr;
	    }
/* 	    $a=0;
	    
	    foreach ($list as $k=>$v)
	    {
	        $new_title=str_replace($sousuo,"<font color='red'>".$sousuo.'</font>',$v['title']);
	    
	        $list[$a]['title']=$new_title;
	        
	        $a++;
	    } */
	}
	
	function findteachercourse($sousuo,$key)
	{
	    header("Content-Type:text/html;charset=UTF-8");  // 解决乱码问题
	    
	    (!($key==9910)) && $this->error("禁止访问!!",U('Index/index'));
	    
	    $teacher=M('teacher');//在teacher表里搜索
	    
	    $where['name']=array('like',"%".$sousuo."%");
	    
	    $list=$teacher->where($where)->select();
	    
	    $a=0;
	    
	    foreach ($list as $k=>$v)
	    {
	        $arr[$a]=$v['id'];
	        
	        $a++;
	    }
	    
	    if(empty($arr[0]))
	    {
	        return;
	    }
	    else 
	    {
	        $course_teacher=M('course_teacher');
	        
	        $where_course_teacher['tid']=array('in',$arr);
	        
	        $list_course_teacher=$course_teacher->distinct(true)->where($where_course_teacher)->field ( 'cid' )->select();
	        
	        if(empty($list_course_teacher[0]['cid']))
            {
                return;
            }
            else 
            {
                $a=0;
                
                foreach ($list_course_teacher as $lc=>$lct)
                {
                    $arr_cid[$a]=$lct['cid'];
                    
                    $a++;
                }
                
                if(empty($arr_cid[0]))
                {
                    return;
                }
                else 
                {
                    $course=M('course');
                    
                    $where_course['id']=array('in',$arr_cid);
                    
                    $con['is_delect'] = 0;
                    $con['show_course'] = 0;
                    $con['_string'] = 'type = 1 OR type = 2';
                    //$list_course=$course->where($where_course)->where(array('is_delect'=>0,'show_course'=>0,'type'=>2))->field ( 'id' )->select();//array('type'=>1,'type'=>2,'or')
                    $list_course = $course->where($where_course)->where($con)->field('id')->select();

                    $a=0;
                    
                    foreach ($list_course as $k=>$v)
                    {
                        $arr_id[$a]=$v['id'];
                        
                        $a++;
                    }
                    
                    return $arr_id;
                }
            }
	    }

	    
	}
	function finddagang($sousuo,$key)
	{
	    header("Content-Type:text/html;charset=UTF-8");  // 解决乱码问题
	     
	    (!($key==99210)) && $this->error("禁止访问!!",U('Index/index'));
	    
	    $course=M('course');
	     
	    $where['outline']=array('like',"%".$sousuo."%");
	    
	    $con['is_delect'] = 0;
        $con['show_course'] = 0;
        $con['_string'] = 'type = 1 OR type = 2'; 
	    //$list=$course->where($where)->where(array('is_delect'=>0,'show_course'=>0,'type'=>2))->select();
	    $list=$course->where($where)->where($con)->select();
	     
	    $a=0;
	     
	    foreach ($list as $k=>$v)
	    {
	        $arr[$a]=$v['id'];
	         
	        $a++;
	    }
	    
	    if(empty($arr[0]))
	    {
	        return;
	    }
	    else
	    {
	        return $arr;
	    }
	}
	//wenjing change the numW from Sousuo/index.html
	function changenumW(){
		$n=$_GET['n'];
		$_SESSION['numW']=$n;
		if(!empty($_SESSION['numW']))
            echo 1;
        else
            echo 0;
	}

	//wenjing change the numC from Sousuo/index.html
	function changenumC(){
		$n=$_GET['n'];
		$_SESSION['numC']=$n;
		if(!empty($_SESSION['numC']))
            echo 1;
        else
            echo 0;
	}
	function no_content()
	{
	    $sousuo=I('sousuo');
	    
	    $this->assign('sousuo',$sousuo);
	    
	    $id=$_SESSION['id'];
	    
	    $this->display();
	}
	
}
?>