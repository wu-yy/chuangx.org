<?php
namespace Home\Controller;

use Think\Controller;

class CourseController extends Controller {
    
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
        
        $this->assign('phone_head','course');

    }
    
    function getstr($string, $length, $encoding  = 'utf-8') {
        $string = trim($string);
    
        if($length && strlen($string) > $length) {
            //截断字符
            $wordscut = '';
            if(strtolower($encoding) == 'utf-8') {
                //utf8编码
                $n = 0;
                $tn = 0;
                $noc = 0;
                while ($n < strlen($string)) {
                    $t = ord($string[$n]);
                    if($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
                        $tn = 1;
                        $n++;
                        $noc++;
                    } elseif(194 <= $t && $t <= 223) {
                        $tn = 2;
                        $n += 2;
                        $noc += 2;
                    } elseif(224 <= $t && $t < 239) {
                        $tn = 3;
                        $n += 3;
                        $noc += 2;
                    } elseif(240 <= $t && $t <= 247) {
                        $tn = 4;
                        $n += 4;
                        $noc += 2;
                    } elseif(248 <= $t && $t <= 251) {
                        $tn = 5;
                        $n += 5;
                        $noc += 2;
                    } elseif($t == 252 || $t == 253) {
                        $tn = 6;
                        $n += 6;
                        $noc += 2;
                    } else {
                        $n++;
                    }
                    if ($noc >= $length) {
                        break;
                    }
                }
                if ($noc > $length) {
                    $n -= $tn;
                }
                $wordscut = substr($string, 0, $n);
            } else {
                for($i = 0; $i < $length - 1; $i++) {
                    if(ord($string[$i]) > 127) {
                        $wordscut .= $string[$i].$string[$i + 1];
                        $i++;
                    } else {
                        $wordscut .= $string[$i];
                    }
                }
            }
            $string = $wordscut;
        }
        return trim($string);
    }
    
    function index()
    {
       	$list1=M('tag')->where('pid=0')->find();
       	
       	$tid=$list1['id'];
       	
       	//log信息
       	write_log('course',0);
       	
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
//        $this->display('phone_index');	return; 
       	if(isMobile())
       	{
       	    $this->display('phone_index');
       	}
       	else 
       	{
       	    $this->display();
       	}
       	  
    }
    function course_details()
    {
        
        $cid=$_GET['cid'];
        
        if(empty($cid) || is_numeric($cid)==false){
        
            redirect(U('index'));
        }
        
        //log信息
        write_log('course',$cid);
        
        log_all('course',$cid);
        
        $info=$this->kecheng_mingxi(7100, $cid);
        
        $teacher=$info['a'];
        
        $count_teacher=count($teacher);
        
        $this->assign('teacher',$teacher);
        
        $this->assign('count_teacher',$count_teacher);
        
        $course=$info['b'];

        $str1=str_replace("\r\n","<br>",$course[0]['summary']);
        
        $course[0]['summary']=$str1;
        
        $str=str_replace("\r\n","<br>",$course[0]['outline']);

        $course[0]['outline']=$str;
        
        $course[0]['nu_add']=$course[0]['course_user_add']+$course[0]['nu'];
        
        if($course[0]['start_time']<=time())
        {
            if($course[0][mark_bit]==0)
            {
                $course[0][mark_bit]=1;
            }
            if($course[0][mark_bit]==3)
            {
                $course[0][mark_bit]=2;
            }
        }
        
        if($this->check_user_course($cid, 8129))
        {
            $user_course_add=1;
        }
        else
        {
            $user_course_add='';
        }
        
        $uid=session('id');
        
        $course_user=M('course_user')->where(array('cid'=>$cid,'uid'=>$uid))->order('id desc')->find();
        
        $this->assign('course_user_type',$course_user['type']);
        
        $this->assign('course_user_end_time',$course_user['end_time']);
        
        $this->assign('user_course_add',$user_course_add);
        
        $this->assign('cid',$cid);
        
        if(empty($user_course_add))
        {
            if(!empty($course[0]['cost']))
            {
                $check_group_user_course=$this->check_user_group($cid, 8943);
                
                if(!empty($check_group_user_course))
                {
                    $course[0]['cost']=0;
                }
                
            }
        }
        if(strlen($course[0]['teacher_name'])>60)
        {
            $course[0]['teacher_name']=$this->getstr($course[0]['teacher_name'],60).'...';
        }
        $this->assign('course',$course);
        
        //print_r($course);return;

        $this->assign('img_fenxiang',C('headimg').$course[0]['image']);
        $this->assign('title_fenxiang','我在中国创业学院发现了一门好课：'.$course[0]['title']);
        $this->assign('desc_fenxiang',$course[0]['brief']);
        
        $this->assign('void',$course[0]['cc_code']);
        
        $this->assign('image',$course[0]['image']);
        
        $tagname=$this->biaoqian(6667,$cid);
        
        $this->assign('tagname',$tagname);
        
        if($course[0]['zhuanti']==0)
        {
        
            $an_course=$this->an_course($cid);
            
            if(!empty($an_course[0]))
            {
    
            $where_c['id']=array('in',$an_course);
            $where_c['type']=1;
            
            $list_c=M('course')->where($where_c)->select(); 
            

            
            }
        }
        else 
        {
            $json_course_group='['.$course[0]['course_group'].']';
            
            $arr_course_group=json_decode($json_course_group,true);
            
            $a=0;
            
            foreach ($arr_course_group as $k=>$v)
            {
                $arr_course_id[$a]=$v['id'];
                
                $a++;
            }
            $list_c=$this->zhuanti_course($arr_course_id);

        }
        //print_r($list_c);return;
        $this->assign('list_c',$list_c);
        
        $this->look_nu($cid);

        $this->assign('cid',$cid);
        
        $jssdk=A("Jssdk");
        $signPackage = $jssdk->GetSignPackage();
        $this->assign('appid_fenxiang',$signPackage['appId']);
        $this->assign('timestamp_fenxiang',$signPackage['timestamp']);
        $this->assign('nonceStr_fenxiang',$signPackage['nonceStr']);
        $this->assign('signature_fenxiang',$signPackage['signature']);
        $this->assign('url_fenxiang',$signPackage['url']);
        
        
        $zhangjie=$this->jie(7766,$cid);
         
        ob_end_clean();
         
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
        
        $this->assign('nowtime',time());
        
        //print_r($add);return;
        
        
        
        //$this->display('phone_course_details');return;

        if(isMobile())
        {
            if($course[0]['zhuanti']==1)
            {
            
                $this->display('phone_course_details_zhuanti');

            }
            else
            {
                
                $this->display('phone_course_details');
                
            }    
        }
        else
        {
            if($course[0]['zhuanti']==1)
            {
                $this->display('course_details_zhuanti');
            }
            else 
            {
                $this->display();
            }
            
        }
        
        
    }
    /* 
     * 蔡政
     * 输入课程id
     * 输出标签内容 
     *  */
    function biaoqian($key,$cid)
    {
        (!($key==6667)) && redirect(U('Index/index'));
        
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
          
          $a=0;
          
          foreach ($list_course as $k=>$v)
          {
              $list_course[$a]['nu_add']=$v['course_user_add']+$v['nu'];
                
              $a++;
          }
        
          $this->assign('list',$list_course);
          
          $this->assign('arr',$arr);
          
          $add_nu=count($arr);
          
          $this->assign('add_nu',$add_nu);
          
          $this->assign('nu',$num);
//            $this->display('phone_course_lie');return;  
          if(isMobile())
          {
              $this->display('phone_course_lie');
          }
          else
          {
              $this->display();
          }

          /* $this->display(); */
          
          
    }
    
    function jiazai()
    {
        header("Content-Type:text/html;charset=UTF-8");  // 解决乱码问题
        
        $num=$_POST['nu'];
        
        $list_course=$this->sort_time(7000,$num);
        
        $a=0;
        
        foreach ($list_course as $k=>$v)
        {
            $list_course[$a]['nu_add']=$v['course_user_add']+$v['nu'];
        
            $a++;
        } 
        
        //print_r($list_course);return;
        
        if(empty($list_course[0]['id']))
        {
        
        }
        else
        {
            echo json_encode($list_course);
        }
        
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
          
          $a=0;
          
          foreach ($list_course as $k=>$v)
          {
              $list_course[$a]['nu_add']=$v['course_user_add']+$v['nu'];
          
              $a++;
          }
        
          $this->assign('list',$list_course);
          
          $this->assign('arr',$arr);
          
          $add_nu=count($arr);
          
          $this->assign('add_nu',$add_nu);
          
          $this->assign('nu',$num);

          $this->display();
    }
    /* 
     * 
     *  
     *  */
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
        unset($_SESSION['tag_id1']);
        unset($_SESSION['num']);
        unset($_SESSION['sort']);
        
    }
    function detag1()
    {
        unset($_SESSION['tag_id']);
    
    }
    function detag2()
    {
        unset($_SESSION['tag_id1']);
    
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
    function shuaxintag1()
    {
        $_SESSION['tag_id1']=$_GET[id];
    
        if(!empty($_SESSION['tag_id1']))
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
    
        (!($key==7000)) && redirect(U('Index/index'));
        
        
        
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
            
            $where_course_teacher['top']=1;
    
            $list_teacher=M('teacher t')->join(' left join course_teacher ct on ct.tid=t.id')->where(array('ct.cid'=>$v['id'],'ct.top'=>1))->order('ct.is_id asc')->select();
         
            if(empty($list_teacher[0]['id']))
            {
                $list_course[$b]['teacher_name']="导师信息暂无";
            }
            else 
            {    
                    $a=0;
            
                    unset($arr_teacher_name); 
            
                    foreach ($list_teacher as $k=>$v)
                    {
                        $arr_teacher_name[$a]=$v['name'].'('.$v['job'].')';
            
                        $a++;
                    }
            
                    $all_teacher_name=implode(',',$arr_teacher_name);
            
                    $list_course[$b]['teacher_name']=$all_teacher_name;
            }

    
            $b++;
        }
        return $list_course;
    }
    /* 
     * 蔡政
     * 同时输入两个TAG_ID查找相关功能
     * ag: 输入 tid:1 tid:2
     * 输出: cid=array(1,2,3,4);
     *  */
    function  get_course_where_two_tag($tid,$tid1)
    {
        $course_tag=M('course_tag');
        
        $list=$course_tag->query("SELECT c.cid FROM course_tag c,course_tag c1 WHERE c.cid=c1.cid AND c.tid=$tid AND c1.tid=$tid1");
        
        return $list;
    }
    /*
     * 蔡政
     * 按时间查询
     *  */
    function descscore($key,$num)
    {
       (!($key==7010)) && redirect(U('Index/index'));
        
    if(empty($num))
        {
            $num=1;
        }
    
        $course=M('course');
        
        $course_nu=C('course_nu');
        
        $tag_id=session('tag_id');
        
        $tag_id1=session('tag_id1');
        
        if(!empty($tag_id) && !empty($tag_id1))
        {
            $arr=$this->gettagarr($tag_id);
            $arr1=$this->gettagarr($tag_id1);
            
            $a=0;
            
            foreach ($arr as $k=>$v)
            {
                foreach ($arr1 as $k1=>$v1)
                {
                    if($v==$v1)
                    {
                        $tag_like[$a]=$v1;
                        
                        $a++;
                    }
                }
            }
            
            if(!empty($tag_like))
                $where['id']=array(in,$tag_like);
            else
            {
                echo '<div style="margin-top:100px;"><center><font size="5">对不起，此标签下暂无课程，敬请期待</font></center></div>';
                return;
            }
        }
        else 
        {
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
            if(!empty($tag_id1))
            {
                $arr=$this->gettagarr($tag_id1);
            
                if(!empty($arr))
                    $where['id']=array(in,$arr);
                else
                {
                    echo '<div style="margin-top:100px;"><center><font size="5">对不起，此标签下暂无课程，敬请期待</font></center></div>';
                    return;
                }
               
            }   
        }
        $list_course=$course->where($where)->where('is_delect != 1 and type=1 and show_course=0')->order('youxianji desc , id desc')->page($num,$course_nu)->select();
    
        return $list_course;
    }
    /* 
     * 蔡政
     * 按评分查询 
     *  */
    function descscore1($key,$num)
    {
        (!($key==7020)) && redirect(U('Index/index'));
        
        if(empty($num))
        {
            $num=1;
        }
    
        $course=M('course');
        
        $course_nu=C('course_nu');
        
        $tag_id=session('tag_id');
        
        $tag_id1=session('tag_id1');
        
        if(!empty($tag_id) && !empty($tag_id1))
        {
            $arr=$this->gettagarr($tag_id);
            $arr1=$this->gettagarr($tag_id1);
            
            $a=0;
            
            foreach ($arr as $k=>$v)
            {
                foreach ($arr1 as $k1=>$v1)
                {
                    if($v==$v1)
                    {
                        $tag_like[$a]=$v1;
                        
                        $a++;
                    }
                }
            }
            
            if(!empty($tag_like))
                $where['id']=array(in,$tag_like);
            else
            {
                echo '<div style="margin-top:100px;"><center><font size="5">对不起，此标签下暂无课程，敬请期待</font></center></div>';
                return;
            }
        }
        else 
        {
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
            if(!empty($tag_id1))
            {
                $arr=$this->gettagarr($tag_id1);
            
                if(!empty($arr))
                    $where['id']=array(in,$arr);
                else
                {
                    echo '<div style="margin-top:100px;"><center><font size="5">对不起，此标签下暂无课程，敬请期待</font></center></div>';
                    return;
                }
               
            }   
        }

        $list_course=$course->where($where)->where('is_delect != 1 and type=1 and show_course=0')->order('nu desc')->page($num,$course_nu)->select();
    
        return $list_course;
    }
    /* 
     * 蔡政
     * 20151216
     * 每页显示$b条数据，返回页数
     *  */
    function count_score($key)
    {
        (!($key==7031)) && redirect(U('Index/index'));
        
        $course_nu=C(course_nu);
        
        $tag_id=session('tag_id');
        $tag_id1=session('tag_id1');
        if(!empty($tag_id)&&!empty($tag_id1))
        {
            $arr=$this->gettagarr($tag_id);
            $arr1=$this->gettagarr($tag_id1);
            $a=0;
            foreach ($arr as $k=>$v)
            {
                foreach ($arr1 as $k1=>$v1)
                {
                    if($v==$v1)
                    {
                        $tag_like[$a]=$v1;
            
                        $a++;
                    }
                }
            }
            if(empty($tag_like))
            {
                return 0;
            }
            $course=M('course');
            
            $where['id']=array('in',$tag_like);
            
            $arr2=$course->where($where)->where('is_delect != 1 and type=1 and show_course=0')->order('nu desc')->count();
            
            $nu=ceil($arr2/$course_nu);
            
            return $nu;
        }
        else 
        {
        if(!empty($tag_id))
        {
            $arr=$this->gettagarr($tag_id);
            
            if(!empty($arr))
            {
                $count=count($arr);
                
                $course=M('course');
                
                $where['id']=array('in',$arr);
                
                $arr1=$course->where($where)->where('is_delect != 1 and type=1 and show_course=0')->order('nu desc')->count();
                
                $nu=ceil($arr1/$course_nu);
                
                return $nu;
            }
            else
            {
                return;
            } 
            
        }   
       
        if(!empty($tag_id1))
        {
            $arr1=$this->gettagarr($tag_id1);
        
            if(!empty($arr1))
            {
                $count=count($arr1);
        
                $course=M('course');
        
                $where['id']=array('in',$arr1);
        
                $arr2=$course->where($where)->where('is_delect != 1 and type=1 and show_course=0')->order('nu desc')->count();
        
                $nu=ceil($arr2/$course_nu);
        
                return $nu;
            }
            else
            {
                return;
            }
            
        }
        }
            $course=M('course');
        
            $nu_course=$course->where('is_delect != 1 and type=1 and show_course=0')->order('nu desc')->count();
            
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
    
        (!($key==7100)) && redirect(U('Index/index'));
        
        $b=0;
    
        $course=M('course');
        
        $where['id']=$cid;
        
        $where['type']=1;
        
        $list_course=$course->where($where)->select();
        
        $list_teacher=M('course_teacher ct')->join('left join teacher t on t.id=ct.tid')->where(array('ct.cid'=>$list_course[0]['id'],'ct.top'=>1))->order('ct.is_id asc')->select();
        
        if(empty($list_teacher[0]['id']))
        {
        
            $list_course[$b]['teacher_name']='导师信息暂无';
        
            $abc['b']=$list_course;
            
            return $abc;
        } 
        
        $abc['a']=M('course_teacher ct')->join('left join teacher t on t.id=ct.tid')->where(array('ct.cid'=>$list_course[0]['id']))->order('ct.top desc,ct.is_id asc')->select();                   
        
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
        function adlook($key,$id,$type,$end_time)
        {
            
            header("Content-Type:text/html;charset=UTF-8");  // 解决乱码问题
            
            (!($key==7735)) && redirect(U('Index/index'));
            
            $uid=session('id');
            
            if(empty($uid)){return;}
            
            if($type==1){return;}
                            
             $course=M('course');
        
            $where['id']=$id;
            
            $where['type']=1;
            
            $where['show_course']=0;
            
            $list_course=$course->where($where)->find();
            
            if(empty($list_course['id'])){return;}
            
            $course_user_add=$list_course['course_user_add'];
            
            $course_user_add++;
            
            $data['course_user_add']=$course_user_add;
            
            $course->where($where)->save($data); 
            
            $course_user=M('course_user');
            
            $where_course_user['cid']=$id;
            
            $where_course_user['time']=time();

            $where_course_user['uid']=$uid;
            
            $where_course_user['type']=$type;
            
            $where_course_user['end_time']=$end_time;
            
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
            
            $cid=$_GET['cid'];

            header("Content-Type:text/html;charset=UTF-8");  // 解决乱码问题
            
            if(empty($id) || is_numeric($id)==false)
            {
            	
	            if(isMobile())
	            {
	                redirect(U('Index/phone_login'));
	            }
	            else
	            {
	                redirect(U('Course/index'));
	            }
            	
            }
            
            if(empty($cid) || is_numeric($cid)==false)
            {
            	
            		redirect(U('Course/index'));
            	 
            }	
            
            //$check_group_user_course=$this->check_user_group($cid, 8943);            
            
            $kcname=M('course')->where(array('id'=>$cid))->field('title , cost,start_time')->find();
            
            if($kcname['start_time']>time())
            {
                redirect(U('Course/course_details',array('cid'=>$cid)));
                return;
            }
            
            if(!($this->check_user_course($cid, 8129)))
            {
                if($kcname['cost']<=0)
                {
                    redirect(U('Course/course_details',array('cid'=>$cid)));
                    return;
            
                }
                else 
                {
                    $stiat='yulan';
                }
            }
            else 
            {
                $this->assign('course_type',1);
            }

            
        	$kcname=$kcname['title'];
        	
        	$zhangjie=$this->jie(7766,$cid);
        	
        	ob_end_clean();
        	
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
                
                $where_c['type']=1;
                
                $where['show_course']=0;
                
                $list_c=$course->where($where_c)->select(); 
                
                $this->assign('list_c',$list_c);
                
                }

        	}
        	
        	$this->assign('n',$n);
        	
        	$this->assign('cid',$cid);
        	
        	$this->assign('kcname',$kcname);
        	
        	$this->assign('nowtime',time());
        	
        	$cul=M('course_user_look')->where(array('uid'=>$id,'cid'=>$cid))->order('time desc')->find();

            //if(empty($cul['is_zhangjie']) || !empty($stiat))//没有购买付费课程，则不记录观看小节log
            if(empty($cul['is_zhangjie']))
            {
                $this->zhangjie_log($zhangjie[0]['is_zhangjie']);
                 
                $this->xiaojie_log($zhangjie[0]['id']);
                 
                $this->course_look_add1($zhangjie[0]['id']);
                
                $this->assign('zhangjie_id',$zhang[0]['id']);
                
                $this->assign('zhangjie_name',$zhang[0]['name']);
                
                $this->assign('xiaojie_id',$zhangjie[0]['id']);
            }
            else
            {
                
                $is=M('zhangjie')->where(array('id'=>$cul['is_zhangjie']))->find();
                 
                $x=M('zhangjie')->where(array('id'=>$cul['zhangjie_id']))->find();
                
                $this->assign('zhangjie_id',$is['id']);
                
                $this->assign('zhangjie_name',$is['name']);
                
                $this->assign('xiaojie_id',$x['id']);
                
                $this->assign('xid',$cul['xid']);
            } 
            
            
            
            if(isMobile())
            {
                $this->display('phone_void');
            }
            else
            {
                $this->display();
            }
        }
        
        function ajax_add_user_look()
        {
            $xiaojie=$_POST['xiaojie'];
            
            $this->course_look_add1($xiaojie);
            
            echo 1;
        }
        
        function voidplay()
        {
            
            $uid=session('id');
            
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

            $arr=M('xiaojie xj')->join('left join zhangjie zj on zj.id=xj.zhangjie_id')->where(array('xj.id'=>$xiaojie[0]['id']))->field('zj.cid,zj.show,zj.show_time')->find();                
            
			if($arr['show']==1)
			{
	            if(!($this->check_user_course($arr['cid'], 8129)))
	            {
	
	               $this->assign('check_cid',$arr['cid']);
	                   	                    
	               $this->display();
	                    
	               return;
	            }
			}   
            
			if($arr['show_time']>time())
			{
			    redirect(U('waiting',array('t'=>$arr['show_time'])));
			    return;
			}
			
        	$this->assign(xiaojie,$xiaojie);
        	
        	$head=$xiaojie[0];
        	
        	if(!empty($head['cc_code']))
        	{
        	    $type=1;
        	}
        	
        	$this->assign(image,$head['image']);
        	
        	$this->assign(srt,$head['srt']);
        	
        	$this->assign(srt1,$head['srt1']);
        	
        	$this->assign(type,$type);
        	
        	if($type==1)
        	{
        	    $this->assign(void,$head['cc_code']);
        	    $this->assign(xid,$head['id']);
        	}
        	else 
        	{
        	    $this->assign(xid,$head['id']);
        	}
        	//$this->display('phone_voidplay');
        	$this->display();
        }
        function waiting()
        {
            header("Content-Type:text/html;charset=UTF-8");  // 解决乱码问题
            $this->assign('t',$_GET['t']);
            if(isMobile())
            {
                $this->assign('is_phone',1);
                $this->assign('id',$_GET['id']);
            }
            $this->display();
        }
        function phone_voidplay()
        {
            header("Content-Type:text/html;charset=UTF-8");  // 解决乱码问题
                
            $id=$_GET['id'];
            
            $zid=$_GET['zid'];
            
            $this->assign('zid',$zid);
            
            if(empty($id) && empty($zid)){return;}
            
            if(!empty($id))
            {
                if(is_numeric($id)==false){return;}
            }
            
            if(!empty($zid))
            {
                if(is_numeric($zid)==false){return;}
            }
            
            if(empty($id)&&!empty($zid))
            {
                $xiaojie_list=M('xiaojie')->where(array('zhangjie_id'=>$zid))->order('is_id asc')->select();
                
                $id=$xiaojie_list[0]['id'];
                
                $this->assign('nu',count($xiaojie_list)) ;
                
                $this->assign('k_jie',$xiaojie_list);
             
            }
            else 
            {
                $xiaojie_list=M('xiaojie xj')->join('left join xiaojie xj1 on xj.zhangjie_id=xj1.zhangjie_id')->where(array('xj.id'=>$id))->order('xj.is_id asc')->select();
                
                $this->assign('nu',count($xiaojie_list)) ;
                
                $this->assign('k_jie',$xiaojie_list);
            }
            
            $cid=M('xiaojie xj')->join('left join zhangjie zj on zj.id=xj.zhangjie_id')->where(array('xj.id'=>$id))->field('zj.cid,zj.show_time')->find();
            
            if($cid['show_time']>time())
            {
                redirect(U('waiting',array('t'=>$cid['show_time'],'id'=>$cid['cid'])));
                return;
            }
            
            //print_r($cid);return;
            
            //$check_group_user_course=$this->check_user_group($cid['cid'], 8943);
             

            
/*             if(!($this->check_user_course($cid, 8129)))
            {
                redirect(U('Course/course_details',array('cid'=>$cid)));
                
                return;
            }
             */
            $this->assign('cid',$cid['cid']);
            
            $this->assign('id',$id);
            
            $course_list=M('course')->where(array('id'=>$cid['cid']))->find();
            
            $this->assign('name',$course_list['title']);
            
            $list=M('xiaojie xj')->join('left join zhangjie zj on zj.id=xj.zhangjie_id')->where(array('xj.id'=>$id))->field('zj.cid,zj.show,xj.type,xj.cc_code')->find();
            
            if($list['show']==1)
            {
            	if(!($this->check_user_course($list['cid'], 8129)))
            	{
            
            		redirect(U('Pay/index',array('cid'=>$cid['cid'],'type'=>course)));
            		 
            		return;
            	}
            } 

/*              $list=M('xiaojie')->where(array('id'=>$id))->find();
            
             if($list['show']==1)
             {                
                 if(!($this->check_user_course($cid['cid'], 8129)))
                 {
                
                 redirect(U('Pay/index',array('cid'=>$cid['cid'],'type'=>course)));
                
                 return;
                 }
            
             }   */
            
            $this->assign('type',$list['type']);
            
            if($list['type']==0)
            {
                $this->assign('cc_code',$list['cc_code']);
            }
            else 
            {
                $text=M('course_file')->where(array('xid'=>$id))->find();
                
                $this->assign('body',$text['body']);
            }
           
            
            $this->display();
        }
        /* 
         * 蔡政
         * 输入课程id 输出课程课节信息
         *  */
        function jie($key,$cid)
        {
        	
        	(!($key==7766)) && redirect(U('Index/index'));
        	
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
             
            (!($key==7766)) && redirect(U('Index/index'));
             
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
        	(!($key==0000)) && redirect(U('Index/index'));
        	
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
            (!($key==0099)) && redirect(U('Index/index'));
        	
        	$xiaojie=M('xiaojie');
        	
        	$where['zhangjie_id']=$id;
        	
        	$list=$xiaojie->where($where)->order("is_id  asc")->select();
        	
        	return $list;
        }
        function p_xiaojie()
        {
            $id=$_POST['id'];
            
            if(empty($id)){ return ;}
          
            if(is_numeric($id)==false){return;}
             
            $xiaojie=M('xiaojie');
             
            $where['zhangjie_id']=$id;
             
            $list=$xiaojie->where($where)->order("is_id  asc")->field('id,type')->select();
             
            $list=json_encode($list);
                
            print_r($list);
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
            
            $list_course_tag_cid=$course->order('nu desc')->page(0,$lctcn)->where("id != $cid and type=1 and is_delect=0 and show_course=0" )->field ('id')->select();
            
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
        
        $list_c=$course_tag->distinct( true )->where($where_c)->where("cid != $cid" )->field ('cid')->select();

        if(!(empty($list_c)))
        {
            $nu=count($list_c);

            if($nu>$lctcn)
            {
                $arrr=NoRand(0,$nu-1,$lctcn);
            
                $a=0;
            
                foreach ($arrr as $k=>$v)
                {
                    $arr_cid[$a]=$list_c[$v]['cid'];
                    $a++;
                }
            }
            else 
            {
                $a=0;
                
                foreach ($list_c as $k=>$v)
                {
                    $arr_cid[$a]=$v['cid'];
                
                    $a++;
                }
            }
            
            return $arr_cid;
        }
        else 
        {
            $course=M('course');
            
            $list_course_tag_cid=$course->order('nu desc')->page(0,$lctcn)->where("id != $cid and type=1 and is_delect=0 and show_course=0" )->field ('id')->select();
            
            $a=0;
            
            foreach ($list_course_tag_cid as $k=>$v)
            {
                $arr_cid[$a]=$v['id'];
            
                $a++;
            }
            
            return $arr_cid;
        }
        
    }
    function shanghuo()
    {
        $id=session('id');
        
        if(empty($id))
        {
            echo 0;
            
            return;
        }
        else
        {
            echo 1;
        }
    }    
    /* 
     * 查找用户是否已关注课程
     * 表：course_user
     * 输入：cid（课程id）
     * 输出：用户关注课程的记录
     *  */  
    function user_course_add($cid)
    {
        $id=session('id');
        
        if(empty($id)){return;}
        
        $course_user=M('course_user');
        
        $where['cid']=$cid;
        
        $where['uid']=$id;
        
        $list=$course_user->where($where)->find();
        
        return $list;
    }    
    /* 
     * 查找课程已关注数
     * 表：course_user
     * 输入cid; 
     * 输出课程关注数 
     *  */   
     function course_user_nu($cid)
     {
         $course_user=M('course_user');
         
         $where['cid']=$cid;
         
         $nu=$course_user->where($where)->count();
         
         echo $nu;
     }   
     /* 
      * 新增课程游览量
      * 表：look_nu,course
      * 输入课程id 
      *  */   
     function look_nu($cid)
     {
         
         $uid=session('id');
         
         $course=M('course');
         
         $where['id']=$cid;
         $where['type']=1;
         
         $where['show_course']=0;
         $list_course=$course->where($where)->find();
         
         $look_nu=$list_course['look_nu'];
         
         $look_nu++;
         
         $data['look_nu']=$look_nu;
         
         $course->where($where)->save($data);
         
         $look_nu=M('look_nu');
         
         $where_course_user['cid']=$cid;
         
         $where_course_user['time']=time();
         
         if(!empty($uid))
         {
             $where_course_user['uid']=$uid;
         }
         
         $look_nu->add($where_course_user);
         
     }   
     function clatagid1()
     {
         unset ($_SESSION['tag_id1']);
         
         $tag=session('tag_id1');
         
         if(empty($tag))
         {
             echo 1;
         }
         else 
         {
             echo 0;
         }
         
     } 
     function clatagid()
     {
         unset ($_SESSION['tag_id']);
          
         $tag=session('tag_id');
          
         if(empty($tag))
         {
             echo 1;
         }
         else
         {
             echo 0;
         }
          
     }  
      /* 
      * 2016/2/19
      * 购买课程 
      * 输入cid
      * 输出 0:余额不足  ; 1:购买成功; 2:购买失败; 3:已购买 
      *  
     function check_credit()
     {
         $cid=$_GET['cid'];
         
         $id=session('id');
         
         if(empty($id)){echo 0;return;}
         if(empty($cid)){echo 0;return;}
         if(is_numeric($cid)==false){echo 0;return;}
         
         $list_credit_log_select=M('course_user')->where("uid=$id and cid=$cid")->find();
         
         if(!empty($list_credit_log_select['id']))
         {
             echo 3;
             
             return;
         }
         
         $list_course=M('course')->where("id=$cid and type=1")->find();
         
         $cost=$list_course['cost'];
         
         $list_user=M('user')->where("id=$id")->find();
         
         $credit=$list_user['credit'];
         
         $rs=$credit-$cost;
         
         if($rs<0)
         {
             echo 0;
         }
         else 
         {
             $data_user['credit']=$rs;
             
             if($cost !=0)
             {
                 $list_user1=M('user')->where("id=$id")->save($data_user);
                  
                 if(empty($list_user1)){echo 2; return;}
             }
             
             $data['uid']=$id;
             
             $data['time']=time();
             
             $data['type']=1;
             
             $data['cost_id']=$cid;
             
             $data['spend']=0-$cost;
             
             $list_credit_log=M('credit_log')->add($data);
             
             if($list_credit_log)
             {
                 $nu=$this->adlook(7735,$cid,1);
                 
                 write_log('course_guanzhu',$cid);
                 
                 log_all('course_guanzhu',$cid);
                 
                 echo 1;
             }
             else 
             {
                 echo 2;
             }
         }
             
     }    */
/*      function check_credit_log()
     {
         $cid=$_GET['cid'];
          
         $id=session('id');
          
         if(empty($id)){redirect(U('Index/index'));}
         if(empty($cid)){redirect(U('Index/index'));}
         if(is_numeric($cid)==false){echo 0;return;}
          
         $list_credit_log_select=M('credit_log')->where("uid=$id and cost_id=$cid")->find();
          
         if(!empty($list_credit_log_select))
         {
             echo 1;
         }
         
         else
         {
             echo 0;
         }
     } */ 
     /* 
      * 关注免费课程
      * 返回0：购买失败 1：购买成功; 
      *  */
     function guanzhu($cid)
     {
         $nu_time=6;
         
         if(empty($cid)){echo 0;return;}
         
         if(is_numeric($cid)==false){echo 0;return;}
         
         $id=session('id');
         
         if(empty($id))
         {
             echo 0;
             
             return;
         }
         
         $list_course_cost=M('course')->where("id=$cid and type=1")->find();
          
         if(empty($list_course_cost['id']))
         {
                echo 0;
                return;
         }
         
         $check_group_user_course=$this->check_user_group($cid, 8943);
          
         if(!empty($check_group_user_course))
         {
             $courser_user=M('course_user')->where(array('uid'=>$id,'cid'=>$cid,'type'=>2,'end_time'=>array('gt',time())))->find();
             
             if(!empty($courser_user['id']))
             {
                 echo 1;
                 return ;
             }
             
             $user_group_course_max_end_time=$this->user_group_course_max_end_time($cid,65301849);
             
             $end_time=$user_group_course_max_end_time['end_time'];
             
             $nu=$this->adlook(7735,$cid,2,$end_time);
              
             write_log('course_guanzhu',$cid);
         
             log_all('course_guanzhu',$cid);
              
             echo $nu;
              
             return;
         
         }
         
         if($list_course_cost['cost']>0)
         {

                 echo 0;
                 
                 return;

         }
         
         if(empty($list_course_cost['show'])) 
         {
             $courser_user=M('course_user')->where(array('uid'=>$id,'cid'=>$cid,'type'=>0,'end_time'=>array('gt',time())))->find();
              
             if(!empty($courser_user['id']))
             {
                 echo 1;
                 return ;
             }
             
                   $end_time=time()+60*60*24*30*$nu_time;

                     $nu=$this->adlook(7735,$cid,0,$end_time);
                     
                     if($list_course_cost['zhuanti']==1)
                     {
                         $arr_course_group=json_decode('['.$list_course_cost['course_group'].']',true);
                          
                         foreach ($arr_course_group as $k=>$v)
                         {
                             $end_time=time()+60*60*24*30*$nu_time;
                              
                             $nu=$this->adlook(7735,$v['id'],0,$end_time);
                         }
                          
                          
                     }
                  
                     write_log('course_guanzhu',$cid);
                     
                     log_all('course_guanzhu',$cid);
                      
                     echo $nu;
                      
                     return;   
         }
         else
         {
             echo 'timeout';
         }
         
         
     }
     function user_group_course_max_end_time($cid,$key)
     {
         if($key != 65301849)return 0;
         
         if(empty($cid) || is_numeric($cid)==false)return 0; 
         
         $id=session('id');
         
         $user_group_bao_end_time=M('user_group ug')->join('left join course_group cg on cg.gid=ug.gid')->join('left join course_admin_tag cat on cat.tid=cg.cid')->where(array('ug.uid'=>$id,'ug.is_delect'=>0,'cg.end_time'=>array('gt',time()),'cg.type'=>2,'cg.is_delect'=>0,'cat.is_delect'=>0,'cat.cid'=>$cid))->order('cg.end_time desc')->field('cg.end_time')->find();

         $user_group_course_end_time=M('user_group ug')->join('left join course_group cg on cg.gid=ug.gid')->where(array('ug.uid'=>$id,'ug.is_delect'=>0,'cg.cid'=>$cid,'cg.end_time'=>array('gt',time()),'cg.type'=>1,'cg.is_delect'=>0))->order('cg.end_time desc')->field('cg.id,cg.end_time')->find();
            
         if($user_group_bao_end_time>$user_group_course_end_time)
         {
             //print_r($user_group_bao_end_time);
             return $user_group_bao_end_time;
         }
         else 
         {
             //print_r($user_group_course_end_time);
             return $user_group_course_end_time;
         }
         
     }
     //用户与课程关系
     function check_user_course($cid,$key)
     {
         if($key != 8129){return false;}
         
         $uid=session('id');
          
         if(empty($uid))
         {
             return false;
         }
         
         if(empty($cid) || is_numeric($cid)==false)
         {
             return false;
         }
         
         $course_list=M('course')->where(array('id'=>$cid,'is_delect'=>0,'type'=>1))->field('id,show_course,cost')->find();
          
         if(empty($course_list['id']))
         {
             return false;
         }
         
         $course_user=M('course_user')->where(array('cid'=>$cid,'uid'=>$uid))->order('id desc')->find();
         
         if(empty($course_user['id']))
         {
             return false;
         }
         
         if($course_user['type']==0)
         {
             /* if($course_list['cost']==0 && $course_list['show_course']==0)
             {
                 return true;
             }
             else 
             {
                 return false;
             } */ 
             if($course_user['end_time']>=time())
             {
                 return true;
             }
             else 
             {
                 return false;
             }
         }
         if($course_user['type']==1)
         {
             if($course_user['end_time']>=time())
             {
                 return true;
             }
             else 
             {
                 return false;
             }
         }
         if($course_user['type']==2)
         {
/*              $check_user_group=$this->check_user_group($cid,8943);
             //echo $check_user_group;
             if(!empty($check_user_group))
             {
                 return true;
             }
             else 
             {
                 return false;
             } */
             if($course_user['end_time']>=time())
             {
                 return true;
             }
             else
             {
                 return false;
             }
         }
         return false;
     } 
     //用户所在组与课程关系
     function check_user_group($cid,$key)
     {
         if($key != 8943){return;}
         
         if(empty($cid) || is_numeric($cid)==false)
         {
             return;
         }
         
         $uid=session('id');
         
         if(empty($uid))
         {
             return;
         }
         
         $course_list=M('course')->where(array('id'=>$cid,'is_delect'=>0,'type'=>1))->field('id,show_course')->find();
         
         if(empty($course_list['id']))
         {
             return;
         }
         
         $arr=M('user_group')->where(array('uid'=>$uid,'is_delect'=>0))->select();
         
         $a=0;
         
         foreach ($arr as $k=>$v)
         {
             $sel_group_course=$this->sel_group_course($v['gid'],$cid,2134);
             if(!empty($sel_group_course))  
             {
                 return 1;
             }
         }
         
         return ;
     }
     
     function sel_group_course($gid,$cid,$key)
     {
         if($key != 2134)
         {
             return;
         }
         
         if(empty($gid) || empty($cid) || is_numeric($cid)==false ||is_numeric($gid)==false)
         {return;}
         
         $course_gruop=M('course_group')->where(array('cid'=>$cid,'gid'=>$gid,'type'=>1,'end_time'=>array('gt',time()),'is_delect'=>0))->find();
         
         if(!empty($course_gruop['id']))
         {
             return 1;
         }
         
         $tag_group=M('course_group')->where(array('gid'=>$gid,'type'=>2,'end_time'=>array('gt',time()),'is_delect'=>0))->select();
         
         if(empty($tag_group[0]['id']))
         {
             return;
         }
         
         $a=0;
          
         foreach ($tag_group as $k=>$v)
         {
             $arr_tag[$a]=$v['cid'];
              
             $a++;
         }
         
         $course_admin_tag=M('course_admin_tag')->where(array('cid'=>$cid,'tid'=>array('in',$arr_tag),'type'=>1,'is_delect'=>0))->find();
         
         if(!empty($course_admin_tag['id']))
         {
             return 1;
         }

         return;
     }
     
     /* 插入章节log
      * 输出：1为插入成功，0为插入失败 */
     function zhangjie_log($zhangjie_id)
     {
         header("Content-Type:text/html;charset=UTF-8");  // 解决乱码问题
         
         $id=session('id');
         
         if(is_numeric($zhangjie_id)==false){return;}
         
         $cid=M('zhangjie')->where(array('id'=>$zhangjie_id,'is_zhangjie'=>0))->field('cid')->find();
         
         if(empty($cid['cid'])){ return;}

         log_all('zhangjie',$zhangjie_id);
     }
     /* 插入小节log
      * 输出 1：插入成功 0：插入失败 */
     function xiaojie_log($xiaojie_id)
     {
         header("Content-Type:text/html;charset=UTF-8");  // 解决乱码问题
         
          $id=session('id');
         
         if(is_numeric($xiaojie_id)==false){return;}
         
         $cid=M('zhangjie')->where("id=$xiaojie_id and is_zhangjie!=0")->field('cid,is_zhangjie')->find();
         
         if(empty($cid['cid'])){ return;}
         
         log_all('xiaojie',$xiaojie_id);
         
     }
     function course_look_add1($xiaojie_id)
     {
         
         if(is_numeric($xiaojie_id)==false){return;}
          
         $xiaojie=M('xiaojie')->where(array('zhangjie_id'=>$xiaojie_id,'is_id'=>1))->field('id')->find();
          
         if(empty($xiaojie['id'])){ return;}
         
         $nu=$this->course_look_add($xiaojie['id']);
     }
     /*用户观看视频信息记录  
      *1:记录成功，0:记录失败，2：返还积分 
      * */
     function course_look_add($xid)
     {
         
         header("Content-Type:text/html;charset=UTF-8");  // 解决乱码问题
         
         if(is_numeric($xid)==false){echo "数据错误";return;}
         
         $course=M('xiaojie xj')->join('zhangjie zj ON zj.id=xj.zhangjie_id')->where("xj.id=$xid")->find();
         
         if(empty($course['id'])){echo '数据暂无'; return;}
         
         $id=session('id');
         
         $cid=$course['cid'];
         
/*          if(!($this->check_user_course($cid, 8129)))
         {return ;} */
         
         $course_user=M('course_user')->where(array('uid'=>$id,'cid'=>$cid,'end_time'=>array('gt',time())))->order('id desc')->find(); 
         
         if(empty($course_user['id']))
         {
             $where['cu_id']=array('exp','is null');
         }
         else 
         {
             $where['cu_id']=$course_user['id'];
         }
         
         
         $list_course_user_look=M('course_user_look')->where(array('uid'=>$id,'xid'=>$xid))->where($where)->find();

         if(empty($list_course_user_look['id']))
         {
             $data=array(
                 'uid'=>$id,
                 'xid'=>$xid,
                 'time'=>time(),
                 'cid'=>$course['cid'],
                 'zhangjie_id'=>$course['zhangjie_id'],
                 'is_zhangjie'=>$course['is_zhangjie'],
                 'cu_id'=>$course_user['id'],
             );
             $add=M('course_user_look')->add($data);
         }
         else 
         {
             $add=M('course_user_look')->where(array('id'=>$list_course_user_look['id']))->data(array('time'=>time()))->save();
         }
         
         return ;
         if(empty($add))
         {
             echo 0;
         }
         else 
         {
             echo 1;
         }
         
         /* $sel_course_xiaojie=$this->sel_course_xiaojie(0019,$xid); */
         
/*          if(!empty($add))
         {
            if(!empty($sel_course_xiaojie[0]))
            {                
                $list_course_user_look=M('course_user_look')->distinct( true )->where("uid = $id" )->field ('xid')->select();
                
                $c_list_course_user_look=count($list_course_user_look);
                
                $c_sel_course_xiaojie=count($sel_course_xiaojie);
                
                print_r($sel_course_xiaojie);
            }
            else 
            {
                echo 1;
            }
         }
         else 
         {
             echo 0;
         } */
         
         /* print_r($sel_course_xiaojie); */
         
     }
    /* 
     * 输入章节id
     * 输出本节课程所有的视频id
     *  */
     function sel_course_xiaojie($key,$xid)
     {
         (!($key==0019)) && redirect(U('Index/index'));
         
         if(empty($xid)){redirect(U('Index/index'));}
         
         $list_zhangjie_cid=M('zhangjie')->where("id=$xid")->find();
         
         $cid=$list_zhangjie_cid["cid"];
         
         $list_zhangjie=M('zhangjie')->where("cid=$cid and is_zhangjie != 0")->select();
         
         $a=0;
         
         foreach ($list_zhangjie as $k=>$v)
         {
             $zhangjie_id[$a]=$v['id'];
             
             $a++;
         }
         
         if(empty($zhangjie_id[0]))
         {
             return;
         }
         
         $where['zhangjie_id']=array('in',$zhangjie_id);
         
         $list_xiaojie=M('xiaojie')->where($where)->select();
         
         $a=0;
          
         foreach ($list_xiaojie as $k=>$v)
         {
             $xiaojie_id[$a]=$v['id'];
              
             $a++;
         }
         
         return $xiaojie_id; 
     }
      function gettext()
      {
          $id=$_POST['id'];
          
          if(empty($id)){ return ;}
          
          if(is_numeric($id)==false){echo "数据错误";return;}
          
          $list=M('course_file')->where(array('xid'=>$id))->find();
          
          echo $list['body'];
      }  
      function voidplay_phone($cc_code)
      {
          $this->assign('cc_code',$cc_code);
          
          $this->display();
          
      }
      function zhuanti_course($id)
      {
          if(empty($id) || is_array($id)==false)
          {
              return;
          }
          
          $list=M('course')->where(array('id'=>array('in',$id)))->field('id,cost,title,type,start_time,image,jietu,botton_name,forshort')->select();
          
          $a=0;
          
          foreach ($list as $k=>$v)
          {
              
              $list[$a]['luck']=$a+1;
              
              $a++;
              
          }
          
          return $list;
      }  
      
}
