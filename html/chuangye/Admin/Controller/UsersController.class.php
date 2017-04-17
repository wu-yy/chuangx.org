<?php
namespace Admin\Controller;
use Think\Controller;
class UsersController extends CommonController {
	public function lists(){
	    $key=I('key');
	    if(empty($key))
	    {  
              $count=M("user")->count();
            
              $Page       = new \Think\Page($count,15);
             
              $show       = $Page->show();// 分页显示输出
             
              $data=M("user u")->join("LEFT JOIN uinfo e ON u.id=e.userid")->where(array('is_delect'=>0))->order('u.id desc')->field("u.id as uid,u.*,e.*")->limit($Page->firstRow.','.$Page->listRows)->select();
	    }
	    else
	    {
	        
	        $sql=" (e.nikename like '%$key%') or (u.useremail like '%$key%') or (u.usermobilenum like '%$key%') ";
	        
	        $count=M("user u")->join("LEFT JOIN uinfo e ON u.id=e.userid")->where($sql)->count();
	        
// 	        $Page       = new \Think\Page($count,15);
	        
// 	        $show       = $Page->show();// 分页显示输出
	        
	        $data=M("user u")->join("LEFT JOIN uinfo e ON u.id=e.userid")->where($sql)->field("u.id as uid,u.*,e.*")->select();
	        
	        
	    }
    	$this->assign('data',$data);
    	
    	$this->assign('count',$count);
    	
    	$this->assign('page',$show);// 赋值分页输出
    	
    	$this->display();
	}
	
	
	

	public function deluser(){
	    
		$id= I('id');
		
		if(empty($id))
		{
		    $this->error("参数错误");
		}
		
		$userfind=M('user')->where(array('id'=>$id))->find();
		
		$data_edituser=array(
		    
		    'password'=>'',
		    
		    'openid'=>'',
		    
		    'phone_openid'=>'',
		    
		    'useremail'=>'',
		    
		    'usermobilenum'=>'',
		    
		    'xuetang_id'=>'',
		    
		    'is_delect'=>1,
		    
		);
		
		$data_deuser=array(
		    
		    'uid'=>$userfind['id'],
		    
		    'password'=>$userfind['$userfind'],
		    
		    'openid'=>$userfind['openid'],
		    
		    'phone_openid'=>$userfind['phone_openid'],
		    
		    'useremail'=>$userfind['useremail'],
		    
		    'usermobilenum'=>$userfind['usermobilenum'],
		    
		    'xuetang_id'=>$userfind['xuetang_id'],
		    
		);
		
		$ad=M('deuser')->data($data_deuser)->add();
		
		if(empty($ad))
		{
		    $this->error("删除失败");
		    
		    return;
		}
		
		$delReturn = M('user') -> where(array('id'=>$id))->data($data_edituser) -> save();

		if(!empty($delReturn))
		{
		    
			$this->success("删除成功");
			
		}
		else
		{
			$this->error("删除失败");
	    }
}
	
	//重置密码
	public function resetpwd(){
		$id=I('id');
			if(!empty($id)){
			$edit=array(
			'password'=>md5('12345678')
			);
			$res=M("user")->where(array('id'=>$id))->save($edit);
			if($res==true){
					$this->success('密码重置成功');
				}else{
					$this->error('密码重置失败');
					
					}
			}else{
				$this->error('错误操作');
				}
		}
	//查看详情
	public function detail(){
		$id=I('id');
			if(!empty($id)){
			$data=M("user u")->join("uinfo e ON u.id=e.userid")->where(array('u.id'=>$id))->find();
		    $this->assign('data',$data);
			$this->display();
			}else{
			$this->error('错误操作');
				}
		}

   //导出用户
   public function exportusers(){
	   $data=M("user u")->join("uinfo e ON u.id=e.userid")->where($sql)->limit($Page->firstRow.','.$Page->listRows)->select();
      	$xlsName  = "用户列表";
        $xlsCell  = array(
        array('userid','序号'),
        array('nikename','用户昵称'),
        array('username','真实姓名'),
        array('usermobilenum','手机号'),
        array('useremail','邮箱'),
        array('usertype','用户类型'),
        array('addtime','创建时间')
        );
		
			foreach($data as $keys=>$val){
   		        if($val['usertype']==0){
				$xlsCell[$key]['usertype']='系统用户';	
				}else if($val['usertype']==1){
				$xlsCell[$key]['usertype']='qq用户';	
				}else if($val['usertype']==2){
				$xlsCell[$key]['usertype']='新浪用户';	
				}else if($val['usertype']==3){
				$xlsCell[$key]['usertype']='微信用户';	
				}else if($val['usertype']==4){
				$xlsCell[$key]['usertype']='学堂在线';	
				}
		
   		     }
   		
   		  $this->exportExcel($xlsName,$xlsCell,$data);
		
		
	   }
   
   
   
   
     
	   //导出
	public function exportExcel($expTitle,$expCellName,$expTableData){
        $xlsTitle = iconv('utf-8', 'gb2312', $expTitle);//文件名称
        $fileName =$xlsTitle.date('_YmdHis');//or $xlsTitle 文件名称可根据自己情况设定
        $cellNum = count($expCellName);
        $dataNum = count($expTableData);
      import('Org.Util.PHPExcel');

                    $objPHPExcel = new \PHPExcel();
        $cellName = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ');
        
      //  $objPHPExcel->getActiveSheet(0)->mergeCells('A1:'.$cellName[$cellNum-1].'1');//合并单元格
       // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $expTitle.'  Export time:'.date('Y-m-d H:i:s'));  
        for($i=0;$i<$cellNum;$i++){
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$i].'1', $expCellName[$i][1]); 
        } 
          // Miscellaneous glyphs, UTF-8   
        for($i=0;$i<$dataNum;$i++){
          for($j=0;$j<$cellNum;$j++){
            $objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$j].($i+2), $expTableData[$i][$expCellName[$j][0]]);
          }             
        }  
        
        header('pragma:public');
        header('Content-type:application/vnd.ms-excel;charset=utf-8;name="'.$xlsTitle.'.xls"');
        header("Content-type:application/vnd.ms-excel"); 
        header("Content-Disposition:attachment;filename=$fileName.xls");//attachment新窗口打印inline本窗口打印
		// 保存
           import('Org.Util.PHPExcel.IOFactory');
          $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  
        $objWriter->save('php://output'); 
        exit;   
    }
	
	
	//导入
       public function leadusers(){
		   if($_FILES){

set_time_limit(0);  
		     $upload = new \Think\Upload();// 实例化上传类
     $upload->exts      =     array('xlsx', 'xls');// 设置附件上传类型
    $upload->rootPath  =     'Uploads'; // 设置附件上传根目录
    $upload->savePath  =     'Excel/'; // 设置附件上传（子）目录
    $upload->subName   =   array('date','Ymd');
    $info   =   $upload->upload();
	  $file_name='./Uploads/'.$info['excel']['savepath'].$info['excel']['savename'];
                    $save_name=$info['excel']['savename'];
                if (!$info) {
                    $this->error($upload->getError());
                } else {
				}
		  vendor('PHPExcel.PHPExcel.IOFactory');

                    $PHPExcel = new \IOFactory();
                    $file_name='./Uploads/'.$info['excel']['savepath'].$info['excel']['savename'];
                    $save_name=$info['excel']['savename'];
                    $objReader = $PHPExcel->createReader('Excel2007');
                    $objPHPExcel = $objReader->load($file_name,$encode='utf-8');
                    $sheet = $objPHPExcel->getSheet(0);
                    $highestRow = $sheet->getHighestRow(); // 取得总行数
                    $highestColumn = $sheet->getHighestColumn(); // 取得总列数
					 for($i=1;$i<=$highestRow;$i++){
				$user_name=$objPHPExcel->getActiveSheet()->getCell("A".$i)->getValue();
				$usermobilenum=$objPHPExcel->getActiveSheet()->getCell("B".$i)->getValue();
				$useremail=$objPHPExcel->getActiveSheet()->getCell("C".$i)->getValue();
				$password=$objPHPExcel->getActiveSheet()->getCell("D".$i)->getValue();
				$nickname=$objPHPExcel->getActiveSheet()->getCell("E".$i)->getValue();
				$username=$objPHPExcel->getActiveSheet()->getCell("F".$i)->getValue();
				if($user_name=="" || $usermobilenum=="" || $useremail==""){
				$num=M("user")->where("user_name='$user_name' or usermobilenum='$usermobilenum' or useremail='$useremail'")->count();
				if($num==0){
					$password=$password==""?'123456':$password;
					$adddata=array(
					'user_name'=>$user_name,
					'usermobilenum'=>$usermobilenum,
					'useremail'=>$useremail,
					'usertype'=>4,
					'password'=>md5($password)
					);
					$userid=M("user")->add($adddata);
					$addarr=array(
					'userid'=>$userid,
					'nikename'=>$nickname,
					'username'=>$username
					);
					M("uinfo")->add($addarr);
					}
					 
		   }
		  }
		  $this->success("导入成功",U('lists'));
		   }else{
			 
			   $this->display();
			   

		   }	
	   }
	

	public function tests(){
		
		   echo 456;
			print_r($_FILES);
set_time_limit(0);  
		     $upload = new \Think\Upload();// 实例化上传类
     $upload->exts      =     array('xlsx', 'xls');// 设置附件上传类型
    $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
    $upload->savePath  =     'Excel/'; // 设置附件上传（子）目录
    $upload->subName   =   array('date','Ymd');
    $info   =   $upload->upload($_FILES);
	  $file_name='./Uploads/'.$info['excel']['savepath'].$info['excel']['savename'];
                 //   $save_name=$info['excel']['savename'];
                if (!$info) {
                    $this->error($upload->getError());
                } else {
					//  echo $info['savepath'].$info['savename'];
				}
			
			import('Org.Util.reader'); 
			
			
			$reader=new \Spreadsheet_Excel_Reader();
		   $reader->setOutputEncoding('CP1251');
		    $reader->read($file_name);
		   
error_reporting(E_ALL ^ E_NOTICE);

for ($i = 1; $i <=$reader->sheets[0]['numRows']; $i++) {
	for ($j = 1; $j <=$reader->sheets[0]['numCols']; $j++) {
		echo "\"".$reader->sheets[0]['cells'][$i][$j]."\",";
	}
	echo "\n";

}
		}
		
		/* 用户组管理 */
		function add_group()
		{
		    $this->display();
		}
	    function upload_add_group()
	    {
	        $name=$_POST['name'];
	        
	        $nu=$_POST['nu'];
	        
	        if(empty($nu)||is_numeric($nu)==false)
	        {
	            $this->error('群组最大人数只能为整数');
	        }
	        
	        if(empty($name))
	        {
	            $this->error('请输入用户组名称');
	        }
	        
	        $logo=$_FILES['logo'];
	        
	        if(empty($logo['name']))
	        {
	            $this->error('请上传用户组logo图片');
	        }
	        
	        $photo=$_FILES['photo'];
	        
	        if(empty($photo['name']))
	        {
	            $this->error('请上传用户组封面图片');
	        }
	        
	        $image=$_FILES['image'];
	         
	        if(empty($image['name']))
	        {
	            $this->error('请上传用户组封面图片');
	        }
	        
	        $re_logo=$this->getphoto($logo);
	        
	        if(empty($re_logo))
	        {
	            $this->error('上传logo失败，未知错误');
	        }
	        
	        $re_photo=$this->getphoto($photo);
	        
	        if(empty($re_photo))
	        {
	            $this->error('上传封面失败，未知错误');
	        }
	        
	        $re_image=$this->getphoto($image);
	         
	        if(empty($re_image))
	        {
	            $this->error('上传封面失败，未知错误');
	        }
	        
	        if(empty($_POST['type_value']))
	        {
	            $type=1;
	        }
	        else 
	        {
	            $type=$_POST['type_value'];
	        }
	        
	        $list=M('group1')->data(array('max_nu'=>$nu,'image'=>$re_image,'name'=>$name,'time'=>time(),'type'=>$type,'img'=>$re_photo,'img_logo'=>$re_logo,'is_delect'=>0))->add();
	    
	        if(empty($list))
	        {
	            $this->error('添加用户组失败，未知错误');
	        }
	        else 
	        {
	            $this->success('添加用户组成功');
	        }
	    
	    }
	    /*
	     * 上传图片
	     *  */
	    function getphoto($photo)
	    {
	        header("Content-Type:text/html;charset=UTF-8");  // 解决乱码问题
	        $upload = new \Think\Upload();// 实例化上传类
	        $upload->maxSize   =     3145728 ;// 设置附件上传大小
	        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg','mp4');// 设置附件上传类型
	        $upload->rootPath  =     './Uploads/enterprise/'; // 设置附件上传根目录
	        $upload->saveName  = time().'_'.session('id').'_'.mt_rand(10,99).'_'.mt_rand(10,99).'_'.mt_rand(10,99).'_'.mt_rand(10,99).'_enterprise';
	        $upload->autoSub = false;
	        // 上传文件
	        $info   =   $upload->uploadOne($photo);
	        if(!$info) {// 上传错误提示错误信息
	            return 0;
	        }else{// 上传成功
	            return  $image='./Uploads/enterprise/'.$info['savename'];
	        }
	    }
	    function group_table()
	    {
	        $list=M('group1')->select();
	        
	        $a=0;
	        
	        foreach ($list as $k=>$v)
	        {
	            $list[$a]['img']=C('void_url').$v['img'];
	            $list[$a]['img_logo']=C('void_url').$v['img_logo'];
	            $list[$a]['url_code'] = U('Home/Index/group_login', array('code'=>$v[code]));//wenjing add
	            $a++;
	        }
	        
	        $this->assign('list',$list);
	        
	        $this->display();
	    }
	    function del_group()
	    {
	        if(empty($_GET['id']) || is_numeric($_GET['id'])==false)
	        {
	            echo 0;
	            return;
	        }
	        
	        $list=M('group1')->where(array('id'=>$_GET['id'],'is_delect'=>0))->find();
	        
	        if(empty($list['name']))
	        {
	            echo 0;
	            return;
	        }
	        
	        $save_group=M('group1')->where(array('id'=>$_GET['id']))->data(array('is_delect'=>1))->save();
	    
	        if(empty($save_group))
	        {
	            echo 0;
	        }
	        else 
	        {
	            echo 1;
	        }
	    } 
	    function save_group()
	    {
	        if(empty($_GET['id']) || is_numeric($_GET['id'])==false)
	        {
	            echo 0;
	            return;
	        }
	         
	        $list=M('group1')->where(array('id'=>$_GET['id'],'is_delect'=>1))->find();
	         
	        if(empty($list['name']))
	        {
	            echo 0;
	            return;
	        }
	         
	        $save_group=M('group1')->where(array('id'=>$_GET['id']))->data(array('is_delect'=>0))->save();
	         
	        if(empty($save_group))
	        {
	            echo 0;
	        }
	        else
	        {
	            echo 1;
	        }
	    }  
	    function sa_group()
	    {
	        if(empty($_GET['id']) || is_numeric($_GET['id'])==false)
	        {
	            $this->error('参数错误');
	            return;
	        }
	        
	        $list=M('group1')->where(array('id'=>$_GET['id']))->select();
	        
	        if(empty($list[0]['name']))
	        {
	            $this->error('参数错误');
	            return;
	        }
	        
	        $this->assign('list',$list);
	        
	        $this->display();

	        
	    }
	    function upload_save_group()
	    {
	        $id=$_POST['id'];
	        
	        if(empty($id) || is_numeric($id)==false)
	        {
	            $this->error('参数错误');
	            return;
	        }
	        
	        $list=M('group1')->where(array('id'=>$id))->find();
	        
	        if(empty($list['name']))
	        {
	            $this->error('参数错误');
	            return;
	        }
	        
	        $data['name']=$_POST['name'];
	        
	        if(empty($_POST['nu']) || is_numeric($_POST['nu'])==false)
	        {}
	        else 
	        {
	            $data['max_nu']=$_POST['nu'];
	        }
	        
	        $logo=$_FILES['logo'];
	        
	        if(!empty($logo['name']))
	        {
	           $logo_url=$this->getphoto($logo);

	           $data['img_logo']=$logo_url;
	        }
	        
	        if(!empty($_POST['type_value']))
	        {
	            $data['type']=$_POST['type_value'];
	        }
	        
	        $photo=$_FILES['photo'];
	        
	        if(!empty($photo['name']))
	        {
	            $photo_url=$this->getphoto($photo);
	            
	            $data['img']=$photo_url;
	        }
	        
	        $image=$_FILES['image'];
	         
	        if(!empty($image['name']))
	        {
	            $image_url=$this->getphoto($image);
	             
	            $data['image']=$image_url;
	        }
	        
	        $return=M('group1')->where(array('id'=>$id))->data($data)->save();
	        
	        if(empty($return))
	        {
	            $this->error('修改失败，未知错误');
	        }
	        else 
	        {
	            $this->success('修改成功');
	        }
	        
	    }
	    function add_course_group()
	    {
	        $id=$_GET['gid'];
	        
	        if(empty($id) || is_numeric($id)==false)
	        {
	            $this->error('参数错误');
	            return;
	        }
	         
	        $list1=M('group1')->where(array('id'=>$id))->find();
	         
	        if(empty($list1['name']))
	        {
	            $this->error('参数错误');
	            return;
	        }
	        
	        $list=M('course_group cg')->join('left join course c on c.id=cg.cid')->where(array('cg.gid'=>$id,'cg.type'=>1,'cg.is_delect'=>0))->order('cg.end_time asc')->field('cg.id,c.title,cg.end_time')->select();
            
	        $this->assign('list',$list);
	        
	        $this->assign('gid',$id);
	        
	        $this->display();
	    }
	    /* 输入课程id 添加课程 */
	    function add_course()
	    {
	        $id=$_GET['name'];
	        
	        $gid=$_GET['gid'];
	         
	        if(empty($id) || is_numeric($id)==false || empty($gid) || is_numeric($gid)==false)
	        {
	            $arr=array(0,'参数错误');
	            echo json_encode($arr);
	            return;
	        }
	        
	        $course=M('course')->where(array('id'=>$id))->find();
	        
	        if(empty($course['id']))
	        {
	            $arr=array(0,'输入的课程id有误');
	            echo json_encode($arr);
	            return;
	        }
	        
	        $group=M('group1')->where(array('id'=>$gid))->count();
	        
	        if(empty($group))
	        {
	            $arr=array(0,'该组不存在');
	            echo json_encode($arr);
	            return;
	        }
	        
	        $course_group=M('course_group')->where(array('cid'=>$course['id'],'gid'=>$gid,'type'=>1,'is_delect'=>0))->count();
	        if(!empty($course_group))
	        {
	            $arr=array(0,'该课程已录入');
	            echo json_encode($arr);
	            return;
	        }
	        
	        $data=array(
	          'cid'=> $course['id'],
	          'gid'=> $gid,
	          'time'=>time(),
	          'type'=>1,
	          'is_delect'=>0,    
	        );
	        
	        $daa_course_group=M('course_group')->data($data)->add();
	        
	        if(empty($daa_course_group))
	        {
	            $arr=array(0,'录入失败，未知错误');
	            echo json_encode($arr);
	            return;
	        }
	        else 
	        {
	            $arr=array(1,$course['title'],$daa_course_group);
	            echo json_encode($arr);
	            return;
	        }

	    }
	    function save_course()
	    {
	        $cgid=$_GET['id'];
	        $cid=$_GET['name'];
	        
	        if(checkNumber($cgid)==0 || checkNumber($cid)==0)
	        {
	            $arr=array(0,'参数错误');
	            echo json_encode($arr);
	            return;
	        }
	        
	        $course=M('course')->where(array('id'=>$cid))->find();
	         
	        if(empty($course['id']))
	        {
	            $arr=array(0,'输入的课程id有误');
	            echo json_encode($arr);
	            return;
	        }
	        
	        $course_group=M('course_group')->where(array('id'=>$cgid,'type'=>1))->find();
	        if(empty($course_group['gid']))
	        {
	            $arr=array(0,'该课程未录入');
	            echo json_encode($arr);
	            return;
	        }
	        $course_group_count=M('course_group')->where(array('gid'=>$course_group['gid'],'cid'=>$cid,'type'=>1,'is_delect'=>0))->count();
	        
	        if(!empty($course_group_count))
	        {
	            $arr=array(0,'相同组中课程不可重复');
	            echo json_encode($arr);
	            return;
	        }
	        
	        $list=M('course_group')->where(array('id'=>$cgid))->data(array('cid'=>$cid))->save();
	        
	        if(empty($list))
	        {
	            $arr=array(0,'录入失败，未知错误');
	            echo json_encode($arr);
	            return;
	        }
	        else
	        {
	            $arr=array(1,$course['title']);
	            echo json_encode($arr);
	            return;
	        }
	    }
	    /* 修改课程截止时间 */
	    function end_time()
	    {
	        $check_day=checkNumber($_POST['day']);
	        $check_id=checkNumber($_POST['id']);
	        
	        if(empty($check_day) || empty($check_id))
	        {
	            $arr=array(0,'输入的天数只能为整数');
	            echo json_encode($arr);
	            return;
	        }
            
	        $course_group=M('course_group')->where(array('id'=>$_POST['id']))->count();
	        if(empty($course_group))
	        {
	            $arr=array(0,'该课程未录入');
	            echo json_encode($arr);
	            return;
	        }
	        
	        $time=time()+60*60*24*$_POST['day'];
	        
	        $list=M('course_group')->where(array('id'=>$_POST['id']))->data(array('end_time'=>$time))->save();
	        
            if(empty($list))
            {
                $arr=array(0,'课程时间录入失败，未知错误');
                echo json_encode($arr);
                return;
            }
            else 
            {
                $date=date("Y-m-d H:i:s",$time);
                $arr=array(1,$date);
                echo json_encode($arr);
                return;
            }
	        
	    }
	    /* 删除群组课程 */
	    function del_course()
	    {
	        $id=$_GET['id'];
	        
	        if(checkNumber($id)==0)
	        {
	            $arr=array(0,'参数错误');
	            echo json_encode($arr);
	            return;
	        }
	        
	        $course_group=M('course_group')->where(array('id'=>$_GET['id']))->count();
	        if(empty($course_group))
	        {
	            $arr=array(0,'未知错误');
	            echo json_encode($arr);
	            return;
	        }
	        $list=M('course_group')->where(array('id'=>$_GET['id']))->data(array('is_delect'=>1))->save();
	        
	        if(empty($list))
	        {
	            $arr=array(0,'未知错误');
	            echo json_encode($arr);
	            return;
	        }
	        else 
	        {
	            $arr=array(1);
	            echo json_encode($arr);
	            return;
	        }
	    }
        function add_bao()
        {
            $id=$_GET['gid'];
             
            if(empty($id) || is_numeric($id)==false)
            {
                $this->error('参数错误');
                return;
            }
                       
            $list1=M('group1')->where(array('id'=>$id))->find();
            
            if(empty($list1['name']))
            {
                $this->error('参数错误');
                return;
            }
            
            $list=M('course_group cg')->join('left join admin_tag c on c.id=cg.cid')->where(array('cg.gid'=>$id,'cg.type'=>2,'cg.is_delect'=>0,'c.is_delect'=>0))->order('cg.end_time asc')->field('cg.id,c.name as title,cg.end_time')->select();
            
            
            $this->assign('list',$list);
             
            $this->assign('gid',$id);
             
            $this->display();
        }
        
        /* 输入课程id 添加课程包 */
        function add_course_bao()
        {
            $id=$_GET['name'];
             
            $gid=$_GET['gid'];
        
            if(empty($id) || is_numeric($id)==false || empty($gid) || is_numeric($gid)==false)
            {
                $arr=array(0,'参数错误');
                echo json_encode($arr);
                return;
            }
            
            if($id==1)
            {
                $arr=array(0,'课程包id不能等于1');
                echo json_encode($arr);
                return;
            }
             
            $course=M('admin_tag')->where(array('id'=>$id))->find();
             
            if(empty($course['id']))
            {
                $arr=array(0,'输入的课程包id有误');
                echo json_encode($arr);
                return;
            }
             
            $group=M('group1')->where(array('id'=>$gid))->count();
             
            if(empty($group))
            {
                $arr=array(0,'该组不存在');
                echo json_encode($arr);
                return;
            }
             
            $course_group=M('course_group')->where(array('cid'=>$course['id'],'gid'=>$gid,'type'=>2,'is_delect'=>0))->count();
            if(!empty($course_group))
            {
                $arr=array(0,'该课程包已录入');
                echo json_encode($arr);
                return;
            }
             
            $data=array(
                'cid'=> $course['id'],
                'gid'=> $gid,
                'time'=>time(),
                'type'=>2,
                'is_delect'=>0,
            );
             
            $daa_course_group=M('course_group')->data($data)->add();
             
            if(empty($daa_course_group))
            {
                $arr=array(0,'录入失败，未知错误');
                echo json_encode($arr);
                return;
            }
            else
            {
                $arr=array(1,$course['name'],$daa_course_group);
                echo json_encode($arr);
                return;
            }
        
        }
        function save_course_bao()
        {
            $cgid=$_GET['id'];
            $cid=$_GET['name'];
             
            if(checkNumber($cgid)==0 || checkNumber($cid)==0)
            {
                $arr=array(0,'参数错误');
                echo json_encode($arr);
                return;
            }
             
            if($id==1)
            {
                $arr=array(0,'课程包id不能等于1');
                echo json_encode($arr);
                return;
            }
            
            $course=M('admin_tag')->where(array('id'=>$cid))->find();
        
            if(empty($course['id']))
            {
                $arr=array(0,'输入的课程包id有误');
                echo json_encode($arr);
                return;
            }
             
            $course_group=M('course_group')->where(array('id'=>$cgid,'type'=>2))->find();
            if(empty($course_group['gid']))
            {
                $arr=array(0,'该课程未录入');
                echo json_encode($arr);
                return;
            }
            $course_group_count=M('course_group')->where(array('gid'=>$course_group['gid'],'cid'=>$cid,'type'=>2,'is_delect'=>0))->count();
             
            if(!empty($course_group_count))
            {
                $arr=array(0,'相同组中课程不可重复');
                echo json_encode($arr);
                return;
            }
             
            $list=M('course_group')->where(array('id'=>$cgid))->data(array('cid'=>$cid))->save();
             
            if(empty($list))
            {
                $arr=array(0,'录入失败，未知错误');
                echo json_encode($arr);
                return;
            }
            else
            {
                $arr=array(1,$course['name']);
                echo json_encode($arr);
                return;
            }
        }
        /* 添加群组用户 */
        function group_user()
        {
            $id=$_GET['gid'];
             
            if(empty($id) || is_numeric($id)==false)
            {
                $this->error('参数错误');
                return;
            }
             
            $list1=M('group1')->where(array('id'=>$id))->find();
            
            if(empty($list1['name']))
            {
                $this->error('参数错误');
                return;
            }
            $list=M('user_group ug')->join('left join user u on u.id=ug.uid')->where(array('ug.gid'=>$id,'ug.is_delect'=>0))->order('ug.id asc')->field('u.useremail,u.usermobilenum,ug.id,ug.type,u.id as uid')->select();

            $this->assign('list',$list);
            $this->assign('gid',$id);
            $this->display();
        }
        
        function add_group_user()
        {
            $id=$_GET['name'];
             
            $gid=$_GET['gid'];
        
            if(empty($id) || empty($gid) || is_numeric($gid)==false)
            {
                $arr=array(0,'参数错误');
                echo json_encode($arr);
                return;
            }
            
            $group=M('group1')->where(array('id'=>$gid))->count();
             
            if(empty($group))
            {
                $arr=array(0,'该组不存在');
                echo json_encode($arr);
                return;
            }
            
            $mail=strlen($id) > 6 && preg_match("/^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/", $id);
            $phone=strlen($id) == 11 && preg_match("/^1[3|4|5|8][0-9]\d{8}$/", $id);
            
            if($mail || $phone)
            {
                if($mail)
                {
                    $user_mail=M('user')->where(array('useremail'=>$id))->find();
                
                    if(empty($user_mail['id']))
                    {
                        $arr=array(0,'该邮箱号未注册');
                        echo json_encode($arr);
                        return;
                    }
                    else 
                    {
                        $uid=$user_mail['id'];
                    }
                }
                if($phone)
                {
                    $user_mail=M('user')->where(array('usermobilenum'=>$id))->find();
                
                    if(empty($user_mail['id']))
                    {
                        $arr=array(0,'该手机号未注册');
                        echo json_encode($arr);
                        return;
                    }
                    else 
                    {
                        $uid=$user_mail['id'];
                    }
                }
                
                $user_group=M('user_group')->where(array('uid'=>$uid,'gid'=>$gid,'is_delect'=>0))->find();

                if(!empty($user_group['id']))
                {
                    $arr=array(0,'该用户已加入群组');
                    echo json_encode($arr);
                    return;
                }
                else 
                {
                    $list=M('user_group')->data(array('uid'=>$uid,'gid'=>$gid,'time'=>time(),'type'=>1,'is_delect'=>0))->add();
                    
                    if(empty($list))
                    {
                        $arr=array(0,'添加失败未知错误');
                        echo json_encode($arr);
                        return;
                    }
                    else 
                    {
                        $user_group_list=M('user_group ug')->join('left join user u on u.id=ug.uid')->where(array('ug.id'=>$list))->order('ug.id desc')->field('u.useremail,u.usermobilenum,ug.id,ug.uid')->find();
                        $arr=array(1,$list,$user_group_list['usermobilenum'],$user_group_list['useremail'],$user_group_list['uid']);
                        echo json_encode($arr);
                        return;
                    }
                }
            }
            
            $arr=array(0,'请输入正确的邮箱账号或手机账号');
            echo json_encode($arr);
            return;
        
        }
        function del_group_user()
        {
            $id=$_GET['id'];
            
            if(empty($id) || is_numeric($id)==false)
            {
                $arr=array(0,'参数错误');
                echo json_encode($arr);
                return;
            }
            
            $count=M('user_group')->where(array('id'=>$id,'is_delect'=>0))->data(array('is_delect'=>1))->save();
            
            if(empty($count))
            {
                $arr=array(0,'删除失败未知错误');
                echo json_encode($arr);
                return;
            }
            else 
            {
                $arr=array(1);
                echo json_encode($arr);
                return;
            }
           
        }
        function add_information()
        {
            $id=$_GET['gid'];
             
            if(empty($id) || is_numeric($id)==false)
            {
                $this->error('参数错误');
                return;
            }
             
            $list1=M('group1')->where(array('id'=>$id))->find();
            
            if(empty($list1['name']))
            {
                $this->error('参数错误');
                return;
            }
            
            $list=M('course_group cg')->join('left join information i on i.id=cg.cid')->where(array('cg.gid'=>$id,'cg.type'=>3,'cg.is_delect'=>0))->field('i.title,cg.id')->select();

            
            $this->assign('list',$list);
            
            $this->assign('gid',$id);
            
            $this->display();
         
        }
        function add_information_group()
        {
            $id=$_GET['name'];
             
            $gid=$_GET['gid'];
            
            if(empty($id) || empty($gid) || is_numeric($gid)==false)
            {
                $arr=array(0,'参数错误');
                echo json_encode($arr);
                return;
            }
            
            $group=M('group1')->where(array('id'=>$gid))->count();
             
            if(empty($group))
            {
                $arr=array(0,'该组不存在');
                echo json_encode($arr);
                return;
            }
            
            $information=M('information')->where(array('id'=>$id))->find();
        
            if(empty($information['id']))
            {
                $arr=array(0,'该资讯不存在');
                echo json_encode($arr);
                return;
            }
            
            $course_group=M('course_group')->where(array('cid'=>$id,'gid'=>$gid,'type'=>3,'is_delect'=>0))->count();
            
            if(!empty($course_group))
            {
                $arr=array(0,'该资讯已录入');
                echo json_encode($arr);
                return;
            }
            
            $list=M('course_group')->data(array('cid'=>$id,'gid'=>$gid,'type'=>3,'is_delect'=>0,'time'=>time()))->add();
            
            if(empty($list))
            {
                $arr=array(0,'录入失败，未知错误');
                echo json_encode($arr);
                return;
            }
            else
            {
                $arr=array(1,$information['title'],$list);
                echo json_encode($arr);
                return;
            }
        }
        function shengcheng_code($type,$key,$nu)
        {
            if($key != 5032){return;}
            
            $sl=strlen($nu);
            
            if($sl<3)
            {
                for($a=3-$sl;$a>0;$a--)
                {
                    $nu='0'.$nu;
                }
                
                $strlen=3;
            }
            else 
            {
                $strlen=$sl;
            }
            
            $nu=strval($nu);
            
            $arr_english=array('9','8','7','6','5','4','3','2','1','0','q','w','e','r','t','y','u','i','o','p','a','s','d','f','g','h','j','k','l','z','x','c','v','b','n','m');
        
            $rand_keys = array_rand($arr_english, $strlen);
            
            $code=$type;
            
            for($a=0;$a<$strlen;$a++)
            {
                $code=$code.$nu[$a].$arr_english[$rand_keys[$a]];
            }

            return $code;
        }
        
        function add_code()
        {
            $nu=$_POST['nu'];
            
            $type=$_POST['type'];
            
            $gid=$_POST['gid'];
            
            $day=$_POST['day'];
            
            $money=$_POST['money'];
            
            if(empty($type) || empty($day) || is_numeric($day)==false ||is_numeric($money)==false || empty($nu) || is_numeric($nu)==false )
            {
                $this->error('参数错误');
                return;
            } 
            
            if($type=='CZ')
            {
                if($money<0)
                {
                    $this->error('请输入充值金额');
                    return;
                }
            }
            
            if($type=='QZ')
            {
                if(empty($gid) || is_numeric($gid)==false)
                {
                    $this->error('群组id不能为空');
                    return;
                }
            }
            
            if($nu>50)
            {
                $this->error('每次生成的验证码不得大于50');
                return;
            }
            
            if($type=='QZ')
            {
                
                $group=M('group1')->where(array('id'=>$gid))->count();
                 
                if(empty($group))
                {
                    return;
                }
                
                
            }  
             
            $end_time=time()+60*60*24*$day;
            
            $uid=session('uid');
            
            $a=0;
            
            $code=M('code')->order('id desc')->field('id')->find();
             
            for($nu;$nu>0;$nu--)
            {
                
                $arr[$a]['code']=$this->shengcheng_code($type,5032,$code['id']+$nu);
            
                $a++;

            }
            
            if($type=='QZ')
            {
                $a=0;
                
                foreach ($arr as $k=>$v)
                {
                    $arr[$a]['name']='group';
                    
                    $arr[$a]['type']=1;
                    
                    $arr[$a]['eid']=$gid;
                    
                    $arr[$a]['aid']=$uid;
                    
                    $arr[$a]['time']=time();
                    
                    $arr[$a]['end_time']=$end_time;
                    
                    $arr[$a]['use']=0;
                    
                    $arr[$a]['is_delect']=0;
                    
                    $arr[$a]['money']=$money;
                    
                    $a++;
                }
                
                $list=M('code')->addAll($arr);
                
                if(!empty($list))
                {
                    $this->success('添加成功');
                }
                else 
                {
                    $this->error('添加失败');
                }
            }
            if($type=='CZ')
            {
                $a=0;
            
                foreach ($arr as $k=>$v)
                {
                    $arr[$a]['name']='recharge';
            
                    $arr[$a]['type']=1;
            
                    $arr[$a]['aid']=$uid;
            
                    $arr[$a]['time']=time();
            
                    $arr[$a]['end_time']=$end_time;
            
                    $arr[$a]['use']=0;
            
                    $arr[$a]['is_delect']=0;
                    
                    $arr[$a]['money']=$money;
            
                    $a++;
                }
            
                $list=M('code')->addAll($arr);
            
                if(!empty($list))
                {
                    $this->success('添加成功');
                }
                else
                {
                    $this->error('添加失败');
                }
            }
        }

        
        function code()
        {
            if(empty($_GET['gid']) || is_numeric($_GET['gid'])==false)
            {
                $this->error('参数错误');
                return;
            }
            
            $group=M('group1')->where(array('id'=>$_GET['gid']))->find();
            
            if(empty($group['id']))
            {
                $this->error('群组不存在');
            }
            
            $this->assign('name',$group['name']);
            
            $this->assign('gid',$_GET['gid']);
            
            $this->display();
            
        }
        
        function code_table()
        {
            if(empty($_GET['gid']) || is_numeric($_GET['gid'])==false)
            {
                $this->error('参数错误');
                return;
            }
            
            $group=M('group1')->where(array('id'=>$_GET['gid']))->find();
            
            if(empty($group['id']))
            {
                $this->error('群组不存在');
            }
            
            $this->assign('name',$group['name']);
            
            
            $this->assign('gid',$group['id']);
            
            
            $code=M('code')->where(array('name'=>'group','type'=>1,'eid'=>$_GET['gid'],'is_delect'=>0))->order('uid asc')->select();
            
            $this->assign('code',$code);
            
            $this->display();
        }
        
        function use_code()
        {
            if(empty($_GET['gid']) || is_numeric($_GET['gid'])==false)
            {
                $this->error('参数错误');
                return;
            }
            
            $group=M('group1')->where(array('id'=>$_GET['gid']))->find();
            
            if(empty($group['id']))
            {
                $this->error('群组不存在');
            }
            
            $this->assign('name',$group['name']);
            
            
            $this->assign('gid',$group['id']);
            
            
            $code=M('code')->where(array('name'=>'group','type'=>1,'eid'=>$_GET['gid'],'is_delect'=>0,'use'=>0))->select();
            
            $a=0;
            
            foreach ($code as $k=>$v)
            {
                $code[$a]['number']=$a;
                
                $a++;
            }
            
            $this->assign('code',$code);
            
            $this->display();

        }

        //wenjing
        //for group_url.html
        function group_url(){
        	$gid = $_GET['gid'];

        	$group=M('group1')->where(array('id'=>$gid))->find();
        	$group['url'] = U('Home/Index/group_login', array('code'=>$group['code']));
	        
	        $this->assign('group',$group);
	        
	        $this->display();
        }
        //wenjing
        //add code for a gid
        function add_url_code(){
        	$gid = $_POST['gid'];
        	if(empty($gid)){
        		echo json_encode("群组id为空");
        		return;
        	}
        	$code = $_POST['code'];
        	if(empty($code)){
        		echo json_encode("请输入群组code");
        		return;
        	}
        	//this code must not be same as other group
        	$group = M('group1')->where(array('code'=>$code))->select();
        	foreach ($group as $k => $v) {
        		# code...
        		if($v['id'] != $gid){
        			echo json_encode("请不要输入和其他群组相同的code");
        			return;
        		}
        	}

        	$g = M('group1')->where(array('id'=>$gid))->save(array('code'=>$code));
        	if($g){
        		echo 1;
        	}else{
        		echo json_encode("操作失败");
        	}

        }

        //wenjing
        //delate code/url
        function del_url_code(){
        	$gid = $_POST['gid'];
        	$return_del = M('group1')->where(array('id'=>$gid))->data(array('code'=>null))->save();
			if($return_del){
				echo 1;
				return;
			}

        }
        function recharge()
        {
            $this->display();
        }
        
        function recharge_table()
        {        
        
            $code=M('code')->where(array('name'=>'recharge','type'=>1,'is_delect'=>0))->order('uid asc,end_time desc')->select();
        
            $this->assign('code',$code);
        
            $this->display();
        }
        function use_recharge()
        {
        
            $code=M('code')->where(array('name'=>'recharge','type'=>1,'is_delect'=>0,'use'=>0))->select();
        
            $a=0;
        
            foreach ($code as $k=>$v)
            {
                $code[$a]['number']=$a;
        
                $a++;
            }
        
            $this->assign('code',$code);
        
            $this->display();
        
        }
        function top_user_group()
        {
            
            if(empty($_POST['uid']) || is_numeric($_POST['uid']==false) || empty($_POST['gid']) || is_numeric($_POST['gid']==false)){echo 0;return;}
           
            $user=M('user')->where(array('id'=>$_POST['uid']))->find();
            
            if(empty($user['id'])){echo 0;return;}
            
            $group=M('group1')->where(array('id'=>$_POST['gid']))->find();
            
            if(empty($group['id'])){echo 0;return;}
            
            $user_group=M('user_group')->where(array('uid'=>$_POST['uid'],'gid'=>$_POST['gid'],'is_delect'=>0))->find();
            
            if(empty($user_group['type'])){echo 0; return;}
            
            if($user_group['type']==1)
            {
                $type=2;
            }
            else
            {
                $type=1;
            }
            
            $save_user_group=M('user_group')->where(array('uid'=>$_POST['uid'],'gid'=>$_POST['gid'],'is_delect'=>0))->data(array('type'=>$type))->save();
            
            if(empty($save_user_group))
            {
                echo 0;
                return;
            }
            else 
            {
                echo $type;
                return;
            }

        }        
        
        function initialize_credit()
        {
            if(empty($_POST['nu']))
            {
            	$file_path="newfile.txt";
            	$conn=file_get_contents($file_path);
            	fclose($fp);
            	if(empty($conn) || is_numeric($conn)==FALSE){$conn=500;}
            	
            	$this->assign('conn',$conn);
            	
            	$this->display();
            	
            	return;
            
            }
            if(is_numeric($_POST['nu'])==false){$this->error('参数只能为整数');return;}
            $myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
            $txt = $_POST['nu'];
            $list=fwrite($myfile, $txt);
            fclose($myfile);	
            if($list)
            {
                $this->success('修改成功');
            }
            else 
            {
                $this->error('修改失败');
            }
        }
}

?>