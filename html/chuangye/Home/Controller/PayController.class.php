<?php
namespace Home\Controller;

use Think\Controller;

class PayController extends Controller {
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
        
        vendor('Alipay.Corefunction');
        vendor('Alipay.Md5function');
        vendor('Alipay.Notify');
        vendor('Alipay.Submit');


    }
    function index()
    {   
        
        $user=$this->user(7231);
        
        if(!$user)
        {
            redirect(U('Pay/result',array('str'=>'请登录','type'=>0,'cid'=>$_GET['cid'])));return;
        }
        else 
        {
            $this->assign('credit',$user['credit']);
        }
        
        if($_GET['type']='course')
        {            
            $course=$this->course($_GET['cid'], 7279);
            
            if($course)
            {
                $this->assign('course',$course);
                
                $_SESSION['pay_cid']=$_GET['cid'];
            }
            else 
            {
            
                redirect(U('Pay/result',array('str'=>'您暂时没有兑换此课程的权限','type'=>0,'cid'=>$_GET['cid'])));return;

            }
        }
        
        //print_r($course);return;
        
        //$this->display('phone_index');return;
        
        if(isMobile())
        {
            $this->display('phone_index');
        }
        else
        {
            $this->display();
        }
        
        //$this->display('phone_index');
    }
    function course($cid,$key)
    {
        if($key !=7279 ){return false ;}
        
        if(empty($cid) || is_numeric($cid)==false){return false;}
        
        $course=M('course')->where(array('id'=>$cid,'is_delect'=>0,'show_course'=>0))->select();
        
        if(empty($course[0]['id']))
        {
            return false;
        }
        else 
        {
            if(empty($course[0]['cost']) || is_numeric($course[0]['cost'])==false)
            {
                return false;
            }
            else 
            {
                return $course;
            }
        }
        
    }
    
    function user($key)
    {
        if($key !=7231 ){return false ;}
        
        $uid=session('id');
        
        if(empty($uid)){return false;}
        
        $user=M('user')->where(array('id'=>$uid))->find();
        
        if(!empty($user['id']))
        {
            return $user;
        }
        else 
        {
            return false;
        }
    }
    function result()
    {
        $this->assign('cid',$_GET['cid']);
        
        $this->assign('type',$_GET['type']);
    
        $this->assign('str',$_GET['str']);
        
        //$this->display('phone_result');return;
        
        if(isMobile())
        {
            $this->display('phone_result');
        }
        else
        {
            $this->display();
        }
        
        //$this->display();
    }
    
    //check the discount code 
    //for discount
    function check_discount(){

        header("Content-Type:text/html;charset=UTF-8");  // 解决乱码问题
        
        $code=$_POST['discount_code'];
        
        if(empty($code))
        {
            $arr=array(0, '优惠码为空');
            echo json_encode($arr);
            return;
        }

        $arr_code=M('code')->where(array('name'=>'discount','type'=>1,'code'=>$code))->find();
       
        if(empty($arr_code['id']))
        {
            $arr=array(0,'优惠码不存在');
            echo json_encode($arr);
            return;
        }
        
        if($arr_code['is_delect']!=0)
        {
           
            $arr=array(0,'优惠码被删除');
            echo json_encode($arr);
            return;

        }
       
        if($arr_code['end_time']<time())
        {
           
            $arr=array(0,'优惠码失效');
            echo json_encode($arr);
            return;
        }
        
        if($arr_code['use'] !=0)
        {
            $arr=array(0,'优惠码已被使用');
            echo json_encode($arr);
            return;
        }

        //如果没有上述情况，则说明该优惠码可用
        $money = $arr_code['money']; //优惠的钱数
        if($money >= 0){
            $arr = array(1, $money);
            echo json_encode($arr);
            $_SESSION['discount_code'] = $code;//for payment to save used
            return;
        }else{
            $arr = array(0, '出现错误，请稍后再试');
            echo json_encode($arr);
            return;
        }

    }
    //兑换付账函数，$discount是该用户的优惠码数值
    function payment($nu, $discount)
    {
        //$discount = $_GET('discount');

        $uid=session('id');
        
        $pay_cid=session('pay_cid');
        
        $cid=$pay_cid;
        
        if(empty($uid))
        {
            redirect(U('Pay/result',array('str'=>'兑换失败，请登录','type'=>0,'cid'=>$cid)));return;            
        }
        
        if(empty($_GET['nu']) || $_GET['nu'] !=6)
        {
            redirect(U('Pay/result',array('str'=>'兑换失败，请输入兑换时间','type'=>0,'cid'=>$cid)));return;
        }
        
        
        if(empty($pay_cid) || is_numeric($pay_cid)==false)
        {
            redirect(U('Pay/result',array('str'=>'兑换失败，请重新兑换','type'=>0,'cid'=>$cid)));return;
        }

        
        $course=$this->course($pay_cid, 7279);

        $course_type = $course[0]['type'];
        
        

        if(!empty($course[0]['id']))
        {
            if($this->course_user(1008, $pay_cid))
            {
                $list_course=$course[0];
                 
                $cost=$list_course['cost'] - $discount; //优惠，wenjing
                if($cost <= 0){
                    $cost = 0;
                }
                 
                $list_user=M('user')->where("id=$uid")->find();
                 
                $credit=$list_user['credit'];
                 
                $rs=$credit-$cost;
                
                if($rs<0)
                {
                    //积分不足
                    $type=$_GET['type'];

                    $tab='jifen_order';
                    
                    if(empty($type))
                    {
                        redirect(U('Pay/result',array('str'=>'网络繁忙请稍后再试','type'=>0,'cid'=>$cid)));return;
                        
                        return;
                    }
                    
                    if($type !='wx' && $type !='zfb')
                    {
                        redirect(U('Pay/result',array('str'=>'网络繁忙请稍后再试','type'=>0,'cid'=>$cid)));return;
                    
                        return;
                    }
                    
                    $pay_cost=0-$rs;
                    
                    $add_pay_order=add_order($pay_cost,'course',$type,'jifen_order',$cid);
                    
                    if($type=='wx')
                    {
                        $_SESSION['pay_order_id']=$add_pay_order;
                        redirect(C('weixinpayurl'));
                    }
                    else 
                    {
                        redirect(U('Pay/result',array('str'=>'网络繁忙请稍后再试','type'=>0,'cid'=>$cid)));return;
                        
                        return;
                    }
                    
               }
                else
                {
                    
                    $credit_log_id=money(10234,0-$cost,1,$cid);
                    
                    if($credit_log_id)
                    {
  
                        $end_time=$this->end_time($course[0]['id'], $course[0]['start_time'], $_GET['nu']);
                        
                        $nu=$this->adlook(7735,'7735asdsad',$cid,1,$end_time);

                        if($course[0]['zhuanti']==1)
                        {
                            $arr_course_group=json_decode('['.$course[0]['course_group'].']',true);
                            
                            foreach ($arr_course_group as $k=>$v)
                            {
                                $end_time=$this->end_time($v['id'], $v['start_time'], $_GET['nu']);
                                $nu=$this->adlook(7735,'7735asdsad',$v['id'],1,$end_time);
                            }
                            
                            
                        }
                    }
                    else
                    {
                        redirect(U('Pay/result',array('str'=>'兑换失败，未知错误-1','type'=>0,'cid'=>$cid)));return;
                    
                    }
                    if(!empty($nu))
                    {
                    	$data['user_course_id']=$nu;
                    	
                        $list_credit_log=M('credit_log')->where(array('id'=>$credit_log_id))->save($data);
                         
                        if(!empty($list_credit_log))
                        {
                            write_log('course_guanzhu',$cid);
                             
                            log_all('course_guanzhu',$cid);
                            
                            unset($_SESSION['pay_cid']);

                            //兑换成功，则优惠码失效（即在code表里加上user）
                            $code = $_SESSION['discount_code'];
                            $save_code = M('code')->where(array('name'=>'discount', 'code'=>$code))->data(array('use'=>1, 'uid'=>$uid))->save();

                            if($save_code !== false){
                                redirect(U('Pay/result',array('str'=>'兑换成功','type'=>$course_type,'cid'=>$cid)));return;
                            }
                            else{
                                redirect(U('Pay/result',array('str'=>'网络繁忙，请稍后再试','type'=>0,'cid'=>$cid)));return;
                            }
                            unset($_SESSION['discount_code']);
                            
                        }
                        else 
                        {
                            redirect(U('Pay/result',array('str'=>'兑换失败，未知错误-2','type'=>0,'cid'=>$cid)));return;
                            
                        }
                        
                         
                        
                    }
                    else
                    {
                       redirect(U('Pay/result',array('str'=>'兑换失败，未知错误-3','type'=>0,'cid'=>$cid)));return;
                        
                    }
                }
            }
            else 
            {
                redirect(U('Pay/result',array('str'=>'您已兑换此课程，请到个人中心我的课程中查看该课程','type'=>1,'cid'=>$cid)));return;
                
            }   

        }  
        else
        {
        
            redirect(U('Pay/result',array('str'=>'您暂时没有兑换此课程的权限','type'=>0,'cid'=>$cid)));return;
        
        }
    }
    
    
    //课程是否已被用户购买
    function course_user($key,$cid)
    {
        if($key != 1008){ return false;}
        
        $uid=session('id');
        
        if(empty($uid) || is_numeric($uid)==false){return false;}
        
        if(empty($cid) || is_numeric($cid)==false){return false;}
        
        $course_user=M('course_user')->where(array('uid'=>$uid,'cid'=>$cid,'type'=>1,'end_time'=>array('gt',time())))->find();             
        
        if(empty($course_user['id']))
        {
            return true;
        }
        else 
        {
            return false;
        }
        
    }
    /* 
     * 
     * 计算结课时间
     *  
     *  */
    function end_time($cid,$start_time,$nu)
    {
        $uid=session('id');//用户id
        //获取用户对应课程的最后结课时间
        $course_user_time=M('course_user')->where(array('uid'=>$uid,'cid'=>$cid,'end_time'=>array('gt',time())))->field('end_time')->order('id desc')->find();
        //如果用户未关注课程
        if(empty($course_user_time['end_time']))
        {
            //如果未开课
            if($start_time>time())
            {
                $end_time=$start_time+60*60*24*30*$nu;//开课时间加购课时间
            }
            else 
            {
                $end_time=time()+60*60*24*30*$nu;//购买时间加购课时间
            }
        }
        else
        {
            //如果用户结课时间大于开课时间
            if($course_user_time['end_time']>$start_time)
            {
                $end_time=$course_user_time['end_time']+60*60*24*30*$nu;//结课8
            }
            else 
            {
                $end_time=$start_time+60*60*24*30*$nu;
            }
        }

        return $end_time;
    }
    /*
     * 蔡政
     * 统计课程游览量
     * 进入页面向游览课程表中插入数据
     *  */
    function adlook($key,$key1,$id,$type,$end_time)
    {
    
        header("Content-Type:text/html;charset=UTF-8");  // 解决乱码问题
        (!($key==7735)) && redirect(U('Index/index'));
        
        (!($key1=='7735asdsad')) && redirect(U('Index/index'));
    
        $uid=session('id');
    
        if(empty($uid)){return false;}
    
        if($type!=1){return false;}
    
        $course=M('course');
    
        $where['id']=$id;
    
        $where['type']=1;
    
        $where['show_course']=0;
    
        $list_course=$course->where($where)->find();
    
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
    
        $list=$course_user->add($where_course_user);
    
        if(empty($course_user))
        {
            return false;
        }
        else
        {
            return $list;
        }
    
    
    }
    /*****************************************支付宝支付***************************************/

 public function doalipay(){
           /*********************************************************
                            把alipayapi.php中复制过来的如下两段代码去掉，
                            第一段是引入配置项，
                            第二段是引入submit.class.php这个类。
                           为什么要去掉？？
                            第一，配置项的内容已经在项目的Config.php文件中进行了配置，我们只需用C函数进行调用即可；
                            第二，这里调用的submit.class.php类库我们已经在PayAction的_initialize()中已经引入；所以这里不再需要；
           *****************************************************/
           // require_once("alipay.config.php");
           // require_once("lib/alipay_submit.class.php");
           
           //这里我们通过TP的C函数把配置项参数读出，赋给$alipay_config；
           header("Content-type:text/html;charset=utf-8");
           $alipay_config=C('alipay_config');  
     
            /**************************请求参数**************************/
            $payment_type = "1"; //支付类型 //必填，不能修改
            //$notify_url = C('alipay.notify_url'); //服务器异步通知页面路径
            //$return_url = C('alipay.return_url'); //页面跳转同步通知页面路径
            $seller_email = C('alipay.seller_email');//卖家支付宝帐户必填
            
			//echo $data['title'];
//            $out_trade_no = $_POST['trade_no'];//商户订单号 通过支付页面的表单进行传递，注意要唯一！
//            $subject = $_POST['ordsubject'];  //订单名称 //必填 通过支付页面的表单进行传递
//            $total_fee = $_POST['ordtotal_fee'];   //付款金额  //必填 通过支付页面的表单进行传递
            $out_trade_no =0000001;//商户订单号 通过支付页面的表单进行传递，注意要唯一！
            $subject = '连载课';  //订单名称 //必填 通过支付页面的表单进行传递
            $total_fee ='0.01';   //付款金额  //必填 通过支付页面的表单进行传递
            $body='测试支付';
            //$body = $data['title'];
            $show_url = "http://localhost".$_POST['url'];
          // $body = $_POST['ordbody'];  //订单描述 通过支付页面的表单进行传递
            //$show_url = $_POST['ordshow_url'];  //商品展示地址 通过支付页面的表单进行传递
            $anti_phishing_key = "";//防钓鱼时间戳 //若要使用请调用类文件submit中的query_timestamp函数
            $exter_invoke_ip = get_client_ip(); //客户端的IP地址 
            /************************************************************/
        
            //构造要请求的参数数组，无需改动
        $parameter = array(
            "service" => "create_direct_pay_by_user",
            "partner" => trim($alipay_config['partner']),
            "payment_type"    => $payment_type,
            //"notify_url"    => $notify_url,
            //"return_url"    => $return_url,
            "seller_email"    => $seller_email,
            "out_trade_no"    => $out_trade_no,
            "subject"    => $subject,
            "total_fee"    => $total_fee,
            "body"            => $body,
            "show_url"    => $show_url,
            "anti_phishing_key"    => $anti_phishing_key,
            "exter_invoke_ip"    => $exter_invoke_ip,
            "_input_charset"    => trim(strtolower($alipay_config['input_charset']))
            );
          //print_r($parameter);return;
            //建立请求
            $alipaySubmit = new \ AlipaySubmit($alipay_config);
            $html_text = $alipaySubmit->buildRequestForm($parameter,"post", "确认");
            echo $html_text;
   }
        
            /******************************
            服务器异步通知页面方法
            其实这里就是将notify_url.php文件中的代码复制过来进行处理
            
            *******************************/
   function notifyurl(){
                    /*
                    同理去掉以下两句代码；
                    */ 
                    //require_once("alipay.config.php");
                    //require_once("lib/alipay_notify.class.php");
                    
                    //这里还是通过C函数来读取配置项，赋值给$alipay_config
                $data=array(
                   'request'=>file_get_contents("php://input"),
                   'createtime'=>date('Y-m-d H:i:s')
                   );
             M("apply_log")->add($data);    
             if($_POST['sign_type']=='RSA'){
             	if($_POST['notify_id']!=''){
             	   //获取支付宝的通知返回参数，可参考技术文档中服务器异步通知参数列表
               $out_trade_no   = $_POST['out_trade_no'];      //商户订单号
               $trade_no       = $_POST['trade_no'];          //支付宝交易号
               $trade_status   = $_POST['trade_status'];      //交易状态
               $total_fee      = $_POST['total_fee'];         //交易金额
               $notify_id      = $_POST['notify_id'];         //通知校验ID。
               $notify_time    = $_POST['notify_time'];       //通知的发送时间。格式为yyyy-MM-dd HH:mm:ss。
               $buyer_email    = $_POST['buyer_email'];       //买家支付宝帐号；
              $parameter = array(
                 "out_trade_no"     => $out_trade_no, //商户订单编号；
                 "trade_no"     => $trade_no,     //支付宝交易号；
                 "total_fee"     => $total_fee,    //交易金额；
                 "trade_status"     => $trade_status, //交易状态
                 "notify_id"     => $notify_id,    //通知校验ID。
                 "notify_time"   => $notify_time,  //通知的发送时间。
                 "buyer_email"   => $buyer_email,  //买家支付宝帐号；
               );
               if($_POST['trade_status'] == 'TRADE_FINISHED') {
                           //
               }else if ($_POST['trade_status'] == 'TRADE_SUCCESS') {                        
               	   if(!checkorderstatus($out_trade_no)){
                   orderhandle($parameter); 
                               //进行订单处理，并传送从支付宝返回的参数；
                   }
                }
                    echo "success";        //请不要修改或删除
             	}else{
             		
             		 echo "fail";
             	}
             }else{
            $alipay_config=C('alipay_config');
            //计算得出通知验证结果
            $alipayNotify = new AlipayNotify($alipay_config);
            $verify_result = $alipayNotify->verifyNotify();
            if($verify_result) {
                   //验证成功
                  
               //获取支付宝的通知返回参数，可参考技术文档中服务器异步通知参数列表
               $out_trade_no   = $_POST['out_trade_no'];      //商户订单号
               $trade_no       = $_POST['trade_no'];          //支付宝交易号
               $trade_status   = $_POST['trade_status'];      //交易状态
               $total_fee      = $_POST['total_fee'];         //交易金额
               $notify_id      = $_POST['notify_id'];         //通知校验ID。
               $notify_time    = $_POST['notify_time'];       //通知的发送时间。格式为yyyy-MM-dd HH:mm:ss。
               $buyer_email    = $_POST['buyer_email'];       //买家支付宝帐号；
              $parameter = array(
                 "out_trade_no"     => $out_trade_no, //商户订单编号；
                 "trade_no"     => $trade_no,     //支付宝交易号；
                 "total_fee"     => $total_fee,    //交易金额；
                 "trade_status"     => $trade_status, //交易状态
                 "notify_id"     => $notify_id,    //通知校验ID。
                 "notify_time"   => $notify_time,  //通知的发送时间。
                 "buyer_email"   => $buyer_email,  //买家支付宝帐号；
               );
               if($_POST['trade_status'] == 'TRADE_FINISHED') {
                           //
               }else if ($_POST['trade_status'] == 'TRADE_SUCCESS') {                        
               	   if(!checkorderstatus($out_trade_no)){
                   orderhandle($parameter); 
                               //进行订单处理，并传送从支付宝返回的参数；
                   }
                }
                    echo "success";        //请不要修改或删除
             }else {
                    //验证失败
                    echo "fail";
            }
             }   
   }
        
        /*
            页面跳转处理方法；
            这里其实就是将return_url.php这个文件中的代码复制过来，进行处理； 
            */
    function returnurl(){
                    //头部的处理跟上面两个方法一样，这里不罗嗦了！
            $alipay_config=C('alipay_config');
            $alipayNotify = new AlipayNotify($alipay_config);//计算得出通知验证结果
            $verify_result = $alipayNotify->verifyReturn();
            if($verify_result) {
                //验证成功
                //获取支付宝的通知返回参数，可参考技术文档中页面跳转同步通知参数列表
            $out_trade_no   = $_GET['out_trade_no'];      //商户订单号
            $trade_no       = $_GET['trade_no'];          //支付宝交易号
            $trade_status   = $_GET['trade_status'];      //交易状态
            $total_fee      = $_GET['total_fee'];         //交易金额
            $notify_id      = $_GET['notify_id'];         //通知校验ID。
            $notify_time    = $_GET['notify_time'];       //通知的发送时间。
            $buyer_email    = $_GET['buyer_email'];       //买家支付宝帐号；
                
            $parameter = array(
                "out_trade_no"     => $out_trade_no,      //商户订单编号；
                "trade_no"     => $trade_no,          //支付宝交易号；
                "total_fee"      => $total_fee,         //交易金额；
                "trade_status"     => $trade_status,      //交易状态
                "notify_id"      => $notify_id,         //通知校验ID。
                "notify_time"    => $notify_time,       //通知的发送时间。
                "buyer_email"    => $buyer_email,       //买家支付宝帐号
            );
            
    if($_GET['trade_status'] == 'TRADE_FINISHED' || $_GET['trade_status'] == 'TRADE_SUCCESS') {
            if(!checkorderstatus($out_trade_no)){
                 orderhandle($parameter);  //进行订单处理，并传送从支付宝返回的参数；
        }
            $this->redirect(C('alipay.successpage'));//跳转到配置项中配置的支付成功页面；
        }else {
            echo "trade_status=".$_GET['trade_status'];
            $this->redirect(C('alipay.errorpage'));//跳转到配置项中配置的支付失败页面；
        }
    }else {
        //验证失败
        //如要调试，请看alipay_notify.php页面的verifyReturn函数
  $this->redirect("Orders/success");
        //$this->display();
       // echo "支付失败！";
        }
    }
    /*************************************微信支付*******************************************/
    
    
 public function weixin()
 {
        
        $user=$this->user(7231);
        
        $cid=session('pay_cid');
        
         if(!$user)
        {
            redirect(U('Pay/result',array('str'=>'请登录','type'=>0,'cid'=>$cid)));return;
            return;
        }
        
        $oid=session('pay_order_id');
        
        if(empty($oid) || is_numeric($oid)==false)
        {
            redirect(U('Pay/result',array('str'=>'网络错误,请稍后再试1','type'=>0,'cid'=>$cid)));return;
            return;
        }
        
        $uid=session('id');

        if(empty($uid) || is_numeric($uid)==false)
        {
            redirect(U('Pay/result',array('str'=>'网络错误,请稍后再试2','type'=>0,'cid'=>$cid)));return;
            
            return;
        }
        
        $pay_order=M('pay_order po')->join('left join jifen_order jo on jo.id=po.un_id')->where(array('po.uid'=>$uid,'po.id'=>$oid,'po.is_delect'=>0,'po.type'=>'wx','po.is_paid'=>0))->find();
        
        if(empty($pay_order['id']))
        {
            redirect(U('Pay/result',array('str'=>'网络错误,请稍后再试3','type'=>0,'cid'=>$cid)));return;
            
            return;
        }
        
        $total_fee = $pay_order['money']*100;   //总共的付款金额

            $body='积分充值';
        
        
        if(weixin_login())
        { 
            
               vendor('WxPayPubHelper.SDKRuntimeException');
               vendor('WxPayPubHelper.WxPay.pub.config');//微信支付配置
               vendor('WxPayPubHelper.WxPayPubHelper');
               //$user=M('user')->where(array('id'=>$uid))->find();
               $unifiedOrder = new \ UnifiedOrder_pub();
               
               $wx_id=$user['phone_openid'];
               //$total_fee = 1;
               //$body = "订单支付{$promsg['orderid']}";
               $unifiedOrder->setParameter("openid", "$wx_id");//用户标识
               $unifiedOrder->setParameter("body", "$body");//商品描述
               //自定义订单号，此处仅作举例
               //$out_trade_no = $promsg['orderid'];
               $unifiedOrder->setParameter("out_trade_no",$pay_order['order_id']);//商户订单号
               $unifiedOrder->setParameter("total_fee","$total_fee");//总金额
               $unifiedOrder->setParameter("notify_url",'http://test.chuangx.org/index.php/Home/Pay/weixin_result/');//通知地址
               $unifiedOrder->setParameter("trade_type", "JSAPI");//交易类型
               $prepay_id = $unifiedOrder->getPrepayId();
               //echo $prepay_id;return;
               $jsApi = new \ JsApi_pub();
               //=========步骤3：使用jsapi调起支付============
               $jsApi->setPrepayId($prepay_id);
               $jsApiParameters = $jsApi->getParameters();
               //       	 print_r($jsApiParameters);
               $wxconf = json_decode($jsApiParameters, true);
               //     	 print_r($wxconf);
               //     	 exit();
               
               //print_r($wxconf);return;
               
               if ($wxconf['package'] == 'prepay_id=') {
                   redirect(U('Pay/result',array('str'=>'当前订单存在异常，不能使用支付','type'=>0,'cid'=>$_GET['cid'])));return;
                   return;
               }
               $this->assign('jsApiParameters', $jsApiParameters);
                
               $this->assign('money',$total_fee/100);
            
               $this->assign('nu',$pay_order['nu']);
            
               $this->assign('cid',$cid);
            
               $this->assign('order_id',$pay_order['order_id']);
               
               $this->assign('jifen',$pay_order['jifen']);
               
               $this->assign('body',$body);
               
               $this->display('phone_weixin');
        }
        else
        {
            vendor ( "WxPayPubHelper.lib.WxPayNativePay" );
            vendor ( "WxPayPubHelper.lib.WxPayApi" );
            $input = new \ WxPayUnifiedOrder();
            $input->SetBody("$body");
            $input->SetAttach("$body");
            $input->SetOut_trade_no($pay_order['order_id']);
            $input->SetTotal_fee("$total_fee");
            $input->SetTime_start(date("YmdHis"));
            $input->SetTime_expire(date("YmdHis", time() + 600));
            $input->SetGoods_tag("$body");
            $input->SetNotify_url("http://paysdk.weixin.qq.com/example/notify.php");
            $input->SetTrade_type("NATIVE");
            $input->SetProduct_id("123456789");
            
            $WxPayApi = new \ WxPayApi();
            
            if($input->GetTrade_type() == "NATIVE")
            {
                $result = $WxPayApi->unifiedOrder($input);
                
                //print_r($result);return;
            }
            else 
            {
                redirect(U('Pay/result',array('str'=>'网络错误,请稍后再试','type'=>0,'cid'=>$cid)));return;
                return;
            }
            
            $code_url=urlencode($result["code_url"]);
            
            //print_r($result);return;
            
            $this->assign('code_url',$code_url);
            
            $this->assign('money',$total_fee/100);
            
            $this->assign('nu',$pay_order['nu']);
            
            $this->assign('cid',$cid);
            
            $this->assign('order_id',$pay_order['order_id']);
            
            $this->display();
            
            //$pay_order=$this->add_pay_prder($order_id,'weixin');
    
            //$this->weixin_erweima($result["code_url"]);

            
        }
    }
    //生成二维码
    function weixin_erweima($data)
    {
        $user=$this->user(7231);
        
        if(!$user)
        {
            redirect(U('Pay/result',array('str'=>'请登录','type'=>0,'cid'=>$_GET['cid'])));return;
        }
        ob_clean();
        vendor ( "WxPayPubHelper.phpqrcode.phpqrcode" );
        error_reporting(E_ERROR);
        //require_once 'phpqrcode/phpqrcode.php';
        $url = urldecode($data);
        $input = new \ QRcode();
        $input->png($url);
    }

    public function weixin_result(){   //微信支付回调函数
        
        $uid=session('id');
        
        if(!$uid)
        {
            echo 3;
            return;
        }
        
        vendor ( "WxPayPubHelper.lib.WxPayApi" );
        
        $order_id=$_POST['order_id'];
        
        if(empty($order_id))
        {
            echo 2;
            return;
        }
        
        $pay_order=M('pay_order po')->join('left join jifen_order jo on jo.id=po.un_id')->where(array('po.order_id'=>$order_id,'po.uid'=>$uid,'po.is_paid'=>0))->field('po.id,jo.jifen,po.un_id,jo.name')->find();
        
        if(empty($pay_order['id']))
        {
            echo 0;
            return;
        }
        
        if(isset($order_id) && $order_id != "")
        {
        	
        	$input = new \ WxPayOrderQuery();
        	
        	$input->SetOut_trade_no($order_id);
        	
        	$wxpayapi =new \ WxPayApi;
        	
        	$rest=$wxpayapi->orderQuery($input);

        	if($rest['trade_state']=='SUCCESS')
        	{
        	    
        	    $m=money(10234, $pay_order['jifen'],5);
         	    if($m)
         	    {

        	        $sa_pay_order=M('pay_order')->where(array('id'=>$pay_order['id']))->data(array('end_time'=>time(),'is_paid'=>1))->save();

        	        if(empty($sa_pay_order))
        	        {
        	            echo 3;
        	        }
        	        else
        	        {
        	            $sa_jifen_order=M('jifen_order')->where(array('id'=>$pay_order['un_id']))->data(array('is_paid'=>1,'credit_log_id'=>$m))->save();
        	            
        	            unset($_SESSION['pay_order_id']);

        	            echo $pay_order["name"];

        	        }
         	    }
         	    else
         	    {
         	        echo 2;
         	    }

                
        	    
        	}
            else
            {
                echo 4;
                return;
            }
        }
        else
        {
            echo 5;
            return;
        }
    }
    
    function https_request($url, $data = null){
          $curl = curl_init();
          curl_setopt($curl, CURLOPT_URL, $url);
          curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
          curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
          if (!empty($data)){
                  curl_setopt($curl, CURLOPT_POST, 1);
                  curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
              }
              curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
              $output = curl_exec($curl);
              curl_close($curl);
              return $output;
             }
    /***************************************微信扫码支付********************************************/
   function add_pay_prder($order_id,$type)
   {
       $list=M('pay_order')->where(array('order_id'=>$order_id))->find();
       
       if(!empty($list['id']))
       {
           return false;
       }
       
       $add=M('pay_order')->data(array('order_id'=>$order_id,'time'=>time(),'is_delect'=>0,'type'=>$type,'is_paid'=>0))->add();
   
        if(empty($add))
        {
            return false;
        }
        else 
        {
            return true;
        }
   }
   
   function change_order($order_id)
   {
       $uid=$_SESSION['id'];

       //$pay_order=M('pay_order')->where(array('order_id'=>$order_id,'uid'=>$uid))->find();
       
       $pay_order=M('pay_order po')->join('left join jifen_order jo on jo.id=po.un_id')->where(array('po.order_id'=>$order_id,'po.uid'=>$uid,'po.is_paid'=>0))->field('po.id,jo.jifen,po.un_id')->find();
       
       if(empty($pay_order['id']))
       {
           echo 0;return ;
       }       
   }
   
   function paymentvip()
   {
   
       $uid=session('id');
   
       if(empty($uid))
       {
           redirect(U('Pay/result',array('str'=>'兑换失败，请登录','type'=>0,'cid'=>$cid)));return;
       }
   
       if(empty($_GET['nu']) || $_GET['nu'] !=6)
       {
           redirect(U('Pay/result',array('str'=>'兑换失败，请输入兑换时间','type'=>0,'cid'=>$cid)));return;
       }
       else
       {
           
       }   
        
       $cost=C('vipuser');
       
       $list_user=M('user')->where("id=$uid")->find();
        
       $credit=$list_user['credit'];
        
       $rs=$credit-$cost;

       if($rs<0)
       {
           //积分不足
           $type=$_GET['type'];

           $tab='jifen_order';

           if(empty($type))
           {
               redirect(U('Pay/result',array('str'=>'网络繁忙请稍后再试','type'=>0,'cid'=>$cid)));return;

               return;
           }

           if($type !='wx' && $type !='zfb')
           {
               redirect(U('Pay/result',array('str'=>'网络繁忙请稍后再试','type'=>0,'cid'=>$cid)));return;

               return;
           }

           $pay_cost=0-$rs;

           $add_pay_order=add_order($pay_cost,'vip',$type,'jifen_order',$cid);

           if($type=='wx')
           {
               $_SESSION['pay_order_id']=$add_pay_order;
               redirect(C('weixinpayurl'));
           }
           else
           {
               redirect(U('Pay/result',array('str'=>'网络繁忙请稍后再试','type'=>0,'cid'=>$cid)));return;

               return;
           }

       }
       else
       {
           
           $m=money(10234,0-$cost,6);
           
           if(!$m)
           {
               redirect(U('Pay/result',array('str'=>'网络繁忙请稍后再试','type'=>0,'cid'=>$cid)));return;
               
               return;
           }
           
            $addvip=addvip(1008611, $_GET['nu']);
       
            if(empty($addvip[0]))
            {
                redirect(U('Pay/result',array('str'=>'网络繁忙请稍后再试','type'=>0,'cid'=>$cid)));return;
                
                return;
            }
            else 
            {
                R('Message/weixin_mood',array('weixin_user_change','weixin',date('y年m月d H:i'),'升级会员',date('y年m月d H:i',$addvip[1])));
                
                redirect(U('Pay/result',array('str'=>'兑换成功','type'=>1,'cid'=>'vip')));return;
                                
                return;
            }
       }

   }
   
   function pay_vip()
   {
   
       $user=$this->user(7231);
   
       if(!$user)
       {
           redirect(U('Pay/result',array('str'=>'请登录','type'=>0,'cid'=>$_GET['cid'])));return;
       }
       else
       {
           $this->assign('credit',$user['credit']);
       }
   
       $this->assign('cost',C('vipuser'));
   
       $this->display();
   }
   
}











           
           
