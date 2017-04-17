<?php
class UserBalanceAction extends Action {
	public function index(){
		$parkid=I('parkid');
		$sql="";
		if($parkid !=0){
			$sql.="u.cityid=$parkid";
			$this->assign('parkid',$parkid);
		}else{
			$sql.="1=1";
		
		}
		$lourennum=I('lourennum');
		if($lourennum != ""){
			$sql.=" and u.usermobilenum='$lourennum'";
			$this->assign('lourennum',$lourennum);
		}else{
			$sql.=" and 1=1";
		
		}
		$startdate=I("startdate");
		$enddate=I("enddate");
		if(!empty($startdate)){
			$sql.=" and ( ub.createtime between '$startdate' and '$enddate' )";
			$this->assign('startdate',$startdate);
			$this->assign('enddate',$enddate);
		}else{
			$sql.=" and 1=1";
		}
		$dealstartdate=I("dealstartdate");
		$dealenddate=I("dealenddate");
		if(!empty($dealstartdate)){
			$sql.=" and ub.handletime between '$dealstartdate' and '$dealenddate'";
			$this->assign('dealstartdate',$dealstartdate);
			$this->assign('dealenddate',$dealenddate);
		}else{
			$sql.=" and 1=1";
		}
		$dealstatus=I("dealstatus");
		if($dealstatus!=0){
			$sql .= " and ub.status=($dealstatus-1) ";
			$this->assign("dstatus",$dealstatus );
		}else{
			$sql .= " and 1=1 ";
		}
		import('ORG.Util.Page');// 导入分页类
		$model=new Model();
		$ad=$model->db(3,'Yezhu');
		$count=$ad->table("userbalance ub,user u")->where("ub.userid=u.id and $sql")->count();
		$p=I('p',1);
		$Page = new Page($count);// 实例化分页类 传入总记录数
	   	$show = $Page->show();// 分页显示输出
		$data=$ad->table("userbalance ub,user u")->where("ub.userid=u.id and $sql")->order("ub.createtime desc")->field("ub.*,u.usernick,u.lourennick,u.usermobilenum")->limit($Page->firstRow.','.$Page->listRows)->select();
		foreach ($data as $key=>$val){
			if($val['paytype']!=0 && $val['paytype']!=''){
				$data[$key]['payname']=$ad->table("paystype")->where("id=$val[paytype]")->getfield('payname');
			}else{
				$data[$key]['payname']="未知";
			}
		}
	
		//小区
		$xqlists=$ad->table("park_maintaince")->where("city='TJ' or city='WH'")->order("convert(park_name using gbk) asc")->select();
		
		$this->assign('xqlists',$xqlists);
		$this->assign('page',$show);// 赋值分页输出
		$this->assign("datas",$data);
		$this->assign('p',$p);
		$this->display();
	}
	
//3.0版本以前记录
	public function oldlog(){
		$id=I("id");
		if(empty($id)){
			$this->error("错误的操作");
		}else{
			import('ORG.Util.Page');// 导入分页类
			$model=new Model();
			$ad=$model->db(3,'Yezhu');
			$count=$ad->table("userbalancelog")->where("userid=$id")->count();
			  $Page = new Page($count);// 实例化分页类 传入总记录数
		   	$show = $Page->show();// 分页显示输出
			$sdata=$ad->table("userbalancelog")->where("userid=$id")->order("createtime desc")->limit($Page->firstRow.','.$Page->listRows)->select();
			//echo  $ad->table("userbalancelog")->getlastsql();	
			//print_r($sdata);
			foreach ($sdata as $key=>$val){
				if($val['type']==0){
				   $sdata[$key]['orderid']=$ad->table("orders")->where("id=$val[typeid] and status=1")->getfield('orderid');	
				  // echo $ad->table("orders")->getlastsql();	
				}else if($val['type']==1 && $val['logstatus']==31){
					//返现
				 $sdata[$key]['orderid']=$ad->table("orders")->where("id=$val[typeid] and status=1")->getfield('orderid');	
				}
			}
			//print_r($sdata);
			$this->assign('sdata',$sdata);
			$this->assign('userid',$id);
			  $this->assign('page',$show);// 赋值分页输出
			$this->display();
		}
	}
	
//收支记录3.0版本以后
	public function szresult(){
		$id=I("id");
		if(empty($id)){
			$this->error("错误的操作");
		}else{
			import('ORG.Util.Page');// 导入分页类
			$model=new Model();
			$ad=$model->db(3,'Yezhu');
			$count=$ad->table("userlourenbalancelog")->where("userid=$id and '2016-02-22 23:59:59' < createtime")->count();
			$Page = new Page($count);// 实例化分页类 传入总记录数
		   	$show = $Page->show();// 分页显示输出
		   	$status=0;
		   	$sdata=$ad->table("userlourenbalancelog")->where("userid=$id and '2016-02-22 23:59:59' < createtime ")->order("createtime desc")->limit($Page->firstRow.','.$Page->listRows)->select();
			foreach ($sdata as $key=>$val){
				if($val['type']==0){
				   $sdata[$key]['orderid']=$ad->table("orders")->where("id=$val[typeid] and status=1")->getfield('orderid');	
				  // echo $ad->table("orders")->getlastsql();	
				}else if($val['type']==1 && $val['logstatus']==31){
					//返现
				 $sdata[$key]['orderid']=$ad->table("orders")->where("id=$val[typeid] and status=1")->getfield('orderid');	
				}
			}
			
			$this->assign('sdata',$sdata);
			$this->assign('userid',$id);
			  $this->assign('page',$show);// 赋值分页输出
			$this->display();
		}
	}
	
  //处理提现记录
  public function chuli(){
	  	$model=new Model();
		$ad=$model->db(3,'Yezhu');
		$p=I('p');
	  	if($_POST){
	  		//print_r($_POST);
	  		$id=I("id");   //进行处理的那条操作
	  		$data1=$ad->table("userbalance")->where("id=$id")->find();    //查询提现金额
	  		$data2=$ad->table("userlourenbalancelog")->where("type=1 and typeid=$id and logstatus=-31")->getField("balance");	 // 查询手续费
	  		$status=I("status");     //处理状态：1已处理，2拒绝
	  		$editdata=array( 		
		  		'status'=>$status,
		  		'handleremark'=>I("handleremark"),     //处理备注
		  		'handletime'=>date('Y-m-d H:i:s')      //处理时间
	  		);
	  		$re=$ad->table("userbalance")->where("id=$id")->save($editdata);
	  		//echo $ad->table("userbalance")->getlastsql();
	  		
	  		
	  		if($re==true){
	  			if($status==2){
	  				$usermoney=$ad->table("user")->where("id=$data1[userid]")->getField("lourenbalance");	 // 查询账户剩余牛人金额
	  				$tuimoney = $data1['balance']+$data2+$usermoney;
	  				$editmoney=array('lourenbalance'=>$tuimoney);
		  			$ad->table("user")->where("id=$data1[userid]")->save($editmoney);
		  		    //echo $ad->table("user")->getlastsql();
		  		    //拒绝牛人体现，生成记录
		  		    $shourulog=array(
		  		    	'userid'=>$data1[userid],
		  		    	'balance'=>$data1['balance'],
		  		    	'createtime'=>date('Y-m-d H:i:s'),
		  		    	'type'=>0,  //收入
		  		    	'uuid'=>"",  //体现设备
		  		    	'typeid'=>"",
		  		    	'logstatus'=>35,
		  		    	'title'=>"返还提现金额"
		  		    );
		  		    $inputjine=$ad->table("userlourenbalancelog")->add($shourulog);
		  		    if($data2>0){
		  		    	$shouxufeilog=array(
			  		    	'userid'=>$data1[userid],
			  		    	'balance'=>$data2,
			  		    	'createtime'=>date('Y-m-d H:i:s'),
			  		    	'type'=>0,  //收入
			  		    	'uuid'=>"",  //体现设备
			  		    	'typeid'=>"",
			  		    	'logstatus'=>35,
			  		    	'title'=>"返还提现手续费"
			  		    );
			  		    $inputjine1=$ad->table("userlourenbalancelog")->add($shouxufeilog);
		  		    }
	  			}
	  			$this->success("处理成功",U('index',array('p'=>$p)));
	  		}else{
	  		
	  			$this->error("处理失败");
	  		}
	  	}else{
		  	$id=I("id");
		  	if(empty($id)){
		  		$this->error("错误操作");
		  	}else{
		  	
				$data=$ad->table("userbalance ub")->where("ub.id=$id")->find();
				if($data['paytype']!='' && $data['paytype']!=0){
					$data['payname']=$ad->table("paystype")->where("id=$data[paytype]")->getfield('payname');
				}else{
				 	$data['payname']="未知";
				}
				//print_r($data);
				$smoney2=$ad->table("userbalancelog ub,orders o")->where("ub.userid=$data[userid] and ub.type=0 and o.id=ub.typeid and o.status=1")->sum('ub.balance');//收入
				$smoney1=$ad->table("userbalancelog ub,orders o")->where("ub.userid=$data[userid] and ub.type=1 and ub.logstatus=31 and o.id=ub.typeid")->sum('ub.balance');//订单返现
				//echo $ad->table("userbalancelog ub,orders o")->getlastsql();
				if($smoney2==""){
					$smoney2=0;
				}
				if($smoney1==""){
					$smoney1=0;
				}
				$smoney=$smoney1+$smoney2;
				$tmoney=$ad->table("userbalance")->where("userid=$data[userid] and status!=2")->sum('balance');
				
				//提现的总金额为
				//这个人的余额
				$yue=$ad->table("user")->where("id=$data[userid]")->getField('lourenbalance');
				$ttotal=$tmoney;
				if($ttotal==""){
					$ttotal=0;
				}
				
				$this->assign('ttotal',$ttotal);
				$this->assign('smoney',$smoney);
				$this->assign('yue',$yue);
				$this->assign('id',$id);
				$this->assign('data',$data);
				$this->assign('p',$p);
				$this->display();
		    }
	    }
  }	
  
  //批量拒绝提现
	public function refuselists(){
		$model=new Model();
		$ad=$model->db(3,'Yezhu');
		$data = array();
		$nidArr = I('id');
		if(!empty($nidArr)) {
			for($i=0;$i<count($nidArr);$i++){
				$nidStr = $nidArr[$i];
//				echo $nidStr;
				$data1=$ad->table("userbalance")->where("id=$nidStr")->find();    //查询提现金额
			  	$data2=$ad->table("userlourenbalancelog")->where("type=1 and typeid=$nidStr and logstatus=-31")->getField("balance");	 // 查询手续费
			  	$status=I("status");     //处理状态：1已处理，2拒绝
		  		$editdata=array( 		
			  		'status'=>2,
			  		'handleremark'=>'拒绝提现',     //处理备注
			  		'handletime'=>date('Y-m-d H:i:s')      //处理时间
		  		);
			  	$re=$ad->table("userbalance")->where("id=$nidStr")->save($editdata);
			  		//echo $ad->table("userbalance")->getlastsql();
	  			$usermoney=$ad->table("user")->where("id=$data1[userid]")->getField("lourenbalance");	 // 查询账户剩余金额
	  			$tuimoney = $data1['balance']+$data2+$usermoney;  
	  			$editmoney=array('lourenbalance'=>$tuimoney);
		  		$ad->table("user")->where("id=$data1[userid]")->save($editmoney);
		  		
				//拒绝牛人体现，生成记录
		  		    $shourulog=array(
		  		    	'userid'=>$data1[userid],
		  		    	'balance'=>$data1['balance'],
		  		    	'createtime'=>date('Y-m-d H:i:s'),
		  		    	'type'=>0,  //收入
		  		    	'uuid'=>"",  //体现设备
		  		    	'typeid'=>"",
		  		    	'logstatus'=>35,
		  		    	'title'=>"返还提现金额"
		  		    );
		  		    $inputjine=$ad->table("userlourenbalancelog")->add($shourulog);
		  		    if($data2>0){
		  		    	$shouxufeilog=array(
			  		    	'userid'=>$data1[userid],
			  		    	'balance'=>$data2,
			  		    	'createtime'=>date('Y-m-d H:i:s'),
			  		    	'type'=>0,  //收入
			  		    	'uuid'=>"",  //体现设备
			  		    	'typeid'=>"",
			  		    	'logstatus'=>35,
			  		    	'title'=>"返还提现手续费"
			  		    );
			  		    $inputjine1=$ad->table("userlourenbalancelog")->add($shouxufeilog);
		  		    }

				if($re==true && $ad==true) {
					$data['status'] = '1';
				} else {
					$data['status'] = '0';
				}
			}
			
		} else {
			$data['status'] = '0';
		}
		$this -> ajaxReturn($data);
	}
	
	//备注
	public function beizhu(){
		$model=new Model();
		$ad=$model->db(3,'Yezhu');
			$id=I("id");
	  	if(empty($id)){
	  		$this->error("错误操作");
	  	}else{
	  			$model=new Model();
		$ad=$model->db(3,'Yezhu');
		$data=$ad->table("userbalance")->where("id=$id")->find();	
		$this->assign('data',$data);
		$this->display();
	  	}
	}
	
	//打印新版本的收支记录
	public function szresultout(){
		ini_set('memory_limit', '1024M');
		ini_set('max_execution_time', -1); 
		set_time_limit(0);
	 //	echo 456123;
	 	$model=new Model();
	  $ad=$model->db(3,'Yezhu');
	 // print_r($_POST);
	  $id=I("id");
	  $lourennick=$ad->table("user")->where("id=$id")->getField("lourennick");
		$xlsData=$ad->table("userlourenbalancelog")->where("userid=$id and '2016-02-22 23:59:59' < createtime ")->order("createtime desc")->select();
		foreach ($xlsData as $key=>$val){
			if($val['type']==0){
			   $xlsData[$key]['orderid']=$ad->table("orders")->where("id=$val[typeid] and status=1")->getfield('orderid');	
			  // echo $ad->table("orders")->getlastsql();	
			}else if($val['type']==1 && $val['logstatus']==31){
				//返现
			 $xlsData[$key]['orderid']=$ad->table("orders")->where("id=$val[typeid] and status=1")->getfield('orderid');	
			}
		}
        $xlsName  = "牛人体现记录-3.0版本之后";
        $xlsCell  = array( 	 			
	        array('balance','金额（收/提）'),
	        array('type','类型'),
	        array('orderid','金额来源'),
	        array('title','名称'),
	        array('createtime','创建时间'),
        );
//        $xlsModel = M('student');
    
       // $xlsData  = $xlsModel->where("tid=$tid")->Field('username,school,grade,class,birthday,sex,stu_code,stu_pwd')->select();
        foreach ($xlsData as $k => $v){
        	if($v['type']==0 || $v['logstatus']==31){
        		$v['balance']= "+".$v['balance'];
        	}else{
        		$v['balance']= "-".$v['balance'];
        	}
        	if($v['type']==0){
        		$v['type']="收入";
        	}else if($v['logstatus']==31){
        		$v['type']="订单返现";
        	}else{
        		$v['type']="提现";
        	}
        	if($v['type']==0 || $v['logstatus']==31){
				if($v['orderid']==""){
					$v['orderid']="";
				}else{
					$v['orderid']="订单号".$v['orderid'];
				}
        	}
	        $xlsData[$k]['balance']=$v['balance']." ";
	        $xlsData[$k]['type']=$v['type']." ";
	        $xlsData[$k]['orderid']=$v['orderid']." "; 
	        $xlsData[$k]['title']=$v['title']." "; 
	        $xlsData[$k]['createtime']=$v['createtime']." ";
        }
	
      $this->exportExcel($xlsName,$xlsCell,$xlsData,$lourennick);
	}
	
	//牛人提现管理3.0版本之前记录打印
	public function oldlogout(){
		ini_set('memory_limit', '1024M');
		ini_set('max_execution_time', -1); 
		set_time_limit(0);
	 //	echo 456123;
	 	$model=new Model();
	  $ad=$model->db(3,'Yezhu');
	 // print_r($_POST);
	  $id=I("id");
	  $lourennick=$ad->table("user")->where("id=$id")->getField("lourennick");
	  $xlsData=$ad->table("userbalancelog")->where("userid=$id")->order("createtime desc")->select();
	  
//		$xlsData=$ad->table("userlourenbalancelog")->where("userid=$id and '2016-02-22 23:59:59' < createtime ")->order("createtime desc")->select();
		foreach ($xlsData as $key=>$val){
			if($val['type']==0){
			   $xlsData[$key]['orderid']=$ad->table("orders")->where("id=$val[typeid] and status=1")->getfield('orderid');	
			  // echo $ad->table("orders")->getlastsql();	
			}else if($val['type']==1 && $val['logstatus']==31){
				//返现
			 $xlsData[$key]['orderid']=$ad->table("orders")->where("id=$val[typeid] and status=1")->getfield('orderid');	
			}
		}
        $xlsName  = "牛人体现记录-3.0版本之前";
        $xlsCell  = array( 	 			
	        array('balance','金额（收/提）'),
	        array('type','类型'),
	        array('orderid','金额来源'),
	        array('title','名称'),
	        array('createtime','创建时间'),
        );
//        $xlsModel = M('student');
    
       // $xlsData  = $xlsModel->where("tid=$tid")->Field('username,school,grade,class,birthday,sex,stu_code,stu_pwd')->select();
        foreach ($xlsData as $k => $v){
        	if($v['type']==0 || $v['logstatus']==31){
        		$v['balance']= "+".$v['balance'];
        	}else{
        		$v['balance']= "-".$v['balance'];
        	}
        	if($v['type']==0){
        		$v['type']="收入";
        	}else if($v['logstatus']==31){
        		$v['type']="订单返现";
        	}else{
        		$v['type']="提现";
        	}
        	if($v['type']==0 || $v['logstatus']==31){
				if($v['orderid']==""){
					$v['orderid']="";
				}else{
					$v['orderid']="订单号".$v['orderid'];
				}
        	}
	        $xlsData[$k]['balance']=$v['balance']." ";
	        $xlsData[$k]['type']=$v['type']." ";
	        $xlsData[$k]['orderid']=$v['orderid']." "; 
	        $xlsData[$k]['title']=$v['title']." "; 
	        $xlsData[$k]['createtime']=$v['createtime']." ";
        }
	
      $this->exportExcel($xlsName,$xlsCell,$xlsData,$lourennick);
	}
	
//导出
	public function exportExcel($expTitle,$expCellName,$expTableData,$lourennick){
		set_time_limit(0);
        $xlsTitle = iconv('utf-8', 'gb2312', $expTitle);//文件名称
        $lourennick = iconv('utf-8', 'gb2312', $lourennick);//文件名称
        $fileName =$xlsTitle.date('_YmdHis')."(".$lourennick.")";//or $xlsTitle 文件名称可根据自己情况设定
        $cellNum = count($expCellName);
        $dataNum = count($expTableData);
        vendor("PHPExcel.PHPExcel");
       
        $objPHPExcel = new PHPExcel();
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
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  
        $objWriter->save('php://output'); 
        exit;   
    }
    
    function expUser(){
    	set_time_limit(0);
    	ini_set('memory_limit', '1024M');
		ini_set('max_execution_time', -1); 
		set_time_limit(0);
	 //	echo 456123;
	 	$model=new Model();
	    $ad=$model->db(3,'Yezhu');
	    $parkid=I('parkid');
		$sql="";
		if($parkid !=0){
			$sql.="u.cityid=$parkid";
			$this->assign('parkid',$parkid);
		}else{
			$sql.="1=1";
		
		}
		$lourennum=I('lourennum');
		if($lourennum != ""){
			$sql.=" and u.usermobilenum='$lourennum'";
			$this->assign('lourennum',$lourennum);
		}else{
			$sql.=" and 1=1";
		
		}
		$startdate=I("startdate");
		$enddate=I("enddate");
		if(!empty($startdate)){
			$sql.=" and ( ub.createtime between '$startdate' and '$enddate' )";
			$this->assign('startdate',$startdate);
			$this->assign('enddate',$enddate);
		}else{
			$sql.=" and 1=1";
		}
		$dealstartdate=I("dealstartdate");
		$dealenddate=I("dealenddate");
		if(!empty($dealstartdate)){
			$sql.=" and ub.handletime between '$dealstartdate' and '$dealenddate'";
			$this->assign('dealstartdate',$dealstartdate);
			$this->assign('dealenddate',$dealenddate);
		}else{
			$sql.=" and 1=1";
		}
		$dealstatus=I("dealstatus");
		if($dealstatus!=0){
			$sql .= " and ub.status=($dealstatus-1) ";
			$this->assign("dstatus",$dealstatus );
		}else{
			$sql .= " and 1=1 ";
		}
		import('ORG.Util.Page');// 导入分页类
		$model=new Model();
		$ad=$model->db(3,'Yezhu');
		$xlsDatasxnum=$ad->table("userbalance ub,user u,userlourenbalancelog ug")->where("ub.userid=u.id and ug.type=1 and ug.logstatus=-31 and ug.typeid=ub.id and $sql")->count();
		if($xlsDatasxnum>0){
			$xlsDatasx=$ad->table("userbalance ub,user u,userlourenbalancelog ug")->where("ub.userid=u.id and ug.type=1 and ug.logstatus=-31 and ug.typeid=ub.id and $sql")->order("ub.createtime desc")->field("ub.*,u.usernick,u.username,u.lourennick,u.usermobilenum,ug.balance as tixianmoney,ug.logstatus")->select();
			$sql .= " and ub.id not in ( ";
			if($xlsDatasxnum==0){
				$sql .= "$xlsDatasx[0]['id']";
			}else{
				for($i=0;$i<$xlsDatasxnum-1;$i++){
					$sql .= "".$xlsDatasx[$i]['id'].",";
				}
				$sql .= "".$xlsDatasx[$xlsDatasxnum-1]['id']."";
			}
			$sql .= " )";
		}
		$xlsData=$ad->table("userbalance ub,user u,userlourenbalancelog ug")->where("ub.userid=u.id and ug.type=1 and ug.typeid=ub.id and $sql")->order("ub.createtime desc")->field("ub.*,u.usernick,u.username,u.lourennick,u.usermobilenum,ug.balance as tixianmoney,ug.logstatus")->select();
		$xlsDatanum=$ad->table("userbalance ub,user u,userlourenbalancelog ug")->where("ub.userid=u.id and ug.type=1 and ug.typeid=ub.id and $sql")->count();
//		 echo $xlsDatanum;
		 $xlsName = "牛人提现记录";
         $xlstops = 0;
         $xlsCell  = array(
	         array('lourenusername','提现牛人账号'),
	         array('lourennick','牛人昵称'),
	         array('createtime','申请时间'),
	         array('tixianstatus','提现状态'),
	         array('handtime','客服处理时间'),
	         array('tixianmoney','提现金额'),
	         array('anothermoney','手续费'),
	         array('username','提现人姓名'),
	         array('payment_trade_no','支付账号（支付宝账号/银行卡号）'),
         );
         for($i=0;$i<$xlsDatanum;$i++){
         	if($xlsData[$i]['status'] == 0){
         		$tixianstatus = "未处理";
         	}else if($xlsData[$i]['status'] == 1){
         		$tixianstatus = "已处理";
         	}else{
         		$tixianstatus = "拒绝";
         	}
         	if($xlsData[$i]['logstatus'] == -31){
         		$tixianshouxufei = $xlsData[$i]['tixianmoney'];
         	}else{
         		$tixianshouxufei = "0.00";
         	}
         	$xlsData[$i]['lourenusername']=$xlsData[$i]['usermobilenum']." ";
	        $xlsData[$i]['lourennick']=$xlsData[$i]['lourennick']." ";
	        $xlsData[$i]['createtime']=$xlsData[$i]['createtime']." "; 
	        $xlsData[$i]['tixianstatus']=$tixianstatus." "; 
	        $xlsData[$i]['handtime']=$xlsData[$i]['handletime']." ";
	        $xlsData[$i]['tixianmoney']=$xlsData[$i]['balance']." ";
	        $xlsData[$i]['anothermoney']=$tixianshouxufei." ";  
	        $xlsData[$i]['username']=$xlsData[$i]['alipayusername']." ";  
	        $xlsData[$i]['payment_trade_no']=$xlsData[$i]['alipayname']." ";
         }
    	for($i=0;$i<$xlsDatasxnum;$i++){
         	if($xlsDatasx[$i]['status'] == 0){
         		$tixianstatus = "未处理";
         	}else if($xlsDatasx[$i]['status'] == 1){
         		$tixianstatus = "已处理";
         	}else{
         		$tixianstatus = "拒绝";
         	}
         	if($xlsDatasx[$i]['logstatus'] == -31){
         		$xlsDatasx[$i]['tixianmoney'] = $xlsDatasx[$i]['tixianmoney'];
         	}else{
         		$xlsDatasx[$i]['tixianmoney'] = "0.00";
         	}
         	$xlsData[$i+$xlsDatanum]['lourenusername']=$xlsDatasx[$i]['usermobilenum']." ";
	        $xlsData[$i+$xlsDatanum]['lourennick']=$xlsDatasx[$i]['lourennick']." ";
	        $xlsData[$i+$xlsDatanum]['createtime']=$xlsDatasx[$i]['createtime']." "; 
	        $xlsData[$i+$xlsDatanum]['tixianstatus']=$tixianstatus." "; 
	        $xlsData[$i+$xlsDatanum]['handtime']=$xlsDatasx[$i]['handletime']." ";
	        $xlsData[$i+$xlsDatanum]['tixianmoney']=$xlsDatasx[$i]['balance']." ";
	        $xlsData[$i+$xlsDatanum]['anothermoney']=$xlsDatasx[$i]['tixianmoney']." ";  
	        $xlsData[$i+$xlsDatanum]['username']=$xlsDatasx[$i]['alipayusername']." ";  
	        $xlsData[$i+$xlsDatanum]['payment_trade_no']=$xlsDatasx[$i]['alipayname']." ";
         }
//         foreach($xlsData as $k=>$value){
//         	if($value['status'] == 0){
//         	$tixianstatus = "未处理";
//         	}else if($value['status'] == 1){
//         		$tixianstatus = "已处理";
//         	}else{
//         		$tixianstatus = "拒绝";
//         	}
//         	if($value['logstatus'] == -31){
//         		$value['tixianmoney'] = $value['tixianmoney'];
//         	}else{
//         		$value['tixianmoney'] = "0.00";
//         	}
//         	$xlsData[$k]['lourenusername']=$value['usermobilenum']." ";  
//	        $xlsData[$k]['lourennick']=$value['lourennick']." ";
//	        $xlsData[$k]['createtime']=$value['createtime']." "; 
//	        $xlsData[$k]['tixianstatus']=$tixianstatus." "; 
//	        $xlsData[$k]['handtime']=$value['handletime']." ";
//	        $xlsData[$k]['tixianmoney']=$value['balance']." ";
//	        $xlsData[$k]['anothermoney']=$value['tixianmoney']." ";  
//	        $xlsData[$k]['username']=$value['alipayusername']." ";  
//	        $xlsData[$k]['payment_trade_no']=$value['alipayname']." ";
//         }
      	 $this->exportExcel($xlsName,$xlsCell,$xlsData,"综合");
    }
}
?>