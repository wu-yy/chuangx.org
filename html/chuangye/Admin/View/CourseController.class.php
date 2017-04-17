<?php
namespace TestHome\Controller;

use Think\Controller;

class CourseController extends Controller {
    function index()
    {
        
        $name=username();
        	 
       	$this->assign('username',$name);
       	
       	$list1=M('tag')->where('pid=0')->find();
       	
       	$tid=$list1['id'];
       	
       	$list=M('tag')->where("pid=$tid")->select();
       	
       	$list_biao1[0]=$list[0];
       	
       	$list_biao2[0]=$list[1];
       	
       	$this->assign('list_biao1',$list_biao1);
       	
       	$this->assign('list_biao1_id',$list_biao1[0]['id']);
       	
       	$this->assign('list_biao2_id',$list_biao2[0]['id']);
       	
       	$this->assign('list_biao2',$list_biao2);
       	
       	$list=sousuo_tag($list_biao1[0]['id']);
       	
       	$this->assign('list',$list);
       	
       	$list1=sousuo_tag($list_biao2[0]['id']);
       	
       	$this->assign('list1',$list1);
       	
       	$userimg=userimg();
       		
       	$this->assign('userimg',$userimg);
       	

         
        $this->display();
    }
    function course_details($cid)
    {
    	
    	$name=username();
        	 
        $this->assign('username',$name);
        
        $info=$this->kecheng_mingxi(7100, $cid);
        
        $teacher=$info['a'];
        
        $this->assign('teacher',$teacher);
        
        $course=$info['b'];
        
        $this->assign('course',$course);
        
        $tagname=$this->biaoqian(6667,$cid);
        
        $this->assign('tagname',$tagname);
        
        $an_course=$this->an_course($cid);
        
        if(!empty($an_course[0]))
        {
        
        $course=M('course');

        $where_c['id']=array('in',$an_course);
        
        $list_c=$course->where($where_c)->select(); 
        
        $this->assign('list_c',$list_c);
        
        }
        
        $userimg=userimg();
        	
        $this->assign('userimg',$userimg);
        
        $this->display();
        
    }
    /* 
     * 蔡政
     * 输入课程id
     * 输出标签内容 
     *  */
    function biaoqian($key,$cid)
    {
        (!($key==6667)) && $this->error('禁止访问','../Index/index');
        
        $course_tag=M('course_tag');
        
        $where['cid']=$cid;
        
        $list=$course_tag->where($where)->select();
        
        for($a=0;$a<count($list);$a++)
        {
            $arr[$a]=$list[$a]['code'];
        }
        if(empty($arr[0]))
        {
            $tagname='标签信息暂无';
            
            return $tagname;
        }
        
        $tag=M('tag');
        
        $where_tag['code']=array(in,$arr);
        
        $biaoqian=$tag->where($where_tag)->select();
        
        for($a=0;$a<count($biaoqian);$a++)
        {
        $tagname[$a]=$biaoqian[$a]['name'];
        }
        
        $tagname=implode(',',$tagname);
        
        return $tagname;
    }
    function course_lie()
    {

          $this->sess(session('num'));
          
          $num=session('num');
        
          $nu=$this->count_score(7031);
          
          $a=1;
                    
          for($b=0;$b<$nu;$b++)
          {
              $arr[$b]['number']=$a;
              
              $a++;

          }
          
          $list_course=$this->sort_time(7000,$num);
        
          $this->assign('list',$list_course);
          
          $this->assign('arr',$arr);
          
          $add_nu=count($arr);
          
          $this->assign('add_nu',$add_nu);
          
          $this->assign('nu',$num);

          $this->display();
    }
    public function course_hang()
    {
          
          $this->sess(session('num'));
          
          $num=session('num');
        
          $nu=$this->count_score(7031);
          
          $a=1;
                    
          for($b=0;$b<$nu;$b++)
          {
              $arr[$b]['number']=$a;
              
              $a++;

          }
          
          $list_course=$this->sort_time(7000,$num);
        
          $this->assign('list',$list_course);
          
          $this->assign('arr',$arr);
          
          $add_nu=count($arr);
          
          $this->assign('add_nu',$add_nu);
          
          $this->assign('nu',$num);

          $this->display();
    }
    
    function renqi()
    {
        $_SESSION['sort']='renqi';
        
        if(!empty($_SESSION['sort']))
             echo 1;
        else 
             echo 0;
    }
    function num()
    {
        $n=$_GET['n'];
        
        $_SESSION['num']=$n;
    
        if(!empty($_SESSION['num']))
            echo 1;
        else
            echo 0;
    }
    function zonghe()
    {
        $_SESSION['sort']='zonghe';
    
        if(!empty($_SESSION['sort']))
            echo 1;
        else
            echo 0;
    }
    function detag()
    {
        unset($_SESSION['tag_id']);
    }
    function shuaxintag()
    {
        $_SESSION['tag_id']=$_GET[id];
    
        if(!empty($_SESSION['tag_id']))
        {
            echo 1;
            
            $_SESSION['num']=1;
        }
        else
            echo 0;
    }
    /*
     * 蔡政
     * 20151216
     * 查询课程首页信息
     *  */
    function sort_time($key,$num)
    {
    
        (!($key==7000)) && $this->error('禁止访问','../Index/index');
        
        
        
        if(session('sort')=="renqi")
        {
    
            $list_course=$this->descscore1(7020,$num);
            
        }
        else 
        {
            $list_course=$this->descscore(7010,$num);
        }
    
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
    
            $b++;
        }
        return $list_course;
    }
    /*
     * 蔡政
     * 按时间查询
     *  */
    function descscore($key,$num)
    {
        (!($key==7010)) && $this->error('禁止访问','../Index/index');
        
        if(empty($num))
        {
            $num=1;
        }
        
        $course=M('course');
        
        $course_nu=C(course_nu);
        
/*         $arr=array(1,2);
        
        $where['id']=array(in,$arr); */
        
        $tag_id=session('tag_id');
        
        if(!empty($tag_id))
        {
            $arr=$this->gettagarr($tag_id);
            
            if(!empty($arr))
            $where['id']=array(in,$arr);
            else
            {
                echo '<div style="margin-top:100px;"><center><font size="5">对不起，此标签下暂无课程，敬请期待</font></center></div>';
                return;
            }
        }
        $list_course=$course->where($where)->where('is_delect != 1')->order('id desc')->page($num,$course_nu)->select();
    
        return $list_course;
    }
    /* 
     * 蔡政
     * 按评分查询 
     *  */
    function descscore1($key,$num)
    {
        (!($key==7020)) && $this->error('禁止访问','../Index/index');
        
        if(empty($num))
        {
            $num=1;
        }
    
        $course=M('course');
        
        $course_nu=C(course_nu);
        
        $tag_id=session('tag_id');
        
        if(!empty($tag_id))
        {
            $arr=$this->gettagarr($tag_id);
            if(!empty($arr))
            $where['id']=array(in,$arr);
            else
            {
                echo '<div style="margin-top:100px;"><center><font size="5">对不起，此标签下暂无课程，敬请期待</font></center></div>';
                return;
            }
        }
        $list_course=$course->where($where)->where('is_delect != 1')->order('nu desc')->page($num,$course_nu)->select();
    
        return $list_course;
    }
    /* 
     * 蔡政
     * 20151216
     * 每页显示$b条数据，返回页数
     *  */
    function count_score($key)
    {
        (!($key==7031)) && $this->error('禁止访问','../Index/index');
        
        $course_nu=C(course_nu);
        
        $tag_id=session('tag_id');
        
        if(!empty($tag_id))
        {
            $arr=$this->gettagarr($tag_id);
            
            if(!empty($arr))
            {
                $count=count($arr);
                
                $course=M('course');
                
                $where['id']=array('in',$arr);
                
                $arr1=$course->where($where)->where('is_delect != 1')->order('nu desc')->count();
                
                $nu=ceil($arr1/$course_nu);
                
                return $nu;
            }
            else
            {
                return;
            } 
            
        }   
        
            $course=M('course');
        
            $nu_course=$course->where('is_delect != 1')->order('nu desc')->count();
            
            $nu=ceil($nu_course/$course_nu);
        
            return $nu;
    }
    /* 
     * 蔡政
     * 输入id;
     * 获取当前访问标签的子标签id数组  
     *  */
    function  gettagarr($id)
    {
        header("Content-Type:text/html;charset=UTF-8");  // 解决乱码问题
        
        $tag=M('tag');
        
        $where['id']=$id;
        
        $list=$tag->where($where)->where("is_delect != 1")->find();
        
        if(empty($list))
        {
            echo "标签已被删除！";
            return;
        }
        
        $where_arr['code']=array('like',$list['code']."%");
        
        $list_arr=$tag->where($where_arr)->where("is_delect != 1")->select();
        
        for($a=0;$a<count($list_arr);$a++)
        {
            $arr[$a]=$list_arr[$a]['id'];
        }
        
        $course_tag=M('course_tag');
        
        $where_tag['tid']=array(in,$arr);
        
        $list_tag_arr=$course_tag->where($where_tag)->select();
        
        for($a=0;$a<count($list_tag_arr);$a++)
        {
        $arr_tag[$a]=$list_tag_arr[$a]['cid'];
        }
        
        $arr_tag=array_unique($arr_tag);
        
        return $arr_tag;
    }
    
    /* 
     * 蔡政
     *  
     *  输入课程id，输出课程内容（包括导师信息和游览量）
     *  */
    function kecheng_mingxi($key,$cid)
    {
        header("Content-Type:text/html;charset=UTF-8");  // 解决乱码问题
    
        (!($key==7100)) && $this->error('禁止访问','../Index/index');
        
        $b=0;
    
        $course=M('course');
        
        $where['id']=$cid;
        
        $list_course=$course->where($where)->select();
    
        $course_teacher=M('course_teacher');
    
        $where_course_teacher['cid']=$list_course[0]['id'];
    
        $list_course_teacher=$course_teacher->where($where_course_teacher)->select();

        
            $a=0;
            
            foreach ($list_course_teacher as $k=>$v)
            {
                 
                $arr[$a]=$v['tid'];
    
                $a++;
    
            }
            
            if(empty($arr[0]))
            {
            
                $list_course[$b]['teacher_name']='导师信息暂无';
            
                $abc['b']=$list_course;
                
                return $abc;
            } 
            
            $teacher=M('teacher');
    
            $where_teacher['id']=array('in',$arr);
    
            $abc['a']=$list_teacher=$teacher->where($where_teacher)->select();/* 导师信息，需要 */

            
            $a=0;
    
            unset($arr_teacher_name);
    
            foreach ($list_teacher as $k=>$v)
            {
                $arr_teacher_name[$a]=$v['name'];
    
                $a++;
            }
    
            $all_teacher_name=implode(',',$arr_teacher_name);
    
            $list_course[$b]['teacher_name']=$all_teacher_name;
            
            if(empty($all_teacher_name))
            {
                $all_teacher_name='导师信息暂无';
            }
            
            $abc['b']=$list_course;
    
            $b++;
            
            return ($abc) ;
        }
        /* 
         * 蔡政
         * 统计课程游览量
         * 进入页面向游览课程表中插入数据 
         *  */
        function adlook($key,$id)
        {
            
            header("Content-Type:text/html;charset=UTF-8");  // 解决乱码问题
            
            (!($key==7735)) && $this->error('禁止访问','../Index/index');
            
            $course=M('course');
        
            $where['id']=$id;
        
            $list_course=$course->where($where)->find();
            
            $nu=$list_course['nu'];
            
            $nu++;
            
            $data['nu']=$nu;
            
            $course->where($where)->save($data);
            
            $course_user=M('course_user');
            
            $where_course_user['cid']=$id;
            
            $where_course_user['time']=time();
            
            $uid=session('id');
            
            if(!empty($uid))
            {
                $where_course_user['uid']=$uid;
                
            }
            else 
            {
                $where_course_user['uid']='';
            }
            
            $course_user->add($where_course_user);
            
            if(empty($course_user))
            {
                return 0;
            }
            else
            {
                return 1;
            } 

            
        }
        function sess($mun)
        {
            if(empty($mun))
            {
                $_SESSION['num']=1;
            }
        }
        function void()
        {
            $id=session('id');
            
            (empty($id)) && $this->error('请先登录');
        	
        	header("Content-Type:text/html;charset=UTF-8");  // 解决乱码问题
			
        	$name=username();
        	 
        	$this->assign('username',$name);
        	
        	$cid=$_GET['cid'];
        	
        	$kcname=$_GET['kcname'];
        	
        	$zhangjie=$this->jie(7766,$cid);
        	
        	$zhang=$this->zhang(7766,$cid);
        	
        	$a=0;
        	
        	foreach ($zhang as $k=>$v)
        	{
        	    $add[$a]=$v;
        	    
        	    $a++;
        	    
        	    foreach ($zhangjie as $c=>$f)
        	    {
        	        if($v['id']==$f['is_zhangjie'])
        	        {
        	            $add[$a]=$f;
        	            
        	            $a++;
        	        }
 
        	    }
        	    
        	    $b++;
        	}

        	
        	$this->assign('add',$add);
        	
        	$this->assign('zhangjie',$zhangjie);
        	
        	$n=count($zhang);
        	
        	if($n==1)
        	{
        	    $an_course=$this->an_course($cid);
        	    
            	if(!empty($an_course[0]))
                {
                
                $course=M('course');
        
                $where_c['id']=array('in',$an_course);
                
                $list_c=$course->where($where_c)->select(); 
                
                $this->assign('list_c',$list_c);
                
                }

        	}
        	
        	$this->assign('n',$n);
        	
        	$this->assign('cid',$cid);
        	
        	$this->assign('kcname',$kcname);
        	
        	$userimg=userimg();
        	 
        	$this->assign('userimg',$userimg);
        	
        	$this->display();
        }
        
        function voidplay()
        {

            $cid=$_GET['cid'];
        	
        	$is_id=$_GET['is_id'];
        	
        	$id=$_GET['id'];
        	
        	if(isset($cid) && isset($is_id))
        	    
        	{
        	    
         	$zhangjie=$this->zhang_id(0000, $cid, $is_id);
        	$xiaojie=$this->xiaojie(0099,$zhangjie['id']);
        	}
            else
            {
                
                $xiaojie=$this->xiaojie(0099,$id);
            }
            
        	$this->assign(xiaojie,$xiaojie);
        	
        	$head=$xiaojie[0];
        	
        	$this->assign(image,$head['image']);
        	
        	$this->assign(void,$head['void']);
        
        	$this->display();
        }
        /* 
         * 蔡政
         * 输入课程id 输出课程课节信息
         *  */
        function jie($key,$cid)
        {
        	
        	(!($key==7766)) && $this->error('禁止访问','../Index/index');
        	
         	$zhangjie=M('zhangjie');
        	
        	$where_zhangjie['cid']=$cid;
        	
        	$list_zhangjie=$zhangjie->where($where_zhangjie)->where('is_zhangjie != 0')->order('is_id asc')->select(); 
        	
        	return $list_zhangjie ;
        	
        }
        /*
         * 蔡政
         * 输入课程id 输出课程章节信息
         *  */
        function zhang($key,$cid)
        {
             
            (!($key==7766)) && $this->error('禁止访问','../Index/index');
             
            $zhangjie=M('zhangjie');
             
            $where_zhangjie['cid']=$cid;
             
            $list_zhangjie=$zhangjie->where($where_zhangjie)->where('is_zhangjie = 0')->order('is_id asc')->select();
             
            return $list_zhangjie ;
             
        }
    	/* 
    	 * 蔡政
    	 * 输入课程id，章节标志位，输出章节id
    	 *  */
        function zhang_id($key,$cid,$is_id)
        {
        	(!($key==0000)) && $this->error('禁止访问','../Index/index');
        	
        	$zhangjie=M('zhangjie');
        	
        	$where['cid']=$cid;
        	
        	$where['is_id']=$is_id;
        	
        	$list=$zhangjie->where($where)->where('is_zhangjie != 0')->order('id asc')->find();
        	
        	return $list;
        }
        /* 
         * 蔡政
         * 输入章节id 输出小节信息
         *  */
        function xiaojie($key,$id)
        {
        	(!($key==0099)) && $this->error('禁止访问','../Index/index');
        	
        	$xiaojie=M('xiaojie');
        	
        	$where['zhangjie_id']=$id;
        	
        	$list=$xiaojie->where($where)->order("is_id  asc")->select();
        	
        	return $list;
        }
        function test()
        {
            echo time();
            
            return ;
        }
        /* 
         * 蔡政
         * 获取标签
         * 输入pid 输出子类标签 
         *  */
        function gettag($id)
        {
            $tag=M('tag');
            
            $where['pid']=$id;
            
            $list=$tag->where($where)->where("is_delect != 1")->select();
            
            if(empty($list))
            {
                echo '';
            }
            else 
            {
                $list=json_encode($list);
                
                print_r($list);
            }

        }
    /* 
     * 蔡政
     * 相关课程
     *  */
    function an_course($cid)
    {
        
        $lctcn=C('list_course_tag_cid_nu');
        
        $course_tag=M('course_tag');
        
        $where['cid']=$cid;
        
        $list=$course_tag->where($where)->select();
        
        if(empty($list))
        {
            
            $course=M('course');
            
            $list_course_tag_cid=$course->order('nu desc')->page(0,$lctcn)->where("id != $cid" )->field ('id')->select();
            
            $a=0;
            
            foreach ($list_course_tag_cid as $k=>$v)
            {
                $arr_cid[$a]=$v['id'];
                
                $a++;
            }
            
            return $arr_cid;
            
        }
        
        $a=0;
        
        foreach ($list as $k=>$v)
        {
            $arr[$a]=$v['code'];
            
            $a++;
        }
        
        $where_c['code']=array('in',$arr);
        
        $list_c=$course_tag->distinct( true )->where($where_c)->where("cid != $cid" )->page(1,$lctcn)->field ('cid')->select();
        
        if(!(empty($list_c)))
        {
            $a=0;
            
            foreach ($list_c as $k=>$v)
            {
                $arr_cid[$a]=$v['cid'];
                
                $a++;
            }
            
            return $arr_cid;
        }
        else 
        {
            $course=M('course');
            
            $list_course_tag_cid=$course->order('nu desc')->page(0,$lctcn)->where("id != $cid" )->field ('id')->select();
            
            $a=0;
            
            foreach ($list_course_tag_cid as $k=>$v)
            {
                $arr_cid[$a]=$v['id'];
            
                $a++;
            }
            
            return $arr_cid;
        }
        
    }
    function shanghuo($cid)
    {
        $id=session('id');
        
        if(empty($id))
        {
            echo 'null';
            
            return;
        }
        
        $nu=$this->adlook(7735,$cid);
        
        echo $nu;
    }    
        
        
        
        
        
        
        
        
        
        
        
        
        
    }
