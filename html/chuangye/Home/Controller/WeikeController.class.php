<?php
namespace Home\Controller;

use Think\Controller;

use Think\Log;

class WeikeController extends Controller {
    
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
        
        $this->assign('phone_head','weike');
    }
    
    function index()
    {
        
        write_log('lecture',0);
        
        //置顶
        $weike_top=M('weike_top')->order('id desc')->select();
        $a=0;
        foreach ($weike_top as $k=>$v)
        {
            $weike_top1[$a]['url']=str_replace('/','\/',$v['url']);
            $weike_top1[$a]['img']=str_replace('/','\/',$v['img']);
            $weike_top1[$a]['left']='{';
            $weike_top1[$a]['right']='}';
            $a++;
        }
        
        $this->assign('weike_top1',$weike_top1);
        //热门微课
        $weike_paiming=M('course')->where("is_delect != 1 and type=2 ")->limit(C('weike_hot'))->order('look_nu desc,youxianji desc')->select();
        
        $a=0;
        
        foreach ($weike_paiming as $k=>$v)
        {
            $weike_paiming[$a]['number']=$a+1;
            
            $a++;
        }
        
        $this->assign('weike_paiming',$weike_paiming);
        
        //微课标签
        $weike_tag=M('weike_tag')->order('id asc')->select();
        
        $this->assign('weike_tag',$weike_tag);
        
        $this->assign('one_tag',$weike_tag[0]['id']);
        
        $jssdk=A("Jssdk");
        $signPackage = $jssdk->GetSignPackage();
        $this->assign('appid_fenxiang',$signPackage['appId']);
        $this->assign('timestamp_fenxiang',$signPackage['timestamp']);
        $this->assign('nonceStr_fenxiang',$signPackage['nonceStr']);
        $this->assign('signature_fenxiang',$signPackage['signature']);
        $this->assign('url_fenxiang',$signPackage['url']);
        $this->assign('img_fenxiang','');
        $this->assign('title_fenxiang','每天三分钟，创业更轻松。我在中国创业学院等你来!');
        $this->assign('desc_fenxiang','有我陪伴，创业不再孤单！');
/*           $this->display('phone_index');
        return;   */
         if(isMobile())
        {
            $this->display('phone_index');
        }
        else
        {
            $this->display();
        } 
        
        //$this->display();
        
        //$this->display('phone_index');
    }
    function weike()
    {
        header("Content-Type:text/html;charset=UTF-8");  // 解决乱码问题
    
        $id=$_GET[id];
        $this->assign('gid',$id);
        $weike_nu=session('weike_num');
    
        if(empty($weike_nu))
        {
            $weike_nu=1;
        }
    
        $nu=c('weike_list');
    
        if(empty($id) || is_numeric($id)==false){

            $weike=M('course c')->join("LEFT JOIN course c1 ON c.source=c1.id")->where("c.is_delect != 1 and c.type=2 ")->page($weike_nu,$nu)->order('c.youxianji desc,c.id desc')->field('c.*,c1.title as name')->select();
    
        }
        else
        {
    
            $weike=M('course c')->join("LEFT JOIN course c1 ON c.source=c1.id")->where("c.is_delect != 1 and c.type=2 and c.mark_bit=$id")->page($weike_nu,$nu)->order('c.youxianji desc,c.id desc')->field('c.*,c1.title as name')->select();
    
        }
        $a=$this->nu($id, 34512);
        $b=0;
        for($x=1;$x<=$a;$x++)
        {
        $arr[$b]['number']=$x;
            $b++;
        }
    
        $weike_hot=c('weike_hot');
    
        $this->assign('add_nu',$a);
    
        $this->assign('arr',$arr);
    
        $this->assign('weike',$weike);
    
        $this->assign('nu',$weike_nu);
        
        
        
        unset($_SESSION['weike_num']);
        //$this->display('phone_weike');
         if(isMobile())
        {
            $this->display('phone_weike');
        }
        else
        {
            $this->display();
        } 
    
        
    
        
    
    }
    function jiazai()
    {
        $id=$_POST['gid'];
        
        $nu=c('weike_list');
        
        $weike_nu=$_POST['nu'];
        
        if(empty($id) || is_numeric($id)==false){
        
            $weike=M('course c')->join("LEFT JOIN course c1 ON c.source=c1.id")->where("c.is_delect != 1 and c.type=2 ")->page($weike_nu,$nu)->order('c.youxianji desc,c.id desc')->field('c.*,c1.title as name')->select();
        
        }
        else
        {
        
            $weike=M('course c')->join("LEFT JOIN course c1 ON c.source=c1.id")->where("c.is_delect != 1 and c.type=2 and c.mark_bit=$id")->page($weike_nu,$nu)->order('c.youxianji desc,c.id desc')->field('c.*,c1.title as name')->select();
        
        }
        
        if(empty($weike[0]['id']))
        {
            
        }
        else 
        {
            echo json_encode($weike);
        }
        
        
    }
    function bofang()
    {
        header("Content-Type:text/html;charset=UTF-8");  // 解决乱码问题
        
        $id=$_GET['id'];
        
        if(empty($id) || is_numeric($id)==false){
            
            redirect(U('index'));
         }
         
         $weike=M('course')->where(array("id=$id and is_delect!=1 and type=2"))->find();
        
         if(empty($weike['title']))
         {
             redirect(U('index'));
         }
         
         write_log('lecture',$id);
         
         log_all('lecture',$id);
         
         $this->look_nu($id);
         
         if(!empty($weike['source']))
         {
             $this->assign('ws',$weike['source']);
             
             $type=3;
         }
         else 
         {
             $type=2;
         }
         if(!empty($weike['name']))
         {
             $this->assign('nm',$weike['name']);
              
             $type1=3;
         }
         else
         {
             $type1=2;
         }

         $teacher=M('course_teacher ct')->join("LEFT JOIN teacher t ON ct.tid=t.id")->where("ct.cid=$id")->order('ct.id desc')->select();

         $this->assign('teacher',$teacher);
         
         $mark_bit=$weike['mark_bit'];
         
         $xiangguan=M('course')->where(array("mark_bit=$mark_bit and is_delect!=1 and type=2"))->order('youxianji desc')->select();
         $this->assign('type',$type);
         $this->assign('type1',$type1);
         $this->assign('name',$weike['title']);
         $this->assign('source',$weike['source']);
         $this->assign('source_name',$course['title']);
         $this->assign('brief',$weike['brief']);
         $this->assign('look_nu',$weike['look_nu']);
         $this->assign('xiangguan',$xiangguan);
         $this->assign('cc_code',$weike['cc_code']);
         $this->assign('srt',$weike['zimu']);
         $this->assign('cid',$id);
         
         $jssdk=A("Jssdk");
         $signPackage = $jssdk->GetSignPackage();
         $this->assign('appid_fenxiang',$signPackage['appId']);
         $this->assign('timestamp_fenxiang',$signPackage['timestamp']);
         $this->assign('nonceStr_fenxiang',$signPackage['nonceStr']);
         $this->assign('signature_fenxiang',$signPackage['signature']);
         $this->assign('url_fenxiang',$signPackage['url']);
         $this->assign('img_fenxiang',C('headimg').$weike['image']);
         $this->assign('title_fenxiang','精品推荐：'.$weike['title']);
         $this->assign('desc_fenxiang',$weike['brief']);
         //$this->display('phone_bofang');return;
         if(isMobile())
         {
             $this->display('phone_bofang');
         }
         else
         {
             $this->display();
         }
         
        //$this->display();
         
    }

    /* 微课热门 */
    function weike_hot()
    {
        
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
        $where['type']=2;
        $list_course=$course->where($where)->find();
        
        if(empty($list_course['title']))
        {
            return;
        }
         
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
    /* 微课页数 */
    function nu($id,$key)
    {
        if($key!=34512){return;}
        $nu=c('weike_list');
        if(!empty($id))
        {
            $count=M('course')->where("is_delect != 1 and type=2 and mark_bit=$id")->count();
        }
        else 
        {
            $count=M('course')->where("is_delect != 1 and type=2")->count();
            
        }
        $a=$count/$nu;
        $a1=floor($a);
        if($a==$a1)
        {
            $a2=$a1;
        }
        else
        {
            $a2=$a1+1;
        }
        return $a2;
    }
    function num()
    {
        $n=$_GET['n'];
    
        $_SESSION['weike_num']=$n;
    
        if(!empty($_SESSION['weike_num']))
            echo 1;
        else
            echo 0;
    }
}