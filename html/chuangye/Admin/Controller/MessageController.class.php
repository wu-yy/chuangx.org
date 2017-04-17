<?php
namespace Admin\Controller;
use Think\Controller;

class MessageController extends CommonController {
      
      function course()
      {
          $count=M('mood')->count();
          
          $Page       = new \Think\Page($count,15);
          
          $show       = $Page->show();// 分页显示输出
          
          $list=M('mood')->where(array('is_delect'=>0))->limit($Page->firstRow.','.$Page->listRows)->select();
          
          $this->assign('page',$show);
          
          $this->assign('list',$list);
          
          $this->display();
      }
      
      function course_mood()
      {
          $this->display();
      }
      
      function course_me_mood()
      {   
          
          $this->assign('tplid',C('JUHECONFIG.tpl_id1'));
          
          $this->display();
      
      }
      
      function addcourse_mood()
      {
          $cid=$_GET['cid'];
          
          $title=$_GET['title'];
          
          $mood=$_GET['mood'];
          
          $mood1=$_GET['mood1'];
          
          $mood2=$_GET['mood2'];
          
          $type=$_GET['type'];
          
          $mood_type=$_GET['mood_type'];
          
          $send_type=$_GET['send_type'];

          if(empty($cid) || is_numeric($cid)==false || empty($mood) || empty($type) || empty($mood1))
          {
              $this->error('参数错误');
              
              return;
          }
          
          $course=M('course')->where(array('id'=>$cid,'type'=>1))->find();//查询课程是否存在
           
          if(empty($course['id']))
          {
              $this->error('参数错误');
              
              return;
          }
          
          if($send_type==1)
          {
            $arrmood=json_encode(array($mood,$mood1,$course['title']));
          }
          else 
          {
            $arrmood=json_encode(array($mood,$mood1,$course['title'],$mood2,));
          }
          $data=array(
              'cid'=>$cid,
              'mood'=>$arrmood,
              'is_delect'=>0,
              'time'=>time(),
              'is_send'=>0,
              'send_type'=>$send_type,
              'mood_type'=>$mood_type,
              'title'=>$title
              
          );
          
          $add=M('mood')->data($data)->add();//增加模板
          
          $course_user_list=M('course_user')->where(array('cid'=>$cid,'end_time'=>array('gt',time())))->field('uid')->select();//查询关注课程的有效用户

          $count=count($course_user_list);//记录有效关注课程人数
          
          $a=0;
          
          foreach ($course_user_list as $k=>$v)
          {
              $arr_uid[$a]=$v['uid'];
              
              $a++;
          }
          
          if($send_type==1)
          {
                $this->send_weixin($arr_uid, $add, $count,$type);
          }
          if($send_type==0)
          {
                $this->send_duanxin($arr_uid, $add, $count, $type);
          }
      }
      
      
      //微信群发建立群发 
      //输入用户uid二维数组数，mood id，有效关注课程人数 type 1为人工触发，0为系统自动触发
      function send_weixin($arr_uid,$add,$count,$type)
      {
          $list_openid=M('user u')->join('left join uinfo ui on ui.userid=u.id')->where(array('u.id'=>array('in',$arr_uid),'u.phone_openid'=>array('neq','')))->field('u.phone_openid,u.id,ui.nikename')->select();//查询有效关注用户的uid
          
          $a=0;
          
          foreach ($list_openid as $k=>$v)
          {
              if(!empty($v['phone_openid']))
              {
                  $message_data[$a]['openid']=$v['phone_openid'];
          
                  $message_data[$a]['uid']=$v['id'];
          
                  $message_data[$a]['mood_id']=$add;
          
                  $message_data[$a]['type']=$type;
                  
                  if(empty($v['nikename']))
                  {
                      $message_data[$a]['nikename']='新用户';
                  }
                  else 
                  {
                      $message_data[$a]['nikename']=$v['nikename'];
                  }
          
                  $a++;
              }
          }
          
          $count_openid=count($message_data);//可发送消息提醒人数
          
          $message_openid=M('message')->addAll($message_data);
          
          $save_mood=M('mood')->where(array('id'=>$add))->data(array('course_user_nu'=>$count,'spnu'=>$count_openid))->save();
          
          if(!empty($message_openid) && !empty($save_mood))
          {
              $this->success('消息录入成功','course');
          }
          
      }
      
      function send_duanxin($arr_uid,$add,$count,$type)
      {
          $list_openid=M('user u')->join('left join uinfo ui on ui.userid=u.id')->where(array('u.id'=>array('in',$arr_uid),'u.usermobilenum'=>array('neq','')))->field('u.usermobilenum,u.id,ui.nikename')->select();//查询有效关注用户的uid
          
          $a=0;
      
          foreach ($list_openid as $k=>$v)
          {
              if(!empty($v['usermobilenum']))
              {
                  $message_data[$a]['openid']=$v['usermobilenum'];
      
                  $message_data[$a]['uid']=$v['id'];
      
                  $message_data[$a]['mood_id']=$add;
      
                  $message_data[$a]['type']=$type;
      
                  if(empty($v['nikename']))
                  {
                      $message_data[$a]['nikename']='新用户';
                  }
                  else
                  {
                      $message_data[$a]['nikename']=$v['nikename'];
                  }
      
                  $a++;
              }
          }
      
          $count_openid=count($message_data);//可发送消息提醒人数
      
          $message_openid=M('message')->addAll($message_data);
      
          $save_mood=M('mood')->where(array('id'=>$add))->data(array('course_user_nu'=>$count,'spnu'=>$count_openid))->save();
      
          if(!empty($message_openid) && !empty($save_mood))
          {
              $this->success('消息录入成功','course');
          }
          else 
          {
              $this->error('消息录入失败');
          }
      
      }
      
      
      //输入课程id echo课程名称
      function get_course_name()
      {
          $id=$_GET['name'];
      
          if(empty($id) || is_numeric($id)==false)
          {
              $arr=array(0,'参数错误');
              echo json_encode($arr);
              return;
          }
      
          $course=M('course')->where(array('id'=>$id,'type'=>1))->find();
           
          if(empty($course['id']))
          {
              $arr=array(0,'输入的课程id有误');
              echo json_encode($arr);
              return;
          }
          else
          {
              $arr_user=$this->send_weixin_nu($course['id']);
              $arr=array(1,$course['title'],$course['id']);
              $a=3;
              foreach ($arr_user as $k=>$v)
              {
                  $arr[$a]=$v;
                  $a++;
              }
              echo json_encode($arr);
              return;
          }
      }
      
      function send_weixin_nu($cid)
      {
          $course_user_list=M('course_user')->where(array('cid'=>$cid,'end_time'=>array('gt',time())))->field('uid')->select();//查询关注课程的有效用户
          
          $course_user_count=count($course_user_list);
          
          $a=0;
          
          foreach ($course_user_list as $k=>$v)
          {
              $arr_uid[$a]=$v['uid'];
          
              $a++;
          }
          
          $count_openid=M('user')->where(array('id'=>array(in,$arr_uid),'phone_openid'=>array('neq','')))->count();
          
          $count_phonenu=M('user')->where(array('id'=>array(in,$arr_uid),'usermobilenum'=>array('neq','')))->count();
          
          return array($course_user_count,$count_openid,$count_phonenu);
          
      }
      
      function del()
      {
          $id=$_GET['id'];
          
          $f_m=M('mood')->where(array('id'=>$id))->find();
          
          if(empty($f_m['id']))
          {
              echo 0;
              return;
          }
          
          $de_m=M('mood')->where(array('id'=>$id))->data(array('is_delect'=>1))->save();
          
          if(empty($de_m))
          {
              echo 0 ;
          }
          else
          {
              echo 1;
          }
          
      }
      
      function sav()
      {
          $id=$_GET['id'];
      
          $f_m=M('mood')->where(array('id'=>$id))->find();
      
          if(empty($f_m['id']))
          {
              echo 0;
              return;
          }
      
          $de_m=M('mood')->where(array('id'=>$id))->data(array('is_delect'=>0))->save();
      
          if(empty($de_m))
          {
              echo 0 ;
          }
          else
          {
              echo 1;
          }
      
      }
      
      function checkmood($id)
      {
          
          if(empty($id) || is_numeric($id)==false)
          {
              echo 0;
              return; 
          }
          
          $list=M('mood')->where(array('id'=>$id))->find();
          
          if($list['is_send']==1)
          {
              echo 2;
              return;
          }
          
          if($list['is_delect']==1)
          {
              echo 3;
              return;
          }
          
          echo 1;
      }
      
      function send_mood($id)
      {

          if(empty($id) || is_numeric($id)==false)
          {
              echo 0;
          }
          
          $find_mood=M('mood')->where(array('id'=>$id,'is_send'=>0,'is_delect'=>0))->find();
          
          $save_mood_time=M('mood')->where(array('id'=>$id))->data(array('send_time'=>time()))->save();
          
          if(empty($find_mood['id']))
          {
              echo 0;
          }
          
          $mood=json_decode($find_mood['mood'],true);
          
          $list_send_message=M('message')->where(array('mood_id'=>$id))->select();
          
          $a=0;
          
          $b=0;
          
          if($find_mood['send_type']==1)
          {
          
              foreach ($list_send_message as $k=>$v)
              {
                  
                  $re=R('Sendmessage/weixin_mood',array($v['openid'],$find_mood['mood_type'],$find_mood['send_type'],$mood[0],$mood[2],$v['nikename'],$mood[1]));
              
                  if(empty($re))
                  {
                      $a++;
                      
                      $_SESSION['nspnu']=$a;
                  }
                  else 
                  {
                      $b++;
                      
                      $_SESSION['spnu']=$b;
                  }
              }
          }
          
          if($find_mood['send_type']==0)
          {
          
              foreach ($list_send_message as $k=>$v)
              {
          
                  //$re=R('Sendmessage/weixin_mood',array($v['openid'],$find_mood['mood_type'],$find_mood['send_type'],$mood[0],$mood[2],$v['nikename'],$mood[1]));

                  $re=$this->send_phone($v['openid'], $find_mood['mood_type'], $v['nikename'], $mood[2], $mood[0], $mood[1], $mood[3]);
                  
                  if(empty($re))
                  {
                      $a++;
          
                      $_SESSION['nspnu']=$a;
                  }
                  else
                  {
                      $b++;
          
                      $_SESSION['spnu']=$b;
                  }
              }
          }
          
          $save_mood=M('mood')->where(array('id'=>$id,'is_send'=>0,'is_delect'=>0))->data(array('is_send'=>1,'nspnu'=>$b))->save();
          
          if(!empty($save_mood))
          {
              M('message')->where(array('mood_id'=>$id))->delete();
              echo json_encode(array(1,$find_mood['course_user_nu'],$b));
          }
          else 
          {
              echo json_encode(array(0));
          }
          
          unset($_SESSION['nspnu']);
          
          unset($_SESSION['spnu']);
      }
      function send_phone($phone,$tpl_nu,$name,$course,$time,$status,$hint)
      {
          
          $tpl_value='#name#='.$name.'&#course#='.$course.'&#time#='.$time.'&#status#='.$status.'&#hint#='.$hint.'&#company#=聚合数据';
          
          if(sendSms($phone,$tpl_value,$tpl_nu))
          {
              return 1;
          }
          else
          {
              return 0;
          }           
          
      }

      function get_time($day)
      {
          $time=strtotime("$day day");
          
          $begin_time=mktime(0,0,0,date('m',$time),date('d',$time),date('Y',$time));
          
          $over_time=mktime(0,0,0,date('m',$time),date('d',$time)+1,date('Y',$time))-1;

          $arr_time=array($begin_time,$over_time);
          
          return $arr_time;
      }
      //自动生结课成消息
      function make_jieke_message()
      {
            $arr_time=$this->get_time(+10);
            
            if(empty($arr_time) || is_array($arr_time)==false)
            {
                return;
            }

            $list_course_user=M('course_user')->where("end_time<=$arr_time[1] and end_time>=$arr_time[0]")->field('cid,uid,end_time')->select();
            
            $a=0;
            
            foreach ($list_course_user as $k=>$v)
            {
                $list_user=M('user u')->join('left join uinfo ui on ui.userid=u.id')->where(array('u.id'=>$v['uid'],'u.usermobilenum'=>array('neq','')))->field('u.usermobilenum,u.id,ui.nikename')->find();//查询有效关注用户的uid
            
                if(!empty($list_user['usermobilenum']))
                {
                   $course_name=M('course')->where(array('id'=>$v['cid']))->field('title')->find();
                   
                   $arr_message[$a]=array('uid'=>$v['uid'],'cid'=>$v['cid'],'openid'=>$list_user['usermobilenum'],'type'=>0,'nikename'=>$list_user['nikename'],'course_name'=>$course_name['title'],'send_type'=>0,'course_time'=>$v['end_time'],'tplid'=>19305);
                
                   $a++;
                }
                
                
            }
            $re=M('message')->addAll($arr_message);
            
            if(!empty($re))
            {
                echo $re;
            }
            else
            {
                echo 0;
            }
      }
      //自动发送模板消息
      function send_zidong_message()
      {
          $list=M('message')->where(array('type'=>0))->limit(3)->select();
          
          if(empty($list) || is_array($list)==false)
          {
              echo 'none';
              return;
          }
          
          $a=0;
          
          foreach ($list as $k=>$v)
          {
             if($v['send_type']==0)
             {
                 $re=$this->send_phone($v['openid'], $v['tplid'], $v['nikename'], $v['course_name'], date('Y年m月d日 H:i',$v['course_time']), '结课', '请及时学习！');
                 
                 if(!empty($re))
                 {
                     $a++;
                 }
             }
             if($v['send_type']==1)
             {
                 $re=$this->send_phone($v['openid'], $v['tplid'], $v['nikename'], $v['course_name'], date('Y年m月d日 H:i',$v['course_time']), '开课', '请及时学习！');
                 
                 if(!empty($re))
                 {
                     $a++;
                 }
             }

             M('message')->where(array('id'=>$v['id']))->delete();
          }
          
          echo $a;
      }
      //自动生成开课消息
      function make_kaike_message()
      {
          $arr_time=$this->get_time(+1);
      
          if(empty($arr_time) || is_array($arr_time)==false)
          {
              return;
          }
      
          $list_course=M('course')->where("start_time<=$arr_time[1] and start_time>=$arr_time[0]")->field('id,title,start_time')->select();
          
          $a=0;
          
          foreach ($list_course as $k1=>$v1)
          {
              $list_course_user=M('course_user')->where(array('cid'=>$v1['id']))->field('uid')->select();
              
              foreach ($list_course_user as $k=>$v)
              {
                  $list_user=M('user u')->join('left join uinfo ui on ui.userid=u.id')->where(array('u.id'=>$v['uid'],'u.usermobilenum'=>array('neq','')))->field('u.usermobilenum,u.id,ui.nikename')->find();//查询有效关注用户的uid
              
                  if(!empty($list_user['usermobilenum']))
                  {
                       
                      $arr_message[$a]=array('uid'=>$v['uid'],'cid'=>$v1['id'],'openid'=>$list_user['usermobilenum'],'type'=>0,'nikename'=>$list_user['nikename'],'course_name'=>$v1['title'],'send_type'=>1,'course_time'=>$v1['start_time'],'tplid'=>19305);
              
                      $a++;
                  }
              
              
              }
              
              unset($list_course_user);
              
              unset($list_user);
              
          }
          
          $re=M('message')->addAll($arr_message);
          
          if(!empty($re))
          {
              echo $re;
          }
          else
          {
              echo 0;
          }
          
      }
}
