<?php
namespace Admin\Controller;
use Think\Controller;

class IncourseController extends CommonController {
    
        function index()
        {
            
            $this->display();
        }
/*         function tag()
        {
            
            $list1=M('tag')->where('pid=0')->find();
            
            $tid=$list1['id'];
            
            $list=M('tag')->where("pid=$tid")->select();
            
            $this->assign('list',$list);
            
            $this->display();
        } */
        function upload()
        {
            
            header("Content-Type:text/html;charset=UTF-8");  // 解决乱码问题
            
            if(empty($_POST['biaoqian']) || empty($_POST['jiaoshi_top']))
            {
                $this->error('请添加导师与标签信息，',U('Incourse/index'));
                return;
            }
            
    	    $where['title']=$_POST['name'];
    	    
    	    $time=$_POST['time'];
    	    
    	    $where['start_time']=strtotime($time);
    	    
    	    $where['yuanjifen']=$_POST['yuanjifen'];
    	    
    	    $where['botton_name']=$_POST['botton_name'];
    	    
    	    $where['forshort']=$_POST['forshort'];
    	    
    	    $where['source']=$_POST['laiyuan'];
    	    
    	    $where['cost']=$_POST['cost'];
    	    
    	    $where['back_credit']=$_POST['back_credit'];
    	    
    	    $where['language']=$_POST['yuyan'];
    	    
    	    $where['brief']=$_POST['jianjie'];
    	    
    	    $where['summary']=$_POST['gaishu'];
    	    
    	    $where['outline']=$_POST['dagang'];
    	    
    	    $where['href']=$_POST['zhanwai'];
    	    
    	    $where['mark_bit']=$_POST['shangke_value'];
    	    
    	    $where['anpai']=$_POST['anpai'];
    	    
    	    $where['nu']=$_POST['nu'];
    	    
    	    $where['is_delect']=0;
    	   
    	    $where['show_course']=$_POST['type_value'];

    	    $where['type']=1;
    	    
            $photo= $_FILES['photo'];
            
            $photo=$this->getphoto($photo);
            
            if(empty($_POST['void_url1']))
            {
                $void=$_FILES['void'];
                if(!empty($void['name']))
                {
                    $where['void']=$this->getvoids($void);
                }
            
            }
            else 
            {
                $where['cc_code']=$_POST['void_url1'];
            }
            
            $where['image']=$photo;
            
            $where['score']=$_POST['score'];
            
            $course=M('course');
            
            $list=$course->data($where)->add();
            
            $kechengbao=$_POST['kechengbao'];
            
            $kechengbao = stripslashes($kechengbao);
            
            $kechengbao='['.$kechengbao.']';
            
            $kechengbao=json_decode($kechengbao,true);
            
            $biaoqian=$_POST['biaoqian'];
            
            $biaoqian = stripslashes($biaoqian);
            
            $biaoqian='['.$biaoqian.']';

            $biaoqian=json_decode($biaoqian,true);
            
            $jiaoshi_top=$_POST['jiaoshi_top'];
            
            $jiaoshi_top = stripslashes($jiaoshi_top);
            
            $jiaoshi_top='['.$jiaoshi_top.']';
            
            $jiaoshi_top=json_decode($jiaoshi_top,true);
            
            $this->adct(3326,$list, $jiaoshi_top,1);
            
            $jiaoshi=$_POST['jiaoshi'];
            
            $jiaoshi = stripslashes($jiaoshi);
            
            $jiaoshi='['.$jiaoshi.']';
            
            $jiaoshi=json_decode($jiaoshi,true); 
            
            $this->adct(3326,$list, $jiaoshi,0);
            
            $this->adctag(3321,$list, $biaoqian);
            
            //$this->adcat(3321, $list, $kechengbao);
            
            if(empty($list))
            {
                $this->error('添加失败，未知错误');
                
                return;
            }
            
/*             if($where['mark_bit']==1)
            {
                $this->redirect("course_add?cid=$list");
            }
            else 
            { */
                $this->success('添加成功');
/*             } */
            
            
            return;
            
            

         }
         
         function zhuanti()
         {
             $this->display();
         }
         
         function zhuanti_upload()
         {
         
             header("Content-Type:text/html;charset=UTF-8");  // 解决乱码问题
         
             if(empty($_POST['biaoqian']) || empty($_POST['jiaoshi_top']) )
             {
                 $this->error('请添加导师与标签信息，',U('Incourse/index'));
                 return;
             }
         
             $where['title']=$_POST['name'];
             	
             $time=$_POST['time'];
             	
             $where['start_time']=strtotime($time);
             
             $where['course_group']=$_POST['zhuanti'];

             $where['yuanjifen']=$_POST['yuanjifen'];
             	
             $where['source']=$_POST['laiyuan'];
             	
             $where['cost']=$_POST['cost'];
             	
             $where['back_credit']=$_POST['back_credit'];
             	
             $where['language']=$_POST['yuyan'];
             	
             $where['brief']=$_POST['jianjie'];
             	
             $where['summary']=$_POST['gaishu'];
             	
             $where['outline']=$_POST['dagang'];
             	
             $where['href']=$_POST['zhanwai'];
             	
             $where['mark_bit']=$_POST['shangke_value'];
             	
             $where['anpai']=$_POST['anpai'];
             	
             $where['nu']=$_POST['nu'];
             	
             $where['is_delect']=0;
         
             $where['show_course']=$_POST['type_value'];
         
             $where['type']=$_POST['course_type_value'];
             
             $where['zhuanti']=1;
             	
             $photo= $_FILES['photo'];
         
             $photo=$this->getphoto($photo);
         
             if(empty($_POST['void_url1']))
             {
                 $void=$_FILES['void'];
                 if(!empty($void['name']))
                 {
                     $where['void']=$this->getvoids($void);
                 }
         
             }
             else
             {
                 $where['cc_code']=$_POST['void_url1'];
             }
         
             $where['image']=$photo;
         
             $where['score']=$_POST['score'];
         
             $course=M('course');
         
             $list=$course->data($where)->add();
         
             $kechengbao=$_POST['kechengbao'];
         
             $kechengbao = stripslashes($kechengbao);
         
             $kechengbao='['.$kechengbao.']';
         
             $kechengbao=json_decode($kechengbao,true);
         
             $biaoqian=$_POST['biaoqian'];
         
             $biaoqian = stripslashes($biaoqian);
         
             $biaoqian='['.$biaoqian.']';
         
             $biaoqian=json_decode($biaoqian,true);
         
             $jiaoshi_top=$_POST['jiaoshi_top'];
         
             $jiaoshi_top = stripslashes($jiaoshi_top);
         
             $jiaoshi_top='['.$jiaoshi_top.']';
         
             $jiaoshi_top=json_decode($jiaoshi_top,true);
         
             $this->adct(3326,$list, $jiaoshi_top,1);
         
             $jiaoshi=$_POST['jiaoshi'];
         
             $jiaoshi = stripslashes($jiaoshi);
         
             $jiaoshi='['.$jiaoshi.']';
         
             $jiaoshi=json_decode($jiaoshi,true);
         
             $this->adct(3326,$list, $jiaoshi,0);
         
             $this->adctag(3321,$list, $biaoqian);
         
             //$this->adcat(3321, $list, $kechengbao);
         
             if(empty($list))
             {
                 $this->error('添加失败，未知错误');
         
                 return;
             }
         
             /*             if($where['mark_bit']==1)
              {
              $this->redirect("course_add?cid=$list");
              }
              else
              { */
             $this->success('添加成功');
             /*             } */
         
         
             return;
         
         
         
         }
         
         /* 
          * 蔡政
          * 添加课程关联的导师信息
          * 输入课程id，导师id数组 
          *  */
       function adct($key,$id,$tid,$top)
       {
           (!($key==3326)) && $this->error('禁止访问',U('Incourse/index'));
           
           if(!(is_int($id)) && !(is_array($tid)))
           {
               echo "数据错误";
               return;
           }
           
           $a=0;
           
           foreach ($tid as $k=>$v)
           {
               $ct[$a]['cid']=$id;
               
               $ct[$a]['tid']=$v['id'];
               
               $ct[$a]['is_id']=$k;
               
               $ct[$a]['top']=$top;
               
               $a++;
           }
           
           $course_teacher=M('course_teacher');

           $course_teacher->addAll($ct);
       }
       /*
        * 蔡政
        * 添加课程关联的标签信息
        * 输入课程id，标签id数组
        *  */
       function adctag($key,$cid,$tid,$code)
       {
           (!($key==3321)) && $this->error('禁止访问',U('Incourse/index'));
            
           if(!(is_int($cid)) && !(is_array($tid)))
           {
               echo "数据错误";
               return;
           }
            
           $a=0;
            
           foreach ($tid as $k=>$v)
           {
               $ct[$a]['cid']=$cid;
                
               $ct[$a]['tid']=$v['id'];
               
               $ct[$a]['code']=$v['code'];
                
               $a++;
           }
            
           $course_tag=M('course_tag');
       
           $course_tag->addAll($ct);
       }
       /*
        * 蔡政
        * 添加课程关联的课程包信息
        *  */
       function adcat($key,$cid,$tid,$code)
       {
           (!($key==3321)) && $this->error('禁止访问',U('Incourse/index'));
       
           if(!(is_int($cid)) && !(is_array($tid)))
           {
               echo "数据错误";
               return;
           }
       
           $a=0;
       
           foreach ($tid as $k=>$v)
           {
               $ct[$a]['cid']=$cid;
       
               $ct[$a]['tid']=$v['id'];
                
               $ct[$a]['code']=$v['code'];
       
               $a++;
           }
       
           $course_tag=M('course_admin_tag');
            
           $course_tag->addAll($ct);
       }
       /* 
        * 
        *  上传课程图片
        *  
        *  */
	   function getvoid($void)
	   {
	        header("Content-Type:text/html;charset=UTF-8");  // 解决乱码问题
    	    $upload = new \Think\Upload();// 实例化上传类
    	    $upload->maxSize   =     3145728 ;// 设置附件上传大小
    	    $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
    	    $upload->rootPath  =     './Uploads/void/'; // 设置附件上传根目录
    	    $upload->saveName  = time().'_'.mt_rand(10,1000).mt_rand(10,1000);
    	    $upload->autoSub = false;
    	    // 上传文件
    	    $info   =   $upload->uploadOne($void);
    	    if(!$info) { // 上传错误提示错误信息
    	        echo $upload->getError(); ;
    	    }else{// 上传成功
    	       return  $image='./Uploads/void/'.$info['savename'];
    	    }
	   }
	   /* 
	    * 上传视频
	    *  */
	   function getphoto($photo)
	   {
	       header("Content-Type:text/html;charset=UTF-8");  // 解决乱码问题
	       $upload = new \Think\Upload();// 实例化上传类
	       $upload->maxSize   =     3145728 ;// 设置附件上传大小
	       $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg','mp4');// 设置附件上传类型
	       $upload->rootPath  =     './Uploads/course/'; // 设置附件上传根目录
	       $upload->saveName  = time().'_'.session('id').'_'.mt_rand(10,99);
	       $upload->autoSub = false;
	       // 上传文件
	       $info   =   $upload->uploadOne($photo);
	       if(!$info) {// 上传错误提示错误信息
	           return ;
	       }else{// 上传成功
	           return  $image='./Uploads/course/'.$info['savename'];
	       }
	   }
	   /* 
	    * 获取所有标签信息
	    *  
	    *  */
	   function gettag()
	   {
	       header("Content-Type:text/html;charset=UTF-8");  // 解决乱码问题
	       
	       $tag=M('tag');
	       
	       $list=$tag->where('is_delect != 1')->select();
	       
	       $list=json_encode($list);
	       
	       print_r($list);
	       
	   }
	   /*
	    * 获取所有课程包信息
	    *
	    *  */
	   function getkechengbao()
	   {
	       header("Content-Type:text/html;charset=UTF-8");  // 解决乱码问题
	   
	       $admin_tag=M('admin_tag');
	   
	       $list=$admin_tag->where('is_delect != 1')->select();
	   
	       $list=json_encode($list);
	   
	       print_r($list);
	   
	   }
	   /*
	    * 蔡政
	    * 获取标签
	    * 输入pid 输出子类标签
	    *  */
/* 	   function gettag_pid($id)
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
	   
	   } */
	   /* 
	    * 获取所有导师信息
	    *  */
	   function getteacher()
	   {
	       header("Content-Type:text/html;charset=UTF-8");  // 解决乱码问题
	   
	       $teacher=M('teacher');
	   
	       $list=$teacher->select();
	   
	       $list=json_encode($list);
	   
	       print_r($list);
	   
	   }
	   /*获取所有课程信息  */
	   function getzhuanti()
	   {
	       header("Content-Type:text/html;charset=UTF-8");  // 解决乱码问题
	   
	       $list=M('course')->where(array('type'=>1))->field('title,id')->select();
	   
	       $list=json_encode($list);
	   
	       print_r($list);
	   
	   }
	   function course_add()
	   {
	       
	       $cid=$_GET['cid'];
	       
	       if(empty($cid))
	       {
	           $this->error('参数错误');
	       }
	       
	       $this->assign('cid',$cid);
	       
	       $this->display();
	       
	   }
	   function upload_zhangjie()
	   {
	       

	       
	       header("Content-Type:text/html;charset=UTF-8");  // 解决乱码问题
	       
	       $cid=$_POST['course'];
	       
	       if(empty($cid))
	       {
	           echo "参数错误";
	           return;
	       } 



	       
	       $zhangjiename=$_POST['zhangjiename'];
	       
	       $xiaojiename=$_POST['xiaojiename'];
	       
	       $shipin_name=$_POST['shipin_name'];
	       
	       $shipin_url1=$_POST['shipin_url1'];
	       
	       $photo=$_FILES['photo'];
	       
	       $zhangjie=M('zhangjie');
	       
	       $a=1;
	       
	       foreach ($zhangjiename as $k=>$v)
	       {
	           if(empty($v))
	           {
	               continue;
	           }
	           
	           $data_zhangjie['is_id']=$a;
	           
	           $data_zhangjie['cid']=$cid;
	           
	           $data_zhangjie['is_zhangjie']=0;
	           
	           $data_zhangjie['name']=$v;
	           
  	           $list_zhangjie=$zhangjie->data($data_zhangjie)->add();  
	           
	           $b=1;
	           
	           foreach ($xiaojiename[$a] as $x=>$xn)
	           {
	               if(empty($xn))
	               {
	                   continue;
	               }
	               
	               $data_xiaojie['is_id']=$b;
	               
	               $data_xiaojie['cid']=$cid;
	               
	               $data_xiaojie['is_zhangjie']=$list_zhangjie;
	               
	               $data_xiaojie['name']=$xn;
	               
 	               $list_xiaojie=$zhangjie->data($data_xiaojie)->add(); 
	               
	               $shipin_name_is_id=1;
	               
	               $c=1;
	               
	               unset($data_shipin);
	               
	               unset($upphoto);
	                
	               
/* 	               print_r($shipin_name); */
	               
	               foreach ($shipin_name[$a][$b] as $sp1=>$spn)
	               {
	                   
    	               $data_shipin[$c]['is_id']=$shipin_name_is_id;
    	               
    	               $data_shipin[$c]['zhangjie_id']=$list_xiaojie;
    	               
    	               $data_shipin[$c]['name']=$spn;
    	               
    	               $c++;
    	               
    	               $shipin_name_is_id++;

	               }
	               
	               $c=1;
	               
	               foreach ($shipin_url1[$a][$b] as $sp2=>$spu)
	               {
	                   $data_shipin[$c]['void']=$spu;
	                   
	                   $c++;
	               }
	               
	               $c=1;
	               
	       
         	       foreach ($photo['name'][$a][$b] as $pn=>$pname)
        	       {
        	           
        	           $upphoto[$c]['name']=$pname;
        	           
        	           $c++;
        	           
        	       }
        	       
        	       $c=1;
        	       
        	       foreach ($photo['type'][$a][$b] as $pn=>$ptype) 
        	       {
        	           $upphoto[$c]['type']=$ptype;
        	           
        	           $c++;
        	       }
        	       
        	       $c=1;
        	       
        	       foreach ($photo['tmp_name'][$a][$b] as $pn=>$ptmp_name)
        	       {
        	           $upphoto[$c]['tmp_name']=$ptmp_name;
        	       
        	           $c++;
        	       }
        	       
        	       $c=1;
        	       
        	       foreach ($photo['error'][$a][$b] as $pn=>$perror)
        	       {
        	           $upphoto[$c]['error']=$perror;
        	       
        	           $c++;
        	       }
        	       
        	       $c=1;
        	       
        	       foreach ($photo['size'][$a][$b] as $pn=>$psize)
        	       {
        	           $upphoto[$c]['size']=$psize;
        	       
        	           $c++;
        	       }
        	       
         	       $c=1;

         	       foreach ($upphoto as $u=>$upp)
         	       {
         	           $r=$this->getvoid($upp);
         	           
         	           $data_shipin[$c]['image']=$r;
         	           
         	           $c++;
         	       }
         	       
         	       $xiaojie=M('xiaojie');
         	       
         	       foreach ($data_shipin as $dd=>$ds)
         	       {
         	       
             	      
             	        
             	       $list_xiaojie=$xiaojie->add($ds);
         	       
         	       }
         	       
        	       
	               $b++; 
	           }
	          
	           
	           
	           $a++;
	       }
	       
	       $this->success('添加成功',U('Incourse/index'));
	       
	   }
	    /*
	    * 蔡政
	    * 将标签插入标签表中
	    * 输入：标签名,父类id(pid)
	    *  */
	  /* function addtag()
	   {
	       (empty($_GET['name']) || empty($_GET['pid'])) && $this->error('参数错误',U('Index/index'));
	   
	       header("Content-Type:text/html;charset=UTF-8");  // 解决乱码问题
	   
	       $name=$_GET['name'];
	   
	       $pid=$_GET['pid'];
	   
	       $ftag=$this->ftag(7870, $pid);
	   
	       if(!(empty($ftag['is_delect'])))
	       {
	           echo "您输入的父类已删除";
	   
	           return;
	       }
	   
	       $fidnametag=$this->fidnametag(2324, $pid, $name);
	   
	       if(!(empty($fidnametag)))
	       {
	           echo "该标签分类中有相同标签,请重新编写";
	           return ;
	       }
	   
	       $code=$this->appendtagN1(1110,$pid);
	   
	       $list=$this->adtag(0101,$name,$pid,$code);
	   
	       if(empty($list))
	       {
	           echo "添加失败";
	           return;
	       }
	   
	       echo $list;
	   
	   } */
	   /*
	    * 蔡政
	    * 标签插入tag表中
	    * 输入 名称（name），父类id（pid）,编码（code）
	    * 返回1，插入成功，0插入失败
	    *  */
/* 	   function adtag($key,$name,$pid,$code)
	   {
	       (!($key==0101)) && $this->error('禁止访问',U('Index/index'));
	   
	       $tag=M('tag');
	   
	       $data['time']=time();
	   
	       $data['name']=$name;
	   
	       $data['pid']=$pid;
	   
	       $data['code']=$code;
	   
	       $data['is_delect']=0;
	   
	       $list=$tag->data($data)->add();
	   
	       return $list;
	   } */
	   /*
	    * 蔡政
	    * 生成编号
	    * 输入父类id（pid），输出编号
	    *  */
/* 	   function appendtagN1($key,$pid)
	   {
	       (!($key==1110)) && $this->error('禁止访问',U('Index/index'));
	   
	       header("Content-Type:text/html;charset=UTF-8");  // 解决乱码问题
	   
	       (empty($_GET['pid'])) && $this->error('参数错误',U('Index/index'));
	   
	       $pid=$_GET['pid'];
	   
	       $big_tag=$this->big_tag(7770,$pid);
	   
	       if(!(empty($big_tag['code'])))
	       {
	           $code=$big_tag['code']+1;
	            
	       }
	       else
	       {
	   
	           $ftag=$this->ftag(7870,$pid);
	   
	           if(!(empty($ftag['code'])))
	           {
	               $code=$ftag['code'].'001';
	           }
	           else
	           {
	               echo "父类不存在";
	   
	               return;
	           }
	       }
	   
	       return $code;
	   
	   } */
	   /*
	    * 蔡政
	    * 搜索标签
	    * 输入标签pid 输出最大code值的标签信息
	    *  */
/* 	   function big_tag($key,$pid)
	   {
	       (!($key==7770)) && $this->error('禁止访问',U('Index/index'));
	   
	       (empty($_GET['pid'])) && $this->error('参数错误',U('Index/index'));
	   
	       $pid=$_GET['pid'];
	   
	       $tag=M('tag');
	   
	       $list=$tag->where("pid=$pid")->order('code desc')->find();
	   
	       return $list;
	   } */
	   /*
	    * 蔡政
	    * 搜索标签
	    * 输入标签id，输出标签信息
	    *  */
/* 	   function ftag($key,$id)
	   {
	       (!($key==7870)) && $this->error('禁止访问',U('Index/index'));
	   
	       $tag=M('tag');
	   
	       $where["id"]=$id;
	   
	       $list=$tag->where($where)->where("is_delect !=1")->find();
	   
	       return $list;
	   } */
	   /*
	    * 蔡政
	    * 搜索标签
	    * 输入标签pid，name 输出标签信息
	    *  */
/* 	   function fidnametag($key,$pid,$name)
	   {
	       (!($key==2324)) && $this->error('禁止访问',U('Index/index'));
	   
	       $tag=M('tag');
	   
	       $where['pid']=$pid;
	   
	       $where['name']=$name;
	   
	       $list=$tag->where($where)->where("is_delect !=1")->select();
	   
	       return $list;
	   } */
	   /*
	    * 蔡政
	    * 删除标签
	    * 输入id,删除该标签并删除所有子类标签
	    *   */
/* 	   function deletag($key,$key1,$code)
	   {
	   
	       (!($key==1245)) && $this->error('禁止访问',U('Index/index'));
	   
	       (!($key1==2398)) && $this->error('禁止访问',U('Index/index'));
	   
	       $tag=M('tag');
	   
	       $data['is_delect']=1;
	   
	       $where_p['code']=array('like',$code."%");
	   
	       $list=$tag->where($where_p)->save($data);
	   
	       return $list;
	   
	   } */
	   
	  /*  function detag()
	   {
	       $id=$_GET['id'];
	   
	       header("Content-Type:text/html;charset=UTF-8");  // 解决乱码问题
	   
	       if($id==1 || $id==2)
	       {
	           echo "此标签不可删除";
	   
	           return;
	       }
	   
	   
	       $ftag=$this->ftag(7870, $id);
	   
	       if(empty($ftag['code']))
	       {
	           echo "此标签不存在";
	           return;
	       }
	   
	   
	   
	       $list=$this->deletag(1245, 2398, $ftag['code']);
	   
	       if(empty($list))
	           echo '删除失败，未知错误！！';
	       else
	           echo '删除成功';
	   } */
	   
	   
	   /*
	    * 蔡政
	    * 获取标签
	    * 输入pid 输出子类标签
	    *  */
	   /*     function prtag($id)
	    {
	    $list=$this->sousuo_tag($id);
	   
	    return($list);
	    } */
	   /* function saname()
	   {
	   
	       $id=$_GET['id'];
	        
	       $name=$_GET['name'];
	        
	       $ftag=$this->ftag(7870, $id);
	        
	       if(empty($ftag['code']))
	       {
	           echo "此标签不存在";
	           return;
	       }
	        
	       $fidnametag=$this->fidnametag(2324, $ftag['pid'], $name);
	        
	       if(!(empty($fidnametag)))
	       {
	           echo "该标签分类中有相同标签,请重新编写";
	           return ;
	       }
	        
	       $list=$this->name(7839, $id, $name);
	        
	       if(empty($list))
	       {
	           echo "修改失败";
	       }
	       else
	       {
	           echo 1;
	       }
	        
	   } */
	   /*
	    * 蔡政
	    * 修改标签，输入id,name
	    *  */
/* 	   function name($key,$id,$name)
	   {
	       (!($key==7839)) && $this->error('禁止访问',U('Index/index'));
	   
	   
	   
	       $tag=M('tag');
	   
	       $where['id']=$id;
	   
	       $data['name']=$name;
	   
	       $list=$tag->where($where)->save($data);
	   
	       if(empty($list))
	           return  0;
	       else
	           return 1;
	   
	   }  */
	   function table()
	   {
	   
	       header("Content-Type:text/html;charset=UTF-8");  // 解决乱码问题
	   
	       $course=M('course');
	  	 $count=M('course')->where(array('type'=>1,'zhuanti'=>0))->count();
		$Page       = new \Think\Page($count,15);
		$show       = $Page->show();// 分页显示输出
//	       $list=$course->order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
 	       $list=M('course c')->join("LEFT JOIN course_user cu ON c.id=cu.cid")->where('c.type=1 and c.zhuanti=0')->group('c.id')->order('c.id desc')->limit($Page->firstRow.','.$Page->listRows)->field('c.*,count(cu.id) as nuadd')->select();
 	   $this->assign('page',$show);
	       $this->assign('list',$list);
	       
	       $this->display();
	   }
	   function zhuanti_table()
	   {
	   
	       header("Content-Type:text/html;charset=UTF-8");  // 解决乱码问题
	   
	       $course=M('course');
	       $count=M('course')->where(array('type'=>1,'zhuanti'=>1))->count();
	       $Page       = new \Think\Page($count,15);
	       $show       = $Page->show();// 分页显示输出
	       //	       $list=$course->order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
	       $list=M('course c')->join("LEFT JOIN course_user cu ON c.id=cu.cid")->where('c.zhuanti=1')->group('c.id')->order('c.id desc')->limit($Page->firstRow.','.$Page->listRows)->field('c.*,count(cu.id) as nuadd')->select();
	       $this->assign('page',$show);
	       $this->assign('list',$list);
	   
	       $this->display();
	   }
	   /*
	    * 删除课程
	    * 输入课程id，删除课程
	    *  */
	   function del($id)
	   {
	       $course=M('course');
	   
	       $where['id']=$id;
	   
	       $data['is_delect']=1;
	   
	       $list=$course->where($where)->save($data);
	   
	       echo $list;
	   }
	   /*
	    * 恢复课程
	    * 输入课程id，恢复课程
	    *  */
	   function sav($id)
	   {
	       $course=M('course');
	   
	       $where['id']=$id;
	   
	       $data['is_delect']=0;
	   
	       $list=$course->where($where)->save($data);
	   
	       echo $list;
	   }
	   function xiugai($id)
	   {
	       
	       header("Content-Type:text/html;charset=UTF-8");  // 解决乱码问题
	       
	       $course=M('course');
	   
	       $where['id']=$id;
	   
	       $list=$course->where($where)->select();
	   
	       $this->assign('list',$list);
	       
	       $this->assign('course',$id);
	   
	       $this->display();
	   
	   }
	   function zhuanti_xiugai($id)
	   {
	   
	       header("Content-Type:text/html;charset=UTF-8");  // 解决乱码问题
	   
	       $course=M('course');
	   
	       $where['id']=$id;
	   
	       $list=$course->where($where)->select();
	   
	       $this->assign('list',$list);
	   
	       $this->assign('course',$id);
	   
	       $this->display();
	   
	   }
	   function zhuanti_upload_xiugai()
	   {

	       header("Content-Type:text/html;charset=UTF-8");  // 解决乱码问题
	   
	       $data['show_course']=$_POST['type_value'];
	   
	       $time=$_POST['time'];
	   
	       $data['title']=$_POST['name'];
	       	
	       /*     	    $time=$_POST['time']; */
	       	
	       $cid=$_POST['course'];
	       	
	       $where['id']=$cid;
	       	
	       /*     	    $data['start_time']=strtotime($time); */
	       	
	       $data['source']=$_POST['laiyuan'];
	       	
	       $data['youxianji']=$_POST['bit'];
	       	
	       $data['yuanjifen']=$_POST['yuanjifen'];
	       	
	       $data['language']=$_POST['yuyan'];
	       if(!empty($time))
	       {
	           $data['start_time']=strtotime($time);
	       }
	       	
	       $data['brief']=$_POST['jianjie'];
	       	
	       $data['summary']=$_POST['gaishu'];
	       	
	       $data['outline']=$_POST['dagang'];
	       	
	       $data['cost']=$_POST['cost'];
	       	
	       $data['anpai']=$_POST['anpai'];
	       	
	       $data['back_credit']=$_POST['back_credit'];
	       	
	       $data['href']=$_POST['zhanwai'];
	       	
	       $data['mark_bit']=$_POST['shangke_value'];

           $data['type']=$_POST['course_type_value'];

           $data['nu']=$_POST['nu'];
	   
	       $photo= $_FILES['photo'];
	       
	       if(!empty($_POST['zhuanti']))
	       {
	           $data['course_group']=$_POST['zhuanti'];
	       }
	   
	       if(!empty($photo['name']))
	       {
	           $photo=$this->getphoto($photo);
	   
	           $data['image']=$photo;
	       }
	   
	       if(empty($_POST['void_url1']))
	       {
	           $void=$_FILES['void'];
	           if(!empty($void['name']))
	           {
	               $data['void']=$this->getvoids($void);
	           }
	   
	       }
	       else
	       {
	           $data['cc_code']=$_POST['void_url1'];
	       }
	   
	       $data['score']=$_POST['score'];
	   
	       $course=M('course');
	   
	       $list=$course->where($where)->data($data)->save();
	   
	       if(!empty($_POST['biaoqian']))
	       {
	   
	           $this->de_c_t(7777, $cid);
	   
	           $biaoqian=$_POST['biaoqian'];
	   
	           $biaoqian = stripslashes($biaoqian);
	   
	           $biaoqian='['.$biaoqian.']';
	   
	           $biaoqian=json_decode($biaoqian,true);
	   
	           $this->adctag(3321,$cid, $biaoqian);
	       }
	   
	       if(!empty($_POST['jiaoshi']))
	       {
	   
	           $this->de_c_t1(7771, $cid,0);
	   
	           $jiaoshi=$_POST['jiaoshi'];
	   
	           $jiaoshi = stripslashes($jiaoshi);
	   
	           $jiaoshi='['.$jiaoshi.']';
	   
	           $jiaoshi=json_decode($jiaoshi,true);
	   
	           $this->adct(3326,$cid, $jiaoshi,0);
	   
	       }
	       if(!empty($_POST['cla_kechuangjiaoshi']))
	       {
	           $this->de_c_t1(7771, $cid,0);
	       }
	       if(!empty($_POST['jiaoshi_top']))
	       {
	   
	           $this->de_c_t1(7771, $cid,1);
	   
	           $jiaoshi_top=$_POST['jiaoshi_top'];
	   
	           $jiaoshi_top = stripslashes($jiaoshi_top);
	   
	           $jiaoshi_top='['.$jiaoshi_top.']';
	   
	           $jiaoshi_top=json_decode($jiaoshi_top,true);
	   
	           $this->adct(3326,$cid, $jiaoshi_top,1);
	   
	       }
	       if(!empty($_POST['kechengbao']))
	       {
	   
	           $this->de_c_a_t(7777, $cid);
	   
	           $kechengbao=$_POST['kechengbao'];
	   
	           $kechengbao = stripslashes($kechengbao);
	   
	           $kechengbao='['.$kechengbao.']';
	   
	           $kechengbao=json_decode($kechengbao,true);
	   
	           $this->adcat(3321, $cid, $kechengbao);
	   
	       }
	        
	       $this->error('添加成功',U('zhuanti_table'));
	   
	       return;
	   
	   }
	   function upload_xiugai()
	   {

	       
	        header("Content-Type:text/html;charset=UTF-8");  // 解决乱码问题
            
	        $data['show_course']=$_POST['type_value'];
            
	        $time=$_POST['time'];

    	    $data['title']=$_POST['name'];
    	    
/*     	    $time=$_POST['time']; */
    	    
    	    $cid=$_POST['course'];
    	    
    	    $where['id']=$cid;
    	    
/*     	    $data['start_time']=strtotime($time); */
    	    
    	    $data['source']=$_POST['laiyuan'];
    	    
    	    $data['botton_name']=$_POST['botton_name'];
    	    
    	    $data['forshort']=$_POST['forshort'];
    	    
    	    $data['youxianji']=$_POST['bit'];
    	    
    	    $data['yuanjifen']=$_POST['yuanjifen'];
    	    
    	    $data['language']=$_POST['yuyan'];
            if(!empty($time))
            {
                $data['start_time']=strtotime($time);
            }
    	    
    	    $data['brief']=$_POST['jianjie'];
    	    
    	    $data['summary']=$_POST['gaishu'];
    	    
    	    $data['outline']=$_POST['dagang'];
    	    
    	    $data['cost']=$_POST['cost'];
    	    
    	    $data['anpai']=$_POST['anpai'];
    	    
    	    $data['back_credit']=$_POST['back_credit'];
    	    
    	    $data['href']=$_POST['zhanwai'];
    	    
    	    $data['mark_bit']=$_POST['shangke_value'];
    	    
    	    $data['nu']=$_POST['nu'];
            
            $photo= $_FILES['photo'];
            
            if(!empty($photo['name']))
            {
                $photo=$this->getphoto($photo);
                
                $data['image']=$photo;
            }
            
            if(empty($_POST['void_url1']))
            {
                $void=$_FILES['void'];
                if(!empty($void['name']))
                {
                    $data['void']=$this->getvoids($void);
                }
            
            }
            else
            {
                $data['cc_code']=$_POST['void_url1'];
            }
            
            $data['score']=$_POST['score'];
            
            $course=M('course');
            
            $list=$course->where($where)->data($data)->save();
            
             if(!empty($_POST['biaoqian']))
            {
            
                $this->de_c_t(7777, $cid);
                
                $biaoqian=$_POST['biaoqian'];
                
                $biaoqian = stripslashes($biaoqian);
                
                $biaoqian='['.$biaoqian.']';
                
                $biaoqian=json_decode($biaoqian,true);
                
                $this->adctag(3321,$cid, $biaoqian);
            }
            
             if(!empty($_POST['jiaoshi']))
            {
            
                $this->de_c_t1(7771, $cid,0);
                
                $jiaoshi=$_POST['jiaoshi'];
                
                $jiaoshi = stripslashes($jiaoshi);
                
                $jiaoshi='['.$jiaoshi.']';
                
                $jiaoshi=json_decode($jiaoshi,true); 
                
                $this->adct(3326,$cid, $jiaoshi,0);
                
            }
            if(!empty($_POST['cla_kechuangjiaoshi']))
            {
                $this->de_c_t1(7771, $cid,0);
            }
            if(!empty($_POST['jiaoshi_top']))
            {
            
                $this->de_c_t1(7771, $cid,1);
            
                $jiaoshi_top=$_POST['jiaoshi_top'];
                
                $jiaoshi_top = stripslashes($jiaoshi_top);
                
                $jiaoshi_top='['.$jiaoshi_top.']';
                
                $jiaoshi_top=json_decode($jiaoshi_top,true);
                
                $this->adct(3326,$cid, $jiaoshi_top,1);
            
            }
            if(!empty($_POST['kechengbao']))
            {
                
                $this->de_c_a_t(7777, $cid);
                
                $kechengbao=$_POST['kechengbao'];
                
                $kechengbao = stripslashes($kechengbao);
                
                $kechengbao='['.$kechengbao.']';
                
                $kechengbao=json_decode($kechengbao,true);
                
                $this->adcat(3321, $cid, $kechengbao);
                
            }  
             
            $this->error('添加成功',U('table'));
            
            return;
	       
	   }
	  //删除课程标签
	  //输入cid
	  //删除相应课程标签信息
	function de_c_t($key,$cid)
	{

	    if($key!=7777)
	        $this->error('参数错误');
	    if(empty($cid))
	        $this->error('参数错误');

	    $list=M('course_tag')->where("cid=$cid")->delete();
	    
	}
	//删除课程包
	//输入cid
	//删除相应课程标签信息
	function de_c_a_t($key,$cid)
	{
	
	    if($key!=7777)
	        $this->error('参数错误');
	    if(empty($cid))
	        $this->error('参数错误');
	
	    $list=M('course_admin_tag')->where("cid=$cid")->delete();
	     
	}
	//删除课程导师
	//输入cid
	//删除相应课程导师信息
	function de_c_t1($key,$cid,$top)
	{
	
	    if($key!=7771)
	        $this->error('参数错误');
	    if(empty($cid))
	        $this->error('参数错误');
	
	    $list=M('course_teacher')->where("cid=$cid and top=$top")->delete();
	     
	}
	
	//教师列表
	/* public function teacherlist(){
		   $sql="1=1";
		if($_POST){
			$username=I('name');
			if($username!=''){
				$sql="name like '$username%'";
				}
			}
			
		$count=M("teacher")->where($sql)->count();
		$Page       = new \Think\Page($count,15);
		$show       = $Page->show();// 分页显示输出
		$data=M("teacher")->where($sql)->limit($Page->firstRow.','.$Page->listRows)->order("createtime desc")->select();
	
		$this->assign('data',$data);
		//print_r($data);
		 $this->assign('page',$show);
         $this->display();
		
		}  */  
	   
	   /*添加教师*/
/* 	  public function addteacher(){
		if($_POST){
			//print_r($_POST);
			 if($_FILES){
		     $upload = new \Think\Upload();// 实例化上传类
     $upload->exts      =     array('jpg', 'png', 'gif','jpeg');// 设置附件上传类型
    $upload->rootPath  =     'Uploads/'; // 设置附件上传根目录
    $upload->savePath  =     'headteacher/'; // 设置附件上传（子）目录
    $upload->subName   =   array('date','Ymd');
    $info   =   $upload->upload();
	  $file_name='/Uploads/'.$info['picurl']['savepath'].$info['picurl']['savename'];
                    $save_name=$info['picurl']['savename'];
                if (!$info) {
                    $this->error($upload->getError());
                } else {
				}
			  }else{
				  $this->error("请上传图片");
				  }
				$add=array(
		'image'=> $file_name,
		'name'=>I('name'),
		'job'=>I('job'),
		'firm'=>I('firm'),
		'istutor'=>I('istutor')
		);		  
		$res=M("teacher")->add($add);
		if($res==true){
			$this->success("添加成功",U('teacherlist'));
			}else{
				$this->error("添加失败");
				}  
			
			
			
		}else{
			 $this->display();
		}
		  
		  }  */
	   
	/*  public function editteacher(){
		 if($_POST){
			 $id=I("id");
				if($_FILES['picurl']['name']!=""){
		     $upload = new \Think\Upload();// 实例化上传类
     $upload->exts      =     array('jpg', 'png', 'gif','jpeg');// 设置附件上传类型
    $upload->rootPath  =     'Uploads/'; // 设置附件上传根目录
    $upload->savePath  =     'picture/'; // 设置附件上传（子）目录
    $upload->subName   =   array('date','Ymd');
    $info   =   $upload->upload();
	  $file_name='/Uploads/'.$info['picurl']['savepath'].$info['picurl']['savename'];
                    $save_name=$info['picurl']['savename'];
                if (!$info) {
                    $this->error($upload->getError());
                } else {
				}
			  }else{
				 $file_name=I('olurl');
				 }
				 $edit=array(
				 'picurl'=>$file_name,
				'name'=>I('name'),
		'job'=>I('job'),
		'firm'=>I('firm'),
		'istutor'=>I('istutor')
				 );
				$res=M("teacher")->where(array('id'=>$id))->save($edit);
		if($res==true){
			$this->success("修改成功",U('teacherlist'));
			}else{
				$this->error("修改失败");
		
				  }
		  }else{
			 $id=I("id");
				if(empty($id)){
					$this->error('错误操作');
					}else{
				$data=M("teacher")->where(array('id'=>$id))->find();
				$this->assign('data',$data);
			 $this->display();	   
	           			   
			}	
		}
		 }   */
	   
	  /*  public function delteacher(){
			 $id=I("id");
				if(empty($id)){
					$this->error('错误操作');
					}else{
						$image=M("teacher")->where(array('id'=>$id))->getfield('image');
						//删除图片
						 unlink($image);
				$res=M("teacher")->where(array('id'=>$id))->delete();
			if($res==true){
			$this->success("删除成功");
			}else{
				$this->error("删除失败");
		
				  }
	           			   
			}	
			} */
			
	   function xiugai_zhangjie()
	   {
	       header("Content-Type:text/html;charset=UTF-8");  // 解决乱码问题
	       
	       $id=$_GET['course'];
	       
	       $zhangjie=M('zhangjie');
	       
	       $where['cid']=$id;
	       
	       $where['is_zhangjie']=0;
	       
	       $list=$zhangjie->where($where)->order('is_id asc')->select();
	       
	       $this->assign('list',$list);
	       
	       $this->assign('cid',$id);
	       
	       $this->display();
	   }
	   function getxiaojie()
	   {
	        $id=$_GET['id'];
	        
	        $zhangjie=M('zhangjie');
	        
	        $where['is_zhangjie']=$id;
	        
	        $list=$zhangjie->where($where)->order('is_id desc')->select();
	        
	        foreach ($list as $k=>$v)
	        {
	            $list[$k]['show_time']=date("Y-m-d H:i:s",$v['show_time']);
	        }
	        
	        $list=json_encode($list);
	        
	        print_r($list);
	   }
	   function savename()
	   {
	        $id=$_GET['id'];
	       
	        $name=$_GET['name'];
	        
	        $zhangjie=M('zhangjie');
	        
	        $where['id']=$id;
	        
	        $data['name']=$name;
	        
	        $list=$zhangjie->where($where)->save($data);
	        
	        if($list)
	        {
	            echo 1;
	        }
	        else 
	        {
	            echo '修改失败未知错误';
	        }
	   }
	   
	   function saveshow_time()
	   {
	       $id=$_GET['id'];
	   
	       $name=$_GET['name'];
	        
	       $zhangjie=M('zhangjie');
	        
	       $where['id']=$id;

	       $data['show_time']=strtotime($name);
	        
	       $list=$zhangjie->where($where)->save($data);
	        
	       if($list)
	       {
	           echo 1;
	       }
	       else
	       {
	           echo '修改失败未知错误';
	       }
	   }
	   
	   function saveaddtime()
	   {
	       $id=$_GET['id'];
	   
	       $name=$_GET['name'];
	        
	       $zhangjie=M('zhangjie');
	        
	       $where['id']=$id;
	   
	       $data['and_time']=$name;
	        
	       $list=$zhangjie->where($where)->save($data);
	        
	       if($list)
	       {
	           echo 1;
	       }
	       else
	       {
	           echo '修改失败未知错误';
	       }
	   }
	   
	   function dezhangjie()
	   {
	       $id=$_GET['id'];
	       
	       $zhangjie=M('zhangjie');
	       
	       $where['id']=$id;
	       
	       $list=$zhangjie->where($where)->delete();
	       
	       if($list)
	       {
	           echo 1;
	       }
	       else
	       {
	           echo 0;
	       }
	   }
	   function adzhangjie()
	   {
	       $where['name']=$_GET['name'];
	       
	       $where['cid']=$_GET['id'];
	       
	       $is_id=$this->is_id_zhangjie($where['cid']);
	       
	       if(empty($is_id))
	       {
	           $where['is_id']=1;
	       }
	       else 
	       {
	           $where['is_id']=$is_id+1;
	       }
	       $where['is_zhangjie']=0;
	       
	       $list=M('zhangjie')->add($where);
	       
	       if(!empty($list))
	       {
	           echo $list;
	       }
	       else
	       {
	           echo "新增章节失败";
	       }
	       
	   }
	   function is_id_zhangjie($cid)
	   {
	       $zhangjie=M('zhangjie');
	   
	       $where['cid']=$cid;
	   
	       $where['is_zhangjie']=0;
	   
	       $list=$zhangjie->where($where)->order('is_id desc')->find();
	   
	       return $list['is_id'];
	   }
	   function adxiaojie()
	   {
	       $data['name']= $_GET['name'];
	       
	       $data['cid']= $_GET['id'];
	       
	       $data['is_zhangjie']= $_GET['is_zhangjie'];
	       
	       $data['show']=0;
	       
	       $is_id_xiaojie=$this->is_id_xiaojie( $data['is_zhangjie']);
	       
	       if(empty($is_id_xiaojie))
	       {
	           $is_id_xiaojie=1;
	       }
	       else 
	       {
	           $is_id_xiaojie=$is_id_xiaojie+1;
	       }

	       $data['is_id']=$is_id_xiaojie;
	       
	       $list=M('zhangjie')->add($data);
	       
	       if(!empty($list))
	       {
	           echo $list;
	       }
	       else
	       {
	           echo "新增章节失败";
	       }
	   }

	   function is_id_xiaojie($is_zhangjie)
	   {
	       $zhangjie=M('zhangjie');
	       
	       $where['is_zhangjie']=$is_zhangjie;
	       
	       $list=$zhangjie->where($where)->order('is_id desc')->find();
	       
	       return $list['is_id'];
	   }
	   function getvoid1()
	   {
	       $where['zhangjie_id']=$_GET['id'];
            
	       $xiaojie=M('xiaojie');
	       
	       $list=$xiaojie->where($where)->order('is_id desc')->select();
	       
	       $list=json_encode($list);
	       
	       print_r($list);
	   }
	   function savevoid()
	   {
	       $id=$_GET['id'];
	       
	       $xiaojie=M('xiaojie');
	       
	       $where['id']=$id;
	       
	       $list=$xiaojie->where($where)->select();
	       
	       $this->assign('list',$list);
	       
	       $this->display();
	   }
	   function savevoids()
	   {
	       if(!empty($_POST['type_value']))
	       {
	           $data['show']=$_POST['type_value'];
	       }
	       else 
	       {
	           $data['show']=0;
	       }
	       $id=$_POST['id'];
           if(empty($id))
           {
               $this->error('参数错误');
           } 
	       $name=$_POST['name'];
	       if(!empty($name))
	       {
	           $data['name']=$name;
	       }
	       
	       $zimu= $_FILES['zimu'];
	       
	       if(!empty($zimu['name']))
	       {
	       
	           $zimu=$this->getsrt($zimu);
	       
	           $data['srt']=$zimu;
	       
	       }
	       
	       $zimu1= $_FILES['ezimu'];
	       
	       if(!empty($zimu1['name']))
	       {
	       
	           $zimu1=$this->getsrt($zimu1);
	       
	           $data['srt1']=$zimu1;
	       
	       }
	       if(!empty($_POST['url']))
	       {

	           $data['cc_code']=$_POST['url'];
	       
	       }
	       
	        $list=M('xiaojie')->where("id=$id")->save($data);

	        if($list)
	        {
	            $this->success('修改成功');
	        }
	        else
	        {
	            $this->error('修改失败');
	        }
	   }
	   /*删除小节  */
	   function shanchu_xiaojie()
	   {
	       $id=$_GET['id'];
	       
	       $a=M('xiaojie')->where(array('id'=>$id))->delete();
	       
	       echo $a;
	   }
	   /* 
	    * 上传视频
	    *  */
	   function getvoids($void)
	   {
	       header("Content-Type:text/html;charset=UTF-8");  // 解决乱码问题
	       $void_url=C('void_url');
	       $upload = new \Think\Upload();// 实例化上传类
	       $upload->maxSize   =     3333145728 ;// 设置附件上传大小
	       $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg','mp4');// 设置附件上传类型
	       $upload->rootPath  =     './Uploads/voids/'; // 设置附件上传根目录
	       $upload->saveName  = time().'_'.mt_rand(10,1000).mt_rand(10,1000);
	       $upload->autoSub = false;
	       // 上传文件
	       $info   =   $upload->uploadOne($void);
	       if(!$info) { // 上传错误提示错误信息
	           echo $upload->getError(); ;
	       }else{// 上传成功
	           return  $image=$void_url.'./Uploads/voids/'.$info['savename'];
	       }
	   }
	   function addvoids()
	   {
	       $id=$_GET['id'];
	       
	       if(empty($id))
	       {
	           $this->error('参数错误');
	       }
	       
	       $this->assign('zhangjie_id',$id);
	       
	       $this->display();
	   }
	   function upvoids()
	   {
	       if(empty($_POST['type_value']))
	       {
	           $show=0;
	       }
	       else 
	       {
	           $show=$_POST['type_value'];
	       }
	       
	       $id=$_POST['id'];
	       if(empty($id))
	       {
	           $this->error('参数错误');
	       }
	       
	       $data['zhangjie_id']=$id;
	       
	       $is_id=$this->xiaojie_is_id($id);
	       
	       if(empty($is_id))
	       {
	           $is_id=1;
	       }
	       else 
	       {
	           $is_id++;
	       }
	       $data['is_id']=$is_id;
	       
	       $data['name']=$_POST['name'];
	       
	       $data['type']=0;
	       
	       $data['show']=$show;
	       
	       $zimu= $_FILES['zimu'];
	       
	       if(!empty($zimu['name']))
	       {
	       
	           $zimu=$this->getsrt($zimu);
	       
	           $data['srt']=$zimu;
	       
	       }
	       
	       $zimu1= $_FILES['ezimu'];
	       
	       if(!empty($zimu1['name']))
	       {
	       
	           $zimu1=$this->getsrt($zimu1);
	       
	           $data['srt1']=$zimu1;
	       
	       }
	       

	       $data['cc_code']=$_POST['url'];

	       $list=M('xiaojie')->add($data);
	       
	       if($list)
	       {
	           $this->success('添加成功');
	       }
	       else 
	       {
	           $this->error('添加失败');
	       }
	   }
	   function xiaojie_is_id($id)
	   {
	       $list=M('xiaojie')->where("zhangjie_id=$id")->order('is_id desc')->find();
	       
	       return $list['is_id']; 
	   }
	   function addtxt()
	   {
	       $id=$_GET['id'];
	       
	       if(empty($id))
	       {
	           $this->error('参数错误');
	       }
	       
	       $this->assign('zhangjie_id',$id);
	       
	       $this->display();
	   }
	   function savetxt()
	   {
	       $id=$_GET['id'];
	   
	       if(empty($id))
	       {
	           $this->error('参数错误');
	       }
	   
	       $this->assign('xid',$id);
	       
	       $list=M('course_file')->where(array('xid'=>$id))->find();
	       
	       $list1=M('xiaojie')->where(array('id'=>$id))->find();
	       
	       $this->assign('name',$list1['name']);
	       
	       $this->assign('show',$list1['show']);
	       
	       $list['body']=str_replace(array("\r\n", "\r", "\n"), "<br />", $list['body']);
	       
	       $list['body']=str_replace('\'','"',$list['body']);
	       
	       $this->assign('body',$list['body']);
	       
	       $this->display();
	   }
	   function upload_txt()
	   {
	       if(empty($_POST['type_value']))
	       {
	           $show=0;
	       }
	       else
	       {
	           $show=$_POST['type_value'];
	       }
	       
	       $id=$_POST['id'];
	       if(empty($id))
	       {
	           $this->error('参数错误');
	       }
	       
	       $data['zhangjie_id']=$id;
	       
	       $is_id=$this->xiaojie_is_id($id);
	       
	       if(empty($is_id))
	       {
	           $is_id=1;
	       }
	       else
	       {
	           $is_id++;
	       }
	       $data['is_id']=$is_id;
	       
	       $data['name']=$_POST['name'];
	       
	       $data['type']=1;
	       
	       $data['show']=$show;
	       
	       $list=M('xiaojie')->add($data);

	       if($list)
	       {
	           if(!empty($_POST['body']))
	           {
	               $body=stripslashes($_POST['body']);
	               
	               $body=str_replace(array("\r\n", "\r", "\n"), "<br />", $body);
	               
	               $body=str_replace('\'','"',$body);
	               
	               $data_file['body']=$body;
	           }
	           if(!empty($_POST['url']))
	           {
	               $inid=$_POST['url'];
	               
	               $information=M('information')->where(array('id'=>$inid))->find();
	               
	               if(empty($information['body'])){$this->error('资讯id错误');return ;}
	               
	               $data_file['body']=$information['body'];
	           }

	           $data_file['xid']=$list;
	           
	           $data_file['time']=time();
	           
	           $list1=M('course_file')->add($data_file);
	           
	           if(!empty($list1))
	           {
	               $this->success('添加成功');
	           }
	           else 
	           {
	               $this->error('添加失败');
	           }
	          
	       }
	       else
	       {
	           $this->error('添加失败');
	       }
	   }
	   function save_txt()
	   {

	       
	       $id=$_POST['id'];
	       
	       if(empty($id)){$this->error('参数错误');return ;}
	       
	       if(!empty($_POST['body']))
	       {
	           $str=stripslashes($_POST['body']);
	           
	           $body=str_replace(array("\r\n", "\r", "\n"), "<br />", $body);
	           
	           $body=str_replace('\'','"',$body);
	           $list=M('course_file')->where(array('xid'=>$id))->data(array('body'=>$str))->save();
	           
	       }
	       if(!empty($_POST['url']))
	       {
	           $inid=$_POST['url'];
	       
	           $information=M('information')->where(array('id'=>$inid))->find();
	       
	           if(empty($information['body'])){$this->error('资讯id');return ;}
	       
	           $data_file['body']=$information['body'];
	           
	           $list=M('course_file')->where(array('xid'=>$id))->data($data_file)->save();
	       }
	   	   if(!empty($_POST['type_value']))
	       {
	           $data['show']=$_POST['type_value'];
	       }
	       else 
	       {
	           $data['show']=0;
	       }
	       if(!empty($_POST['name']))
	       {
	           $data_xiaojie['name']=$_POST['name'];
	           	       
	       }

	       $list1=M('xiaojie')->where(array('id'=>$id))->data($data_xiaojie)->save();

	       if(!empty($list) || !empty($list1))
	       {
	           $this->success('添加成功');
	       }
	       else
	       {
	           $this->error('添加失败');
	       }
	   }
	   function sub_str($a,$str,$str1)
	   {
	       $arr=explode($str, $a);
	       $arr1=explode($str1, $arr[1]);
	       return $arr1[0];
	   }
	   /*微课标签标签部分  */
	   function weike_tag()
	   {
	       $list=M('weike_tag')->order('id asc')->select();
            
	       $this->assign('list',$list);
	       
	       $this->display();
	   }
	   //增加微课标签
	   function add_weike_tag()
	   {
	       $name=$_GET['name'];
	       
	       $list=M('weike_tag')->data(array('name'=>$name,'time'=>time()))->add();
	   
	       if(empty($list))
	       {
	           echo 0;
	       }
	       else 
	       {
	           echo $list;
	       }
	   }
	   //修改微课标签
	   function save_weike_tag()
	   {
	       $id=$_GET['id'];
	       
	       $name=$_GET['name'];
	   
	       $list=M('weike_tag')->where(array('id'=>$id))->data(array('name'=>$name))->save();
	   
	       if(empty($list))
	       {
	           echo 0;
	       }
	       else
	       {
	           echo 1;
	       }
	   }
	   //删除微课标签
	   function del_weike_tag()
	   {
	       $id=$_GET['id'];
	   
	       $list=M('weike_tag')->where(array('id'=>$id))->delete();
	   
	       if(empty($list))
	       {
	           echo 0;
	       }
	       else
	       {
	           echo 1;
	       }
	   }
	   /*微课标签end  */
	   /*微课内容操作 */
	   function add_weike()
	   {
	       $list=M('weike_tag')->order('id asc')->select();
	       $this->assign('list',$list);
	       $this->display();
	   }
	   function course_list()
	   {
	       header("Content-Type:text/html;charset=UTF-8");  // 解决乱码问题
	       $list=M('course')->where(array('is_delect != 1 and type=1'))->select();
	       $list=json_encode($list);
	       print_r($list);
	   }
	   /* 添加微课 */
	   function uplod_weike()
	   {
	       header("Content-Type:text/html;charset=UTF-8");  // 解决乱码问题
	       
	       if(empty($_POST['jiaoshi']))
	       {
	           $this->error('请添加导师信息，');
	           return;
	       }
	       
	       $where['title']=$_POST['name'];
	       
/*	       $biaoqian=$_POST['biaoqian'];
	       
 	       if(!empty($biaoqian))
	       {
	           $biaoqian = stripslashes($biaoqian);
	           
	           $biaoqian='['.$biaoqian.']';
	           
	           $biaoqian=json_decode($biaoqian,true);
	           
	           if(empty($biaoqian))
	           {
	               $where['source']=$_POST['biaoqian'];
	           }
	           else 
	           {
	               $where['source']=$biaoqian[0]['id'];
	           } 
	           
	       } */
	       
	       $where['source']=$_POST['biaoqian'];
	       
	       $where['name']=$_POST['name1'];

	       $where['brief']=$_POST['jianjie'];
	       
	       $where['cc_code']=$_POST['void_url1'];
	       	
	       $where['mark_bit']=$_POST['shangke_value'];
	       	
	       $where['nu']=$_POST['nu'];
	       	
	       $where['type']=2;
	       
	       $photo= $_FILES['photo'];
	       
	       $photo=$this->getphoto($photo);	

	       $zimu= $_FILES['zimu'];

	       $zimu=$this->getsrt($zimu);
	       
	       $where['zimu']=$zimu;
	       
	       $where['image']=$photo;
	       
	       $where['score']=$_POST['score'];
	       
	       $where['start_time']=time();
	       
	       $where['youxianji']=$_POST['youxianji'];
	       
	       $course=M('course');
	       
	       $list=$course->data($where)->add();

	       $jiaoshi=$_POST['jiaoshi'];
	       
	       $jiaoshi = stripslashes($jiaoshi);
	       
	       $jiaoshi='['.$jiaoshi.']';
	       
	       $jiaoshi=json_decode($jiaoshi,true);
	       
	       $this->adct(3326,$list, $jiaoshi,0);
	       
	       if(empty($list))
	       {
	           $this->error('添加失败，未知错误');
	       
	           return;
	       }
	       
	       $this->success('添加成功');
	       
	       return;
	   }
	   /*
	    * 上传字幕
	    *  */
	   function getsrt($photo)
	   {
	       header("Content-Type:text/html;charset=UTF-8");  // 解决乱码问题
	       $upload = new \Think\Upload();// 实例化上传类
	       $upload->maxSize   =     3145728 ;// 设置附件上传大小
	       $upload->exts      =     array('srt');// 设置附件上传类型
	       $upload->rootPath  =     './Uploads/srt/'; // 设置附件上传根目录
	       $upload->saveName  = time().'_'.session('id').'_'.mt_rand(10,99);
	       $upload->autoSub = false;
	       // 上传文件
	       $info   =   $upload->uploadOne($photo);
	       if(!$info) {// 上传错误提示错误信息
	           return ;
	       }else{// 上传成功
	           $url=c('void_url');
	           return  $image=$url.'./Uploads/srt/'.$info['savename'];
	       }
	   }
	   function table_weike()
	   {
	       $count=M('course')->where(array('type'=>2))->count();
	       $Page       = new \Think\Page($count,15);
	       $show       = $Page->show();// 分页显示输出
	       $list=M('course')->where('type=2')->order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
	       $this->assign('page',$show);
	       $this->assign('list',$list);
	       $this->display();
	   }
	   function save_weike()
	   {
	       $id=$_GET['id'];
	       if(empty($id)) {$this->error('参数错误'); return ;}       
	       $list=M('course')->where("id=$id")->select();
	       $this->assign('wid',$id);
	       $this->assign('list',$list);
	       $list1=M('weike_tag')->order('id asc')->select();
	       $name=M('weike_tag')->where(array('id'=>$list[0]['mark_bit']))->find();
	       $this->assign('name',$name['name']);
	       $this->assign('id',$name['id']);
	       $this->assign('list1',$list1);
	       $this->display();
	       
	   }
	   function uplod_save_weike()
	   {
	       
	       header("Content-Type:text/html;charset=UTF-8");  // 解决乱码问题
	       
	       $id=$_POST['id'];
	       
	       if(empty($id)){$this->error('参数错误');}
	       
	       $where['title']=$_POST['name'];
	       
/* 	       if(!empty($_POST['biaoqian']))
	       {
	           $biaoqian=$_POST['biaoqian'];
	           
	           $biaoqian = stripslashes($biaoqian);
	           
	           $biaoqian='['.$biaoqian.']';
	           
	           $biaoqian=json_decode($biaoqian,true);
	            
	           $where['source']=$biaoqian[0]['id'];
	       } */
	       
	       $where['source']=$_POST['biaoqian'];
	       
	       $where['name']=$_POST['name1'];
 
	       $where['brief']=$_POST['jianjie'];
	       
	       $where['cc_code']=$_POST['void_url1'];
	       
	       $where['mark_bit']=$_POST['shangke_value'];
 
	       $where['nu']=$_POST['nu'];
	        
	       $where['type']=2;
	       
	       $photo= $_FILES['photo'];
	       
	       if(!empty($photo['name']))
	       {
	           $photo=$this->getphoto($photo);
	           
	           $where['image']=$photo;
	       }
	       $zimu= $_FILES['zimu'];
	       
	       if(!empty($zimu['name']))
	       {
	       
	       $zimu=$this->getsrt($zimu);
	       
	       $where['zimu']=$zimu;
	       
	       }
	       
	       $where['youxianji']=$_POST['youxianji'];
	       
	       $course=M('course');
	       
	       $list=$course->where(array('id'=>$id))->data($where)->save();
	       
	       if(!empty($_POST['jiaoshi']))
	       {
	       
	           $this->de_c_t1(7771, $id,0);
	       
	           $jiaoshi=$_POST['jiaoshi'];
	       
	           $jiaoshi = stripslashes($jiaoshi);
	       
	           $jiaoshi='['.$jiaoshi.']';
	       
	           $jiaoshi=json_decode($jiaoshi,true);
	       
	           $this->adct(3326,$id, $jiaoshi,0);
	       
	       }

	       if(empty($list))
	       {
	           $this->error('修改失败，未知错误');
	       
	           return;
	       }
	       
	       $this->success('修改成功');
	       
	   }
	   function weike_top()
	   {
	       $weike_top=M('weike_top')->order('id desc')->select();
	       $this->assign('weike_top',$weike_top);
	       $this->display();
	   }
	   function addweiketop()
	   {
	       $this->display();
	   }
	   function saveweiketop()
	   {
	       
	       $id=$_GET['id'];
	       
	       if(empty($id) || is_numeric($id)==false){
	       
	           $this->error('参数错误');return;
	       }
	       
	       $list = M('weike_top')->where(array('id'=>$id))->select();
	       
	       $this->assign('list',$list);
	       
	       $this->display();
	   }
	   function weiketop()
	   {
	       $picurl=$_FILES['picurl'];
	       $photo=$this->getphoto($picurl);
	       $url=$_POST['url'];
	       $list=M('weike_top')->data(array('img'=>C('void_url').$photo,'url'=>$url,'time'=>time()))->add();
	       if(!empty($list))
	       {
	           $this->success('添加成功');
	       }
	       else 
	       {
	           $this->error('添加失败');
	       }
	   }
	   function save_weike_top()
	   {
	       $id=$_POST['id'];
	       
	       if(empty($id) || is_numeric($id)==false){
	       
	           $this->error('参数错误');return;
	       }
	       
	       $photo=$_FILES['picurl'];
	       
	       if(!empty($photo['name']))
	       {
	           $photo=$this->getphoto($photo);
	           
	           $data['img']=C('void_url').$photo;
	       }
	       if(!empty($_POST['url']))
	       {
	           $data['url']=$_POST['url'];
	       }
	       $list=M('weike_top')->where(array('id'=>$id))->data($data)->save();
	       if(!empty($list))
	       {
	           $this->success('添加成功');
	       }
	       else
	       {
	           $this->error('添加失败');
	       }
	       
	   }
	   function delweiketop($id)
	   {
	       $list=M('weike_top')->where(array('id'=>$id))->delete();
	       
	       if(!empty($list))
	       {
	           echo 1;
	       }
	       else
	       {
	           echo 0;
	       }
	   }
	   function add_zhibo()
	   {
           $whereCond = array('zhuanti'=>1, 'type'=>3);
           $zhibo_zhuanti = M('course')->where($whereCond)->select();
           $this->assign('zhuanti_list_zhibo', $zhibo_zhuanti);
	       $this->display();
	   }
	   function upload_zhibo()
	   {
	       $photo= $_FILES['photo_cover'];
	       if(empty($photo['error']))
	       {
	           $photo=$this->getphoto($photo);
	           $data['image']=$photo;
	       }
	       $photo_userout= $_FILES['photo_userout'];
	       if(empty($photo_userout['error']))
	       {
	           $photo_userout=$this->getphoto($photo_userout);
	           $data['jietu']=$photo_userout;
	       }
	       
	       
	         $data['title']=$_POST['name'];
             $data['forshort']=$_POST['forshort'];
             $data['language']=$_POST['lang'];
	         $data['start_time']=strtotime($_POST['time']);
	         $data['time_end']= strtotime($_POST['end_time']);
	         $data['name']=$_POST['place'];
	         $data['nu'] = $_POST['order'];
	         $data['cost']=$_POST['cost'];
             $data['source']=$_POST['zhubanfang'];
	         $data['href']=$_POST['zhibo_url'];
	         $data['brief']=$_POST['jianjie'];
             $data['botton_name']=$_POST['zhibo_zhuanti_value'];
             $data['youxianji']=$_POST['youxianji'];
	         $data['type']=3;
	         $data['show_course']=0;
	         $data['is_delect']=0;
	         $data['mark_bit']=1;       
	       
	       
	       $list=M('course')->data($data)->add();
	       
	       $jiaoshi=$_POST['jiaoshi'];
	       
	       $jiaoshi = stripslashes($jiaoshi);
	       
	       $jiaoshi='['.$jiaoshi.']';
	       
	       $jiaoshi=json_decode($jiaoshi,true);
	       
	       $this->adct(3326,$list, $jiaoshi,0);

	       //**kwonan** link zhuanti and zhibo
           $zhibo_zhuanti_id = $_POST['zhibo_zhuanti_value'];

	       if($zhibo_zhuanti_id != null) {
	           $whereCond = array('id'=>$zhibo_zhuanti_id);
	           $group = M('course')->where($whereCond)->getField('course_group');
               $arr = array("id"=>$list);
               $str = json_encode($arr);
               if($group != null) {
                   $group = $group.','.$str;
               } else {
                   $group = $str;
               }
               M('course')->where($whereCond)->setField('course_group', $group);
           }
	       
	       if(!empty($list))
	       {
	           $this->success('添加成功');
	       }
	       else
	       {
	           $this->error('添加失败');
	       }
	   }
	   function table_zhibo()
	   {
	       $count=M('course')->where(array('type'=>3))->count();
	       $Page       = new \Think\Page($count,15);
	       $show       = $Page->show();// 分页显示输出
	       $list=M('course')->where('type=3')->limit($Page->firstRow.','.$Page->listRows)->order('start_time desc')->select();//wenjing add order
           $a=0;
	       foreach ($list as $k=>$v)
	       {
	           $list[$a]['url']='/Zhibo/zhibo_details/zid/'.$v['id'];    
	           
	           $a++;
	       }

	       $this->assign('page',$show);
	       $this->assign('list',$list);
	       $this->display();
	   }
	   function save_zhibo()
	   {
	       
	       
	       $id=$_GET['id'];
	       
	       if(empty($id) || is_numeric($id)==false){
	       
	           $this->error('参数错误');return;
	       }
	       
	       $list=M('course')->where(array('id'=>$id,'type'=>3))->select();
	       
	       if(empty($list[0]['id']))
	       {
	           $this->error('参数错误');return;
	       }

           $this->assign('list',$list);

           //*kwonan* select
           $whereCond = array('zhuanti'=>1, 'type'=>3);
           $zhibo_zhuanti = M('course')->where($whereCond)->select();
           $this->assign('zhuanti_list_zhibo', $zhibo_zhuanti);

	       $this->display();
	   }
	   
	   function save_uplod_zhibo()
	   {
	       
	       $id=$_POST['id'];
	       
	       if(empty($id) || is_numeric($id)==false){
	       
	           $this->error('参数错误');return;
	       }
	       
 	       $photo= $_FILES['photo_cover'];
	       if(empty($photo['error']))
	       {
	           $photo=$this->getphoto($photo);
	           $data['image']=$photo;
	       }
	       $photo_userout= $_FILES['photo_userout'];
	       if(empty($photo_userout['error']))
	       {
	           $photo_userout=$this->getphoto($photo_userout);
	           $data['jietu']=$photo_userout;
           }
	       
	       if(!empty($_POST['end_time']))
	       {
	           $data['time_end']= strtotime($_POST['end_time']);
	       }
	       if(!empty($_POST['time']))
	       {
	           $data['start_time']= strtotime($_POST['time']);
	       }

           $data['title'] = $_POST['name'];
           $data['name'] = $_POST['place'];
           $data['language'] = $_POST['lang'];
           $data['source'] = $_POST['zhubanfang'];
           $data['href'] = $_POST['zhibo_url'];
           $data['brief'] = $_POST['jianjie'];
           $data['nu'] = $_POST['order'];
           $data['cost'] = $_POST['cost'];
           $data['youxianji'] = $_POST['youxianji'];
           $data['botton_name'] = $_POST['zhibo_zhuanti_value'];


           $origin_zhuanti_id = M('course')->where(array('id' => $id))->getField('botton_name');

           if ($origin_zhuanti_id != $_POST['zhibo_zhuanti_value']) {
               $zhibo_zhuanti_id = $_POST['zhibo_zhuanti_value'];

               if ($zhibo_zhuanti_id != null) {
                   $whereCond = array('id' => $zhibo_zhuanti_id);
                   $group = M('course')->where($whereCond)->getField('course_group');
                   $arr = array("id" => $id);
                   $str = json_encode($arr);
                   if ($group != null) {
                       $group = $group . ',' . $str;
                   } else {
                       $group = $str;
                   }
                   M('course')->where($whereCond)->setField('course_group', $group);
               }

               if ($origin_zhuanti_id != null) {
                   $whereCond = array('id' => $origin_zhuanti_id);
                   $group = M('course')->where($whereCond)->getField('course_group');
                   $arr = array("id" => $id);
                   $str = json_encode($arr);
                   $group = str_replace($str . ',', '', $group);
                   $group = str_replace('.' . $str, '', $group);
                   $group = str_replace($str, '', $group);

                   M('course')->where($whereCond)->setField('course_group', $group);
               }
           }

           $list = M('course')->where(array('id' => $id))->data($data)->save();

	       
	       if(!empty($_POST['jiaoshi']))
	       {
	       
	           $this->de_c_t1(7771, $id,0);
	       
	           $jiaoshi=$_POST['jiaoshi'];
	       
	           $jiaoshi = stripslashes($jiaoshi);
	       
	           $jiaoshi='['.$jiaoshi.']';
	       
	           $jiaoshi=json_decode($jiaoshi,true);
	       
	           $this->adct(3326,$id, $jiaoshi,0);
	           
	           $this->success('修改成功');
	       
	       }
	       else 
	       {
    	       if(!empty($list))
    	       {
    	           $this->success('修改成功');
    	       }
    	       else
    	       {
    	           $this->error('修改失败');
    	       }
	       }
	   }
	   function show_xiaojie($id)
	   {
	   	 if(empty($id) || is_numeric($id)==false)
	   	 {echo null;return;}
	   	 
	   	 $zhangjie=M('zhangjie')->where(array('id'=>$id,'is_zhangjie'=>array('neq',0)))->find();
	   	 
	   	 if(empty($zhangjie['id'])){echo null;return;}
	   	 
	   	 if(empty($zhangjie['show']))
	   	 {
	   	 	$data['show']=1;
	   	 }
	   	 else
	   	 {
	   	 	$data['show']=0;
	   	 }
	   	 
	   	 $list=M('zhangjie')->where(array('id'=>$zhangjie['id']))->save($data);
	   	 
	   	 if(empty($list))
	   	 {
	   	 	echo null;
	   	 	return;
	   	 }
	   	 else 
	   	 {
	   	 	echo $data['show'];
	   	 	return;
	   	 }
	   }
}