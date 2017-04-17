<?php
namespace Home\Controller;

use Think\Controller;

class ZhiboController extends Controller {
    
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
        
        $this->assign('phone_head','zhibo');
    }

    //获取正在直播+还没开始的课程（还没结束）
    //wenjing
    public function next_zhibo($key){
        (!($key==8097)) && $this->error('禁止访问');
    
        header("Content-Type:text/html;charset=UTF-8");  // 解决乱码问题

        $cond['is_delect'] = 0;
        $cond['type'] = 3;
        $cond['zhuanti'] = 0;
        $cond['time_end'] = array('gt', time());//还没结束的直播
        $current = M('course')->where($cond)->order('start_time asc')->select();//wenjign可能要改
        //if($current){
        return $current;
        //}else return null;
    }

    //wenjing
    //获取以前直播视频
    public function past_zhibo($key, $n){
        (!($key==8097)) && $this->error('禁止访问');

        $zhibo_nu = C('information_nu');
    
        header("Content-Type:text/html;charset=UTF-8");  // 解决乱码问题

        $cond['is_delect'] = 0;
        $cond['type'] = 3;
        $cond['zhuanti'] = 0;
        $cond['time_end'] = array('elt', time());//已经结束的直播
        $past = M('course')->where($cond)->page($n,$zhibo_nu)->order('start_time desc')->select();
        return $past;
    }

    //wenjing
    public function index()
    {
            
        $zhibo_next = $this->next_zhibo(8097);
        $zhibo_current = $zhibo_next[0];
        $zhibo_past = $this->past_zhibo(8097, 1);
        $a=0;
        
        foreach ($zhibo_past as $k=>$v)
        {
            $time_ad=time_ad($v['start_time']);
            
            $zhibo_past[$a]['time_ad']=$time_ad;
            
            $zhibo_past[$a]['nu_add']=$v['course_user_add']+$v['nu'];
            
            $a++;
        }

        $a= 0;
        foreach ($zhibo_next as $k=>$v)
        {
            $time_ad=time_ad($v['start_time']);
            
            $zhibo_next[$a]['time_ad']=$time_ad;
            
            $zhibo_next[$a]['nu_add']=$v['course_user_add']+$v['nu'];
            
            $a++;
        }

        if($zhibo_current)
            $zid = $zhibo_current['id'];
        else{//当前直播是最近的zhibo_past
            $zid = $zhibo_past[0]['id'];
        }
        if(is_numeric($zid)==false){}
        else
        {
            if($zhibo_current){
                $this->assign('zhibo_img',$zhibo_current['image']);
                $this->assign('zhibo_title',$zhibo_current['title']);
            }
            else{
                $this->assign('zhibo_img', $zhibo_past[0]['image']);
                $this->assign('zhibo_title',$zhibo_past[0]['title']);
            }
            
            $this->assign('zhibo_id',$zid);
        }

        //log信息
        write_log('zhibo',0);

        $this->assign('zhibo_next', $zhibo_next);

        $this->assign('zhibo_past', $zhibo_past);

        $zhibo_hot = get_nice_zhibo();//精彩直播

        $nu=count($zhibo_hot);

        $num = C('information_nu');
        
        if($nu>$num)//按顺序获取前num个
        {
        
            $a=0;
        
            for ($a = 0; $a < $num; $a++){
                $arr_zhibo_hot[$a] = $zhibo_hot[$a];
            }
            $this->assign('zhibo_hot',$arr_zhibo_hot);
        }
        else
        {
            $this->assign('zhibo_hot',$zhibo_hot);
        }


        if(isMobile())
        {
            if(is_ios()=='ios')
            {
                $this->assign('is_phone','ios');
            }
            
            $this->display('phone_index');//wenjing add phone_index.html
        }
        else
        {
            $this->display();
        }
        
    
    }
    //查看某个直播的具体情况
    function zhibo_details()
    {
        header("Content-Type:text/html;charset=UTF-8");  // 解决乱码问题
        
        $zid=$_GET['zid'];
        
        if(empty($zid) || is_numeric($zid)==false)
        {
                redirect(U('Index/index'));     
        }
        
        $list=M('course')->where(array('is_delect'=>0,'type'=>3,'id'=>$zid))->find();
        
        $list['brief']=str_replace("\r\n","<br>",$list['brief']);
        
        if(isMobile())
        {
            $list['source']=str_replace("\r\n","</span><br/><span style='margin-left:113px; width:200px;font-size:23px; color:#333;'>",$list['source']);
            
        }
        else 
        {
            $list['source']=str_replace("\r\n","</span><br/><span style='margin-left:81px; width:200px;'>",$list['source']);
            
        }
        
        if(empty($list['id']))
        {
            redirect(U('Index/index'));
        }
        
        $this->look_nu($zid);
        
        $arr[0]=$list;
        
        $this->assign('list',$arr);
        
        $this->assign('title',$list['title']);

        $where_s['id'] = $list['botton_name'];
        $series = M('course')->where($where_s)->find();
        $series_arr[0] = $series;
        if($list['botton_name'] == null) {
            $series_arr = null;
            $series_null = 1;
        }
        $this->assign('series', $series_arr);
        $this->assign('series_null', $series_null);


        $where_corre['botton_name'] = array('eq', $list['botton_name']);
        $where_corre['id'] = array('neq', $zid);
        $corre_zhibo=M('course')->where($where_corre)->order('nu')->select();
        $this->assign('corre_zhibo', $corre_zhibo);
        
        $teacher=M('teacher t')->join('left join course_teacher ct on t.id=ct.tid')->where(array('ct.cid'=>$list['id']))->order('ct.is_id asc')->field('t.id,t.image,t.name,t.job,t.brief')->select();
        
        $this->assign('count_teacher',count($teacher));
        
        $this->assign('teacher',$teacher);
        
        $id=session('id');
        
        if(empty($id))
        {
            $type=1;
        }
        else
        {
            $type=0;
        }
        if($this->check_user_course($zid, 8129))
        {
            $user_course_add=1;
        }
        else
        {
            $user_course_add='';
        }
        
        
        $this->assign('type',$type);
        $this->assign('user_course_add', $user_course_add);

/*         $this->display('phone_zhibo_details');
        return;  */
        if(isMobile())
        {
            $this->display('phone_zhibo_details');
        }
        else 
        {
            $this->display();
        }
        
    }

    //wenjing
    //加载更多历史直播
    function get_moreZhi($n){
        $zhibo_nu=C('information_nu')+1;
    
        header("Content-Type:text/html;charset=UTF-8");  // 解决乱码问题
    
        /* $list=$information->order('mark_bit desc,nu desc')->page($n,$information_nu)->select(); */
        
        $list=$this->past_zhibo(8097, $n);
        
        $a=0;
        
        foreach ($list as $k=>$v)
        {
            $time_ad=time_ad($v['start_time']);
            
            $list[$a]['time_ad']=$time_ad;
            
            $list[$a]['nu_add']=$v['course_user_add']+$v['nu'];

            if($v['image'])
                $list[$a]['img'] = $v['image'];
            else
                $list[$a]['img'] = $v['jietu'];
            
            $a++;
        }
        
        
        
        if(empty($list))
        {
            echo 1;
            
            return;
        }
        
        if($n==1)
        {   
            return $list ;
        }
        else 
        {
            echo json_encode($list);
        }
        
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
        $where['type']=3;
         
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

        $course_list=M('course')->where(array('id'=>$cid,'is_delect'=>0,'type'=>3))->field('id,show_course,cost')->find();

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


}
